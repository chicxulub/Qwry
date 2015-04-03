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
		// echo $createClass."<br>";
		mysql_query($insertLect);
		// echo $insertLect."<br>";
		mysql_query($createStud);
		// echo $createStud."<br>";
		mysql_query($createQuest);
		// echo $createQuest."<br>";
		?>
		<head>
			  <link rel="stylesheet" type="text/css" href="css/qwry.css"/>
			  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
			  <title>Qwry: Questing With Realness, Yo!</title>
			</head>

			<body id="teacher">
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
	} else {
		// something went wrong
	}

}

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>
<script src="js/general.js"></script>