<?php include "../../base.php"; ?>
<?php include "generateSQL.php"; ?>
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
    <script>

        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if( !(($_SESSION['Role'] == 'Admin') || ($_SESSION['Role'] == 'Teacher') ))
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        
        $searched_words = isset($_POST['search_words']) ? $_POST['search_words'] : '';
        $num_searched_words = count($searched_words);
        
        $expressionsSQL = "SELECT DISTINCT E.Expression, E.[Context/Vocabulary], CT.Level, L.Language
                           FROM Expressions E, SeqWords SW, Students S, Courses C, CourseTypes CT, Languages L
                           WHERE ";
        $params = [];
        $options = array( "Scrollable" => 'static' );
        for($j = 0; $j < $num_searched_words - 1; $j++)
        {
            $word_title = $searched_words[$j];
            $word_list = $_POST[$word_title];
            $num_words = count($word_list);
            $add_to_query = "E.ExpressionID in (SELECT E2.ExpressionID
                                                FROM Expressions E2, SeqWords SW2
                                                WHERE (";
            for($i = 0; $i < $num_words - 1; $i++)
            {
                $add_to_query .= "SW2.WordID = ? OR ";
                $params[] = $word_list[$i];
            }
            $add_to_query .= "SW2.WordID = ?";
            $params[] = $word_list[$num_words - 1];
            $expressionsSQL .= $add_to_query;
            $expressionsSQL .= ") AND E2.ExpressionID = SW2.ExpressionID) AND ";
        }
        $word_title = $searched_words[$num_searched_words - 1];
        $word_list = $_POST[$word_title];
        $num_words = count($word_list);
        $add_to_query = "E.ExpressionID in (SELECT E2.ExpressionID
                                            FROM Expressions E2, SeqWords SW2
                                            WHERE (";
        for($i = 0; $i < $num_words - 1; $i++)
        {
            $add_to_query .= "SW2.WordID = ? OR ";
            $params[] = $word_list[$i];
        }
        $add_to_query .= "SW2.WordID = ? ";
        $params[] = $word_list[$num_words - 1];
        $expressionsSQL .= $add_to_query;
        $expressionsSQL .= ") AND E2.ExpressionID = SW2.ExpressionID)";
        
        $expressionsSQL .= " AND S.StudentID = E.StudentID AND
                                 L.LanguageID = S.Language AND
                                 C.CourseID = E.CourseID AND
                                 CT.CourseTypesID = C.CourseTypesID";


        
        
        
        /*$expressions = sqlsrv_query($con, $expressionsSQL, $params, $options);
        if ($expressions === false)
            die(print_r(sqlsrv_errors(), true));
        $num_expressions = sqlsrv_num_rows($expressions);
        $expression_data = [];
        
        while (sqlsrv_fetch($expressions) === true)
            $expression_data[] = sqlsrv_get_field($expressions, 0);*/
        
        
        
        
        ?>
        <body>
            <div id="wrapper">
                <div id="sidebar"></div>
                <div id="page-content-wrapper">
                    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                    <span class="hamb-top"></span>
                                    <span class="hamb-middle"></span>
                                    <span class="hamb-bottom"></span>
                                </button>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <form method="POST" action="/Corpus/Search/">
                                    <button class="btn-lg btn-primary">New Search</button>
                                </form>
                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <h3><strong>
                                    <span>
<?php
        for ($i = 0; $i < $num_searched_words - 1; $i++)
            echo "$searched_words[$i] + ";
        $end = $num_searched_words - 1;
        echo "$searched_words[$end]";
?>
                                    </span>
                                </strong></h3>
                                
                            </div>
                        </div>
                        <br>
                        <!--<div class="row">
                            <div class="col-md-10">
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Search Information</div>
                                    <div class="panel-body">
                                        
                                    <p>Search Information</p>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <!--<div class="row">
                            <div class="col-md-5 col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Filter By Language</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><label><input type='checkbox' id='checkAll'> Select All </label></th>
                                                    <th>Language</th>
                                                    <th>Number of Results ( n = 50 )</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="checkbox" name="selectLang"></td>
                                                    <td>Spanish</td>
                                                    <td>20</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info" style="width: 40%">40%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="selectLang"></td>
                                                    <td>French</td>
                                                    <td>30</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info" style="width: 60%">60%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Filter By Level</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <tr>
                                                <th><label><input type='checkbox' id='checkAll'> Select All </label></th>
                                                <th>Language</th>
                                                <th>Number of Results(n= )</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-primary" style="max-height:600px;">
                                    <div class="panel-heading"><h4>Result Expressions</h4></div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Expression</th>
                                                    <th>Context</th>
                                                    <th>Level</th>
                                                    <th>Native Language</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
    
        
        
    $options = array( "Scrollable" => 'static' );
    
    $stmt = sqlsrv_query($con, $expressionsSQL, $params, $options);
    if ( !$stmt )
        die( print_r( sqlsrv_errors(), true));

    /* Extract Pagination Paramaters */

    $rowsPerPage = isset($_GET['pp']) ? $_GET['pp'] : 20; // get rows per page, default = 10


    $rowsReturned = sqlsrv_num_rows($stmt);
    if($rowsReturned === false)
        die(print_r( sqlsrv_errors(), true));
    elseif($rowsReturned == 0)
    {
        echo "No rows returned.";
        exit();
    }
    else
    {
        /* Calculate number of pages. */
        $numOfPages = ceil($rowsReturned/$rowsPerPage);
    }

    /* Echo results to the page */
    $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
    $page = Pagination::getPage($stmt, $pageNum, $rowsPerPage);
    foreach($page as $row)
    {
        //$coursePageLink = "ViewCourse/?courseID=$row[5]";
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
    }

    echo "</tbody></table><br />";
    $modulator = 0;
    Pagination::pageLinks($numOfPages, $pageNum, $rowsPerPage, $rowsReturned, $modulator);
    ?>
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
            $(document).on("change", "#checkAll", function(e){
                e.preventDefault();
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });
            </script>
        </body> 
        <?php        
    }
}

else
{
    ?>
    <!-- To Do: Add alternate corpus view section -->
    <p>Oops! You are not logged in. We do not yet support access to the corpus without authorization from our administrators.</p>
    <p>Redirecting to log-in in 5 seconds</p>
    <p>Click <a href="/">here</a> if you don't want to wait</p>
    <meta http-equiv='refresh' content='5;/' />
    <?php
}
?>

</html>
