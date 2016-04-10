$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById("myTable");
    var corrExpr;
    var exprHead;
    
    $('#EditExpression').on('click',function(e) {
        var exprRow = exprTable.getElementsByTagName("tr");
        var expr = exprTable.getElementsByTagName("td");
        /*var std = expr.getElementsByTagName("option");*/
        /*document.getElementById("ExprToEdit").innerHTML = expr[1].innerHTML;*/
        /*document.getElementById("ExprID").innerHTML = expr[0].innerHTML;*/
        /*$(std[0]).val(expr[0].innerHTML);*/
        $("#CorrectedExpr").val(expr[2].innerHTML);
        $("#VocabCorr").val(expr[3].innerHTML);
        $("#PronCorr").val(expr[3].innerHTML);
    });
    
    $('#SubmitExpr').on('click',function(e){
        corrExpr = document.getElementById("CorrectedExpr").value;
        corrVocab = document.getElementById("VocabCorr").value;
        corrPron = document.getElementById("PronCorr").value;
        document.getElementById("ExpressionStatus").innerHTML='Complete';
        document.getElementById("ExprToEdit").innerHTML=corrExpr;
        document.getElementById("Vocab").innerHTML=corrVocab;
        document.getElementById("Pronunciation").innerHTML=corrPron;
        $("#CorrectedExpr").val("");
        $("#VocabCorr").val("");
        $("#PronCorr").val("");
    });
    
    $("button[name=SelectExpression]").on('click', function(e){
        var expressionid = $(this).val();
        var courseid = $(this).closest("form").find("input[name=courseID]").val();
        $.ajax({
            type: "POST",
            url: "PopulateEditor.php",
            data: {'expressionid' : expressionid,
                   'courseID' : courseid
                  },
                   
            success: function(data){ 
                $("div[name='ExpressionEditor']").empty();
                $("div[name='ExpressionEditor']").html(data);
            }
        });
        $("#loadingicon").empty();
    });
    
    $("button[name=NewExpression]").on('click', function(e){
        var worksheetID = $(this).val();
        var courseID = $(this).closest("form").find("input[name=courseID]").val();
        alert(courseID);
        var expressionNum = $("input[name=newexpressionnumber]").val();
        $.ajax({
            type: "POST",
            url: "NewExpression.php",
            data: {
                "worksheetID": worksheetID,
                "newexpressionnumber": expressionNum
            },
                   
            success: function(data){ 
                $("div[name='ExpressionEditor']").empty();
                $("div[name='ExpressionEditor']").html(data);
            }
        });
    });
    
    $(document).on('click', 'button[name="SaveExpression"]', function(e){
        e.preventDefault();
        var parentForm = $(this).closest("form");
        
        var Expression = $(parentForm).find("input[name=Expression]").val();
        var ContextVocab = $(parentForm).find("input[name=ContextVocab]").val();
        var Pronunciation = $(parentForm).find("input[name=Pronunciation]").val();
        var studentID = $(parentForm).find("select[name=selectstudent]").prop("selected", true).val();        
        var AllDo = 0;;
        if ($(parentForm).find("input[name=alldo][value=all]").is(":checked"))
            AllDo = 1;
        var expressionNum = $(parentForm).find("input[name=newexpressionnumber]").val();
        var worksheetID = $(parentForm).find("input[name=worksheetID]").val();
        alert(Expression);
        $.ajax({
            type: "POST",
            url: "SaveExpression.php",
            data: {
                "Expression": Expression,
                "ContextVocab": ContextVocab,
                "Pronunciation": Pronunciation,
                "studentID": studentID,
                "AllDo": AllDo,
                "expressionNum": expressionNum,
                "worksheetID": worksheetID
            },
                   
            success: function(data){ 
                $("div[name='ExpressionEditor']").empty();
                $("tbody[name='ExpressionTable']").empty();
                $("tbody[name='ExpressionTable']").html(data);
            }
        });
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
