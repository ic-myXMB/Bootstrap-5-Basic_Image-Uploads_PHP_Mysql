<?php
// Display Errors if needed
 //ini_set('display_errors', 1);
 //error_reporting(E_ALL);

// Set up a db connection

// doDB function
function doDB() {

    // Globals
	global $mysqli;

	// Connect to server and select database
    // Database connection details
    $mysqli = mysqli_connect('localhost', 'db_user', 'db_password', 'db_name');	

	// If connection fails, stop script execution
	if (mysqli_connect_errno()) {

		// Print failed
		printf("Connect failed: %s\n", mysqli_connect_error());

		// Kill
		exit();

	}
}

?>
