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
    
    $(document).on('click', "button[name='NewExpression']", function(e){
        var worksheetID = $(this).closest("form").find("input[name=worksheetID]").val();
        var courseID = $(this).closest("form").find("input[name=courseID]").val();
        var expressionNum = $("input[name=newexpressionnumber]").val();
        $.ajax({
            type: "POST",
            url: "NewExpression.php",
            data: {
                "worksheetID": worksheetID,
                "newexpressionnumber": expressionNum,
                "courseID": courseID
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
        
        var courseID = $(parentForm).find("input[name=courseID]").val();
        var expressionID = $(parentForm).find("input[name=expressionID]").val();
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
                "worksheetID": worksheetID,
                "courseID": courseID,
                "expressionID": expressionID
            },
                   
            success: function(data){ 
                /*$("div[name='ExpressionEditor']").empty();
                $("tbody[name='ExpressionTable']").empty();
                $("tbody[name='ExpressionTable']").html(data);*/
                location.reload();
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
