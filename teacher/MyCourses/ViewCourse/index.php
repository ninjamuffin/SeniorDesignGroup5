<!-- Course view (index.php) for Teacher account -->

<?php include "../../../base.php"; ?>
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
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/FlatUI/css/theme.css" rel="stylesheet">
    
    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script type="text/javascript" src="/js/spin.js"></script>
    <script>
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

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
        $courseID = isset($_POST['courseID']) ? $_POST['courseID'] : 0;
        if ($courseID == 0)
            echo "<meta http-equiv='refresh' content='0;../' />";
    
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
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>Course Info</h4>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        $courseinfoSQL = "SELECT CT.CourseName, I.InstitutionName, ST.SessionName, SI.Year, C.Section
                                        From Courses as C, SessionType as ST, SessionInstance as SI, Institutions as I, CourseTypes as CT
                                        WHERE C.CourseID = ?
                                        AND CT.CourseTypesID = C.CourseTypesID
                                        AND I.InstitutionID = C.InstitutionID
                                        AND SI.SessionInstanceID = C.SessionInstanceID
                                        AND ST.SessionTypeID = SI.SessionTypeID";
                                        $params = array($courseID);
                                        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        
                                        $courseinfo = sqlsrv_query($con, $courseinfoSQL, $params, $options);
                                        if ( $courseinfo === false)
                                            die( print_r( sqlsrv_errors(), true));
                                        $length = sqlsrv_num_rows($courseinfo);

                                        if (sqlsrv_fetch( $courseinfo ) === true) 
                                        {
                                            $ClassName = sqlsrv_get_field( $courseinfo, 0);
                                            $InstitutionName = sqlsrv_get_field( $courseinfo, 1);
                                            $SessionName = sqlsrv_get_field( $courseinfo, 2);
                                            $SessionYear = sqlsrv_get_field( $courseinfo, 3);
                                            $Section = sqlsrv_get_field( $courseinfo, 4);
                                        }
                                        $WorksheetsSQL = "
                                        SELECT W.WorksheetID, W.WorksheetNumber, W.EditStatus, CONVERT(VARCHAR(11), W.Date,106), T.Topic
                                        FROM Worksheets W, Topics T
                                        WHERE W.CourseID = ? AND
                                              T.TopicID = W.TopicID
                                              ORDER BY W.WorksheetNumber";
                                        $params = array($courseID);
                                        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                                        $worksheets = sqlsrv_query($con, $WorksheetsSQL, $params, $options);
                                        if ($worksheets === false)
                                            die(print_r(sqlsrv_errors(), true));
                                        $num_worksheets = sqlsrv_num_rows($worksheets);
                                        $new_worksheet_number = $num_worksheets + 1;
                                        $today = date("F j, Y"); 

                                        $worksheetIDs = [];
                                        $worksheet_numbers = [];
                                        $statuses = [];
                                        $dates = [];
                                        $topics = [];
                                        while(sqlsrv_fetch($worksheets) === true)
                                        {
                                            $worksheetIDs[] = sqlsrv_get_field($worksheets, 0);
                                            $worksheet_numbers[] = sqlsrv_get_field($worksheets, 1);
                                            $statuses[] = sqlsrv_get_field($worksheets, 2);
                                            $dates[] = sqlsrv_get_field($worksheets, 3);
                                            $topics[] = sqlsrv_get_field($worksheets, 4);
                                        }

                                    echo "<p>Name: $ClassName</p>
                                    <p>Institution: $InstitutionName</p>
                                    <p>Session: $SessionName $SessionYear</p>
                                    <p>Section: $Section</p>";
                                    ?>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    New Worksheet
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="WorksheetEditor/" name="NewWorksheet">  
                                        <input type="hidden" name="worksheet_number" value="<?=$new_worksheet_number?>">
                                        <input type="hidden" id="courseID" name="courseID" value="<?=$courseID?>">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>Worksheet # <?=$new_worksheet_number?><span class="pull-right"><?=$today?></span></h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="text" name="topic" placeholder="Enter Topic">
                                                    </div>
                                                </div>
                                                <br>
                                                <h4>My Students Will See:</h4>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="worksheetTypeOriginal" checked="checked"> Original Expression</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="worksheetTypeText" value="TextReform" checked="checked">  Text Reformulation</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="worksheetTypeAudio" value="AudioReform" checked="checked">  Audio Reformulation</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="btn-group" class="col-md-3">
                                                <button type="button" name="newworksheet" class="btn btn-primary">Create New Worksheet</button>
                                            </div>
                                            <div name="createnewspinner" class="col-md-1" style="left:50%; top:18px;">
                                                
                                            </div>
                                            
                                        </div>
                                        
                                            
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="panel panel-primary" style="min-height:578px;">
                                <div class="panel-heading">
                                    <h4>Students</h4>
                                </div>
                                <div class="panel-body">
                                    <?php
        $params = array($courseID);
        $options = array( "Scrollable" => 'static' );
        $coursestudentsSQL = "SELECT S.FirstName, S.LastName, ER.EnrollmentID
                              FROM Students as S, Enrollment as ER, Courses as C
                              WHERE C.CourseID = ? AND
                                    ER.CourseID = C.CourseID AND
                                    S.StudentID = ER.StudentID";
        $coursestudents = sqlsrv_query($con, $coursestudentsSQL, $params, $options);
        if ($coursestudents === false)
            die(print_r(sqlsrv_errors(), true));
        $num_students = sqlsrv_num_rows($coursestudents);
        $firstnames = [];
        $lastnames = [];
        $ids = [];
        while (sqlsrv_fetch($coursestudents) === true)
        {
            $firstnames[] = sqlsrv_get_field($coursestudents, 0);
            $lastnames[] = sqlsrv_get_field($coursestudents, 1);
            $ids[] = sqlsrv_get_field($coursestudents, 2);
        }
        ?>
        
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Go To</th>
                                                <th>Go To Archive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
        <?php
        for($i = 0; $i < $num_students; $i++)
        {
            echo "<tr>";
            echo "<td>$firstnames[$i] $lastnames[$i]</td>";
            echo "<td>
                    <form method=\"POST\" action=\"/Teacher/MyCourses/ViewCourse/Students/ViewStudentProfile\" name=\"studentview{$i}\">
                      <input hidden type=\"text\" name=\"enrollmentID\" value=\"$ids[$i]\">
                      <button class=\"btn btn-primary\">Student Page</button>
                    </form>
                  </td>";
            echo "<td>
                    <form method=\"POST\" action=\"/Teacher/Archive/Students/ViewStudent/\" name=\"archivepage{$i}\">
                      <input hidden type=\"text\" name=\"enrollmentID\" value=\"$ids[$i]\">
                      <input hidden type=\"text\" name=\"courseID\" value=\"$courseID\">
                      <button class=\"btn btn-primary\">Archive Page</button>
                    </form>
                  </td>";
        }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-10">
                            <!-- Worksheet Listing -->
                            
                            <div class="panel panel-primary" style="min-height:400px;">
                                <div class="panel-heading">Worksheets</div>
                                
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Topic</th>
                                                <th>Status</th>
                                                <th>Go To</th>
                                                <th>Perform an Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
        $username = $_SESSION['Username'];
        for($i = 0; $i < $num_worksheets; $i++)
        {
            echo "<tr>";
            echo "<td>$worksheet_numbers[$i]</td>";
            echo "<td>$dates[$i]</td>";
            echo "<td>$topics[$i]</td>";
            echo "<td>$statuses[$i]</td>";
            if ($statuses[$i] == "Released")
            {
                echo "<td><form method=\"POST\" action=\"ViewWorksheet/\" name=\"ViewWorksheet\"><input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetIDs[$i]\"><button class=\"btn btn-primary\">Review</button></form></td>";
            }
            else
            {
                echo "<td><form method=\"POST\" action=\"WorksheetEditor/\" name=\"EditWorksheet\"><input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetIDs[$i]\"><button class=\"btn btn-primary\">Edit</button></form></td>";
            }
            echo "<td style=\"width:225px;\"><div class=\"row\"><div class=\"col-xs-4\">
                    <form method=\"POST\" name=\"publishworksheet{$i}\" action=\"PublishWorksheet.php\">
                      <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetIDs[$i]\">
                      <input hidden type=\"text\" name=\"courseID\" value=\"$courseID\">
                      <button class=\"btn btn-primary\">Publish</button>
                    </form></div>
                  ";
            echo "<div class=\"col-xs-4\">
                    <form method=\"POST\" name=\"deleteworksheet{$i}\" action=\"DeleteWorksheet.php\">
                      <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetIDs[$i]\">
                      <input hidden type=\"text\" name=\"courseid\" value=\"$courseID\">
                      <button type=\"button\" name=\"deleteworksheet\" class=\"btn btn-danger\">Delete</button>
                    </form></div>";
            echo "<div class=\"col-xs-1\" name=\"deletespinner\" style=\"top:15px;\">
                    </div>
                  </div></td>";
            echo "</tr>";
        }
        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <!-- END PAGE CONTENT -->
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
        
        $("button[name='deleteworksheet']").on("click", function(e){
            e.preventDefault();
            var memberForm = $(this).closest("form");
            var worksheetID = $(memberForm).find("input[name='worksheetID']").val();
            
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
            var target = $(this).closest("td").find("div[name='deletespinner']");
            var spinner = new Spinner(opts).spin();
            target.append(spinner.el);
            $(":button").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "DeleteWorksheet.php",
                data: {
                    "worksheetID":worksheetID
                },
                success: function(data) {
                    var courseID = $("#courseID").val();
                    $.ajax({
                        type: "POST",
                        url: "index.php",
                        data: {
                            "courseID":courseID
                        },
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            });
        });
            
        
        $("button[name='newworksheet']").on("click", function(e) {
            e.preventDefault();
            var topic = $("input[name='topic']").val();
            var courseid = $("input[name='courseID']").val();
            var worksheetnumber = $("input[name='worksheet_number']").val();
            var original = $("input[name='worksheetTypeOriginal']").val();
            var text = $("input[name='worksheetTypeText']").val();
            var audio = $("input[name='worksheetTypeAudio']").val();
            
            
            var opts = {
                  lines: 13 // The number of lines to draw
                , length: 36 // The length of each line
                , width: 12 // The line thickness
                , radius: 36 // The radius of the inner circle
                , scale: 0.25 // Scales overall size of the spinner
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
            var target = $("div[name='createnewspinner']");
            var spinner = new Spinner(opts).spin();
            target.append(spinner.el);
            $(":button").prop("disabled", true);
            
            $.ajax({
                type: "POST",
                url: "CreateWorksheet.php",
                data: {
                    "topic":topic,
                    "worksheet_number":worksheetnumber,
                    "worksheetTypeOriginal":original,
                    "worksheetTypeText":text,
                    "worksheetTypeAudio":audio,
                    "courseid":courseid
                },
                success: function(data){
                    var courseID = $("#courseID").val();
                    $.ajax({
                        type: "POST",
                        url: "index.php",
                        data: {
                            "courseID":courseID
                        },
                        success: function(data) {
                            location.reload();
                        }

                    });
                }
            });
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