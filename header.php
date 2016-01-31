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
    if(!empty($_SESSION['LoggedIn'] && !empty($_SESSION['Username']))
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
                <a href="index.html" class="navbar-brand">Gonzaga SmallTalk</a>
              </div>

              <div class="collapse navbar-collapse navbar-ex1-collapse right-offset">

                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a href="javascript:void(0);" dropdown="" dropdown-toggle data-toggle="dropdown">
                      <span class="glyphicon glyphicon-user"></span> USER_NAME <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/Admin/Home/ViewProfile/index.html">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="/Admin/Home/ViewProfile/index.html">Settings</a></li>
                        <li class="divider"></li>
                        <li>Logged in as: <?=$_SESSION['role']?></li>
                        <li class="divider"></li>
                        <li><a href="/logout.php">Log out</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
    </body>
    <?php
    }
    
    ?>
    
    
</html>