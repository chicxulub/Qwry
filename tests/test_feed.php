<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password;// = "Killdozer";
$db = "qwry_test";
$link = mysql_connect($server,$username,$password);	
$cID = "test";
$raise = $_POST["raised"];
$user = $_POST["user"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	//header('Content-Type: text/html; charset=utf-8');
	mysql_select_db($db,$link);
	//print_r($student_tables);
	/* collect question tables */
	$questions = array();
	$question_result = mysql_query("SELECT * from question_".$cID);

	if(isset($raise) && isset($user)){
		//echo "UPDATE stud_".$cID." SET raisedHand =".$raise." WHERE stud='".$user."'";
		mysql_query("UPDATE student_".$cID." SET raisedHand =".$raise." WHERE stud='".$user."'");
	}
	
	while($table = mysql_fetch_array($question_result)){
		// echo $table["stud"];
		// echo $table["questionID"];
		// echo $table["message"];
		$raised = mysql_fetch_array(mysql_query("SELECT stud, raisedHand FROM student_".$cID." WHERE stud ='".$table["stud"]."'"));
		//echo $raised["stud"];
		//echo $raised["raisedHand"];
		$id = "q".$table["questionID"];
		$questions[$id] = array("user" => $table["stud"],
												 "question" => $table["message"],
												 "raisedHand" => $raised["raisedHand"]);
		//$question_tables[$table["stud"]]["questionID"] = $table["message"]; 
	}
	
	
	//print_r($question_tables);
	echo json_encode($questions);
	
	
}
?>