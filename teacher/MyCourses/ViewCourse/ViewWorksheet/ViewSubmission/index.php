<!-- View Submission (index.php) for Teacher account -->

<?php include "../../../../../base.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Gonzaga Small Talk</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="/datepicker.less" />
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/FlatUI/css/theme.css" rel="stylesheet" media="screen">
    
    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script>
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
    <style>
    .divider {
        width:100%;
        text-align:center;
        height:inherit;
    }

    .divider hr {
        margin-left:auto;
        margin-right:auto;
        width:45%;
        

    }

    .left {
        float:left;
    }

    .right {
        float:right;
    }
    </style>

</head>
        
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Teacher')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        $worksheetID = isset($_POST['worksheetID']) ? $_POST['worksheetID'] : 0;
        $studentsubmissionID = isset($_POST['studentsubmissionID']) ? $_POST['studentsubmissionID'] : 0;
    ?>        

    <body>
        <div id="wrapper">
            <div id = "sidebar"></div>
            <div id="page-content-wrapper">
                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10">
                        
                            <!-- BEGIN PAGE CONTENT -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Submission Details and Statistics</div>
                                <div class="panel-body">
    <?php
        echo "$worksheetID $studentsubmissionID";
        $params = array($worksheetID, $studentsubmissionID);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        $submissioninfoSQL = "SELECT S.FirstName, S.LastName, CONVERT(VARCHAR(11), SS.Date,106), CT.CourseName, WS.WorksheetNumber, SS. AttemptNumber, TP.Topic
            FROM Students S, Enrollment ER, Worksheets WS, Topics TP, StudentSubmissions SS, Courses C, CourseTypes CT
            WHERE WS.WorksheetID = ? AND
                  WS.WorksheetID = SS.WorksheetID AND
                  SS.StudentSubmissionID = ? AND
                  SS.EnrollmentID = ER.EnrollmentID AND
                  ER.StudentID = S.StudentID AND
                  TP.TopicID = WS.TopicID AND
                  WS.CourseID = C.CourseID AND
                  C.CourseTypesID = CT.CourseTypesID";
        $submissioninfo = sqlsrv_query($con, $submissioninfoSQL, $params, $options);
        if($submissioninfo === false)
            die (print_r(sqlsrv_errors(), true));
        sqlsrv_fetch($submissioninfo);
        $firstname = sqlsrv_get_field($submissioninfo, 0);
        $lastname = sqlsrv_get_field($submissioninfo, 1);
        $date = sqlsrv_get_field($submissioninfo, 2);
        $coursename = sqlsrv_get_field($submissioninfo, 3);
        $worksheetnumber = sqlsrv_get_field($submissioninfo, 4);
        $attemptnumber = sqlsrv_get_field($submissioninfo, 5);
        $topic = sqlsrv_get_field($submissioninfo, 6);
                              echo "<p>Student name: $firstname $lastname</p>
                                    <p>Date: $date</p>
                                    <p>$coursename: Worksheet #$worksheetnumber Attempt $attemptnumber</p>
                                    <p>Topic: $topic</p>";
        ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
    
                            <div class="panel panel-default">
                                <div class="panel-heading">Submitted Sentences</div>
                                <div class="panel-body">
    <?php
        $submissionreformulationsSQL = "SELECT EX.SentenceNumber, EX.Expression, ";
            
        ?>
                                    <div class="panel-group" id="accordian">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                   <a class="accordian-toggle" data-toggle="collapse" data-parent="#accordian" href="#collapseOne" style="width:60%">
                                                        <span>Sentence #1</span>
                                                    </a> 
                                                    <span class="glyphicon glyphicon-star pull-right" style="font-size:20px; "></span>
                                                   
                                                </h3>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Original</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-7" >
                                                            <textarea class="form-control" disabled>Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-11">
                                                            <textarea class="form-control" disabled>Context/Vocab</textarea>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                    
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Corrected</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-8">
                                                            <textarea class="form-control" disabled>Correct Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <audio controls title="Reformulation">
                                                                <source src="/Media/Audio/sample.mp3" type="audio/mpeg">
                                                                Your Browser does not support this audio element
                                                            </audio>
                                                        </div>
                                                    </div>
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Submitted</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-8">
                                                            <textarea class="form-control" disabled >Submitted Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <audio controls title="Reformulation">
                                                                <source src="/Media/Audio/sample.mp3" type="audio/mpeg">
                                                                Your Browser does not support this audio element
                                                            </audio>
                                                        </div>
                                                        
                                                    </div>
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Assessment</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <textarea class="form-control">Stats</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <a class="accordian-toggle" data-toggle="collapse" data-parent="#accordian" href="#collapseTwo" style="width:60%">
                                                        <span>Sentence #2</span>
                                                    </a>
                                                    
                                                    <span class="pull-right">Authored</span>
                                                   
                                                </h3>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Original</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-7" >
                                                            <textarea class="form-control" disabled>Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-11">
                                                            <textarea class="form-control" disabled>Context/Vocab</textarea>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                    
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Corrected</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-8">
                                                            <textarea class="form-control" disabled>Correct Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <audio controls title="Reformulation">
                                                                <source src="/Media/Audio/sample.mp3" type="audio/mpeg">
                                                                Your Browser does not support this audio element
                                                            </audio>
                                                        </div>
                                                    </div>
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Submitted</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-8">
                                                            <textarea class="form-control" disabled >Submitted Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <audio controls title="Reformulation">
                                                                <source src="/Media/Audio/sample.mp3" type="audio/mpeg">
                                                                Your Browser does not support this audio element
                                                            </audio>
                                                        </div>
                                                        
                                                    </div>
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Assessment</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <textarea class="form-control">Stats</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <a class="accordian-toggle" data-toggle="collapse" data-parent="#accordian" href="#collapseThree" style="width:60%">
                                                        <span>Sentence #3</span>
                                                    </a>
                                                    
                                                    <span class="pull-right">Authored</span>
                                                   
                                                </h3>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Original</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-7" >
                                                            <textarea class="form-control" disabled>Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-11">
                                                            <textarea class="form-control" disabled>Context/Vocab</textarea>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                    
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Corrected</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-8">
                                                            <textarea class="form-control" disabled>Correct Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <audio controls title="Reformulation">
                                                                <source src="/Media/Audio/sample.mp3" type="audio/mpeg">
                                                                Your Browser does not support this audio element
                                                            </audio>
                                                        </div>
                                                    </div>
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Submitted</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-8">
                                                            <textarea class="form-control" disabled >Submitted Expression</textarea>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <audio controls title="Reformulation">
                                                                <source src="/Media/Audio/sample.mp3" type="audio/mpeg">
                                                                Your Browser does not support this audio element
                                                            </audio>
                                                        </div>
                                                        
                                                    </div>
                                                    <table width="100%">
                                                      <td><hr /></td>
                                                      <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Assessment</strong></td>
                                                      <td><hr /></td>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <textarea class="form-control">Stats</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/js/bootstrap.min.js"></script>
        <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        </script>
    </body>
    <?php
    }
}
    
else
{
    ?>
    <p>Oops! You are not logged in.  Redirecting to log-in in 5 seconds</p>
    <p>Click <a href="/">here</a> if you don't want to wait</p>
    <meta http-equiv='refresh' content='5;/' />
    <?php
}
?>
</html>