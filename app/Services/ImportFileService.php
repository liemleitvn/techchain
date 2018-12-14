<?php 
namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\Eloquents\QuestionRepository;
use App\Repositories\Eloquents\LevelRepository;
use App\Repositories\Eloquents\AnswerRepository;
use App\Repositories\Eloquents\SkillRepository;
use App\Repositories\Eloquents\CategoryRepository;
use Lang,DB,Excel,File;

class ImportFileService
{
    protected $question,$answer,$skill,$level,$category;
    public function __construct(QuestionRepository $question,LevelRepository $level,AnswerRepository $answer,SkillRepository $skill, CategoryRepository $category){
        $this->question = $question;
        $this->level    = $level;
        $this->answer   = $answer;
        $this->skill    = $skill;
        $this->category = $category;
    }
    
    public function execute ($results,$data_info){
        $data       = [];
        $question   = [];
        $answers    = [];
        // Get skill_id, level_id, category_id
        foreach($results as $key=>$item){
            if($item[0] != null) {
                $skill_obj = $this->skill->getBy()->where('name',$data_info['skill'])->first();
                if($data_info['category'] != 'null'){
                    $category_obj = $this->category->getBy()->where('name',$data_info['category'])->first();
                }
                $level_obj = $this->level->getBy()->where('name',$data_info['level'])->first();
                $data[] = $item[0];
            }
        }
        
        if(!empty($skill_obj) || !empty($data_info['category'])){
            if(($skill_obj->is_can_add_category == 1 && $data_info['category'] && !empty($category_obj)) ||
                ($skill_obj->is_can_add_category == 0 && $data_info['category'] == null)
            ){
                DB::beginTransaction();
                try{
                    foreach ($data as $key=>$item) {
                        $answer = [];
                        $like_question = str_split(trim($item), 8);

                        if( strtoupper($like_question[0]) == 'QUESTION'){
                            $question_content = $data[$key + 1];
                            $check_exist_question = $this->question->getBy()->where('content',$question_content)->first();

                            $data_question  = [
                                'content'   => $question_content,
                                'skill_id'  => $skill_obj->id,
                                'level_id'  => $level_obj->id,
                                'category_id'=>($skill_obj->is_can_add_category == 1)? $category_obj->id : null
                            ];

                            if(empty($check_exist_question)){
                                //Add question -> DB
                                $this->question->create($data_question);
                                $question_obj = $this->question->getBy()->first();

                                for ($i = $key+2 ; $i < count($data); $i++) {
                                    if(mb_substr($data[$i], 0, 1) != '?')
                                        break;
                                    
                                    $tmp            = ltrim($data[$i],"?");
                                    $answer_content = strpos($data[$i],",true") ? $tmp = rtrim($tmp,",true") : $tmp;
                                    $is_corrected   = strpos($data[$i],",true") ? 1 : 0;

                                    $data_answer =[
                                        'content'       => $answer_content,
                                        'is_corrected'  => $is_corrected,
                                        'question_id'   => $question_obj->id
                                    ];
                                    $this->answer->create($data_answer);
                                }
                            }    
                        }
                    }
                    DB::commit();
                } catch(\Exception $e){
                    DB::rollBack();
                    return response()->json(['error'=>Lang::get('messages.error.import')]) ;
                } 
            } else return response()->json(['error'=>Lang::get('messages.error.file.from')]);
        }
    }
}
