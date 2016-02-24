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
                        <li><a href="/<?=$_SESSION['Role']?>/Home/Profile/">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="/<?=$_SESSION['Role']?>/Home/Profile/">Settings</a></li>
                        <li class="divider"></li>
                        <li>Logged in as: <?=$_SESSION['Role']?></li>
                        <li class="divider"></li>
                        <li><a href="/logout.php">Log out</a></li>
                    </ul>
                  </li>
                  <li id="tab" class="btn-group" data-toggle="buttons-radio">
                    <a href="#" class="btn btn-large btn-info active" data-toggle="tab">Admin</a>
                    <a href="#" class="btn btn-large btn-info" data-toggle="tab">Teacher</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
    </body>
    <?php
    }
    else
       {
            ?>
            <!-- Reroute to log-in page if there is no session detected -->
            <meta http-equiv='refresh' content='0;index.php' />
            <?php
       }
    
    ?>
    
    
</html>