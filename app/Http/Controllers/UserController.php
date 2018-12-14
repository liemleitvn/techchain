<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang,DB,Auth;
use Carbon\Carbon;
use App\Models\Setting;
use App\Repositories\Eloquents\AnswerRepository;
use App\Repositories\Eloquents\QuestionRepository;
use App\Repositories\Eloquents\ResultRepository;
use App\Repositories\Eloquents\LevelRepository;
use App\Repositories\Eloquents\SkillRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\CategoryRepository;
use App\Services\Mark;
class UserController extends Controller
{
    protected $question,$result,$skill,$level,$answer,$category,$mark;
    public function __construct(QuestionRepository $question,ResultRepository $result,CategoryRepository $category,
        LevelRepository $level, SkillRepository $skill,AnswerRepository $answer,UserRepository $user, Mark $mark
    ){
        $this->question     = $question;
        $this->result       = $result;
        $this->level        = $level;
        $this->skill        = $skill;
        $this->answer       = $answer;
        $this->user         = $user;
        $this->category     = $category;
        $this->mark         = $mark;
    }
    public function getIndex(Request $rq){
        return view('layouts.front-end.pages.home-wait');
    }
    public function getIndexStart(Request $rq){
        $user    = Auth::user();
        $data;
        // Get data random from database
        $data_questions = $this->getDataQuestionRandom();
            // Get data and add on database -> results
            $check_has_results = $this->result->getBy()->where('user_id',$user->id)->first();
            
            DB::beginTransaction();
            try{
            if($check_has_results == null){
                foreach($data_questions as $questions){
                    foreach($questions as $question){
                        $data = ['user_id'=>$user->id,'question_id'=>$question->id];
                        $this->result->create($data);
                    }
                }
            }
            DB::commit();
        } catch(\Exception $e){
           DB::rollBack();
           return redirect()->refresh()->with(['error'=>Lang::get('messages.error.add.database')]) ;
        }
        // Get data from database -> results
        $data = $this->getPaginate($user->id);
        $count_answer = $this->result->getBy()->where('user_id',$user->id)->count('id');
        return view('layouts.front-end.pages.home',compact('data','user','count_answer'));
    }

    public function getDataQuestionPaginate(Request $rq){
        if($rq->ajax() || 'NULL') {
            $user    = Auth::user();
            $data = $this->getPaginate($user->id);
            
            return view('layouts.front-end.layouts.content-question',compact('data'));
        }
    }
    public function getPaginate($user_id){
        $paginate = 1;
        $questions_result = $this->result->getBy()->where('user_id',$user_id)->paginate($paginate);
        $data= [
            'time_exam'         => Setting::first(),
            'questions_result'  => $questions_result,
            'question'          => $this->question->getBy()
                                                ->where('id',$questions_result[0]->question_id)
                                                ->first(),
            'answer'            => $this->answer->getBy('DESC')
                                                ->where('question_id',$questions_result[0]->question_id)
                                                ->get()
        ];
        return $data;
    }
    public function getDataQuestionRandom(){
        $user = Auth::user();
        $data_questions;

        $levels = $this->level->getAll();
        $skills_has_category = $this->skill->getBy()->where('is_can_add_category',1)->get();
        $skills_no_category = $this->skill->getBy()->where('is_can_add_category',0)->get();
        foreach($levels as $level){
            foreach($skills_has_category as $skill){
                $data_questions[] = $this->question->getQuestionBy(
                    $skill->id,
                    $user->category_id,
                    $level->id,
                    $level->number_of_questions
                );
            }
        }
        foreach($skills_no_category as $skill){
            $data_questions[] = $this->question->getQuestionBySkill($skill->id,$skill->number_of_questions);
        }
        return $data_questions;
    }

    public function addResultOfUser(Request $rq){
        $data_cookie = $rq->data_cookie;
        if(Auth::check() && count($data_cookie) > 0){
            $user = Auth::user();
            $data_question_id;
            $data_answer_id;
            DB::beginTransaction();
            try{
                foreach($data_cookie as $cookie){
                    $tmp = explode('=', $cookie);
                    $cookie_question_id = str_replace('question','',$tmp[0]);
                    $cookie_answer_id   = "[".$tmp[1]."]";
                    $data = ['answer_ids'=>$cookie_answer_id];

                    $this->result->query()->where('user_id',$user->id)
                                          ->where('question_id',$cookie_question_id)
                                          ->update($data);
                }
                DB::commit();
            } catch(\Exception $e){
               DB::rollBack();
               return redirect()->refresh()->with(['error'=>Lang::get('messages.error.add.database')]) ;
            }
        }   
    }

    public function finish(){
        // function mark point, question true
        $user   = Auth::user();
        $data_of_user = $this->mark->execute($user->id);
        
        $count_question_number_true = 0;
        $count_answer_number = $this->result->query()->where('user_id',$user->id)->count('id');

        if(count($data_of_user) > 0){
            $count_question_number_true = count($data_of_user['data_question_true_id']);
        }

        $this->disableAccount();
        return view('layouts.front-end.pages.finish',compact('count_question_number_true','count_answer_number'));
    }

    public function disableAccount(){
        $user    = Auth::user();
        $data_update=['is_disable'=>config('constant.disable')];
        $this->user->update($user->id,$data_update);
        return true;
    }

    public function finishCloseAccount(){
        if(Auth::check())
            Auth::logout();
        return redirect('/');
    }

    public function updateStartTime(){
        $user    = Auth::user();
        $now = Carbon::now("Asia/Ho_Chi_Minh");
        $data = ['start_time'=> $now];

        DB::beginTransaction();
        try{
            $this->user->update($user->id, $data);
            DB::commit();
        } catch(\Exception $e){
           DB::rollBack();
        }
    }

    public function updateEndTime(){
        $user    = Auth::user();
        $now = Carbon::now("Asia/Ho_Chi_Minh");
        $data = ['end_time'=> $now];
        DB::beginTransaction();
        
        try{
            $this->user->update($user->id, $data);
            DB::commit();
        } catch(\Exception $e){
           DB::rollBack();
           return response()->json(['error'=>Lang::get('messages.exam.error.finish')]) ;
        }
    }
}
