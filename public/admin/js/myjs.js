
//---- Tuong tac Menu
$(document).ready(function(){
    $('.btn-add-answer-add').click(function(){
        $('.question-add').append("<div class='answer'><input type='text' name='content-answer' class='form-control ip-answer' placeholder='Enter Answer'><i class='fa fa-times correct-delete'></i><input class='correct' type='checkbox'></div>");
    });
    $('.btn-add-answer-edit').click(function(){
        $('.question-edit').append("<div class='answer-edit-new'><input type='text' name='content-answer-edit-new' class='form-control ip-answer' placeholder='Enter Answer'><i class='fa fa-times correct-delete'></i><input class='correct-edit-new' type='checkbox'></div>");
    });
    deleteAnswer();
});

var deleteAnswer = function(){
    $(document).on("click", ".correct-delete" , function() {
        $(this).parent().remove();
    });
};
 
jQuery(function ($) {
    var path = window.location.pathname;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);
    url = window.location.origin +path ;

    $(".sidebar-menu li").click(function () {
        var href = $(this).children('a').attr('href');
    });
    $(".sidebar-menu li").each(function () {
        var hrefs = $(this).children('a').attr('href');
        if (url == hrefs) {
            $(".sidebar-menu li").removeClass('active');
            $(this).addClass('active').parents('li').addClass('active');
        };
    });
});

$('.alert').delay(3000).fadeOut();
