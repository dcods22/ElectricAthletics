$('textarea').autogrow();

$(function() {
    $( document ).tooltip();
});

$('.navbar-nav a').on('click', function(){
    $('.navbar-collapse').removeClass('collapse in').addClass('collapsing').removeClass('collapsing').addClass('collapse');
});