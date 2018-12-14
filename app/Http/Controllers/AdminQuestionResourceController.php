<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ImportFileRequest;
use Lang,DB,Excel,File;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Setting;
use App\Services\ImportFileService;
use App\Repositories\Eloquents\QuestionRepository;
use App\Repositories\Eloquents\LevelRepository;
use App\Repositories\Eloquents\AnswerRepository;
use App\Repositories\Eloquents\SkillRepository;
use App\Repositories\Eloquents\CategoryRepository;
class AdminQuestionResourceController extends Controller
{
    protected $question,$answer,$skill,$level,$category,$import_file;
    public function __construct(QuestionRepository $question,LevelRepository $level,AnswerRepository $answer,SkillRepository $skill, CategoryRepository $category, ImportFileService $import_file){
        $this->question = $question;
        $this->level    = $level;
        $this->answer   = $answer;
        $this->skill    = $skill;
        $this->category = $category;
        $this->import_file = $import_file;
    }
    public function index(Request $rq){

        $levels     = $this->level->getAll();
        $categories = $this->category->getAll();
        $skills     = $this->skill->getAll();
        $setting    = Setting::first();
        $name       = $rq->nameSkill;
        $category_name =$rq->nameCate;
        
        $skill_id   = $this->skill->getBy()->where('name',$name)->first();
        $category_id= $this->category->getBy()->where('name',$category_name)->first();
        
        $paginate = $setting->paginate;
        if(!empty($category_id)){
            $questions  = $this->question->getBy()->where('skill_id',$skill_id->id)
                                                  ->where('category_id',$category_id->id)
                                                  ->paginate($paginate);
        } else{ 
            $questions  = $this->question->getBy()->where('skill_id',$skill_id->id)
                                                  ->paginate($paginate);
        }
        $answers    = $this->answer->getAll();
       
        return view('layouts.admin.pages.question',
            compact('skill_id','levels','name','questions','answers','categories','skills','category_name','category_id'));
    }

    public function create()
    {
        //
    }
    public function store(Request $rq){
        $data = $rq->data;

        if($data['content_question'] != '' &&
            !empty($data['content_answer'][0]) && 
            $data['level_id'] != 0
        ){
            $check_content = $this->question->getBy()->where('content',$data['content_question'])->get();
            if(count($check_content) >0){
                return response()->json(['error'=>Lang::get('messages.name.unique')]);
            }
            // Add question
            $data_question = [
                'content'       =>$data['content_question'],
                'skill_id'      =>$data['skill_id'],
                'category_id'   => isset($rq->category_id)? $rq->category_id : null,
                'level_id'      =>$data['level_id']
            ];

            DB::beginTransaction();
            try{
                $this->question->create($data_question);
                // Add answer
                $question_id = $this->question->getBy()->first();
                foreach($data['content_answer'] as $key => $answer){
                    $this->answer->create([
                        'content'=>$answer,
                        'is_corrected'=>$data['check_answer'][$key],
                        'question_id'=>$question_id->id
                    ]);
                }
                
                DB::commit();
            } catch(\Exception $e){
               DB::rollBack();
               return response()->json(['error'=>Lang::get('messages.error.add.database')]) ;
            }
            return response()->json(['success'=>Lang::get('messages.success.add')]);
        } return response()->json(['error'=>Lang::get('messages.name-question')]);
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $rq, $id){
        $data = $rq->data;
        $content_answer = $rq->content_answer;
        $content_answer_new = $rq->content_answer_new;
        $category_id = $rq->category_id;

        if(
            $data['content_question'] &&
            $data['level_id'] != 0 &&
            ($content_answer || $content_answer_new)
        ){
            //Update question
            $data_question = [
                'content'=>$data['content_question'],
                'skill_id'=>$data['skill_id'],
                'category_id'=> isset($category_id) ? $category_id : null, 
                'level_id'=>$data['level_id']
            ];
            
            DB::beginTransaction();
            try{
                $this->question->update($data['question_id'],$data_question);
                //Update answer
                if(!empty($content_answer)){
                    foreach($data['content_answer'] as $key => $answer){
                        $answer_id = $data['answer_id'][$key]['idAnswer'];
                        $this->answer->update($answer_id,
                            [
                                'content'=>$answer,
                                'is_corrected'=>$data['check_answer'][$key],
                                'question_id'=>$data['question_id']
                            ]
                        );
                    }
                }
                //Add answer
                if(!empty($content_answer_new)){
                    foreach($data['content_answer_new'] as $key => $answer){
                        $this->answer->create([
                            'content'=>$answer,
                            'is_corrected'=>$data['check_answer_new'][$key],
                            'question_id'=>$data['question_id']
                        ]);
                    }
                }

                DB::commit();
            } catch(\Exception $e){
               DB::rollBack();
               return response()->json(['error'=>Lang::get('messages.error.add.database')]) ;
            }
            return response()->json(['success'=>Lang::get('messages.success.update')]) ;                
        } return response()->json(['error'=>Lang::get('messages.name-question')]); 
    }

    public function destroy($id, Request $rq)
    {
        if(Question::find($rq->id)){
            $this->question->delete($rq->id);
            return response()->json(['success'=>Lang::get('messages.success.delete')]) ;
        } return response()->json(['error'=>Lang::get('messages.error.delete')]) ;
    }

    public function importFile(ImportFileRequest $rq){
        $file = $rq->file('file');
        $type_file = $file->getClientOriginalExtension();
        $check_type_file = ['xlsx','xls','xlsm','csv'];
        $path = $rq->file('file')->getRealPath();
        
        if(in_array($type_file, $check_type_file)){
            $results = Excel::selectSheetsByIndex(0)->load($path,function($data){})->toObject();

            if(empty($results[0][0]) && empty($results[2][0])){
                return redirect()->back()->with(['error'=>Lang::get('messages.error.file.from')]);
            }

            $data_info = [
                'skill'     => $results[0][0],
                'category'  => $results[1][0],
                'level'     => $results[2][0]
            ];
            
            $data = $this->import_file->execute($results,$data_info);
            if(!empty($data)){
                return redirect()->back()->with(['error'=> $data->getData()->error]);
            }
        } else return redirect()->back()->with(['error'=>Lang::get('messages.error.file')]);
        return redirect()->back()->with(['success'=>Lang::get('messages.success.import')]);
    }
}

