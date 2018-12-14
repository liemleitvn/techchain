var array_cookie =[];
var array_cookie_answer =[];
var handleExamCookies = [];
var check_read_question = [];
var count_question_number;
var countDownTimer;
var _token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() {
    $('.alert').delay(2000).fadeOut();
    if($('#start').attr('href') == window.location){
        //Set time when click Start
        var time_start = $('#time_start').val()*1;
        var time_prasent = $('#time_prasent').val()*1;
        //Set time present 
        minute_of_user = Math.floor((time_prasent - time_start)/60);
        minute_of_users = Math.floor((time_prasent - time_start)%60);
        second_of_user = minute_of_users;

        //Clock
        var seconds = 60-second_of_user;
        var second = seconds;
        var minutes  = $('#time').val() - minute_of_user -1; 
        var minute = minutes ;
        var progress = ($('#time').val())*60/100;
        var width = 0; 
        var times = ((1*100)/(($('#time').val())*60*1));

        $('.start').remove();
        $('.finish-test').css('display','block');
        countDownTimer = setInterval(function(){
            time();
        },1000);
    }
    var time = function(){
        if(second == 0){
            minutes = minutes -1; minute = minutes;
            second = 59;
            seconds = second;
        } else {
            second --;seconds = second;
        }
        if(!$.cookie('width')){
            width = width + times;
        } else {
            width =parseFloat($.cookie('width')) +times;
        }

        $.cookie('width',width);

        $('#myProgress').html(Math.floor(parseInt($.cookie('width'))/1)+'%');
        $('.progress-bar').css('width',parseInt($.cookie('width')) +'%');
        
        if (seconds < 10) {seconds = "0" + seconds;}else{ seconds = second;}
        if(minutes < 10){minutes = "0" + minute; } else{ minutes =minute; }
        if(minutes == 0 && seconds == 0) {
            clearInterval(countDownTimer);
            countDownTimer = null;
        }
        $('#countdown').html(minutes+':'+seconds) ;
    }
    if(window.location.href == window.location.origin+'/user/finish'){
        $('.start').remove();
    }
    // Click start
    $('#start').click(function(){
        var origin = window.location.origin;
        var url = origin + '/user/update-start-time';
        clickStart(url);
    });
    var clickStart = function(url){
        $.ajax({
            url: url,
            type: 'POST',
            data: {'_token': _token},
            success: function(){}
        });
    }
    
    function confirmFinish(msg){
        if(window.confirm(msg)){
            return true;
        } else return false;
    }
});
