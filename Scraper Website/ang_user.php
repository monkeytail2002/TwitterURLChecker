<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
13/4/2020
-->

<?php 
//Pulls in required module
require_once('config.php');


//Check session validity
if($_SESSION["Valid"]){
	} else {
	header("Location:index.php");
}


//Run query to pull in username from Users table
$query = "SELECT * FROM Users ORDER BY Username ASC";
$result = mysqli_query($conn,$query);

//Sets the rows to an array
while ($row = mysqli_fetch_array($result)) {
  $output[] = $row;
}

//echos the array in a json object
echo json_encode($output);


?>
