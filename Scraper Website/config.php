<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
31/3/2020
-->

<?php 
//start session
	session_start();


	// connect to database
//Credentials removed since this is public.  Please enter the required credentials where required if you choose to build this tool.
DEFINE ('DB_USER', '#####');
DEFINE ('DB_PASSWORD','#####');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', '#####');
	$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}
    // define global constants
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://securitysuite.scot');
?>
