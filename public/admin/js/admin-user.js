// $(document).ready(function(){
    //Add User ----------------------------------------
        $("input[name='user-password']").attr('disabled','disabled');
        $(".edit-user input[name='user-email']").attr('disabled','disabled');
        //--------Add user--------//
        $('.btn-add-user').click(function(){
            var url             = window.location.href;
            var email           = $("input[name='user-email']").val();
            var password        = $("input[name='user-password']").val();
            var phone           = $("input[name='user-phone']").val();
            var address         = $("input[name='user-address']").val();
            var cv_link         = $("input[name='user-cv']").val();
            var category_id     = $("select option:selected").val();

            var data = {email:email, password:password, phone: phone, address: address, cv_link: cv_link, category_id: category_id};
            $('.btn-add-user').addClass('disablebtn');
            setTimeout(function(){
                $('.btn-add-user').removeClass('disablebtn');
            },2300);
            functionAdd(url,data);
        });
        //Edit user--------------------------------------
        $('.edit-user-account').on('click',function(){
            var user_id         = $(this).attr('data-id');
            var url             = window.location.href+'/'+ user_id;
            
            var category_id     = $(this).parent().parent().find("select option:selected").val();
            var phone           = $(this).parent().parent().find("input[name='user-phone']").val();
            var address         = $(this).parent().parent().find("input[name='user-address']").val();
            var cv_link         = $(this).parent().parent().find("input[name='user-cv']").val();
            
            var data = {phone: phone, address: address, cv_link: cv_link, category_id: category_id};
            functionEdit(url,data);
        });
        //Delete user-------------------------------------
        $('.delete-user').click(function(){
            var id = $(this).attr('data-id');
            var url = window.location.href + '/' + id;

            if(ConfirmDelete('Do you want delete?')){
                functionDelete(url,id);
            }
            return false;
        });
// });
