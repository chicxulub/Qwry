<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);	
$cID = $_GET["classroomID"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	//header('Content-Type: text/html; charset=utf-8');
	mysql_select_db($db,$link);
	/* collect class tables */
	$class_tables  = array();
	$class_result = mysql_query("SELECT * FROM class_".$cID);
	while($table = mysql_fetch_array($class_result)){
		array_push($class_tables, $table[0]);
	}
	print_r($class_tables);
	/* collect student tables */
	$student_tables = array();
	$student_result = mysql_query("SELECT * FROM student_".$cID);
	while($table = mysql_fetch_row($student_result)){
		array_push($student_tables, $table[0]);
	}
	print_r($student_tables);
	/* collect question tables */
	$question_tables = array();
	$question_result = mysql_query("SELECT* from question_".$cID);
	while($table = mysql_fetch_array($question_result)){
		array_push($question_tables, $table[0]);
	}
	
}
?>

