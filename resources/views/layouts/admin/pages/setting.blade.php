@extends('layouts.admin.master',['title'=>'Setting','name_content'=>'Setting'])
@section('script')
    <script src="{{url('admin/js/admin-setting.js')}}"></script>
@stop
@section('content')
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="POST">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">STT</th>
                              <th scope="col">Name</th>
                              <th scope="col">Number of questions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php $stt=0; @endphp
                            <!--Level-->
                            @foreach($levels as $level)
                                @php $stt++; @endphp
                                <tr>
                                  <th>{{$stt}}</th>
                                  <td>{{$level->name}}</td>
                                  <td>
                                    <input type="number" value="{!! !empty($level->number_of_questions)? $level->number_of_questions : 0!!}">
                                    <i class='update' data-check='level' data-id='{{$level->id}}'>
                                        <img src="{{asset('images/update.png')}}" alt="">
                                    </i>
                                  </td>
                                </tr>
                            @endforeach
                            <!--Skill-->
                            @foreach($skills as $skill)
                                @php $stt++; @endphp
                                <tr>
                                  <th>{{$stt}}</th>
                                  <td>{{$skill->name}}</td>
                                  <td>
                                    <input type="number" value="{!! !empty($skill->number_of_questions)? $skill->number_of_questions : 0!!}">
                                    <i class='update' data-check='skill' data-id='{{$skill->id}}'>
                                        <img src="{{asset('images/update.png')}}" alt="">
                                    </i>
                                  </td>
                                </tr>
                            @endforeach
                            <!--Setting-->
                            @php $stt++; @endphp
                            <tr>
                              <th>{{$stt}}</th>
                              <td>Time</td>
                              <td>
                                <input type="number" name='setting' value="{!! !empty($setting->time)? $setting->time : 0!!}">
                                <i class='update' data-check='setting' data-id='{{$setting->id}}'>
                                    <img src="{{asset('images/update.png')}}" alt="">
                                </i>
                              </td>
                            </tr>
                            <tr>
                              <th>{{$stt}}</th>
                              <td>Paginate</td>
                              <td>
                                <input type="number" name='setting' value="{!! !empty($setting->paginate)? $setting->paginate : 0!!}">
                                <i class='update' data-check='setting' data-id='{{$setting->id}}'>
                                    <img src="{{asset('images/update.png')}}" alt="">
                                </i>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </section>
@endsection
<style>
    input{ padding-left: 5px }
    .update:hover{ cursor: pointer;}
    .update{padding-left: 20px }
</style>