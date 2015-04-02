<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);			

/* Get stuff out of the post array */
$lect = $_POST["username"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	header('Content-Type: text/html; charset=utf-8');
	$cID = $_GET["classroomID"];

	/******************
	 * Define Queries *
	 ******************/
	$createClass = "CREATE TABLE class_".$cID."(
		id CHAR(5) PRIMARY KEY,
		lect VARCHAR(20)
		)";
	$createStud = "CREATE TABLE student_".$cID."(
		stud VARCHAR(20) PRIMARY KEY,
		id CHAR(5), 
		CONSTRAINT id_fk FOREIGN KEY (id) REFERENCES class_".$cID."(id)
		)";
	$insertLect = "INSERT INTO class_".$cID." VALUES ('".
		$cID."','".$lect."'
		)";

	if(isset($cID) && mysql_select_db($db,$link)){
	// create the classroom table 
		if(mysql_query($createClass)){;
			echo "Created table ".$cID."<br>";
		}
		if(mysql_query($insertLect)){
			echo "Insert successful<br>";
		}
		if(mysql_query($createStud)){
			echo "Created student table<br>";
		}
		
	}

}

?>