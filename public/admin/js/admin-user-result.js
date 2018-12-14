//User result--------------------------------------
    $('#example2 tr').click(function(){
        var user_id = $(this).attr('data-id');
        var url = window.location.href + '/result';
        
        getDataResult(url,user_id);
    });

    var getDataResult = function(url,user_id){
        $.ajax({
            url: url,
            type: 'GET',
            data: {'id': user_id},
            success: function(data){
                $('.user-result').html(data);
                check = check +1;
            }
        });
    }