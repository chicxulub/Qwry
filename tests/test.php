<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/qwry.css"/>
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
  <title>Qwry: Questing With Realness, Yo!</title>
</head>
<body onload="intro();">
<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password; // = "Killdozer";
$db = "qwry_test";
$link = mysql_connect($server,$username,$password);
$cID = 'test';
$lect = 'lecturer';
$grade = 90;
$raised_hand = 0;

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
?>
	<header>
		<span>Test Qwry</span>
	</header>
	<div class="main-container">
	<div class="intros">
		<div class="test-intro">
			Before you start testing on your local machine,
			Qwry needs its own database, so we'll test to see if you have it.
			If you don't, Qwry will make one for you using the same calls as the real thing. This is the first automated test<br/><br/>
		</div>
		<div class="test-intro">
			P.S. If you are running xampp with a password for your mySQL database, Qwry won't work. Please turn off passwords.
		</div>
		<div class="test-intro">
	<?php

	if (mysql_query("CREATE DATABASE ".$db, $link)) {
		echo "Database created successfully<br/><br/>";
		
	} else {
		echo "Database already exists<br/><br/>";
		

	}	
	echo "Initializing tests and connecting to the database using the same calls as the real thing. This is the second automated test.<br/>";
	mysql_select_db($db,$link);
	$createClass = "CREATE TABLE class_".$cID."(
		id CHAR(5) PRIMARY KEY,
		lect VARCHAR(20)
	)";
	// create student table 
	$createStud = "CREATE TABLE student_".$cID."(
		stud VARCHAR(20) PRIMARY KEY,
		grade INT,
		raisedHand BOOLEAN,
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
	
	$add_student1 = "INSERT INTO student_".$cID." VALUES ('student 1',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student2 = "INSERT INTO student_".$cID." VALUES ('student 2',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student3 = "INSERT INTO student_".$cID." VALUES ('student 3',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student4 = "INSERT INTO student_".$cID." VALUES ('student 4',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student5 = "INSERT INTO student_".$cID." VALUES ('student 5',".$grade.",".$raised_hand.", '".$cID."')";



	mysql_query($createClass);
	// echo $createClass."<br>";
	mysql_query($insertLect);
	// echo $insertLect."<br>";
	mysql_query($createStud);
	// echo $createStud."<br>";
	mysql_query($createQuest);
	mysql_query($add_student1);
	mysql_query($add_student2);
	mysql_query($add_student3);
	mysql_query($add_student4);
	mysql_query($add_student5);

}
	?>
		</div>
		<div class="test-intro">
			Qwry uses php scripts that are called using AJAX calls for the purposes of this project.
			We have generated a test classroom populated with 5 test students to demonstrate the functionality.<br/>
			Taking you to the testing control now.<br/>
		</div>
	</div>
	</div>
	<div class="testing">
		
		<div class="block">
			Test averaging grades<br/>
			<?php
			for($i=1;$i<6;$i++){
				echo 'student '.$i.':
				<select id="student-'.$i.'-grade">
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="F">F</option>
				</select><br/>';
			}
			
			?>
			<div id="test-avg">Average grade: A</div>
		</div>
		
		<div class="block">
			Test the question feed<br/>
			<select id="test-student-asking">
				<option value="student 1">student 1</option>
				<option value="student 2">student 2</option>
				<option value="student 3">student 3</option>
				<option value="student 4">student 4</option>
				<option value="student 5">student 5</option>
			</select><button id="test-raise">Raise Hand</button><br/><br/>
			<textarea id="test-mess" row="10" col="50">Ask a test question...</textarea><button id="test-ask">Ask</button>
		</div>
		<div class="block">
			Here's what your database looks like:
		</div>
	</div>
	<div class="test-q">
	</div>
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="../js/general.js"></script>
<script src="../js/testing.js"></script>
</body>
</html>