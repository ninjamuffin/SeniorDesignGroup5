
$(function(){
    var clickValidArea = false;
    
    
    $("div[name='highlightrange']").on("click", function(e){
        
        $("div[name='highlightrange']").on('mouseup', function(e) {
            var value = (document.all) ? document.selection.createRange().text : document.getSelection();
            var expressionid = $(this).closest("td").find("input[name='expressionid']").val();
            var expressionnumber = $(this).closest("td").find("input[name='expressionnumber']").val();
            
            if ( (String(value).length))
            {
                $("#editorexpression").val(value);
                $("#editorexpressionid").val(expressionid);
                $("#editorexpressionnumber").empty();
                $("#editorexpressionnumber").append(expressionnumber);
            }
                
            
        });
    });
});