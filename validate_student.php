<?php
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);			
$cID = $_GET["classroomID"];
$username = $_POST["username"];
echo $username."<br>";
$student_query = mysql_query("SELECT stud FROM student_".$cID." WHERE stud = ".$username);
if($student_query){
	echo "username already exists";
    header('Location: index.php');
    exit();
} else {
	echo "created student";
    header('Location: student.php');
    exit();
}

?>
