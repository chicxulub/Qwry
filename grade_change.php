<?php
$server = "localhost";
$username = "root";
$password; //= "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);
mysql_select_db($db, $link);

$grade = $_POST["letter_grade"];
$cID = $_POST["classroomID"];
$user = $_POST["user"];

switch ($grade) {
    case "A":
		mysql_query("UPDATE student_".$cID." SET grade=90 WHERE stud='".$user."'");
        break;
    case "B":
		mysql_query("UPDATE student_".$cID." SET grade=80 WHERE stud='".$user."'");
        break;
    case "C":
		mysql_query("UPDATE student_".$cID." SET grade=70 WHERE stud='".$user."'");
        break;
	case "D":
		mysql_query("UPDATE student_".$cID." SET grade=60 WHERE stud='".$user."'");
        break;
	case "F":
		mysql_query("UPDATE student_".$cID." SET grade=50 WHERE stud='".$user."'");
        break;
}

?>