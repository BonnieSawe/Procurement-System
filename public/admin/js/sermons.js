$(function(){
    var activeElementId;
    $(".youtube-link").keyup(function(){
        activeElementId = $(this).attr('id');
        var input = $(this).val();
        var videoId = getId(input);
        var embedLink = 'https://www.youtube.com/embed/'+videoId;
        $(this).val(embedLink);
    });
});
function getId(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}