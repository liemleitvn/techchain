var check =0;
var _token = $('meta[name="csrf-token"]').attr('content');
//Reload page--------------------------------------
    $(document).keyup(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '27' && check != 0) {
            location.reload();
        }
    });
    $('.close, .close-all').click(function(){
        if(check != 0){
            location.reload();
        }
    });
    $(".modal, .fade").on("hide.bs.modal", function () {
        if(check != 0){
            location.reload();
        }
    });
//function All ---------------------------------------------
    //function edit ----------------------------------------
    var functionEdit =  function(url,data){
        $.ajax({
            url: url,
            type: 'PUT',
            data:{'data':data,'_token': _token},
            success: function(data){
                if(data.error){
                    $('.show-edit').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
                } else {
                    $('.show-edit').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    check = check +1;
                }
                $('.show-edit').fadeIn();
                $('.show-edit').delay(1000).slideUp();
            }
        });
    }
    //function delete ---------------------------------------
    var functionDelete =  function(url,id){
        $.ajax({
            url: url,
            type: 'delete',
            data:{'_token': _token},
            success: function(data){
                if(data.error){
                    $('.show-notification-main').append("<p class='alert alert-danger'>"+data.error+"</p>");
                } else {
                    $('.show-notification-main').append("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    $("#example2 tbody tr[data-id="+id+"]").remove();
                }
                $('.show-notification-main').fadeIn();
                $('.show-notification-main').delay(1000).fadeOut();
                setTimeout(function(){
                    $('.show-notification-main').html('');
                },600);
            }
        });
    }
    //function add ----------------------------------------
    var functionAdd = function(url,data){
        $.ajax({
            url: url,
            type: 'POST',
            data: {'data': data,'_token': _token},
            success: function(data){
                if(data.error){
                    $('.show-add').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
                } else {
                    $('.show-add').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                    $("input[name='name-cate']").val('');
                    $("input[name='user-email'], input[name='user-phone'],input[name='user-address'], input[name='user-cv'] ").val('');
                    $("input[name='name-skill'], input[name='number-of-question']").val('');
                    $("input[name='name-level']").val('');
                    $("input[name='user-email'],input[name='user-phone'],input[name='user-address'], input[name='user-cv']").val('');
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
function ConfirmDelete(msg){
    if(window.confirm(msg)){
        return true;
    } else return false;
}