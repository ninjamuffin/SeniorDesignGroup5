<?php 
include "../../../../../../base.php";
?>
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
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">

    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script type="text/javascript" src="/js/getText.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
    <script>
        var selection = "<---------->";
    </script>
</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Admin')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        $courseID = isset($_GET['courseID']) ? $_GET['courseID'] : 0;
        $worksheetNum = isset($_GET['worksheetNum']) ? $_GET['worksheetNum'] : 0;
        if (false)
            echo "<meta http-equiv='refresh' content='0;../../' />";
        else
        {
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
                            <div class="col-lg-10">
                                <h3>Annotation Editor</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="panel panel-primary" style="min-height: 300px;max-height: 300px; overflow-y:scroll">
                                    <div class="panel-heading">
                                        Expressions List
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Expression</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td><a href="/Admin/Archive/Students/ViewStudent/?sid=">Name</a></td>
                                                    <td>Here's a expression</td>
                                                    <td><a href="#Function();">Open in Editor</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="panel panel-primary" style="min-height: 500px;max-height: 500px; overflow-y:scroll">
                                    <div class="panel-heading">
                                        Editor
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-xs-6">
                                            <!--Working here-->
                                            <style>
                                                fieldset {
                                                    display: inline-block;
                                                    padding-left: 220px;
                                                    padding-top: 60px;
                                                }
                                            </style>
                                            <form onsubmit="printSelection()">
                                                <fieldset>
                                                <input type="text" class="form-control"     placeholder="Make Selection" id="input">
                                                </fieldset>
                                                <input class="btn btn-default" type="submit"/>
                                            </form>
                                            
                                            <div style="padding-top: 100px;">
                                                <pre>
                                                    <h3>Expressions:</h3>
                                                    <h5>1. I no understand how to talk English</h5>
                                                    <h5>2. How is you today?</h5>
                                                    <h5>3. I drive to home for meal</h5>
                                                    <h5>4. I no understand how to talk English</h5>
                                                    <h5>5. How is you today?</h5>
                                                    <h5>6. I drive to home for meal</h5>
                                                    <h5>7. I no understand how to talk English</h5>
                                                    <h5>8. How is you today?</h5>
                                                    <h5>9. I drive to home for meal</h5>
                                                    <h5>10. I drive to home for meal</h5>
                                                </pre>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-6" style="padding-top: 100px;">
                                            <div id="expression">
                                                
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Verbs <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Nouns <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Pronouns <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Adjective <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Adverb <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Preposition <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Conjunctions <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Interjections <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-header">Dropdown header</li>
                                                    <li class="disabled">
                                                        <a tabindex="-1" href="#">Disabled</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Something else here</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a tabindex="-1" href="#">Separated link</a>
                                                    </li>
                                                </ul>
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
