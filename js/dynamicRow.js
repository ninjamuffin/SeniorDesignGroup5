$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById("myTable");
    var corrExpr = document.getElementById("CorrectedExpr");
    
    $('#EditExpression').on('click',function(e) {
        var expr = exprTable.getElementsByTagName("td");
        document.getElementById("ExprToEdit").innerHTML= expr[1].innerHTML;
        document.getElementById("EditID").innerHTML= expr[0].innerHTML;
    });
    
    $('#SubmitExpr').on('click',function(e){
        document.getElementById("ExpressionStatus").innerHTML='Complete';
        document.getElementById("Expression").innerHTML=corrExpr;
    })
});
