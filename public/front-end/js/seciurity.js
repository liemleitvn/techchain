
$(document).ready(function(){
    window.history.forward();
    $('textarea')
        .attr('unselectable', 'on')
        .css('-webkit-user-select', 'none')
        .css('-moz-user-select', 'none')
        .css("-ms-user-select","none")
        .css("-o-user-select","none")
        .css("user-select",'none')
        .on('selectstart', false)
        .on('mousedown', false);
    $('*').on("contextmenu",function(e){
        return false;
    });
});
// Disable f12, ctrl + shift + i ....
$(document).keydown(function (event) {
    if (event.keyCode == 123 || event.keyCode == 114 || event.keyCode == 112) {
        return false;
    } else if (
        (event.ctrlKey && event.shiftKey && event.keyCode == 73)
        || (event.ctrlKey && event.keyCode == 65)
        || (event.ctrlKey && event.keyCode == 68)
        || (event.ctrlKey && event.keyCode == 83)
        || (event.ctrlKey && event.keyCode == 85)
        || (event.ctrlKey && event.keyCode == 87)
        || (event.ctrlKey && event.keyCode == 70)
        || (event.ctrlKey && event.keyCode == 71)
        || (event.ctrlKey && event.keyCode == 79)
        || (event.ctrlKey && event.keyCode == 80)
        || (event.ctrlKey && event.keyCode == 191)
    ){     
        return false;
    }
});