<?php require_once('config.php');
//Above is required module
//Check session validity
if($_SESSION["Valid"]){
	} else {
	header("Location:index.php");
}



$query = "SELECT * FROM Users ORDER BY Username ASC";
$result = mysqli_query($conn,$query);


while ($row = mysqli_fetch_array($result)) {
  $output[] = $row;
}

echo json_encode($output);


?>
