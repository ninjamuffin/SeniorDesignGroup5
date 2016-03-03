<!-- Edit Worksheet (index.php) for Teacher account -->

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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    
    
    
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
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
        
        <nav class="navbar navbar-inverse" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex8-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
<!--                <a class="navbar-brand" href="/"><img src="/media/smalltalkimage.gif" style="width:200px;height:40px;"></a>-->
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse right-offset">
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownMenu">
                      <span class="glyphicon glyphicon-user"></span> <?=$_SESSION['Username']?> <b class="caret"></b>
                    </a>
                      
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                        <li><a href="/<?=$_SESSION['Role']?>/Home/Profile/">My Profile</a></li>
                        <li><a href="#">Change Password</a></li>
                        <li class="divider">My Roles</li>
                         <?php                    
        foreach($RolesList as $ListedRole)
        {
            if ($ListedRole == $_SESSION['Role'])
            {
            ?>
                        <li><a><strong><?=$ListedRole?></strong></a></li>
                                
            <?php
            }
            else
            {
                ?>
                <li><a href="/ChangeRole.php?q=<?=$ListedRole?>"><?=$ListedRole?></a></li>
                <?php
            }
        }
        ?>
                        <li class="divider"></li>
                        <li><a href="/logout.php">Log out</a></li>
                    </ul>
          
                            
                </li>
                             
                </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        <section class="container col-xs-12">
            <!--navbar-->
                     
            <!--body-->
            <div id="wrapper">
                
                <div id = "sidebar"></div>
                <div id="page-content-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                    <span class="hamb-top"></span>
                                    <span class="hamb-middle"></span>
                                    <span class="hamb-bottom"></span>
                                </button>
                                    <!-- BEGIN PAGE CONTENT -->
                                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Worksheet Info</div>
                                <div class="panel-body">
                                    <h2 class="page-header">Course: Generated from page</h2>
                                    <h5>Worksheet Number: Generated from page</h5>
                                    <h5>Date: Generated dynamically</h5>
                                    <h5>Topic: Form submission</h5>
                                </div>
                            </div>
                            <div class="entry panel panel-default" style="top-margin:40px;">
                                <div class="panel-heading">Expressions</div>
                                <div class=" panel-body">
                                        <div class="control-group" id="fields">
                                            <div class="controls"> 
                                                <form class=" form-inline">
                                                    <div class="form-group row">
                                                        <div class="col-lg-2">
                                                            <select class="form-control">
                                                                <option selected="selected">--Student--</option>
                                                                <option>Student 1</option>
                                                                <option>Student 2</option>
                                                                <option>Student 3</option>
                                                                <option>Student 4</option>
                                                                <option>Student 5</option>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    <input type="text" class="form-control input-md" placeholder="Expression" style="width: 100%; margin-top:10px;">
                                                    <br>
                                                    <input type="text" class="form-control input-md" placeholder="Vocab/Context" style="width: 100%;margin-top:10px;">
                                                    <br>
                                                    <div class="row" style="padding-right:15px;"><button type="submit"  class="btn btn-primary pull-right">Save</button></div>
                                                     
                                                </form>
                                           
                                            </div>
                                            
                                            
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
                    </div>
                                    <!-- END PAGE CONTENT -->
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
        </section>
        
        <script src="http://code.jquery.com/jquery.js"></script>
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