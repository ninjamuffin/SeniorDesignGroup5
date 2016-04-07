
$(function(){
    var clickValidArea = false;
    
    
    $("div[name='highlightrange']").on("click", function(e){
        
        $("div[name='highlightrange']").on('mouseup', function(e) {
            var value = (document.all) ? document.selection.createRange().text : document.getSelection();
            
            if ( (String(value).length))
                $("#expression").val(value);
        });
    });
});