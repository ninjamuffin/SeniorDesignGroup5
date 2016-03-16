<?php include '../../base.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gonzaga Small Talk</title>
    
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/css/advancedsearch.css" rel="stylesheet">
    <link href="/FlatUI/css/theme.css" rel="stylesheet" media="screen">
    
    
    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    
    
    <!-- Bootstrap -->
    

    
    <script type="text/javascript">$(function()
    {
        $(document).on('click', '.btn-add', function(e)
        {
            e.preventDefault();

            var controlForm = $('.controls form:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function(e)
        {
            $(this).parents('.entry:first').remove();
            e.preventDefault();
            return false;
        });
    });
    </script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
    <style>
        .btn-add {
            min-height: 34px;
        }
        .btn-remove {
            min-height: 34px;
        }
        .btn-primary {
            float: right; 
            min-width: 200px;
            min-height: 34px;
        }
        .input-group {
            min-width: 569px;
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
            <div id="wrapper">
                <div id="sidebar"></div>
                <div id="page-content-wrapper">
                    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                    <span class="hamb-top"></span>
                                    <span class="hamb-middle"></span>
                                    <span class="hamb-bottom"></span>
                                </button>
                    <div class="container-fluid">
                        <div class="control-group" id="fields">
                            <div class="controls">  
                                <form method="POST" action="" role="form" autocomplete="off">
                                    <div class="row">
                                        <div class="col-xs-5">
<button type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
</div>
                                    </div>
                                    <!--Data entry for Level, Language, Topic-->
                                      
                                    <div class="entry row">
                                            <div class=" container">
                                                <div class=" panel panel-primary">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                        <div class="col-lg-10">
                                                            <div class="form-group row" id="adv-search">
                                                                <div class="col-lg-1"><span class="input-group-btn">
                                                                <button class="btn btn-success btn-add" type="button">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                                </button>
                                                                </span>
                                                                    </div>
                                                                <div class="col-lg-6">
                                                                <input type="text" class="form-control" name="words[]" placeholder="Search for a word">
                                                                    </div>
                                                                <div class="col-lg-3">
                                                                <select class="form-control" name="PoS_One" id="PoS_One">
                                                                    <option selected="selected">--PartOfSpeech Category</option>
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                </select>
                                                                    </div>
                                                                
                                                            </div>
                                                        </div>
                                                            </div>
    <!--
    -->
                                                    </div>
                                                </div>


                                            </div>
                                        
                                    </div>
                                </form>                                     
                            </div>
                        </div>
                                
                                <div class="row">
                                    <div class="col-lg-8">
                                        <form method="POST" action="" role="form">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4>Filter Results</h4>
                                        </div>
                                                <div class="panel-body">
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-4">
                                                            <select style="width:150px;" class="form-control" name="Level" id="Level">
                                                                <option selected="selected">Level</option>
                                                                <option value="1">1 (099-100)</option>
                                                                <option value="2">2 (101-102)</option>
                                                                <option value="3">3 (103-104)</option>
                                                                <option value="4">4 (105-106)</option>
                                                                <option value="5">5 (107-108)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-4">
                                                            <input style="width:150px;" class="form-control" type="text" onkeyup="showHint(this.value)" name="Language" id="Language" placeholder="Language" >
                                                        <p>Suggestions: <span id="txtHint"></span></p>

                                                        </div>
                                                        <div class="form-group col-lg-4">
                                                            <input style="width:150px;" class="form-control" type="text" name="Topic" id="Topic" placeholder="Topic" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                </form>
                                    </div>
                                </div>
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Search Results</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Expression</th>
                                                    <th>Vocab/Context</th>
                                                    <th>Topic</th>
                                                    <th>Language</th>
                                                    <th>Level</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


        
</div>
</div>
</div>
            <script>
            
            function showHint(str) {
                if (str.length == 0) { 
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        }
                    };
                    xmlhttp.open("GET", "getlanguage.php?q=" + str, true);
                    xmlhttp.send();
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
    <!-- To Do: Add alternate corpus view section -->
    <p>Oops! You are not logged in. We do not yet support access to the corpus without authorization from our administrators.</p>
    <p>Redirecting to log-in in 5 seconds</p>
    <p>Click <a href="/">here</a> if you don't want to wait</p>
    <meta http-equiv='refresh' content='5;/' />
    <?php
}
?>


</html>