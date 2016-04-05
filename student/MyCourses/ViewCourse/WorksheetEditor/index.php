<!-- Edit Worksheet (index.php) for Student account -->

<?php include "../../../../base.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Gonzaga Small Talk</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">
    
    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script type="text/javascript" src="/js/dynamicRow.js"></script>
    <style>
        .glyphicon:before {
            visibility: visible;
        }
        .glyphicon.glyphicon-star-empty:checked:before {
            content: "\e006";
        }
        input[type=checkbox].glyphicon{
            visibility: hidden;

        }
        .mycontent-left {
            border-right: 1px solid #333;
        }
    </style>
    
    <script>
        
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
    
<!--
    <script type="text/javascript">$(function()
    {
        $(document).on('click', '.btn-add', function(e)
        {
            e.preventDefault();

            var controlForm = $('.controls form:last'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(controlForm.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function(e)
        {
            $(this).parents('.entry:last').remove();
            e.preventDefault();
            return false;
        });
    });
    </script>
-->
    
    <!-- Background Setup -->
    <style>
        .dropdown-backdrop {
            position: static;
        } 
    </style>
</head>
        
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Student')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        $params = array($_SESSION['Username']);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        $ListRolesQuery = "SELECT DISTINCT R.Role, RI.RoleID FROM Roles as R, RoleInstances as RI WHERE RI.SiteUsername = ? AND RI.RoleID = R.RoleID ORDER BY RI.RoleID";
        $stmt = sqlsrv_query($con, $ListRolesQuery, $params, $options);
        if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));
        }

        // Make the first (and in this case, only) row of the result set available for reading.
        $RolesList = [];
        while( sqlsrv_fetch( $stmt ) === true) {
             $RolesList[] = sqlsrv_get_field( $stmt, 0);
        }
    ?>        

    
    <body>    
    <?php
        if(true)
        {
    ?>
            <section class="container-fluid col-xs-12">                     
                <!--body-->
                <div id="wrapper">
                    <div id="sidebar"></div>
                    <div id="page-content-wrapper">
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="col-xs-1">
                                    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                        <span class="hamb-top"></span>
                                        <span class="hamb-middle"></span>
                                        <span class="hamb-bottom"></span>
                                    </button>
                                </div>
                                <!-- BEGIN PAGE CONTENT -->
                                <div class="col-xs-11 container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Worksheet Info</div>
                                                <div class="panel-body">
                                                    <h2>Course: Generated from page</h2>
                                                    <h5>Worksheet Number: Generated from page</h5>
                                                    <h5>Date: Generated dynamically</h5>
                                                    <h5>Topic: Form submission</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="panel panel-default">
                                            <div class="panel-heading">Worksheet Overview</div>
                                                <div class="panel-body">
                                                    <table class="table" id="myTable" >
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Expression</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="ExpressionTable">
                                                            <tr id="ExpressionRow">
                                                                <td id="ExpressionNum">1</td>
                                                                <td id="Expression">This is a sample expression for the purpose of demonstrating how text will wrap when we type too many words.</td>
                                                                <td class="text-danger" id="ExpressionStatus">Incomplete</td>
                                                                <td>
                                                                    <button id="EditExpression" class="btn btn-primary">Edit</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="top-margin:40px;">
                                        <div class="panel-heading">Expression Edit Window</div>
                                        <div class="panel-body">
                                            <div class="col-xs-8" name="left column">
                                                
                                                    <div class="col-xs-1" style="text-align: left";>
                                                        #
                                                    </div>
                                                    <div class="col-xs-11" style="text-align: left";>
                                                        Expression
                                                    </div>

                                                    <!--
                                                        The following 2 div are used to dynamically call the expression to the edit window
                                                    -->

                                                    <div class="col-xs-1" style="text-align: left" id="EditID"></div>
                                                    <div class="col-xs-11">
                                                        <textarea disabled id="ExprToEdit" class="form-control" class="col-xs-11">
                                                        </textarea>
                                                    </div>
                                                   
                                                    
                                               
                                                
                                                <div class="col-xs-12" style="padding-top: 40px">
                                                    <form role="form">
                                                        <div class="form-group">
                                                            <label for="CorrectedExpr">Correction:</label>
                                                            <input type="text" class="form-control" id="CorrectedExpr" placeholder="Enter the correct expression here" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="col-xs-4" name="right column">
                                                <div class="col-xs-12">
                                                    
                                                </div>
                                                <div class="col-xs-12">
                                                    <button id="SubmitExpr"  class="btn btn-primary pull-right">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- END PAGE CONTENT -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    <?php    
        }
    ?>
        
        
    <?php
        if (false)
        {
    ?>    
            <section class="container col-xs-12">                     
                <!--body-->
                <div id="wrapper">
                    <div id="sidebar"></div>
                    <div id="page-content-wrapper">
                        <div class="container-fluid">
                            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                <span class="hamb-top"></span>
                                <span class="hamb-middle"></span>
                                <span class="hamb-bottom"></span>
                            </button>
                            <!-- BEGIN PAGE CONTENT -->
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Worksheet Info</div>
                                            <div class="panel-body">
                                                <h2>Course: Generated from page</h2>
                                                <h5>Worksheet Number: Generated from page</h5>
                                                <h5>Date: Generated dynamically</h5>
                                                <h5>Topic: Form submission</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="panel panel-default">
                                        <div class="panel-heading">Worksheet Overview</div>
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Expression</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>I no understand English</td>
                                                            <td class="text-danger">Incomplete</td>
                                                            <td>
                                                                <form method="POST" action="/Student/MyCourses/ViewCourse/WorksheetEditor/">
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="entry panel panel-default" style="top-margin:40px;">
                                    <div class="panel-heading">Expressions</div>
                                    <div class="panel-body">
                                        <div class="control-group controls" id="fields">
                                            <form method="POST" name="Expressions[]" id="Expressions[]">
                                                <div class="form-group row">
                                                    <div class="col-xs-4 col-md-6">
                                                        <select class="form-control">
                                                            <option selected="selected">--Student--</option>
                                                            <option>Student 1</option>
                                                            <option>Student 2</option>
                                                            <option>Student 3</option>
                                                            <option>Student 4</option>
                                                            <option>Student 5</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input type="checkbox" style="font-size:25px;" class="glyphicon glyphicon-star-empty" >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xs-12">
                                                        <input type="text" class="form-control input-md" placeholder="Expression">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xs-7">
                                                        <input type="text" class="form-control input-md" placeholder="Vocab/Context">
                                                    </div>
                                                    <div class="col-xs-5">
                                                        <input type="text" class="form-control input-md" placeholder="Pronunciation">
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-primary pull-right">Save</button><br>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group" id="adv-search">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-add" type="button">
                                            New Expression
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT -->
                        </div>
                    </div>
                </div>
            </section>
    <?php
        }
    ?>
        
        <script src="//code.jquery.com/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script>
        $('.dropdown-toggle').click(function(e) {
            e.preventDefault();
            setTimeout($.proxy(function() {
                if ('ontouchstart' in document.documentElement) {
                    $(this).siblings('.dropdown-backdrop').off().remove();
                }
            }, this), 0);
        });
        
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