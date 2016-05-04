<!-- Home (index.html) for Teacher account -->
<?php include "../base.php"; ?>
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
    <link rel="stylesheet/less" type="text/css" href="/datepicker.less" />
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">

    
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
        $options = array( "Scrollable" => 'static' );
        $getPasswordQuery = "SELECT password FROM SiteUsers WHERE username = ?";
        $stmt = sqlsrv_query($con, $getPasswordQuery, $params, $options);
        if ($stmt === false)
            die (print_r(sqlsrv_errors(), true));
        if (sqlsrv_fetch($stmt) === true)
            $password = sqlsrv_get_field($stmt, 0);
        
        
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
                            <div class="col-sm-8 col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Reset Password
                                    </div>
                                    <div class="panel-body">
                                        <form method="POST" id="confirmPassword" autocomplete="Off" AutoCompleteType="Disabled">
                                            <div class="form-group row">
                                                <div class="col-xs-6">
                                                    <label for="currentPassword">Enter Password:</label>
                                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" autocomplete="Off">
                                                    <input hidden type="text" id="password" value="<?=$password?>">
                                                </div>
                                                <div class="col-xs-2" id="checkmark"></div>
                                            </div>
                                        </form>
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
        </script>
        <script>
        $(document).ready(function(){
            $("input").blur(function(){
                
                var password = document.getElementById("password").value;
                var currentpassword = document.getElementById("currentPassword").value;
                if ( password !== ""){
                    if (password === currentpassword){
                        ConfirmPassword();}
                    else {
                        DenyPassword();
                    }
                }   
                
                
            });
        });
        function ConfirmPassword(){
            $("#checkmark").empty();
            var span = $('<span />').addClass('glyphicon glyphicon-ok').css("font-size", "25px");
            $("#checkmark").append(span);
            
        }
        function DenyPassword(){
            $("#checkmark").empty();
            var span = $('<span />').addClass('glyphicon glyphicon-remove').css("font-size", "25px");
            $("#checkmark").append(span);
        }
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
