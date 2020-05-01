<?php 
	session_start();


	// connect to database
DEFINE ('DB_USER', '15009351');
DEFINE ('DB_PASSWORD','BlckLblScty7*');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'scraper');
	$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}
    // define global constants
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://securitysuite.scot');
?>
