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
    <link href="/css/SidebarPractice.css" rel="stylesheet">

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

    <!-- Background Setup -->
    <style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}

.filter{
    position: absolute;
    left: 600;
    top:5000;
}

.onoffswitch {
    position: absolute;
    left: 625px;
    top: 50px;
    width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    display: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "ON";
    padding-left: 10px;
    background-color: #34A7C1; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "OFF";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    position: absolue; top:20px ; bottom: 20px;
    right: 56px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
    
.Search {
    position: static;
    right: 120px;
    top: 75px;
    
    
}
</style>        
    <style>
        body{
            background: url(/Media/gonzagasmalltalk_background.png) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: auto;
        }
    </style>
</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if( !(($_SESSION['Role'] == 'Admin') || ($_SESSION['Role'] == 'Teacher') ))
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        ?>
        <body>
            <div id="header"></div>
            <div id="wrapper">
                <div id="sidebar"></div>
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                    <span class="hamb-top"></span>
                                    <span class="hamb-middle"></span>
                                    <span class="hamb-bottom"></span>
                                </button>
                                <div class="Search">
                                            <button type="button" class="btn btn-primary"> 
                                                <a style="color:white" href="/corpus/search/"><span class="glyphicon glyphicon-search"></span> New Search</a></button>
                                        </div>

                                    <div class="panel panel-default">
                                    <div class="panel-heading">Search</div>
                                    <div class="panel-body">

                                        


                                        <!--<div class="onoffswitch">
                                        <label for="filter">Errors</label>
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked="">
                                        <label class="onoffswitch-label" for="myonoffswitch">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                        </label>
                                        </div>-->    

                                    <p>Level: level_Variable</p>
                                    <p>Language: language_Variable</p>
                                    <p>Topic: topic_Variable</p>

                                        <table style="width:80%">
                                        <caption>Analyze an expression</caption>

                                        <tr>
                                        <td>Search String</td>
                                        <td>He ran very fast</td>
                                        </tr>
                                        <tr>
                                        <td>Parts of Speech</td>
                                        <td> pronoun verb adverb adjective </td>
                                        </tr>
                                        </table>      
                                    </div>
                                    </div>



                                    <div class="panel panel-default">
                                        <div class="panel-heading">Search Results</div>
                                            <div class="panel-body">

                                                <!--  <h2>Search Results</h2>  -->
                                                <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#home">Expressions</a></li>
                                                <li><a data-toggle="tab" href="#menu1">Charts</a></li>
                                                <li><a data-toggle="tab" href="#menu2">Stats</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div id="home" class="tab-pane fade in active">
                                                    <!-- EVERYTHING IN HERE IS IN THE FIRST TAB--> 
                                                    <table style="width:80%">
                                                    <caption>Search Results</caption>
                                                    <tr>
                                                    <td>Expression 1 ...</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Expression 2 ...</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Expression 3 ...</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Expression 4 ...</td>
                                                    </tr>
                                                    </table>      

                                                    </div>
                                                    <div id="menu1" class="tab-pane fade">
                                                    <!-- 2ND TAB-->
                                                    <p> Graphical representation of search results.</p>

                                                    </div>
                                                    <div id="menu2" class="tab-pane fade">
                                                    <!--3RD TAB-->
                                                    <p> Statistics about the search results.</p>
                                                    </div>
                                                </div>
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
        </body> 
        <?php        
    }
}

else
{
    ?>
    <!-- To Do: Add alternate corpus view section -->
    <p>Oops! You are not logged in. We do not yet support access to the corpus without authorization from our administrators.</p>
    <p>Redirecting to log-in in 5 seconds</p>
    <p>Click <a href="/">here</a> if you don't want to wait</p>
    <meta http-equiv='refresh' content='5;/' />
    <?php
}
?>

</html>
