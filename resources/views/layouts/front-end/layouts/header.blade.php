<header>
    <div class="logo"><img src="{{asset('images/techchainlogo.png')}}" alt=""></div>
    <div class="clock col-md-3">
        <div class='show-time'>
            <input id ='time' type="hidden" value="{{$time_exam->time}}">
            <input id='time_prasent' type="hidden" value="{{Carbon\Carbon::now()->timestamp + 25200}}">
            <input id ='time_start' type="hidden" value="{{Carbon\Carbon::createFromTimeStamp(strtotime($auth_user->start_time))->timestamp}}">
            <div class="clock-img"><img src="{{asset('images/clock.png')}}" alt=""></div>
            <div class="time">
                <span id='countdown'>00:00</span>
                <div class="prog"><span id='myProgress'>0%</span>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                </div>
            </div>
            <div class="count-question">
                <label for="">Question: &nbsp;</label>
                <span id='countquestion'> 0 </span> / {{!empty($count_answer)? $count_answer : 0}}</div>
        </div>
    </div>
    <div class="col-md-4 info-user">
        <img src="{{asset('images/user.png')}}" alt="">
        <label for=""><strong>Hi!</strong> <strong class='color-name'>{{$auth_user->email}}</strong> - <strong>Skill:</strong> <strong class='color-name'>{{$category_id_of_user->name}}</strong> </label>
    </div>
    <div class=" start"><a href='{{route('userStart')}}' class="btn btn-primary" id='start'>Start</a></div>
</header>