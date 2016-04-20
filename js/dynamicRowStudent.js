var exprTable;
var rowIndex;
var rowID;
var correctedArray = [];
var expressionID;
var exprIDs = []; // On page load: fill with values
var worksheetID;
var enrollmentID;


$(function(){
    // Find a <table> element with id="myTable":
    exprTable = document.getElementById('myTable');
    enrollmentID = document.getElementById('EnrollmentID').innerHTML;
    
    $("button[name='Edit']").on('click',function(e) {
        e.preventDefault();
        
        var $row = $(this).closest("tr");
        rowID = $row.attr('id');
        rowIndex = $row.find(".nr").text();
        var expr = $row.find(".expr").text();
        
        exprIDs[rowID] = $row.find(".expr").attr('id');
        
        document.getElementById("ExprToEdit").innerHTML = expr;
        document.getElementById("ExprID").innerHTML = "- Working on Expression: #" + rowIndex;
    });

    $('#SubmitExpr').on('click',function(e) {
        e.preventDefault();     
        
        document.getElementById("ExprID").innerHTML = " - Load new expression";
        var corrExpr = $("input[name='CorrectedExpr']").val();
        var exprID = $("#expressionID").val();
        var row = $(document).find("button").closest('tr');
        
        //Dont know why the index of the correction td is 9, there must be more children than //there are tds, there are actually a total of 15 children
        document.getElementById(rowID).childNodes[9].innerHTML = corrExpr;
        correctedArray[rowID] = corrExpr;
        $("input[name='CorrectedExpr']").val("");
    });
    
    $('#Update').on('click',function(e){
        e.preventDefault();
        
        alert("Saving your expressions!");
        /*alert(correctedArray.join('\n'));
        alert(exprIDs.join('\n'));
        
        
        worksheetID = document.getElementById('WorksheetID').innerHTML;
        alert(enrollmentID);
        
        $.ajax({
            type: POST,
            url: "WriteCorrections.php",
            data: {
                "worksheetID"   : worksheetID,
                "expressionIDs" : exprIDs,
                "correctedText" : correctedArray,
                "enrollmentID"  : enrollmentID
            },
            success: function(data) {
                // From document retrieve worksheet ID as 'worksheetID'
                $.ajax({
                    type : POST,
                    url: "index.php",
                    data: {
                        "worksheetID" : worksheetID  
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        });*/
    });
    
/*    $(document).on('click', "button[name='SelectExpression']", function(e){
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
    });*/
    
    $(document).ready(function() {
        $("#myTable tr").each(function() {
            var sentence_number = $(this).find("td[name=sentence_number]").val();
            var studentID = $(this).find("td[name=studentID]").val();
            var Expression = $(this).find("td[name=Expression]").val();
            var assign = $(this).find("td[name=assign]").val();
        });
    });
});
