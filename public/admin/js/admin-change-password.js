//Change password an admin
$(".change-is-admin").click(function(){
    var id = $(this).attr('data-id');
    var current_password = $("input[name='admin-current-password']").val();
    var new_password = $("input[name='admin-new-password']").val();
    var url = window.location.origin +"/admin/change-password/"+id;
    var data = {c_password: current_password, n_password: new_password};
    changePasswordIsAdmin(url,data);
});
var changePasswordIsAdmin = function(url,data){
    $.ajax({
        url: url,
        type: 'GET',
        data:{'data':data},
        success: function(data){
            if(data.error){
                $('.show-edit').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
            } else {
                $('.show-edit').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                $("input[name='admin-current-password']").val('');
                $("input[name='admin-new-password']").val('');
                check = check +1;
            }
            $('.show-edit').fadeIn();
            $('.show-edit').delay(1000).slideUp();
        }   
    });
}