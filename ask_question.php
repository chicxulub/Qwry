<?php
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);
mysql_select_db($db, $link);

$message = $_POST["question"];
$cID = $_POST["classroomID"];
$user = $_POST["user"];

mysql_query("INSERT INTO question_".$cID." (stud, message, answered) VALUES ('".$user."','".$message."', 0)");

?>