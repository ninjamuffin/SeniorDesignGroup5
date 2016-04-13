$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById('myTable');
    var expr;
    var rowIndex;
    var exprHead;
    
    $(".btn").on('click',function(e) {
        var $row = $(this).closest("tr");
        rowIndex = $row.find(".nr").text();
        expr = $row.find(".expr").text();
        
        document.getElementById("ExprToEdit").innerHTML = expr;
        document.getElementById("ExprID").innerHTML = "- Working on Expression: #" + rowIndex;
    });
    
    $('#SubmitExpr').on('click',function(e){
        e.preventDefault();
        
        var row = document.getElementsByTagName("tr");
        var cell = row.getElementsbyTagName("td");
        
        var corrExpr = document.getElementById("CorrectedExpr").value;
        
        document.getElementById("ExpressionStatus").innerHTML = "Correct";
        
        document.getElementById("myTable").rows[rowIndex].cell(3) = corrExpr;
        
        $("#CorrectedExpr").empty();
        
    });
    
    $(document).on('click', "button[name='SelectExpression']", function(e){
        var expressionid = $(this).closest("form").find("input[name=expressionID]").val();
        var worksheetid = $(this).closest("form").find("input[name=worksheetID]").val();
        var courseid = $(this).closest("form").find("input[name=courseID]").val();
        var newexpressionnumber = $(this).closest("form").find("input[name=newexpressionnumber]").val();
        $.ajax({
            type: "POST",
            url: "PopulateEditor.php",
            data: {'expressionID' : expressionid,
                   'courseID' : courseid, 
                   'worksheetID' : worksheetid, 
                   'expressionNum' : newexpressionnumber
                  },
                   
            success: function(data){ 
                $("div[name='ExpressionEditor']").empty();
                $("div[name='ExpressionEditor']").html(data);
            }
        });
    });
    
    $(document).ready(function() {
        $("#myTable tr").each(function() {
            var sentence_number = $(this).find("td[name=sentence_number]").val();
            var studentID = $(this).find("td[name=studentID]").val();
            var Expression = $(this).find("td[name=Expression]").val();
            var assign = $(this).find("td[name=assign]").val();
        });
    });
});
