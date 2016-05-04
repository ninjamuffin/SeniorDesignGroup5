<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    
//PHP STUFF
<?php
  //DB connection info
  //value for $host, $user, $pwd, and $db can be gotten from the portal / email
  //ODBC connection string for posterity: Driver={SQL Server Native Client 11.0};Server=tcp:o0tvd0xlpb.database.windows.net,1433;Database=Smalltalk Migrate;Uid=CS05@o0tvd0xlpb;Pwd={your_password_here};Encrypt=yes;TrustServerCertificate=no;Connection Timeout=30;
  $host = "o0tvd0xlpb.database.windows.net";
  $user = "CS05";
  $pwd = "!Elcwebapp";
  $db = "Smalltalk Migrate";

  //Connect to database
  try {
    $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  }
  
  catch(Exception $e){
    die(var_dump($e));
  }
  
  //From here the DB should be connected.  Next step, using info entered earlier to send to DB.
?>
  
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Senior Design Test Site</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Options<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Admin & Dashboard</li>
                            <li><a href="#">Admin 1</a></li>
                            <li><a href="#">Admin 2</a></li>
                            <li class="dropdown-header">Porfolio</li>
                            <li><a href="#">Porfolio 1</a></li>
                            <li><a href="#">Porfolio 2</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
        
        
    
        
        
    <div class="jumbotron">
        <div class="container">
            <form class="form-signin">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
          </form>
        </div>
    </div>

        

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
