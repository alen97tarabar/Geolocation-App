<?php

$servername = "localhost";
$username	= "root";
$password	= "usbw";
$dbname 	= "GEO";

//this makes the connection_aborted
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed because of: " . $conn->connect_error);
} else {
	echo "Connected to the database";
}

?>