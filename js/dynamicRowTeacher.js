$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById("myTable");
    var corrExpr;
    var exprHead;
    
    $('#EditExpression').on('click',function(e) {
        var exprRow = exprTable.getElementsByTagName("tr");
        var expr = exprTable.getElementsByTagName("td");
        
        document.getElementById("ExprToEdit").innerHTML = expr[1].innerHTML;
        document.getElementById("ExprID").innerHTML = expr[0].innerHTML;
        $("#CorrectedExpr").val(expr[1].innerHTML);
    });
    
    $('#SubmitExpr').on('click',function(e){
        corrExpr = document.getElementById("CorrectedExpr").value;
        document.getElementById("ExpressionStatus").innerHTML='Complete';
        document.getElementById("Expression").innerHTML=corrExpr;
        $("#CorrectedExpr").val("");
    });
    
    /*$("tr").each(function(index) {
        if (index !=0) {
            $row = $(this);
            
            var id = $row.find("td:first").text();
            
            if (id.indexOf(value) != 0) {
                $(this).hide();
            } else {
                $(this).show();
            }
        }
    });*/
});
