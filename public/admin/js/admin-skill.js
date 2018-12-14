//Add skill----------------------------------------
    $('.btn-add-skill').click(function(){
        var name_skill      = $("input[name='name-skill']").val();
        var number_question = $("input[name='number-of-question']").val();
        var rdio_check      = $("input[name='customRadio']:checked").val();
        var url             = window.location.href;
        var data = {name_skill: name_skill, number_question: number_question, rdio_check: rdio_check};

        $('.btn-add-skill').addClass('disablebtn');
        setTimeout(function(){
            $('.btn-add-skill').removeClass('disablebtn');
        },2300);
        functionAdd(url,data);
    });

    // Delete skill----------------------------------------
    $('.delete-skill').click(function(){
        var id = $(this).attr('data-id');
        var url =window.location.href+ '/' + id;

        if(ConfirmDelete('Do you want delete?')){
            functionDelete(url,id);
        }
        return false;
    });
    // Edit skill----------------------------------------
    $('.edit-skill').click(function(){
        var id              = $(this).attr('data-id');
        var url             = window.location.href+'/'+ id;
        var name_skill_edit = $(this).parent().parent().find("input[name='name-skill-edit']").val();
        var number_question = $(this).parent().parent().find("input[name='number-of-question']").val();
        var rdio_check      = $(this).parent().parent().find("input[type='radio']:checked").val();
        var data = {name_skill_edit: name_skill_edit, number_question: number_question, rdio_check: rdio_check}; 

        functionEdit(url,data);
    });