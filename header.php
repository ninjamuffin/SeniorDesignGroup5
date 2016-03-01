<?php include "base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Bootstrap -->
        
        <link href="/css/bootstrap.css" rel="stylesheet">
        
    </head>
    
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
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
        <div class="navbar navbar-default navbar-fixed-top ng-scope">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <!--<a href="/<?=$_SESSION['Role']?>/Home/" class="navbar-brand"> <img src="/media/logo.jpeg"></a>-->
              </div>
                
              <div class="collapse navbar-collapse navbar-ex1-collapse right-offset">
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a href="javascript:void(0);" dropdown="" dropdown-toggle data-toggle="dropdown">
                      <span class="glyphicon glyphicon-user"></span> <?=$_SESSION['Username']?> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
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
                </div>
                  </div>
            </div>
          <script>
            function ChangeRole(str) {
            if (str.length == 0) { 
                document.getElementById("UserRoles").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("UserRoles").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "ChangeRole.php?q=" + str, true);
                xmlhttp.send();
            }
        }
          </script>
    </body>
    <?php
    }
    else
       {
            ?>
            <!-- Reroute to log-in page if there is no session detected -->
            <meta http-equiv='refresh' content='0;/index.php' />
            <?php
       }
    
    ?>
    
    
</html>