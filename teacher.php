<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);			

/* Get stuff out of the post & get array */
$lect = $_POST["username"];
$cID = $_GET["classroomID"];

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	header('Content-Type: text/html; charset=utf-8');
	
	/******************
	 * Define Queries *
	 ******************/
	// create classroom table
	$createClass = "CREATE TABLE class_".$cID."(
		id CHAR(5) PRIMARY KEY,
		lect VARCHAR(20)
		)";
	// create student table 
	$createStud = "CREATE TABLE student_".$cID."(
		stud VARCHAR(20) PRIMARY KEY,
		grade INT,
		id CHAR(5), 
		CONSTRAINT id_fk_".$cID." FOREIGN KEY (id) REFERENCES class_".$cID."(id)
		)";
		
	// create the question table
	$createQuest = "CREATE TABLE question_".$cID."(
		questionID INT AUTO_INCREMENT PRIMARY KEY,
		stud VARCHAR(20),
		message TEXT,
		answered BOOLEAN,
		CONSTRAINT stud_fk_".$cID." FOREIGN KEY (stud) REFERENCES student_".$cID."(stud)
	)";
	
	// insert the lecturer into the classroom table and give it a primary key 
	$insertLect = "INSERT INTO class_".$cID." VALUES ('".
		$cID."','".$lect."'
		)";

	if(isset($cID) && mysql_select_db($db,$link)){
		// create the classroom table 
		mysql_query($createClass);
		echo $createClass."<br>";
		mysql_query($insertLect);
		echo $insertLect."<br>";
		mysql_query($createStud);
		echo $createStud."<br>";
		mysql_query($createQuest);
		echo $createQuest."<br>";
		
	} else {
		// something went wrong
	}

}

?>

<script type="text/javascript">
window.onbeforeunload = function(){
  var result = confirm();
};
</script>