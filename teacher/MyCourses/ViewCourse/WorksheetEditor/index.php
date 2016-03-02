<!-- Edit Worksheet (index.php) for Teacher account -->

<?php include "../../../../base.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Gonzaga Small Talk</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/css/theme.css" rel="stylesheet" media="screen">
    
    <!-- Including Header -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
      
    </style>
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
    ?>        

    <body>
        <section class="container">
            <!--navbar-->
        
            <nav class="navbar navbar-inverse" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex8-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                <a class="navbar-brand" href="#">Navbar</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex8-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            
            <!--body-->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Details</div>
                        <div class="panel-body">
                            <h2 class="page-header">Course 121</h2>
                            <h5>Worksheet #1</h5>
                            <h5>Date: 3/2/16</h5>
                            <h5>Topic: English</h5>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Worksheet</div>
                        <div class="panel-body">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>

                                </div><!-- /.modal-content -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Content formating</div>
                            <div class="panel-body">
                                <p class="lead">This is lead paragraph</p>
                                <p>This is an <b>ordinary paragraph</b> that is <i>long enough</i> to wrap to <u>multiple lines</u> so that you can see how the line spacing looks.</p>

                                <hr/>

                                <p class="text-muted">Muted color paragraph.</p>
                                <p class="text-warning">Warning color paragraph.</p>
                                <p class="text-danger">Danger color paragraph.</p>
                                <p class="text-info">Info color paragraph.</p>
                                <p class="text-success">Success color paragraph.</p>

                                <p><small>This is text in a <code>small</code> wrapper. <abbr title="No Big Deal">NBD</abbr>, right?</small></p>

                                <hr/>

                                <div class="row">
                                    <address class="col-lg-6">
                                        <strong>Twitter, Inc.</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        <abbr title="Phone">P:</abbr> (123) 456-7890
                                    </address>
                                    <address class="col-lg-6">
                                        <strong>Full Name</strong><br>
                                        <a href="mailto:#">first.last@example.com</a>
                                    </address>
                                </div>

                                <hr/>

                                <blockquote>Here's what a blockquote looks like in Bootstrap. <small>Use <code>small</code> to identify the source.</small>
                                </blockquote>

                                <hr/>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul>
                                            <li>Normal Unordered List</li>
                                            <li>Can Also Work
                                                <ul>
                                                    <li>With Nested Children</li>
                                                </ul>
                                            </li>
                                            <li>Adds Bullets to Page</li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ol>
                                            <li>Normal Ordered List</li>
                                            <li>Can Also Work
                                                <ol>
                                                    <li>With Nested Children</li>
                                                </ol>
                                            </li>
                                            <li>Adds Bullets to Page</li>
                                        </ol>
                                    </div>
                                </div>

                                <hr/>

                                <pre>
            function preFormatting() {
                // looks like this;

                var something = somethingElse;

                return true;
            }</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        
            <script src="http://code.jquery.com/jquery.js"></script>
            <script src="js/bootstrap.min.js"></script>
        
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