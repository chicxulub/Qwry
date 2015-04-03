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
$grade = 90;

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
	$add_student = "INSERT INTO student_".$cID." VALUES ('".$username."',".$grade.", '".$cID."')";

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
			mysql_query($add_student); // added student 
			?>
			<!DOCTYPE html>
			<head>
			  <link rel="stylesheet" type="text/css" href="css/qwry.css"/>
			  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
			  <title>Qwry: Questing With Realness, Yo!</title>
			</head>

			<body id="qwry">
			  <header>
				<span>Qwry</span>
			  </header>
			  <div class="content">
				<div class="left">
				</div>
				<div class="right">
				</div>
			  
			  </div>
			<?php	
		}
	} else {
		// something went wrong 
	} // end database connection 

}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="js/general.js"></script>