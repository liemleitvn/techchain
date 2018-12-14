
$(document).ready(function(){
    var answer_id;
    var question_id;

    var finish = setInterval(function(){
        if(countDownTimer == null){
            set_cookie_question();
            var url_end_time= origin + '/user/update-end-time';
            clickEndTime(url_end_time); 
        }
    },1000);
    if(countDownTimer == null){
        clearInterval(finish);
    }
    
    if(array_cookie.length >0 && $.cookie('array_cookie') != JSON.stringify(array_cookie) ){
        $.cookie('array_cookie',JSON.stringify(array_cookie));
    }
    if($.cookie('array_cookie')){
        array_cookie = JSON.parse($.cookie('array_cookie'));
    }
    loadAnswered();
    autoHeightTexarea();
    autoHeightContentExam();

    $( ".content-question" ).on( "click", ".content input[type='checkbox']", function() {
        var answer_id_checkbox = $(this).attr('data-id-answer');
        if($(this).is(":checked")){
            array_cookie_answer.push(answer_id_checkbox);
        } else {
            for(i=0; i < array_cookie_answer.length; i++){
                if(array_cookie_answer[i].split('=')[0] == answer_id_checkbox){
                    array_cookie_answer.splice(i, 1);
                }
            }
        }
        if(array_cookie_answer.length > 0){
            $.cookie('array_cookie_answer',JSON.stringify(array_cookie_answer));
        } else {
            $.removeCookie('array_cookie_answer');
        }
    });

    // Add cookie in array cookie
    $(".link, .finish").on("click", function(){
        set_cookie_question();
    });

    $('#countquestion').html(array_cookie.length);
    
    // CLick get data cookie
    $('.section').on('click','.finish',function(){
        var url_end_time= origin + '/user/update-end-time';
        $(".true").on('click',function(){
           clickEndTime(url_end_time);
        });
    });
    // Click finis or Clock 00:00
    var clickFinish = function(){
        var data_cookie = array_cookie; 
        var user_id     = $(this).attr('data-user-id');
        var origin      = window.location.origin;
        var url         = origin +'/user/add-result-of-user';
        var url_finish  = origin +'/finish-close-account';
        var finish      = origin +'/finish';
        var url_end_time= origin + '/user/update-end-time';
        
        clearInterval(countDownTimer);

        $('.finish, .next, .prev').addClass('disablebtn');
        $('*').css('cursor','wait');

        if(data_cookie.length > 0){
            postDataCookie(url,user_id,data_cookie);
        }
        window.location = finish;
        deleteAllCookie();
    }
    //Click update end time
    var clickEndTime = function(url_end_time){
        $.ajax({
            url: url_end_time,
            type: 'POST',
            data: {'_token':_token},
            success: function(data){
                if(!data.error){
                    clickFinish();
                } else {
                    $('.error').html("<p class='alert alert-danger'>"+data.error+"</p>");
                    $('.error').show();
                    $('.finish').addClass('disablebtn');
                    setTimeout(function(){
                        $('.error').fadeOut();
                        $('.finish').removeClass('disablebtn');
                        $('.error').html('');
                    },2000)
                } 
            }
        });
    }

    var set_cookie_question = function(){
        var check_answer = [];
        $(".content input[type='checkbox']").each(function(){
            answer_id = $(this).attr('data-id-answer');
            question_id = $(this).attr('data-id-question');

            if($(this).is(':checked')){
                check_answer.push(answer_id);
            }
        });
        if(check_answer.length >0  ){
            for(i=0; i < array_cookie.length; i++){
                if(array_cookie[i].split('=')[0] == question_id){
                    array_cookie.splice(i,1);
                }
            }
            array_cookie.push(question_id+'='+check_answer);
        } else {
            for(i=0; i < array_cookie.length; i++){
                if(array_cookie[i].split('=')[0] == question_id && array_cookie.length >1 ){
                    array_cookie.splice(i, 1);
                } else if(array_cookie.length ==1 && question_id == array_cookie[i].split('=')[0]){
                    array_cookie.shift();
                    $.removeCookie('array_cookie');
                }
            }
        }
        $.cookie('array_cookie',JSON.stringify(array_cookie));

        $('#countquestion').html(array_cookie.length);
    }
    // function post data cookie -> controller
    var postDataCookie = function(url,user_id,data_cookie){
        $.ajax({
            url: url,
            type: 'POST',
            data: {'data_cookie': data_cookie, 'user_id': user_id,'_token':_token},
            success: function(data){}
        });
    };
    // Logout, disable account
    var finishExam = function(url){
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data){
            },
        });
    }
    $('.btn-save').click(function(){
        var origin  = window.location.origin;
        var url     = origin +'/user/finish-close-account';
        finishExam(url);
        $(this).addClass('disablebtn');
        $('*').css('cursor','wait');
        
        window.location = window.origin;
    })

    $('.link').click( function(e){
        e.preventDefault();
        var page = parseInt($(this).attr('page')); 
        var origin = window.location.origin;
        var pathname = window.location.pathname;
        var url =origin+'/user/question?page='+page;
        
        $('.paginate-item a').removeClass('is_active');
        $(".paginate-item a[page="+page+"]").addClass('is_active');
        $(".paginate-item a[page="+(page)+"]").addClass('read');

        getPosts(url,page);
        return false;
    });

    function disableTextarea(){
        $('textarea')
            .attr('unselectable', 'on')
            .css('-webkit-user-select', 'none')
            .css('-moz-user-select', 'none')
            .css("-ms-user-select","none")
            .css("-o-user-select","none")
            .css("user-select",'none')
            .on('selectstart', false)
            .on('mousedown', false);
    }

    function autosize(textarea) {
        $(textarea).height(1); 
        $(textarea).height($(textarea).prop("scrollHeight"));
    }

    function autoHeightContentExam(){
        var maxHeight         = $(window).height();
        var heightContentExam = maxHeight - 220;

        $(".show-content-exam").css('height',heightContentExam);
    }

    function getPosts(url,page){
       $.ajax({
            url: url,
            type: "GET",
            success: function(data) {
                $('.content-question').html(data);

                loadAnswered();
                disableTextarea();

                $(".content .indexof-question").html(page);
                autoHeightTexarea();
                autoHeightContentExam();
            }
        });
    }
    function autoHeightTexarea(){
        $(document).on("input", "textarea", function() {
            autosize(this);
        });
        $("textarea").each(function () {
            autosize(this);
        });
    }
    function confirmFinish(msg){
        if(window.confirm(msg)){
            return true;
        } else return false;
    }
    function deleteAllCookie(){
        var cookies = $.cookie();
        for(var cookie in cookies) {
           $.removeCookie(cookie);
        }
    }
});

// Show answered of user
function loadAnswered(){
    if($.cookie('array_cookie_answer')){
        array_cookie_answer = JSON.parse($.cookie('array_cookie_answer'));
        $(".content input[type='checkbox']").each(function(){
            var answer_is_check = $(this).attr('data-id-answer');
            for(i=0; i < array_cookie_answer.length; i++){
                if(answer_is_check == parseInt(array_cookie_answer[i])){
                    $(this).attr('checked','checked');
                }
            }
        });
    }
}