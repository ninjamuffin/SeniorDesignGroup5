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

    <!-- Background Setup -->
    <style>
      
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
                <a class="navbar-brand" href="/"><img src="/media/logo.jpeg" style="width:200px;height:40px;"></a>
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
                                <div class="panel-heading">Details</div>
                                <div class="panel-body">
                                    <h2 class="page-header">Course 121</h2>
                                    <h5>Worksheet #1</h5>
                                    <h5>Date: 3/2/16</h5>
                                    <h5>Topic: English</h5>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">Worksheet</div>
                                <div class="panel-body">
                                    <div class="modal-dialog">
                                        <!--<div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>

                                        </div>--><!-- /.modal-content -->
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
            </div>
            
        </section>
        
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="/flatUI/js/bootstrap.min.js"></script>
        
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