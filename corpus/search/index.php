<?php 
include '../../base.php'; 

?>
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
    
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
            newEntry.find('input[name^=offset]').val(0);
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-primary').addClass('btn-danger')
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
/*
            max-width:180px;
*/
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
                        <div class="row">
                            <div class="col-md-4">  
                                
                                <div class="row">
                                    
                                        <!--<div class="form-group row">
                                            <div class="col-md-10">
                                                <div class="col-xs-4">
                                                    <input class="form-control" type="text" id="language-search" name="language-search" placeholder="Language" value="<?php echo isset($_POST['language-search']) ? $_POST['language-search'] : '' ?>">
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
                                        </div>-->
                                        <div class="panel panel-primary" style="min-height:600px;max-height:600px; overflow-y:auto">
                                            <div class="panel-heading">
                                                <h4>Add Search Entity <span><a href= "javascript:window.open('info.php','Gonzaga University Corpus Info','width=700,height=650')" target="_blank" class="pull-right"><class="text-muted">Input Instructions</a></span></h4> 
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <p>To begin building your search, send one of the following to the selector: a word, a POS tag, or an offset</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h4>Load in a word:</h4>
                                                    </div>
                                                </div>
                                                <form method="POST" action="" id="word_load">
                                                <div class="row">
                                                    <div class="col-xs-8">

                                                        <input type="text" class="form-control" name="new_word" placeholder="Type a word to search">                    
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary">
                                                                <span>Send to selector ==></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                </form>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h4>Load in a part-of-speech tag:</h4>
                                                    </div>
                                                </div>
                                                <form method="POST" action="" id="tag_load">
                                                <div class="row">
                                                    <div class="col-xs-8">

                                                        <select class="form-control" name="new_tag">
                                                            <option selected="selected" value="ALL">Full Tagset (165 Tags)</option>
                                                            <option value="noun">Noun Tags</option>
                                                            <option value="pronoun">Pronoun Tags</option>
                                                            <option value="verb">Verb Tags</option>
                                                            <option value="adjective">Adjective Tags</option>
                                                            <option value="adverb">Adverb Tags</option>
                                                            <option value="preposition">Preposition Tags</option>
                                                            <option value="conjunction">Conjunction Tags</option>
                                                            <option value="interjection">Interjection Tags</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary" >
                                                                <span>Send to selector ==></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                </form>
                                                <hr>
                                                
                                                
                                                </form>
                                            </div>
                                        </div>
                                        <!--<div class="entry form-group"> 
                                            <div class="col-md-10">
                                                <div class="col-xs-4">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary btn-add" type="button">
                                                            <span>Add a Word</span>
                                                        </button>
                                                    </span>   
                                                </div>
                                                <div class="col-xs-4">
                                                    <input type="text" class="form-control" name="words[]" placeholder="Word">                                             
                                                </div>
                                                <div class="col-xs-4">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" >
                                                            <span>Load word into selector</span>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="col-xs-5">
                                                    <input class="form-control" name="PoS[]" id="PoS[]" placeholder="Part of Speech">
                                                    <div class="btn-group" id="PoS-suggest" ></div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <label><input class="form-control" type="number" min="0" value=0 id="offset[]" name="offset[]" placeholder="Word Offset"></label>
                                                </div>
                                                
                                            </div>
                                        </div> -->



                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary" style="min-height:600px;max-height:600px; overflow-y:auto">
                                    <div class="panel-heading">
                                        <h4>Customize Search Parameters</h4>
                                    </div>
                                    <div class="panel-body">
                                        <form method="POST" action="" id="SubmitNewEntity" autocomplete="off">
                                        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class='btn btn-danger' name="ClearSelector">Clear field</button>    
                                                    <button type="button" class="btn btn-primary pull-right" name="SubmitSelector">Move to Search Builder ==></button>
                                                </div>
                                            </div>
                                            <div name="DynamicField">

                                                    <?php
                if (!(empty($_POST['new_word'])))
                {
                    $query_valid = false;
                    if ( strlen($_POST['new_word']) > 0 )
                        $query_valid = true;

                    if ( $query_valid)
                    {
                        echo "<table class='table table-hover'><thead><tr>";
                        echo "<th><label><input type='checkbox' id='checkAll'> Select All </label></th><th>Form</th><th>Tag</th><th>Frequency</th></tr></thead>";

                        $query = "SELECT WordID, Form, PoS, Frequency FROM Dictionary WHERE Form= ?";

                        $options = array( "Scrollable" => 'static' );
                        $params = array($_POST['new_word']);
                        $word = $_POST['new_word'];
                        echo "<input hidden type='text' value='$word' name='addedWord'>";
                        echo "<tbody>";

                        $stmt = sqlsrv_query($con, $query, $params, $options);
                        if ($stmt === false)
                            die (print_r(sqlsrv_errors(), true));
                        $result_length = sqlsrv_num_rows($stmt);
                        $ids = [];
                        $forms = [];
                        $tags = [];
                        $freq = [];
                        while (sqlsrv_fetch($stmt) === true)
                        {
                            $ids[] = sqlsrv_get_field($stmt, 0);
                            $forms[] = sqlsrv_get_field($stmt, 1);
                            $tags[] = sqlsrv_get_field($stmt, 2);
                            $freq[] = sqlsrv_get_field($stmt, 3);
                        }

                        for ($i = 0; $i < $result_length; $i++)
                        {
                            echo "<tr><input hidden name='wordID[$i]' value='$forms[$i]'><td><input type='checkbox' name='checkbox[$i]'></td><td>$forms[$i]</td><td>$tags[$i]</td><td>$freq[$i]</td></tr>";
                        }
                        echo "</tbody></table>";


                    }
                    else
                    {
                        echo "<p>No data received</p>";
                    }
                }

                if (!(empty($_POST['new_tag'])))
                {
                    echo "<table class='table table-hover'><thead><tr>";
                    echo "<th><label><input type='checkbox' id='checkAll'> Select All </label></th><th>Tag Name</th><th>Tag Type</th><th>Frequency</th>";
                    echo "</tr></thead><tbody>";

                    if ($_POST['new_tag'] == "ALL")
                    {
                        $query = "SELECT TOP 40 sum(Frequency), PoS FROM Dictionary WHERE PoS in (SELECT Tag FROM CLAWS7) GROUP BY PoS ORDER BY sum(Frequency) desc";
                    }
                    else
                    {
                        $query = "SELECT TOP 10 sum(Frequency), PoS FROM Dictionary WHERE PoS in (SELECT Tag FROM CLAWS7) GROUP BY PoS ORDER BY sum(Frequency) desc";
                    }

                    $options = array( "Scrollable" => 'static' );
                    $params = array();
                    $stmt = sqlsrv_query($con, $query, $params, $options);
                    if ($stmt === false)
                        die(print_r(sqlsrv_errors(), true));
                    $length = sqlsrv_num_rows($stmt);
                    $tag_names = [];
                    $tag_type = [];
                    $frequency = [];

                    while (sqlsrv_fetch($stmt) === true)
                    {
                        $frequency[] = sqlsrv_get_field($stmt, 0);
                        $tag_names[] = sqlsrv_get_field($stmt, 1);
                        $tag_type[] = "Undetermined";

                    }

                    for ($i = 0; $i < $length; $i++)
                    {
                        $tag = $tag_names[$i];
                        $freq = $frequency[$i];
                        $type = $tag_type[$i];
                        echo "<tr><td><input type='checkbox'></td><td>$tag</td><td>$type</td><td>$freq</td>";
                    }
                    echo "</tbody></table>";
                }


            ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary" style="min-height:600px;max-height:600px; overflow-y:auto">
                                    <div class="panel-heading">
                                        <h4>Build Search Query</h4>
                                    </div>
                                    <div class="panel-body" style="height:100%">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <button class="btn btn-primary" type="submit">Submit Search</button>
                                                <div class="pull-right">
                                                    <label class="radio-inline"><input type="radio" name="searchType" checked="checked">Sequential</label>
                                                    <label class="radio-inline"><input type="radio" name="searchType">Non-Sequential</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <table class="table table-hover" id="sortParams">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Content</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>tag</td>
                                                    <td>Content</td>
                                                    <td><button class="btn btn-danger" type="button" name="DeleteRow">Delete</button></td>
                                                </tr>
                                                <tr>
                                                    <td>tag</td>
                                                    <td>Content</td>
                                                    <td><button class="btn btn-danger" type="button" name="DeleteRow">Delete</button></td>
                                                </tr>
                                                <tr>
                                                    <td>tag</td>
                                                    <td>Content</td>
                                                    <td><button class="btn btn-danger" type="button" name="DeleteRow">Delete</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="panel-footer" style="position:absolute; width:95%; bottom:0;">
                                        <form method="POST" onsubmit="addOffset">
                                            <div class="row">
                                                <div class="col-md-12 pull-right">
                                                
                                                    <label>Add a placeholder:<input class="form-control" type="number" min="0" max="8" value="0" id="newOffset" name="addOffset"></label>
                                                    <button class="btn btn-primary" id="addOffsetButton" type="button" >Add to Search Query</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        


        
</div>
</div>
</div>
            <script type="text/javascript">
            
            var fixHelper = function(e, ui) {
                ui.children().each(function() {
                    $(this).width($(this).width());
                });
                return ui;
            };
            
            $("#sortParams tbody").sortable({
                helper: fixHelper
            }).disableSelection();
            </script>
            <script>
            var numOffsets = 0;   
            $(document).ready(function() {
                $("#addOffsetButton").click(function() {
                    var offsetVal = $("#newOffset").val();
                    var before = '<tr><td>offset</td><td>';
                    var after = "</td><td><button class='btn btn-danger' type='button' name='DeleteRow'>Delete</button></td>";
                    var formDataOne = "<input hidden type='text' value='";
                    var formDataTwo = "' name='offset[";
                    var formDataThree = "]'></tr>";
                    
                    var toAdd = before + offsetVal + after + formDataOne + offsetVal + formDataTwo + numOffsets + formDataThree;
                    if (offsetVal == 0)
                        return false;

                    numOffsets = numOffsets + 1;
                    $("#sortParams").append(toAdd);
                });
            });
            
            $(document).ready(function() {
                $("ClearSelector").click(function() {
                    $("div[name='DynamicField']").empty();
                });
            });
            $(document).ready(function() {
                $("button[name='SubmitSelector']").click(function() {
                    var addWord = $("input[name='addedWord']").val();
                    
                    var before = '<tr><td>word</td><td>';
                    var after = "</td><td><button class='btn btn-danger' type='button' name='DeleteRow'>Delete</button></td></tr>";
                    var toAdd = before + addWord + after;
                    $("#sortParams").append(toAdd);
                    $("div[name='DynamicField']").empty();

                    
                });
            });
                
            $(document).on("click", "button[name='DeleteRow']", function() {
                $(this).closest('tr').remove();

            });
                
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
            $(document).on("click", 'input[name=loadWord]', function(){
                 
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
            $("#checkAll").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
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