<?php

	// http://localhost/dashboard/
	// http://localhost/dashboard/phpinfo.php
	// PHP Version 5.6.38
	/*

	CREATE TABLE `test`.`users` ( 
	`user_id` INT UNSIGNED AUTO_INCREMENT, 
	`user_name` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , CONSTRAINT users_pk PRIMARY KEY (user_id));

	*/

	// CREATE USER 'test_user'@'localhost' IDENTIFIED BY 'password!' 
	// GRANT ALL PRIVILEGES ON test.* TO 'test_user'@'localhost';

	$servername = "localhost";
	$username = "test_user";
	$password = "password!";

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully";
	
?> 