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
	
	/******************
	 * Define Queries *
	 ******************/
	 
	$student_query = "SELECT stud FROM student_".$cID." WHERE stud = '".$username."'";
	$add_student = "INSERT INTO student_".$cID." VALUES ('".$username."', '".$cID."')";

	if(isset($cID) && mysql_select_db($db, $link)){
		$user_exists = mysql_query($student_query);
		if(mysql_num_rows($user_exists)){
			echo "username already exists";
			header('Location: index.php?myclass='.$cID);
			exit();
		} else {
			echo $add_student;
			if(mysql_query($add_student)){
				echo "created student";
				//header('Location: student.php');
				exit();
			}
		}
	} else {
	}

}
?>