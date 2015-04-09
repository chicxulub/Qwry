<?php
$server = "localhost";
$username = "root";
$password; //= "Killdozer";
$db = "qwry_test";
$link = mysql_connect($server,$username,$password);
mysql_select_db($db, $link);

$message = addslashes($_POST["question"]);
$cID = "test";
$user = $_POST["user"];

mysql_query("INSERT INTO question_".$cID." (stud, message, answered) VALUES ('".$user."','".$message."', 0)");

?>