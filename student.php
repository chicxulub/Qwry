<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "esb57";
$link = mysql_connect($server,$username,$password);			

/* Get stuff out of the post array */
$stud = $_POST["username"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	header('Content-Type: text/html; charset=utf-8');
	$cID = $_GET["classroomID"];
	
	/******************
	 * Define Queries *
	 ******************/
	 //$insertStud = "INSERT INTO class_".$cID." VALUES('".$stud.)
}
?>