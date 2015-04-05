<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="css/qwry.css"/>
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
  <title>Qwry: Questing With Realness, Yo!</title>
</head>
<body>
<?php
/* Connection Stuff */
$server = "localhost";
$username = "root";
$password = "Killdozer";
$db = "qwry";
$link = mysql_connect($server,$username,$password);
/* Get stuff out of the post & get array */
$username = $_POST["username"];
$cID = $_GET["classroomID"];
$grade = 90;
$raised_hand = 0;

if(!$link){ 
	die("Could not connect to the CEFNS server: ".mysql_error()); 
} else {
	header('Content-Type: text/html; charset=utf-8');
	
	/******************
	 * Define Queries *
	 ******************/
	// check if username already exists 
	$student_query = "SELECT stud FROM student_".$cID." WHERE stud = '".$username."'";
	
	// insert student into student table 
	$add_student = "INSERT INTO student_".$cID." VALUES ('".$username."',".$grade.",".$raised_hand.", '".$cID."')";

	// check if classroom exists 
	$classroom_query = "SHOW TABLES LIKE 'class_".$cID."'";
	
	if(isset($cID) && mysql_select_db($db, $link)){
		$classroom_exists = mysql_query($classroom_query);
		$user_exists = mysql_query($student_query);
		if(!mysql_num_rows($classroom_exists)) {
			echo "Classroom doesn't exist";
			header('Location: index.php?myuser='.$username);
			exit();
		} elseif (mysql_num_rows($user_exists)) {
			echo "username already exists";
			header('Location: index.php?myclass='.$cID);
			exit();
		} elseif((mysql_num_rows($classroom_exists)) && !(mysql_num_rows($user_exists))){
			// the username and classroom checked out
			mysql_query($add_student); // added student 
			?>
			<header>
			<span>Qwry</span>
			</header>
			<div class="content">
			<div class="left">
				<div id="grade-container">	
					<div id="grade-box">A</div>
					<form id="grade-radio-box">
					    Lecture Grade<br/>
						<input type="radio" name="grade" value="A" checked/> A<br/>
						<input type="radio" name="grade" value="B"/> B<br/>
						<input type="radio" name="grade" value="C"/> C<br/>
						<input type="radio" name="grade" value="D"/> D<br/>
						<input type="radio" name="grade" value="F"/> F<br/>
					</form>
				</div>
				<textarea id="question" cols=50 rows=7>Ask a question</textarea><br/><br/>
				<img id="ask" src="images/ask-question.png"/>
			</div>
			<div class="right">
				
			</div>
			</div>
			<?php	
		}
	} else {
		// something went wrong 
	} // end database connection 

}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>
<script src="js/general.js"></script>
<script type="text/javascript">
	var num_questions = 0;
	var ajaxData = function() {
		var obj;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "feed.php",
			data: { classroomID: '<?php echo $cID; ?>' },
			success: function(data) {
				/*var children = $(".right").children();
				console.log("It's running");
				$.each(data, function(key, question) {
					if($.inArray(key, children) > -1){
						$(".right").append("<div id='"++"'")
					}
				});*/
				
			}
		});
	};
	// make a request every second
	setInterval(ajaxData, 3000);
	
	
	$("#grade-radio-box input[type='radio']").click(function(){
		grade = $(this).val();
		$.ajax({
			url: "grade_change.php",
			type: "POST",
			data: { letter_grade: grade, classroomID: '<?php echo $cID; ?>', user: '<?php echo $username; ?>'},
			success: function() { 
				$("#grade-box").text(grade);
				switch (grade) {
					case "A":
						$("#grade-box").css("background-color", "green");
						break;
					case "B":
						$("#grade-box").css("background-color", "blue");
						break;
					case "C":
						$("#grade-box").css("background-color", "yellow");
						break;
					case "D":
						$("#grade-box").css("background-color", "orange");
						break;
					case "F":
						$("#grade-box").css("background-color", "red");
						break;
				}
			}
		});
	});
	
	$("#ask").click(function() {
		message_text = $("#question").val();
		$.ajax({
			url: "ask_question.php",
			type: "POST",
			data: { question: message_text,  classroomID: '<?php echo $cID; ?>', user: '<?php echo $username; ?>'},
			success: function(){
				$("#question").val("Ask another question...");
			}
		
		});
	});
	
	/* ask button cute styles */

	$("#ask").rotate({
		bind:
		{
		   mouseover : function() { 
			$(this).rotate({animateTo:-5})
				},
			mouseout : function() { 
			$(this).rotate({animateTo:0})
				}
		} 
	});


</script>
</body>
</html>