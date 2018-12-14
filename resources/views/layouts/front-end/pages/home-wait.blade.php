@extends('layouts.front-end.master')
@section('content')
<section class='guide'>
    @if(Session::has('error'))
        <div class='alert alert-danger'>
            {{session('error')}}
        </div>
    @endif
    <h3>WELLCOME to <strong class='color'>TechChain Software</strong></br></h3></br>
    <h4>Exam guide:</h4>
    <ul>
        <li>The exam consists of 25 questions</li>
        <li>30 mins for the exam</li>
        <li>If the time runs out the system will self-closing and mark</li>
    </ul>
</section>
<style>
    section{ overflow: hidden !important }
</style>
@endsection