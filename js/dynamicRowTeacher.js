var rowID;
var rowIndex;
var numExprs;

$(function(){
    // Find a <table> element with id="myTable":
    var exprTable = document.getElementById("myTable");
    var corrExpr;
    var exprHead;
    
    var sentence_numbers = new Array();
    
    $("#WorksheetOverview tbody").append("<tr><td>...</td></tr>");
    /*$(document).onload...*/
    
    $("#SaveWorksheet").on('click', function(e){
        alert("Worksheet saved!");
        numExprs = parseInt(document.getElementById("numExprs").innerHTML);
        alert("before worksheetID");
        var worksheetID = parseInt(document.getElementById("WorksheetID").innerHTML);
        var courseID = parseInt(document.getElementById("CourseID").innerHTML);
        alert("after courseID");
        var expressionNums = [];
        var expressions = [];
        var corrections = [];
        var contexts = [];
        var pronunciations = [];
        var enrollmentids = [];
        var alldos = [];
        var altered = [];
        var expressionids = [];
        alert("made it here");
        for(i = 0; i < numExprs; i++)
        {
            expressionNums[i] = parseInt(document.getElementById(i+1).childNodes[1].innerHTML);
            expressions[i] = document.getElementById(i+1).childNodes[5].innerHTML;
            corrections[i] = document.getElementById(i+1).childNodes[7].innerHTML;
            contexts[i] = document.getElementById(i+1).childNodes[9].innerHTML;
            pronunciations[i] = document.getElementById(i+1).childNodes[11].innerHTML;
            enrollmentids[i] = parseInt(document.getElementById(i+1).childNodes[13].innerHTML);
            alldos[i] = parseInt(document.getElementById(i+1).childNodes[17].innerHTML);
            altered[i] = parseInt(document.getElementById(i+1).childNodes[19].innerHTML);
            expressionids[i] = parseInt(document.getElementById(i+1).childNodes[21].innerHTML);
            
//            alert(expressionNums[i]);
//            alert(expressions[i]);
//            alert(corrections[i]);
//            alert(contexts[i]);
//            alert(pronunciations[i]);
//            alert(enrollmentids[i]);
//            alert(alldos[i]);
//            alert(altered[i]);
//            alert(expressionids[i]);
            alert(worksheetID);
            alert(courseID);
        }
        $.ajax({
            type: "POST",
            url: "SaveWorksheet.php",
            data: {
                "Expressions": expressions,
                "ContextVocabs": contexts,
                "Pronunciations": pronunciations,
                "AllDos": alldos,
                "expressionNums": expressionNums,
                "worksheetID": worksheetID,
                "courseID": courseID,
                "expressionIDs": expressionids,
                "reformulations": corrections,
                "isAltered": altered,
                "EnrollmentIDs": enrollmentids            
            },
                   
            success: function(data){ 
                $("div[name='ExpressionEditor']").empty();
                $("tbody[name='ExpressionTable']").empty();
                $("tbody[name='ExpressionTable']").html(data);
                //location.reload();
            }
        });
    });
        
    $("#NewExpression").on('click', function(e){
        e.preventDefault();
        numExprs = parseInt(document.getElementById("numExprs").innerHTML);
        numExprs++;
        
        $("#myTable tr:last").after('<tr id="' + numExprs + '"> <td class="nr">' + numExprs + '</td> <td class="name"></td> <td class="expr"></td> <td class="reform"></td> <td style="display: none" class="context"></td> <td style="display: none" class="pronCorr"></td> <td style="display: none" class="enrollmentid">0</td> <td><span class="glyphicon glyphicon-remove"></span></td> <td style="display: none" class="allDo">0</td> <td style=\"display: none\" class=\"isAltered\">0</td> <td style=\"display: none\" class=\"expressionID\">0</td> <td><button value="" type="button" name="Edit" class="btn btn-primary">Edit</button></td></tr>');
        
        document.getElementById("numExprs").innerHTML = numExprs;
        
        $("input[name='ExprToEdit']").val("");
        $("input[name='context']").val("");
        $("input[name='pronCorr']").val("");
        $("input[name='Corr']").val("");
 
        document.getElementById("selectstudent").selectedIndex = 0;
    });
    
    $(document).on('click',"button[name='Edit']",function(e) {
        e.preventDefault();
        
        var $row = $(this).closest("tr");
        
        rowID = $row.attr('id');
        rowIndex = $row.find(".nr").text();
        
        var expr = $row.find(".expr").text();
        var context = $row.find(".context").text();
        var pronCorr = $row.find(".pronCorr").text();
        var correction = $row.find(".reform").text();
                
        $("input[name='ExprToEdit']").val(expr);
        $("input[name='context']").val(context);
        $("input[name='pronCorr']").val(pronCorr);
        $("input[name='Corr']").val(correction);
        document.getElementById("indy").checked = true;
        
        document.getElementById("exprStatus").innerHTML = "Sentence #";
        document.getElementById("exprNum").innerHTML = rowIndex;
    });
    
    $("#Save").on('click', function(e) {
        e.preventDefault(); 
        
        //SAVE EXPRESSION
            document.getElementById("exprStatus").innerHTML = "";
            document.getElementById("exprNum").innerHTML = "Select or Create New Expression";
            var enrollmentID = $("#selectstudent option:selected").val();
            var studName = $("#selectstudent option:selected").text();
            var studExpr = $("input[name='ExprToEdit']").val();
            var corrContext = $("input[name='context']").val();
            var corrPron = $("input[name='pronCorr']").val();
            var corrExpr = $("input[name='Corr']").val();
            var alldoStatus = $("input:radio[name='alldo']:checked").val();            

            var row = $(document).find("button").closest('tr');
            //Dont know why the index of the correct td's are the way they are there must be more children than //there are tds we want the odd numbered indices left to right on the table
            document.getElementById(rowID).childNodes[3].innerHTML = studName;
            document.getElementById(rowID).childNodes[5].innerHTML = studExpr;
            document.getElementById(rowID).childNodes[7].innerHTML = corrExpr;
            document.getElementById(rowID).childNodes[9].innerHTML = corrContext;
            document.getElementById(rowID).childNodes[11].innerHTML = corrPron;
            document.getElementById(rowID).childNodes[13].innerHTML = enrollmentID;
            document.getElementById(rowID).childNodes[17].innerHTML = alldoStatus;
            document.getElementById(rowID).childNodes[19].innerHTML = 1; //isAltered
        
            if(alldoStatus == 1) {
                document.getElementById(rowID).childNodes[15].innerHTML = "<span class=\"glyphicon glyphicon-ok\"></span>";
            }
            else {
                document.getElementById(rowID).childNodes[15].innerHTML = "<span class=\"glyphicon glyphicon-remove\"></span>";                
            }
        
            $("input[name='ExprToEdit']").val("");
            $("input[name='context']").val("");
            $("input[name='pronCorr']").val("");
            $("input[name='Corr']").val("");
    });
    
/*    $(document).on('click', 'button[name="SaveExpression"]', function(e){
        e.preventDefault();
        
        var parentForm = $(this).closest("form");
        var Expression = $(parentForm).find("input[name=Expression]").val();
        var ContextVocab = $(parentForm).find("input[name=ContextVocab]").val();
        var Pronunciation = $(parentForm).find("input[name=Pronunciation]").val();
        var studentID = $(parentForm).find("select[name=selectstudent]").prop("selected", true).val();
        
        if (studentID == 0) {
            alert("Pick a student!");
            return false;
        }
        if ( (Expression.length == 0) && (ContextVocab == 0) && (Pronunciation == 0)) {
            alert("Enter some data");
            return false;
        }
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
                $("div[name='ExpressionEditor']").empty();
                $("tbody[name='ExpressionTable']").empty();
                $("tbody[name='ExpressionTable']").html(data);
                location.reload();
            }
        });
    });*/
    
    $("tr").each(function(index) {
        if (index !=0) {
            $row = $(this);
            
            var id = $row.find("td:first").text();
            
            if (id.indexOf(value) != 0) {
                $(this).hide();
            } else {
                $(this).show();
            }
        }
    });
});
