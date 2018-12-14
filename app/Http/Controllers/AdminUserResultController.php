<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\CategoryRepository;
use App\Repositories\Eloquents\ResultRepository;
use App\Repositories\Eloquents\QuestionRepository;
use App\Repositories\Eloquents\SkillRepository;
use App\Repositories\Eloquents\AnswerRepository;
use App\Services\Mark;
class AdminUserResultController extends UserController
{
    protected $user,$result,$category,$question,$skill,$mark;
    public function __construct(UserRepository $user,ResultRepository $result, CategoryRepository $category, QuestionRepository $question,SkillRepository $skill, AnswerRepository $answer, Mark $mark){
        $this->user     = $user;
        $this->result   = $result;
        $this->category = $category;
        $this->question = $question;
        $this->skill    = $skill;
        $this->answer   = $answer;
        $this->mark     = $mark;
    }

    public function index(){
        $paginate   = 10;
        $categories = $this->category->getAll();
        $skills     = $this->skill->getAll();
        $users      = $this->user->getBy()->paginate($paginate);

        return view('layouts.admin.pages.user-result',compact('skills','users','categories'));
    }

    public function result(Request $rq){
        $user_id   = $rq->id;
        $questions = $this->question->getAll();
        $check     = $this->result->getBy()->where('user_id',$user_id)->first();
        $question_number = count($this->result->getBy()->where('user_id',$user_id)->get());

        $data_result =[];

        if(!empty($check)){
            $data_result = $this->mark->execute($user_id);
        }
       
        $results    = $this->result->getBy()->where('user_id',$user_id)->get();

        foreach ($results as $key=>$result) {
            $content = $this->question->getBy()->where('id',$result->question_id)->first();
            $data[$key] = [
                'content' => $content['content'],
                'answers' => $this->answer->getBy('DESC')->where('question_id',$result->question_id)->get(),
                'results' => $this->result->getBy()
                                        ->where('question_id',$result->question_id)
                                        ->where('user_id', $user_id)
                                        ->first()
            ];
        }
        return view('layouts.admin.pages.user-result-data',compact('data', 'question_number','data_result'));
    }
}
