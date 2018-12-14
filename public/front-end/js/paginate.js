
$(document).ready(function(){
    var question_id = [];
    var check_read = [];
    var tmp = ["1"];
    
    set_cookie();
    loadAnswerRead();
    loadAnswerCheck();

    $(".link").on("click", function(){
        var check_page = $(this).attr('page');
        var check_question_id = $(this).attr('data-id');
        var nextPage = check_page*1 + 1;
        var prevPage = check_page*1 - 1;

        nextAndPrev(nextPage, prevPage, last_page);
        
        if(check_read_question.indexOf(check_page) == -1){
            check_read_question.push(check_page);  
            $.cookie('check_read_question',JSON.stringify(check_read_question));   
        }
       
        if(question_id.indexOf(check_question_id) > -1){
           $(".pagination a[page="+check_page+"]").addClass('is_answer');
        }
        set_cookie();
        loadAnswerCheck();
        loadAnswerRead();
    });

    //function button next and prev
    function nextAndPrev(nextPage,prevPage,last_page){
        $('.next a').attr("page",nextPage);
        $('.prev a').attr("page",prevPage);
        $(".paginate-item a[page="+1+"]").addClass('read');

        if (nextPage > last_page) {
            $('.next-question .next').addClass('disablebtn');
        } else {
            $('.next-question .next').removeClass('disablebtn');
        }

        if (prevPage === 0) {
            $('.next-question .prev').addClass('disablebtn');
        } else {
            $('.next-question .prev').removeClass('disablebtn');
        }
    }

    //function load answer check
    function loadAnswerCheck(){
        $('.paginate-item a').each(function(index,value){
            var page = $(this).attr('page');
            var check_question_id = $(this).attr('data-id');

            if(question_id.indexOf(check_question_id) > -1){
               $(".paginate-item a[page="+page+"]").addClass('is_answer');
            } else $(".paginate-item a[page="+page+"]").removeClass('is_answer');
        });  
    }

    // function load answer read
    function loadAnswerRead(){
        $('.paginate-item a').each(function(index,value){
            var page = $(this).attr('page');
            if(check_read_question.indexOf(page) > -1){
                $(".paginate-item a[page="+(page)+"]").addClass('read');
            }
        });
    }

    //function set cookie
    function set_cookie(){
        question_id = [];
        $.each(array_cookie,function(index,value){
            question_id[index] = value.split("=")[0]; 
        });

        $('.pagination a').each(function(index,value){
            check_read[index] = ($(this).attr('page'));
        });

        if(check_read_question.length == 0 && !$.cookie('check_read_question')){
            check_read_question = tmp;
        }
        if(check_read_question.length >0 && $.cookie('check_read_question') != JSON.stringify(check_read_question) ){
            $.cookie('check_read_question',JSON.stringify(check_read_question));
        }

        if($.cookie('check_read_question')){
            check_read_question = JSON.parse($.cookie('check_read_question'));
        }
    }
});



