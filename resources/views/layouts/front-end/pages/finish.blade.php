@extends('layouts.front-end.master')
@section('content')
    <section class='show-finish'>
        <h3>WELLCOME to <strong class='color'>TechChain Software</strong></br></h3></br>
        <h4>Thank {{Auth::user()->email}} for doing the exam!</h4>
        <ul>
            <li>Answered true: <strong>{{$count_question_number_true}} / {{$count_answer_number}}</strong></li>
            <li>We will look a result and contact for you after!</li>
        </ul>
    </section>
    <section class='btn-save-result'>
        <button  class="btn-save btn btn-primary"> Save result of You!</button>
    </section>
    
    <style>
        .show-finish{ width: 37%;margin: 40px auto;}
        .btn-save { padding: 20px !important; }
        .start{ display: none}
        .btn-save-result { width: 13%; margin: 0px auto; }
        h3 > strong { color: #0779fa;}
        section {overflow-y: hidden !important;}   
    </style>
@endsection
