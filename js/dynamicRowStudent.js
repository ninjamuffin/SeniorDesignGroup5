$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById('myTable');
    var rowIndex;
    var exprHead;
    
    $("button[name='Edit']").on('click',function(e) {
        var exprID = $(this).val();
        var $row = $(this).closest("tr");
        var rowIndex = $row.find(".nr").text();
        var expr = $row.find(".expr").text();
        
        var first = "<input hidden type='text' name='expressionID' value='";
        var last = "'>";
        var to_add = first + exprID + last;
        
        
        $("#expressionID").val(exprID);
        document.getElementById("ExprToEdit").innerHTML = expr;
        document.getElementById("ExprID").innerHTML = "- Working on Expression: #" + rowIndex;
    });

    $('#SubmitExpr').on('click',function(e){
        e.preventDefault();
        
        $("#CorrectedExpr").val("");
        document.getElementById("ExprID").innerHTML = " - Load new expression";
        var exprID = $("#expressionID").val();
        
        var target_button = $(document).find("button").attr('value', exprID);
        var target_row = $(target_button).closest("tr");
        var target_correct = $(target_row).find("td[name='corrected']");
        
        
        var corrExpr = $("input[name='CorrectedExpr']").val();
        $(target_correct).html(corrExpr);

/*
        document.getElementById("myTable").rows[rowIndex].cell(3) = corrExpr;
*/
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
