<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);	
$cID = $_POST["classroomID"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	mysql_select_db($db,$link);
	$grades = array();
	$grade_result = mysql_query("SELECT grade from student_".$cID);
	while($result = mysql_fetch_array($grade_result)){
		array_push($grades,$result["grade"]);
	}
	echo json_encode($grades);
}
?>
