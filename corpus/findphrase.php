<?php
class DBController {
	private $host = "us-cdbr-azure-west-c.cloudapp.net";
	private $user = "b2a3214e88e413";
	private $password = "325ebc40";
	private $database = "mysqldbproject";
	
	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->selectDB($conn);
		}
	}
	
	function connectDB() {
		$conn = mysql_connect($this->host,$this->user,$this->password);
		return $conn;
	}
	
	function selectDB($conn) {
		mysql_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysql_query($query);
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysql_query($query);
		$rowcount = mysql_num_rows($result);
		return $rowcount;	
	}
}
?>
<!--"SELECT * FROM expressions_full WHERE expression LIKE '%{$q}%'";-->
<?php
//require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$query =""SELECT * FROM expressions_full WHERE expression LIKE '" . $_POST["keyword"] . "%'";
$result = $db_handle->runQuery($query);
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectCountry('<?php echo $country["expression"]; ?>');"><?php echo $country["expression"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>
