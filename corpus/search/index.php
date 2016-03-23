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
<!--
    <link href="/css/advancedsearch.css" rel="stylesheet">
-->
    <link href="/FlatUI/css/corpus/theme.css" rel="stylesheet" media="screen">
    
    
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
                container = controlForm.children()
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span>Remove Word</span>');
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
        #language-list{float:left;list-style:none;margin:0;width:100%;padding:0;opacity:1.0;}
        #language-list li{padding: 10px;background-color: #8b8b8b; border-bottom:#F0F0F0 1px solid;border-width:#F0F0F0 1px solid; opacity:1.0;}
        #language-list li:hover{background: rgba(56, 110, 128, 1);}
        
        #tags-list{float:left;list-style:none;margin:0;width:100%;padding:0;opacity: 1;}
        #tags-list li{padding: 10px;background-color: #8b8b8b; border-bottom:#F0F0F0 1px solid;border-width:#F0F0F0 1px solid;}
        #tags-list li:hover{background: rgba(56, 110, 128, 1);}
        
        .btn-add {
            min-height: 34px;
        }
        .btn-remove {
            min-height: 34px;
        }
        .btn-primary {
            /*float: right; */
            max-width:180px;
            min-height: 34px;
            position: static;
        }
        .input-group {
            /*min-width: 569px;*/
        }
        
        .select {
            position:relative;
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
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="pull-right">Gonzaga University Smalltalk Corpus</h2>
                            </div>
                        </div>
                        <hr style="border-top: medium double;">
                        <div class="controls">  
                            <div class="row">
                                <div>
                                    <h4>Filter Results by Category</h4> 
                                </div>
                            </div>
                            <div class="row">
                                <form method="POST" role="form" id="WordsForm" autocomplete="off">
                                    <div class="form-group row">
                                        <div class="col-md-10">
                                            <div class="col-xs-4">
                                                <input class="form-control" type="text" id="language-search" name="language-search" placeholder="Language" value="<?php echo isset($_POST['language-search']) ? $_POST['language-search'] : '--Select Level--' ?>">
                                                <div id="languages-box"></div>
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="form-control" type="text" id="topic" name="topic" placeholder="Topic Keywords" value="<?php echo isset($_POST['topic']) ? $_POST['topic'] : '' ?>">
                                            </div>
                                            <div class="col-xs-4">
                                                <select class="form-control" name="level" id="level">
                                                    <option selected="selected" value="<?php echo isset($_POST['level']) ? $_POST['level'] : '--Select Level--' ?>"><?php echo isset($_POST['level']) ? $_POST['level'] : '--Select Level--' ?></option>
                                                    <option value="Entry">Entry</option>
                                                    <option value="Basic">Basic</option>
                                                    <option value="Intermediate">Intermediate </option>
                                                    <option value="Advanced">Advanced</option>
                                                    <option value="Seminar">Seminar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <span><h2>Search</h2></span>
                                            <a href= "javascript:window.open('info.php','Gonzaga University Corpus Info','width=500,height=150')" target="_blank" class="pull-right"><class="text-muted">Input Instructions</a>
                                        </div>
                                    </div>  
                                    <div class="entry form-group row"> 
                                        <div class="col-md-10">
                                            <div class="col-xs-3">
                                                <input type="text" class="form-control" name="words[]" placeholder="Word">                                             
                                            </div>
                                            <div class="col-xs-3">
                                                <input class="form-control" name="PoS[]" id="PoS[]" placeholder="Part of Speech">
                                                <!--<div class="btn-group" id="PoS-suggest" ></div>-->
                                            </div>
                                            
                                            <div class="col-xs-3">
                                                <label><input class="form-control" type="number" min="0" id="offset[]" name="offset[]" placeholder="Word Offset"></label>
                                            </div>
                                            <div class="col-xs-2">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success btn-add" type="button">
                                                        <span>Add a Word</span>
                                                    </button>
                                                </span>   
                                            </div>
                                        </div>
                                    </div> 
                                        
                                    
                                    
                                </form> 
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                <button type="submit" class="btn btn-primary" form="WordsForm">
                                    Search
                                </button>  
                            </div>
                        </div>
                            
                        <hr>       
                        
                        <div class="row">
                            
                            <div class="col-md-10">
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
                                            <tbody>
                                            <?php
        if (!(empty($_POST['words'])))
        {
            $words = $_POST['words'];  
            
            foreach($words as $word)
                echo $word;
        }
        if (!(empty($_POST['PoS'])))
        {
            $PoS = $_POST['PoS'];  
            $len = count($PoS);
            for($i = 0; $i < $len; $i++)
                echo $PoS[$i];
        }
        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>


        
</div>
</div>
</div>
            <script>
            
            
            $(document).ready(function(){
                $("#language-search").keyup(function(){
                    $.ajax({
                    type: "POST",
                    url: "getlanguage.php",
                    data:'keyword='+$(this).val(),
                    
                    success: function(data){
                        $("#languages-box").show();
                        $("#languages-box").html(data);
                    }
                    });
                });
                
                
                    
                   
            });
            
            /*$(document).on("keyup", 'input[name^=PoS]', function(){
                $(this).closest( "div.entry").css("background-color", "red");
                $.ajax({
                    type: "POST",
                    url: "suggestPartOfSpeech.php",
                    data:'keyword='+$(this).val(),
                    success: function(data){
                        $("#PoS-suggest").show();
                        $("#PoS-suggest").html(data);
                    }
                });
            });
            function selectTag(val) {
                $(window.prevPrevFocus).val(val);
                $("#PoS-suggest").hide();
            }*/
            function selectLanguage(val, id) {
                $("#language-search").val(val);
                $("#language-id").val(id);
                $("#languages-box").hide();
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