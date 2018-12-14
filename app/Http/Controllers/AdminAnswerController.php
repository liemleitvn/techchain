<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use App\Models\Answer;
use App\Repositories\Eloquents\AnswerRepository;
class AdminAnswerController extends Controller
{
    protected $answer;
    public function __construct(AnswerRepository $answer){
     $this->answer = $answer;
    }
  public function deleteAnswer(Request $rq){
      if(Answer::find($rq->answer_id)){
         $id = $rq->answer_id;
         $this->answer->delete($id);
         return response()->json(['success'=>Lang::get('messages.success.delete')]) ;
      } else return response()->json(['error'=>Lang::get('messages.error.delete')]) ;
  }
}
