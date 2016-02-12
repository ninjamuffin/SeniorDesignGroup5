<?php include "base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Gonzaga Small Talk</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        
        <!-- Header File -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <style>
            body{
                background: url(Media/GonzagaBackground.jpg) no-repeat center center fixed;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: auto;
                
            }
            a{
                color:white;
                text-decoration: underline;
            }
        </style>
    </head>
    
 <?php
        
        require_once 'vendor\autoload.php';
        use WindowsAzure\Common\ServiceBuilder;
        use WindowsAzure\Blob\Models\CreateContainerOptions;
        use WindowsAzure\Blob\Models\PublicAccessType;
        use WindowsAzure\Common\ServiceException;

        $connectionString="DefaultEndpointsProtocol=https;AccountName=smalltalkelc;AccountKey=9Dp8HQ0qsk3ZWW1fADulCa7KEMO3Py5gOeTadrcbSwPYl+O4se+b4hfCUhDbe7KoPz+4ioJj5YSyomNcIPnyUw==";

        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);

        $createContainerOptions = new CreateContainerOptions();

        $createContainerOptions->addMetaData("key1", "value1");
        $createContainerOptions->addMetaDasta("key2", "value2");
        echo $connectionString;
        try {
            // Create Container.
            $blobRestProxy->createContainer("mycontainer", $createContainerOptions);
        }
        catch(ServiceException $e){
            //Handl exception based on error codes and messages. 
            //Error codes and messages are here:
            // http://msdn.microsoft.com/library/azure/dd179437.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    ?>  
    <body>
        <div class ="well col-xs-12">
            <p>Successful creation of a container!</p>
        </div>  
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
    
</html>


<?php
