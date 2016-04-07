$(function(){
    $("#highlightrange").on('mouseup', function(e) {
        var value = (document.all) ? document.selection.createRange().text : document.getSelection();
        if (String(value).length != 0) {
            $("#expression").val(value);
        }
        
    });
});