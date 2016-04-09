<?php include "../../base.php"; ?>
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
    <link href="/FlatUI/css/theme.css" rel="stylesheet" media="screen">

    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if( !(($_SESSION['Role'] == 'Admin') && ($_SESSION['AccessType'] == 'Super')))
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        $params = array();
        $options = array( "Scrollable" => 'static');
        $adminsSQL = "
        SELECT I.InstitutionName, A.FirstName, A.LastName, A.AdministratorID, R.Designation, CONVERT(VARCHAR(11), SU.date_added, 106)
        FROM Institutions as I, Administrators as A, RoleInstances as RI, Roles as R, SiteUsers as SU
        WHERE A.RoleInstanceID = RI.RoleInstanceID AND
              SU.username = A.SiteUsername AND
              RI.RoleID = R.RoleID AND
              R.Role = 'Admin' AND
              I.InstitutionID = A.InstitutionID";
        $admins = sqlsrv_query($con, $adminsSQL, $params, $options);
        if ($admins === false)
            die(print_r(sqlsrv_errors(), true));
        $num_admins = sqlsrv_num_rows($admins);
        $institutions = [];
        $fnames = [];
        $lnames = [];
        $adminids = [];
        $designations = [];
        $dates = [];
            
        while (sqlsrv_fetch($admins) === true)
        {
            $institutions[] = sqlsrv_get_field($admins, 0);
            $fnames[] = sqlsrv_get_field($admins, 1);
            $lnames[] = sqlsrv_get_field($admins, 2);
            $adminids[] = sqlsrv_get_field($admins, 3);
            $designations[] = sqlsrv_get_field($admins, 4);
            $dates[] = sqlsrv_get_field($admins, 5);
            
        }
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
                            <div class="col-lg-8">
                                <h1>Smalltalk Admins</h1>
                                <h4><small>Superuser Page</small></h4>
                            </div>
                            

                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                
                                <h4><form method="POST" action="/Admin/AddUser/"><button class="btn btn-primary">Create Admin</button></form></h4>
                                <!--<div class="panel panel-primary">
                                    <div class="panel-heading">Add New Admin (Manually)</div>
                                    <div class="panel-body">
                                         <form method="POST" id="filterActivityQueue" action="">
                                            <div class="form-group row">
                                                
                                                
                                                <div class="col-lg-4">
                                                    <input class="form-control" type="text" name="fname" id="fname" placeholder="First Name"><br />
                                                    <input class="form-control" type="text" name="Email" id="Email" placeholder="School Email"><br />
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control" type="text" name="lname" id="lame" placeholder="Last Name"><br />
                                                    
                                                    <input class="form-control" type="text" name="AltEmail" id="AltEmail" placeholder="Alternate Email"><br />
                                                </div>
                                                <div class="col-lg-4">
                                                    
                                                <select class="form-control" name="Designation" id="Section">
                                                    <option selected="selected">--Designation--</option>
                                                    <option>Primary</option>
                                                    <option>Developer</option>
                                                    <option>Other</option>
                                                </select>
                                                </div>
                                                
                                                
                                            </div>
                                             <button class="btn btn-primary pull-right">Add Admin</button>
                                        </form>
                                    </div>
                                </div>-->
                                
                                    
                            </div>
                            <!--<div class="col-lg-3 col-md-3 col-sm-4">
                                <div class="panel panel-primary" style="min-height: 225px;max-height: 225px;">
                                    <div class="panel-heading">Add New Admin (By File)</div>
                                    <div class="panel-body">
                                        <form>
                                             <div class="form-group">
                                                <input type="file" id="studentListFile">
                                                <p class="help-block">File format: .csv</p>
                                                <p class="help-block">Columns (no headers): First Name, Last Name, Email, Alternate Email, Designation</p>
                                            </div>
                                            <button type="submit" class="btn btn-primary pull-right">Add Admins</button>
                                        </form>
                                    </div>
                                </div>
                                
                                    
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-10">

                                <div class="panel panel-primary" style="min-height: 400px; max-height: 400px; ">
                                    <div class="panel-heading">Admins</div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Institution</th>
                                                    <th>Name</th>
                                                    <th>Designation</th>
                                                    <th>Date Added</th>
                                                    <th>Visit Page</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
        for($i = 0; $i < $num_admins; $i++)
        {
            echo "<tr>
                    <td>$institutions[$i]</td>
                    <td>$fnames[$i] $lnames[$i]</td>
                    <td>$designations[$i]</td>
                    <td>$dates[$i]</td>
                    <td><form method=\"POST\" action=\"ViewAdmin/\" name=\"admins{$i}\">
                          <input hidden type=\"text\" name=\"adminID\" value=\"$adminids[$i]\">
                          <button class=\"btn btn-primary\">View Admin</button>
                        </form>
                    </td>
                  </tr>";
        }
?>
                                                
                                            </tbody>
                                        </table>
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
            <script src="/js/bootstrap-datepicker.js"></script>
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
