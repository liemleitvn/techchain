//Add category-------------------------------------
    //Edit category----------------------------------------
    $('.edit-category').click(function(){
        var name_category   = $(this).parent().parent().find("input[name='name-category-edit']").val();
        var id              = $(this).attr('data-id');
        var skill_id        = $(this).parent().parent().find(".option-edit option:selected").val();
        var url             = window.location.href +'/'+ id;
        var data = {skill_id: skill_id, name_category: name_category};
        
        functionEdit(url,data);
    })
    //Delete category----------------------------------------
    $('.delete-category').click(function(){
        var id = $(this).attr('data-id');
        var origin = window.location.origin;
        var url = window.location.href +'/'+id;

        if(ConfirmDelete('Do you want delete?')){
            functionDelete(url,id);
        }
        return false;
    });
    //Edit category----------------------------------------
    $('.btn-add-category').click(function(){
        var name_category   = $("input[name='name-cate']").val();
        var skill_id        = $("select option:selected").val();
        var url             = window.location.href;
        var data = {skill_id: skill_id, name_category:name_category};
        $('.btn-add-category').addClass('disablebtn');
        setTimeout(function(){
            $('.btn-add-category').removeClass('disablebtn');
        },2300);

        functionAdd(url,data);
    });