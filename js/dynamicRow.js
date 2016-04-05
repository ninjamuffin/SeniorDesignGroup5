$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById("myTable");
    var corrExpr;
    
    $('#EditExpression').on('click',function(e) {
        var expr = exprTable.getElementsByTagName("td");
        document.getElementById("ExprToEdit").innerHTML= expr[1].innerHTML;
        document.getElementById("EditID").innerHTML= expr[0].innerHTML;
        document.getElementById("Expression").innerHTML=expr[1].innerHTML;
        $("#CorrectedExpr").val(expr[1].innerHTML);
    });
    
    $('#SubmitExpr').on('click',function(e){
        corrExpr = document.getElementById("CorrectedExpr").value;
        document.getElementById("ExpressionStatus").innerHTML='Complete';
        document.getElementById("Expression").innerHTML=corrExpr;
        $("#CorrectedExpr").val("");
    })
});
