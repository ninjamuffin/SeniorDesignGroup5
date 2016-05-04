var exprTable;
var rowIndex;
var rowID;
var numExpressions;
var correctedArray = [];
var expressionID;
var exprIDs = []; // On page load: fill with values
var is_altered = [];
var worksheetID;
var enrollmentID;


$(function(){
    $.getScript('/js/spin.js', function() {
         
    });
    enrollmentID = document.getElementById('EnrollmentID').innerHTML;
    numExpressions = parseInt(document.getElementById('NumExpressions').innerHTML);
    //exprIDs = document.getElementByID('ExpressionIDs');
    //alert(numExpressions);
    var $tb = $(this).find(".table");
    
    for(i = 0; i < numExpressions; i++) {
        correctedArray[i] = 'n/a';
        is_altered[i] = 0;
    }
    
    $('.table tr').each(function (i, row) {
        exprIDs[i - 1] = $(row).find(".expr").attr('id');
        //started counting at index 1.
    });
    //alert(exprIDs[9]);
    $("button[name='Clear']").on('click',function(e) {
        e.preventDefault();
        $("input[name=CorrectedExpr]").val("");
        
    });
    $("button[name='Edit']").on('click',function(e) {
        e.preventDefault();
        $("#SubmitExpr").attr("disabled", false);
        $("#CorrectedExpr").attr("disabled", false);
        
        var $row = $(this).closest("tr");
        rowID = $row.attr('id');
        rowIndex = $row.find(".nr").text();
        var expr = $row.find(".expr").text();
        var corr = $row.find(".corr").text();
        
        exprIDs[rowID] = $row.find(".expr").attr('id');
        
        $("textarea[name=OriginalExpression]").val(expr);
        $("input[name=CorrectedExpr]").val(corr);
        document.getElementById("ExprID").innerHTML = "- Working on Expression: #" + rowIndex;
    });

    
    $('input[name="CorrectedExpr"]').keypress(function(e){
        if (e.which == 13) {
            $("#SubmitExpr").click();
            return false;
        }
    });

    $('#SubmitExpr').on('click',function(e) {
        e.preventDefault();   
        $("#SubmitExpr").attr("disabled", true);
        $("#CorrectedExpr").attr("disabled", true);
        
        
        document.getElementById("ExprID").innerHTML = " - Load new expression";
        var corrExpr = $("input[name='CorrectedExpr']").val();
        var exprID = $("#expressionID").val();
        var row = $(document).find("button").closest('tr');
        //Dont know why the index of the correction td is 9, there must be more children than //there are tds, there are actually a total of 15 children
        document.getElementById(rowID).childNodes[9].innerHTML = corrExpr;
        correctedArray[rowID] = corrExpr;
        is_altered[rowID] = 1;
        $("input[name='CorrectedExpr']").val("");
        $("textarea[name='OriginalExpression']").val("");
    });
    
    
    $('#Update').on('click',function(e){
        e.preventDefault();
        var is_changed = false;
        for(i = 0; i < numExpressions; i++) {
            if (is_altered[i])
                is_changed = true;
        }
        if (!is_changed) {
            alert("Make a correction before updating!");
            return false;
        }
        var opts = {
                  lines: 13 // The number of lines to draw
                , length: 36 // The length of each line
                , width: 12 // The line thickness
                , radius: 36 // The radius of the inner circle
                , scale: 0.15 // Scales overall size of the spinner
                , corners: 1 // Corner roundness (0..1)
                , color: '#000' // #rgb or #rrggbb or array of colors
                , opacity: 0.45 // Opacity of the lines
                , rotate: 0 // The rotation offset
                , direction: 1 // 1: clockwise, -1: counterclockwise
                , speed: 1.2 // Rounds per second
                , trail: 59 // Afterglow percentage
                , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
                , zIndex: 2e9 // The z-index (defaults to 2000000000)
                , className: 'spinner' // The CSS class to assign to the spinner
                , top: '75%' // Top position relative to parent
                , left: '50%' // Left position relative to parent
                , shadow: false // Whether to render a shadow
                , hwaccel: false // Whether to use hardware acceleration
                , position: 'absolute' // Element positioning
            }
        var target = $(this).closest("td").find("div[name='updatespinner']");
        var spinner = new Spinner(opts).spin();
        target.append(spinner.el);
        $(":button").prop("disabled", true);

        
        worksheetID = document.getElementById('WorksheetID').innerHTML;
        
        $.ajax({
            type: "POST",
            url: "WriteCorrections.php",
            data: {
                "worksheetID"   : worksheetID,
                "expressionIDs" : exprIDs,
                "correctedText" : correctedArray,
                "isAltered"     : is_altered,
                "enrollmentID"  : enrollmentID
            },
            success: function(data) {
                            
                $.ajax({
                    type : "POST",
                    url: "index.php",
                    data: {
                        "worksheetID" : worksheetID  
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        });
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
