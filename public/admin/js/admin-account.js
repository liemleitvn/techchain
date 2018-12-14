//Account admin------------------------------------
$(".email-admin, .role-admin").attr('disabled','disabled');
//Add account--------------
$(".btn-add-admin").click(function(){
    var email    = $("input[name='admin-email']").val();
    var password = $("input[name='admin-password']").val();
    var url      = window.location.href;
    var data = {email, password,};
    addAdmin(url,data);
});

//Delete account---------------
$(".delete-acc-admin").click(function(){
    var id = $(this).attr('data-id');
    var url = window.location.href +'/'+ id;
    if(ConfirmDelete('Do you want delete?')){
        functionDelete(url,id);
    }
    return false;
});
//Edit account-----------------
$(".btn-edit-acc-admin").click(function(){
    var id = $(this).attr('data-id');
    var url = window.location.href +'/'+ id;
    var password = $("input[name='admin-password-edit']").val();
    var data = { password: password};

    functionEdit(url,data);
});
var addAdmin = function(url,data){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: url,
        type: 'POST',
        data: data,
        success: function(data){
            if(data.error){
                $('.show-add').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
            } else {
                $('.show-add').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                $("input[name='admin-email'], input[name='admin-password']").val('');
                check = check +1;
            }
            $('.show-add').fadeIn();
            $('.show-add').delay(1500).slideUp();
        },
        error: function(data) {
            var errors = data.responseJSON['errors'];
            for(error in errors){
                $('.show-add').append("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+errors[error]+"</p>");
                $('.show-add').fadeIn();
                $('.btn-add-admin').addClass('disablebtn');
                setTimeout(function(){
                    $('.show-add').html('');
                    $('.btn-add-admin').removeClass('disablebtn');
                },1500)
                
                $('.show-add').delay(1500).fadeOut();
            }
        }
    });
}