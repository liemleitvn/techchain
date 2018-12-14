<?php
namespace App\Services;

use Illuminate\Http\Request;

use App\Repositories\Eloquents\AnswerRepository;
use App\Repositories\Eloquents\ResultRepository;
class Mark
{   
    protected $result,$answer;
    public function __construct(ResultRepository $result, AnswerRepository $answer){
        $this->result = $result;
        $this->answer = $answer;
    }
    public function execute ($user_id){
        $count_question_number_true =0;
        $data =[];
        $data_question_true_id =[];

        $data_results = $this->result->getBy()->where('user_id',$user_id)->get();
       
        foreach($data_results as $data_questions){
            // get array question id
            $question_ids[] = $data_questions->question_id;
        }

        foreach($question_ids as $id){
            // get data answer in table answers 
            $data_answer_from_answers = $this->answer->getBy('ASC')->where('question_id',$id)
                                                             ->where('is_corrected',1)
                                                             ->get();
            // get data answer in table results 
            $data_answer_from_results = $this->result->getBy()->where('question_id',$id)
                                                             ->where('user_id',$user_id)
                                                             ->get();
            $answer_id_true=[];
            foreach($data_answer_from_answers as $item){
                $answer_id_true[] = $item['id'];
                $data_answer_id_true = implode(',', $answer_id_true);
            }

            $answer_id_from_answers = '['.$data_answer_id_true.']';
            $answer_id_from_results = $data_answer_from_results[0]->answer_ids;

            if($answer_id_from_answers == $answer_id_from_results){
                $count_question_number_true ++;
                $data_question_true_id[]=$id;
            }
        }
        if($data_question_true_id!=null){
            $data = [
               'data_question_true_id'     =>$data_question_true_id,
               'count_question_number_true'=>$count_question_number_true,
            ];
        }
       
       return $data;
    }
}