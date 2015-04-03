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
	// check if username already exists 
	$student_query = "SELECT stud FROM student_".$cID." WHERE stud = '".$username."'";
	
	// insert student into student table 
	$add_student = "INSERT INTO student_".$cID." VALUES ('".$username."', '".$cID."')";

	// check if classroom exists 
	$classroom_query = "SHOW TABLES LIKE 'class_".$cID."'";
	
	if(isset($cID) && mysql_select_db($db, $link)){
		$classroom_exists = mysql_query($classroom_query);
		$user_exists = mysql_query($student_query);
		if(!mysql_num_rows($classroom_exists)) {
			echo "Classroom doesn't exist";
			header('Location: index.php?myuser='.$username);
			exit();
		} elseif (mysql_num_rows($user_exists)) {
			echo "username already exists";
			header('Location: index.php?myclass='.$cID);
			exit();
		} elseif((mysql_num_rows($classroom_exists)) && !(mysql_num_rows($user_exists))){
			// the username and classroom checked out
			mysql_query($add_student);
		}
	} else {
		// something went wrong 
	} // end database connection 

}
?>