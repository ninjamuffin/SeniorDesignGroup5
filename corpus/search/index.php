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
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/advancedsearch.css" rel="stylesheet">
    <!-- Including Header -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
    
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    
    
    
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
            $("#sidebar").load("/corpus/sidebar.php");
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
                                <div class="control-group" id="fields">
                                <div class="controls"> 
                                <div class="well"> 
                                <form method="POST" action="../Results/" role="form" autocomplete="off">
                                    <div class="form-group">
                                        <label for="Level">Level</label>
                                        <select class="form-control" name="Level" id="Level">
                                            <option value="1">1 (099-100)</option>
                                            <option value="2">2 (101-102)</option>
                                            <option value="3">3 (103-104)</option>
                                            <option value="4">4 (105-106)</option>
                                            <option value="5">5 (107-108)</option>
                                        </select>
                                    </div>
                                    <label for="Language">Language</label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="Language" id="Language">
                                    </div>
                                    <label for="Topic">Topic</label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="Topic" id="Topic">
                                    </div>
                                <div class="entry col-lg-10">
                                <div class="container">
                                <label for="contain">Word Search</label>
                                    <div class="word filter">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group" id="adv-search">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn-add" type="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                        </button>
                                                    </span>
                                                    <input type="text" class="form-control" name="words[]" placeholder="Search for a word">
                                                    <div class="input-group-btn">
                                                        <div class="btn-group" role="group">
                                                            <div class="dropdown dropdown-lg">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                                                                <div class="dropdown-menu dropdown-menu-right" role="menu">

                                                                    <div class="form-group">
                                                                        <label for="PoS">Part of Speech</label>
                                                                        <select class="form-control" name="PoS[]" id="PoS">
                                                                            <option value="Verb">Verb</option>
                                                                            <option value="Noun">Noun</option>
                                                                            <option value="Pronoun">Pronouns</option>
                                                                         </select>
                                                                      </div>                                          
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                    </div>
          
</div>
<div class="col-xs-5">
<button type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
    <!-- THIS WILL SEARCH THE WHOLE FIELD -->
                                </div>

</form>
                        </div>
                    </div>
                </div>
            </div>

        
</div>
</div>
</div>
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