//Setting------------------------------------------
    $('.update').click(function(){
        var number_question = $(this).parent().find("input[type='number']").val();
        var id      = $(this).attr('data-id');
        var check   = $(this).attr('data-check'); 
        var url     = window.location.href +'/'+id;
        var data_setting =[];
        if(check == 'setting'){
            $("input[name='setting']").each(function(){
                data_setting.push($(this).val());
            });
        }
        
        var data = {
            id:id, check:check, number_question: number_question, data_setting:data_setting
        }
        updateSetting(url,data);
    });
    var updateSetting = function(url,data){
        $.ajax({
            url: url,
            type: 'GET',
            data: {'data':data},
            success: function(data){
                if(data.error){
                    $('.show-notification-main').html("<p class='alert alert-danger'><i class='fa fa-exclamation'></i>"+data.error+"</p>");
                } else {
                    $('.show-notification-main').html("<p class='alert alert-success'><i class='fa fa-check'</i>"+data.success+"</p>");
                }
                $('.show-notification-main').fadeIn();
                $('.show-notification-main').delay(1500).slideUp();
            }
        });
    }