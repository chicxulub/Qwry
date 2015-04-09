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
$cID = "test";
$lect = "lecturer";
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
	mysql_query("DROP TABLE question_test CASCADE");
	mysql_query("DROP TABLE student_test CASCADE");
	mysql_query("DROP TABLE class_test CASCADE");
	
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
	
	$add_student1 = "INSERT INTO student_".$cID." VALUES ('student1',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student2 = "INSERT INTO student_".$cID." VALUES ('student2',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student3 = "INSERT INTO student_".$cID." VALUES ('student3',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student4 = "INSERT INTO student_".$cID." VALUES ('student4',".$grade.",".$raised_hand.", '".$cID."')";
	$add_student5 = "INSERT INTO student_".$cID." VALUES ('student5',".$grade.",".$raised_hand.", '".$cID."')";



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
		
		<div id="test-grade" class="block">
			Test changing grades<br/>
			<?php
			for($i=1;$i<6;$i++){
				echo 'student '.$i.':
				<select id="student'.$i.'">
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="F">F</option>
				</select><br/>';
			}
			
			?>
			<div id="test-avg">Test Averaging Grades<br/>Average grade: <span id="dispgrade">A</span></div>
		</div>
		
		<div id="test-question" class="block">
			Test the question feed<br/>
			<select id="test-student-asking">
				<option value="student1">student 1</option>
				<option value="student2">student 2</option>
				<option value="student3">student 3</option>
				<option value="student4">student 4</option>
				<option value="student5">student 5</option>
			</select><button id="test-raise">Raise Hand</button><br/><br/>
			<textarea id="test-mess" row="10" col="50">Ask a test question...</textarea><button id="test-ask">Ask</button>
		</div>
	</div>
	<div class="test-q">
	</div>
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="../js/general.js"></script>
<script src="../js/testing.js"></script>
<script type="text/javascript">
	var stuff = [];
	var q_boxes = [];
	var testAjaxData = function() {
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "test_feed.php",
			data: {},
			success: function(data) {
				var key_container = Object.keys(data);
				for(key_i in key_container) {
					key_i = key_container[key_i];
					if($.inArray(key_i, stuff) == -1){
						stuff.push(key_i);
						var q = $("<div/>", {	
									id: key_i,
									class: 'q-box',
									html: '<span class="user-tits">'+data[key_i].user+'</span><br/><span class="mess">'+data[key_i].question+'</span>'})
						q.appendTo(".test-q").show('bounce',1000);
					}
					// check for raised hands
					q_boxes = $(".test-q").children();
					if(data[key_i].raisedHand == 1){
						// for each of the questions 
						$.each(q_boxes, function() {
							var the_box = $(this)
							var user_in_q = $(this).find(".user-tits").text();
							console.log(user_in_q);
							console.log(data[key_i].user);
							if(user_in_q == data[key_i].user){
								the_box.css("background-color", "yellow");
							}
						});
						
					}
					
				}
			setTimeout(testAjaxData, 1000);

			}
		});
	};
	//setTimeout(ajaxData, 5000);
	testAjaxData();
	
	var test_calculate_grade = function(){
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "test_grade_avg.php",
			data: { },
			success: function(data) {
				var sum = 0;
				tot = data.length;
				$.each(data,function(key,val) {
					sum += parseInt(val);
				})
				avg = sum/tot;
				if (avg > 89 ) {
					$("#dispgrade").text("A");
				} else if (avg > 85 && avg < 90) {
					$("#dispgrade").text("B+");
				} else if (avg > 82 && avg < 86) {
					$("#dispgrade").text("B");
				} else if (avg > 79 && avg < 83) {
					$("#dispgrade").text("B-");
				} else if (avg > 75 && avg < 80) {
					$("#dispgrade").text("C+");
				} else if (avg > 72 && avg < 76) {
					$("#dispgrade").text("C");
				} else if (avg > 69 && avg < 73) {
					$("#dispgrade").text("C-");
				} else if (avg > 65 && avg < 70) {
					$("#dispgrade").text("D+");
				} else if (avg > 62 && avg < 66) {
					$("#dispgrade").text("D");
				} else if (avg > 59 && avg < 63) {
					$("#dispgrade").text("D-");
				}
				else {
					$("#dispgrade").text("F");
				}
				
				setTimeout(test_calculate_grade, 3000);
			}
		});
	}
	test_calculate_grade();
	
	$("#test-grade select").change(function(){
		var stud = $(this).attr('id');
		var grade = $(this).val();
		//console.log(stud);
		//console.log(grade);
		$.ajax({
			url: "test_grade_change.php",
			type: "POST",
			data: { letter_grade: grade, user: stud}
		});
	});
	
	$("#test-ask").click(function() {
		var message_text = $("#test-mess").val();
		//console.log(message_text);
		var stud = $("#test-student-asking option:selected").val();
		//console.log(user);
		$.ajax({
			url: "test_ask_question.php",
			type: "POST",
			data: { question: message_text, user: stud},
			success: function(){
				//$("#question").val("Ask another question...");
				console.log("done.");
			}
		});
	});
	
	$("#test-raise").click(function() {
		var stud = $("#test-student-asking option:selected").val();	
		$.ajax({
			url: "test_feed.php",
			type: "POST",
			dataType: "json",
			data: { raised: 1, user: stud },
			success: function(data) {
				console.log(data);
			}
		});
	});

</script>
</body>
</html>