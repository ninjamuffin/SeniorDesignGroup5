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
    
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    


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
        $params = array();
        $options = array( "Scrollable" => 'static' );
        $query = "SELECT * FROM CLAWS7";
        $stmt = sqlsrv_query($con, $query, $params, $options);
        if ($stmt === false)
            die(print_r(sqlsrv_errors(), true));
        $tag_names = [];
        $tag_desc = [];
        $num_rows = sqlsrv_num_rows($stmt);
        
        while (sqlsrv_fetch($stmt) === true)
        {
            $tag_names[] = sqlsrv_get_field($stmt, 0);
            $tag_desc[] = sqlsrv_get_field($stmt, 1);
        }
        
        
            
        ?>
        <body>
            <div class="container-fluid">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        CLAWS7 Tagset
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tag</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
        for($i = 0; $i < $num_rows; $i++)
        {
            ?>
                                <tr>
                                    <td><?=$tag_names[$i]?></td>
                                    <td><?=$tag_desc[$i]?></td>
                                </tr>
                                <?php
        }?>
                            
                            </tbody>
                        </table>
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