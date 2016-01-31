<?php include "/base.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Gonzaga Smalltalk</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
    </script>
</head>

<?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        // let the user access the page
        if($_SESSION['Role'] != 'admin')
        {
            ?>
            <p> Sorry, you do not have permissions to view this page. <a href=\index.php>Back to main page</a>;
            <?php
        }
        else
        {
            ?>
            <body background="/media/gonzagasmalltalk_background.png">
                <div id="header"></div>
                <div class="jumbotron">
                    <div class="container">
                        <p>Documentation:</p>
                        <p></p>
                    </div>
                </div>
            </body>
            <?php
        }
    }
    else
    {
        ?>
        <p>Oops! it looks like you aren't logged in. <a href=/index.php>Click here to log in.</a></p>
        <?php        
    }
?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.js"></script>
</html>