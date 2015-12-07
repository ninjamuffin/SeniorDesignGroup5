<html>
<head>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","Brianinsert.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>

<h1>Submit a new entry in user table</h1>
<form method="post" action="Brianinputform.php">
FirstName: <input type="text" name="FirstName" id="firstname"><br>
LastName: <input type="text" name="LastName" id="lastname"><br>
Age:      <input type="int" name="Age" id="age"><br>
HomeTown: <input type="text" name="Hometown" id="hometown"><br>
Job:      <input type="text" name="Job" id="job"><br>
<input type="submit" name="submit" value="Submit" />
</form>

<?php
$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
$sql_insert ="INSERT INTO user (id, FirstName, LastName, Age, Hometown, Job)
VALUES (0, 'FirstName' , 'LastName' , 'Age' , 'Hometown' , 'Job')";
$stmt = $con->prepare($sql_insert);
$stmt -> bindValue(2, $FirstName);
$stmt -> bindValue(3, $LastName);
$stmt -> bindValue(4, $Age);
$stmt -> bindValue(5, $Hometown);
$stmt -> bindValue(6, $Job);
$stmt -> execute();
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";
 
mysql_close($con)
?>
</body>
</html>
