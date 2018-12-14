//Add quick question---------------------------------
    $(document).ready(function () {
        var question = "";
        var content_answers = [];
        var check_answers = [];

        function previewQuestion () {
            $('#show-preview-question').empty();
            var content_question = $('#txt-content-question').val();
            var lines = content_question.split('\n');

            question = lines[0];

            var html = '<label>Question preview</label>' +
                '<p>' + lines[0] + '</p>';

            for (var i = 1; i < lines.length; i++) {
                check_answers[i-1] =0;
                html += '<label style="cursor: pointer; font-weight: normal"> ' +
                    '<input type="checkbox" value="'+lines[i]+'" name="answer" class="answer-checkbox" data-id="'+(i-1)+'">\n'
                     + lines[i] +
                    '</label>' +
                    '<br>';
            }

            $('#show-preview-question').append(html);

            $('.answer-checkbox').click(function() {
                check_answers[$(this).attr('data-id')] = ($(this).prop('checked')) ? 1 : 0;
            });

        }

        //onclick preview button
        $('#btn-preview-question').on('click', function (event) {
            previewQuestion();
        });

        //get content answer
        function getContentAnswer() {
            content_answers = [];
            if(!$("input[name='answer']").length) {
                previewQuestion();
            }
            var answer = $("input[name='answer']");
            if(content_answers.length === 0) {
                answer.map(function ( index, input) {
                    content_answers.push(input.value);
                });
            }
            return content_answers;
        }

        $('.btn-add-quick-insert-question').on('click', function (event) {
            content_answers = getContentAnswer();

            var origin          = window.location.origin;
            var url             = origin +'/admin/question/'+question;
            var level_id        = $("#select-level option:selected").val();
            var category_id     = $("#select-cate option:selected").val();
            var skill_id        = $("#select-skill option:selected").val();

            //validation content question
            if(question === "") {
                var htmlErr = "<p class='alert alert-danger'>" +
                    "<i class='fa fa-exclamation'>" +
                    "</i>Please input content question and content answer before click Add" +
                    "</p>";
                $('.question-notification').html(htmlErr);
                return;
            }

            //validation content answer
            if(content_answers.length === 0) {
                var htmlErr = "<p class='alert alert-danger'>" +
                    "<i class='fa fa-exclamation'>" +
                    "</i>Please input content question and content answer before click Add" +
                    "</p>";

                $('.question-notification').html(htmlErr);
                return;
            }

            //validation checked answer
            var flagCheckAnswer = false;
            for (var i = 0; i< check_answers.length; i++) {
                if(check_answers[i] === 1) {
                    flagCheckAnswer = true;
                    break;
                }
            }
            if(!flagCheckAnswer) {
                var htmlErr = "<p class='alert alert-danger'>" +
                    "<i class='fa fa-exclamation'>" +
                    "</i>Please select correct answer before click Add" +
                    "</p>";
                $('.question-notification').html(htmlErr);
                return;
            }

            var data = {
                level_id:level_id,
                content_question:question,
                content_answer:content_answers,
                check_answer:check_answers,
                skill_id:skill_id,
                category_id:category_id
            };
            addQuestions(url,data,category_id);
        })
    });
//Add question-------------------------------------
    var name_question   = $("input[name='name-question']").val();
    var skill_id = $("input[name='skill_id']").val();
    $('.btn-add-question').click(function(){
        var origin          = window.location.origin;
        var url             = origin +'/admin/question/'+name_question;
        // var content_question= $("input[name='content-question']").val();
        var content_question= $(".content-question").val();
        var level_id        = $(".select-level option:selected").val();
        var category_id     = $(".select-cate option:selected").val();
        var skill_id        = $(".select-skill option:selected").val();

        var check_answer =[];
        var content_answer =[];
        $.each($(".answer"),function(){
            if($(this).find('.correct').is(':checked')){
                check_answer.push(1);
            }else {check_answer.push(0);}
        });
        $.each($("input[name='content-answer']"),function(){
            content_answer.push(this.value);
        });

        var data = {level_id:level_id,content_question:content_question, content_answer:content_answer,
            check_answer:check_answer, skill_id:skill_id, category_id:category_id
        }
        addQuestions(url,data,category_id);
    });
    //Delete question----------------------------------------
    $('.delete-question').click(function(){
        var id = $(this).attr('data-id');
        var href = window.location.href;
        var url = origin +'/admin/question/'+name_question+'/'+id;

        if(ConfirmDelete('Do you want delete?')){
            deleteQuestions(url,id);
        }
    });
    //Edit question----------------------------------------
    $('.edit-question').click(function(){
        var content_question= $(this).parent().parent().find(".content-question-edit").val();
        var question_id     = $(this).attr('data-id-question');
        var level_id        = $(this).parent().parent().find(".select-level-edit option:selected").val();
        var skill_id        = $(this).parent().parent().find(".select-skill-edit option:selected").val();
        var category_id     = $(this).parent().parent().find(".select-cate-edit option:selected").val();
        var origin          = window.location.origin;
        var url             = origin + '/admin/question/'+ name_question+'/'+ question_id;

        var check_answer        = [];
        var content_answer      = [];
        var answer_id           = [];
        var content_answer_new  = [];
        var check_answer_new    = [];

        // Get info answer current
        $.each($(this).parent().parent().find(".answer-edit"),function(){
            if($(this).find('.correct-edit').is(':checked')){
                check_answer.push(1);
            }else {check_answer.push(0);}
        });

        $.each($(this).parent().parent().find("input[name='content-answer-edit']"),function(){
            content_answer.push(this.value);
            answer_id.push(this.dataset);
        });

        // Get info answer new
        $.each($(this).parent().parent().find(".answer-edit-new"),function(){
            if($(this).find('.correct-edit-new').is(':checked')){
                check_answer_new.push(1);
            }else {check_answer_new.push(0);}
        });
        $.each($(this).parent().parent().find("input[name='content-answer-edit-new']"),function(){
            content_answer_new.push(this.value);
        });
        var data = {question_id:question_id, level_id: level_id, content_question: content_question, 
            content_answer: content_answer, check_answer: check_answer, name_question: name_question,
            skill_id: skill_id, answer_id: answer_id, category_id: category_id, content_answer_new: content_answer_new,
            check_answer_new: check_answer_new
        }
        editQuestion(url,data,content_answer,content_answer_new,category_id);
    });
    //Delete answer----------------------------------------
    $('.correct-delete').click(function(){
        var answer_id   = $(this).attr('data-id-answer');
        var origin      = window.location.origin;
        var url         = origin + '/admin/answer/delete/' + answer_id;
        
        deleteAnswers(url,answer_id);
    })
//function add question----------------------------
    var addQuestions = function(url,data,category_id){
        $.ajax({
            url: url,
            type: 'POST',
            data:{'data':data, 'category_id':category_id,'_token':_token},
            success: function(data){
                if(data.error){
                    $('.question-notification').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
                } else {
                    $('.question-notification').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    $("input[name='content-question']").val('');
                    $('.question-add .answer').remove();
                    $('.content-question').val('');
                    check = check +1;
                }
                $('.question-notification').fadeIn();
                $('.question-notification').delay(1000).slideUp();
            }
        });
    }
    //function delete question----------------------------------------
    var deleteQuestions =  function(url,id){
        $.ajax({
            url: url,
            type: 'delete',
            data:{'id': id,'_token':_token},
            success: function(data){
                if(data.error){
                    $('.show-notification-main').append("<p class='alert alert-danger'>"+data.error+"</p>");
                } else {
                    $('.show-notification-main').append("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    $('#example2 tbody tr[data-id='+id+']').remove();
                }
                $('.show-notification-main').fadeIn();
                $('.show-notification-main').delay(1000).fadeOut();
                setTimeout(function(){
                    $('.show-notification-main').html('');
                },600);
            }
        });
    }
    
    //function edit question----------------------------------------
    var editQuestion =  function(url,data,content_answer,content_answer_new,category_id){
        $.ajax({
            url: url,
            type: 'POST',
            data:{
                'data':data, 'content_answer':content_answer,
                'content_answer_new': content_answer_new,
                'category_id': category_id,
                '_token': _token
            },
            success: function(data){
                if(data.error){
                    $('.show-question-edit').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
                } else {
                    $('.show-question-edit').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    check = check +1;
                }
                $('.show-question-edit').fadeIn();
                $('.show-question-edit').delay(1000).slideUp();
            }
        });
    }
    // Delete answer
    var deleteAnswers = function(url,answer_id){
        $.ajax({
            url: url,
            type: 'GET',
            data:{'answer_id': answer_id,'_token': _token},
            success: function(data){
                if(data.error){
                    $('.show-question-edit').html("<p class='alert alert-danger'>"+data.error+"</p>");
                } else {
                    $('.show-question-edit').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    $(".answer-edit input[data-id-answer="+answer_id+"]").parent().remove();
                    check = check +1;
                }
                $('.show-question-edit').fadeIn();
                $('.show-question-edit').delay(1000).fadeOut();
            }
        });
    }
