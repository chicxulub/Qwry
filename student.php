<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);			

/* Get stuff out of the post & get array */
$username = $_POST["username"];
$cID = $_GET["classroomID"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	header('Content-Type: text/html; charset=utf-8');
	mysql_select_db($db, $link);
	$student_query = mysql_query("SELECT stud FROM student_".$cID." WHERE stud = '".$username."'");
	if(mysql_num_rows($student_query)){
		echo "username already exists";
		header('Location: index.php?error="userexists"');
		exit();
	} else {
		$add_student = "INSERT INTO student_".$cID." VALUES ('".$username."', '".$cID."')";
		echo $add_student;
		if(mysql_query($add_student)){
			echo "created student";
			//header('Location: student.php');
			exit();
		}
	}

	/******************
	 * Define Queries *
	 ******************/
	 //$insertStud = "INSERT INTO class_".$cID." VALUES('".$stud.)
}
?>