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
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">

    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
    if( !( ($_SESSION['Role'] == 'Admin') && $_SESSION['AccessType'] == 'Super'))
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
                            <div class="col-lg-8 col-md-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3>Add Institution</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form method="POST" id="NewInstitution" name="NewInstitution" action="">
                                            <label for="Name">Institution Name and Location</label>
                                            <div class="form-group row">
                                                <div class="col-lg-6 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-3 col-md-4 col-sm-4">
                                                    <input type="text" class="form-control" id="City" name="City" placeholder="City" />
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-4">
                                                    <input type="text" class="form-control" id="StateRegionProvince" name="StateRegionProvince" placeholder="State/Region/Province" />
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-4">
                                                    <input type="text" class="form-control" id="Country" name="Country" placeholder="Country" />
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <label for="NumTerms">Enter the number of terms in a year and enter their names (Spring I, Fall, Winter II, etc)</label>
                                            <div class="form-group row">
                                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-8">
                                                    <select class="form-control" name="NumTerms" id="NumTerms" onchange="addFields();">
                                                        <option selected="selected">--Number of Terms--</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                    </select>
                              
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-10" id="TermContainer">
                                                </div>
                                            </div>
                                            <button class="btn btn-primary pull-right" type="submit">Create Institution</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3>Institutions</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Location</th>
                                                    <th>Number of Teachers</th>
                                                    <th>Active Courses</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Gonzaga University</td>
                                                    <td>Spokane, WA, USA</td>
                                                    <td>32</td>
                                                    <td>5</td>
                                                    <td><a href="ViewInstitution/">View/Edit</a></td>
                                                </tr>
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
            <script type="text/javascript" src="/js/SidebarPractice.js"></script>
            <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
            </script>
            <script type="text/javascript">
            function addFields(){
                var number = document.getElementById("NumTerms").value;
                var container = document.getElementById("TermContainer");
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }
                for (i=1;i<=number;i++){
                    var input = document.createElement("input");
                    input.type = "text";
                    input.className = "form-control";
                    input.name = "term" + i;
                    input.id = "term" + i;
                    input.placeholder = "Enter Term " + i;
                    container.appendChild(input);
                    //container.appendChild(document.createElement("br"));
                }  
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
