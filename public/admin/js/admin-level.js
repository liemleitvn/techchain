
//Add level----------------------------------------
$('#btn-add-level').click(function(){
    var name_level = $("input[name='name-level']").val();
    var url = window.location.href ;

    $('#btn-add-level').addClass('disablebtn');
    setTimeout(function(){
        $('#btn-add-level').removeClass('disablebtn');
    },2300);
    functionAdd(url,name_level);
}); 
// Delete level----------------------------------------
$('.delete-level').click(function(){
    var id = $(this).attr('data-id');
    var url = window.location.href +'/'+ id;

    if(ConfirmDelete('Do you want delete?')){
        functionDelete(url,id);
    }
    return false;
});
// Edit level----------------------------------------
$('.edit-level').click(function(){
    var id = $(this).attr('data-id');
    var url =window.location.href + '/' + id;
    var name_level_edit = $(this).parent().parent().find("input[name='edit-level']").val();
    
    functionEdit(url,name_level_edit);
});