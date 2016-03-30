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
                            <div class="controls col-md-3">  
                                <div class="row">
                                    <div>
                                        <h4><a href= "javascript:window.open('info.php','Gonzaga University Corpus Info','width=700,height=650')" target="_blank"><class="text-muted">Input Instructions</a></h4> 
                                    </div>
                                </div>
                                <div class="row">
                                    <form method="POST" action="" role="form" id="WordsForm" autocomplete="off">
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
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <span><h2>New Search</h2><button type="submit" class="btn btn-primary pull-right">
                                                        Load search data into selector ==>
                                                    </button> </span>
                                                 </div>
                                                <div class="row">
                                                    <div class="col-md-12 pull-right">
                                                        <hr>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="entry form-group row"> 
                                            <div class="col-md-10">
                                                <div class="col-xs-5">
                                                    <input type="text" class="form-control" name="words[]" placeholder="Word">                                             
                                                </div>
                                                <div class="col-xs-5">
                                                    <input class="form-control" name="PoS[]" id="PoS[]" placeholder="Part of Speech">
                                                    <!--<div class="btn-group" id="PoS-suggest" ></div>-->
                                                </div>

                                                <!--<div class="col-xs-3">
                                                    <label><input class="form-control" type="number" min="0" value=0 id="offset[]" name="offset[]" placeholder="Word Offset"></label>
                                                </div>-->
                                                <div class="col-xs-2">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary btn-add" type="button">
                                                            <span>Add a Word</span>
                                                        </button>
                                                    </span>   
                                                </div>
                                            </div>
                                        </div> 



                                    </form> 
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-primary" style="min-height:500px;max-height:500px; overflow-y:scroll">
                                    <div class="panel-heading">
                                        Select Search Parameters 
                                            <button type="submit" class="btn btn-default pull-right">Preview</button>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="panel-body">
                                            
                                                <?php
            if ((!(empty($_POST['words']))) && (!(empty($_POST['PoS']))))
            {
                $query_count = 0;
                
                $words = $_POST['words'];  
                $tags = $_POST['PoS'];
                $num_entries = max(count($words), count($tags));
                for ($i = 0; $i < $num_entries; $i++)
                {
                    if ( ( strlen($words[$i]) > 0 ) || ( strlen($tags[$i]) > 0))
                        $query_count++;
                }
                
                if ( $query_count > 0)
                {
                    echo "<table class='table table-hover'><thead>
                                                <tr>
                                                    <th><label><input type='checkbox' id='checkAll'> Select All </label></th>
                                                    <th>Form</th>
                                                    <th>Tag</th>
                                                    <th>Frequency</th>
                                                </tr>
                                            </thead>";
                    $query_index = 1;
                    $query_stem = "SELECT WordID, Form, PoS, Frequency FROM Dictionary WHERE ";
                    
                    $options = array( "Scrollable" => 'static' );
                    echo "<tbody>";
                    while ($query_index <= $query_count)
                    {
                        $condition = "";
                        if ( (strlen($words[$query_index - 1]) > 0) && (strlen($tags[$query_index - 1]) > 0))
                        {
                            $condition = "Form = ? AND PoS = ?";
                            $query = $query_stem . $condition;
                            $params = array($words[$query_index - 1], $tags[$query_index - 1]);
                            $display_string = $params[0] . " with Part-of-Speech " . $params[1];
                        }
                        elseif (strlen($words[$query_index - 1]) > 0)
                        {
                            $condition = "Form = ?";
                            $query = $query_stem . $condition;
                            $params = array($words[$query_index - 1]);
                            $display_string = $params[0] . " with any Part-of-Speech";
                        }
                        elseif (strlen($tags[$query_index - 1]) > 0)
                        {
                            $query = "SELECT PoS, count(*) FROM Dictionary WHERE PoS=? GROUP BY PoS";
                            $params = array($tags[$query_index - 1]);
                            $stmt = sqlsrv_query($con, $query, $params, $options);
                            if ($stmt === false)
                                die (print_r(sqlsrv_errors(), true));
                            $result_length = sqlsrv_num_rows($stmt);
                            $tags_ = [];
                            $freq = [];
                            $forms = [];
                            $ids = [];
                            while (sqlsrv_fetch($stmt) === true)
                            {
                                $tags_[] = sqlsrv_get_field($stmt, 0);
                                $freq[] = sqlsrv_get_field($stmt, 1);
                                $ids[] = '';
                                $forms[] = '';
                            }
                            echo "<tr><td>$query_index [Tag Only]</td><td></td><td></td><td></td></tr>";
                            for ($i = 0; $i < $result_length; $i++)
                                echo "<tr><td><input type='checkbox'></td><td>$forms[$i]</td><td>$tags_[$i]</td><td>$freq[$i]</td></tr>";

                            $query_index++;
                            continue;
                        }
                        
                        $stmt = sqlsrv_query($con, $query, $params, $options);
                        if ($stmt === false)
                            die (print_r(sqlsrv_errors(), true));
                        $result_length = sqlsrv_num_rows($stmt);
                        $ids = [];
                        $forms = [];
                        $tags_ = [];
                        $freq = [];
                        while (sqlsrv_fetch($stmt) === true)
                        {
                            $ids[] = sqlsrv_get_field($stmt, 0);
                            $forms[] = sqlsrv_get_field($stmt, 1);
                            $tags_[] = sqlsrv_get_field($stmt, 2);
                            $freq[] = sqlsrv_get_field($stmt, 3);
                        }
                        
                        
                                                
                        echo "<tr><td>$query_index</td><td></td><td></td><td></td></tr>";
                        for ($i = 0; $i < $result_length; $i++)
                            echo "<tr><td><input type='checkbox'></td><td>$forms[$i]</td><td>$tags_[$i]</td><td>$freq[$i]</td></tr>";
                       
                        $query_index++;
                    }
                    
                }
                else
                {
                    echo "<p>To search, enter desired data into the form to the left of this window</p>";
                }
            }
            
                
            
        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Preview Search
                                    </div>
                                    <div class="panel-body">
                                        [ WORDS | TAGS | OFFSETS ]
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