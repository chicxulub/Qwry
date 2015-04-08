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
$password; //= "Killdozer";
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
		<header>
			<span><?php echo $cID; ?></span>
		</header>
		<div class="content">
		<div class="left">
			<div id="thegrade">A</div>

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
<script text="text/javascript">
	var stuff = [];
	var ajaxData = function() {
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "feed.php",
			data: { classroomID: '<?php echo $cID; ?>' },
			success: function(data) {
				//console.log(data);
				var key_container = Object.keys(data);
				for(key_i in key_container) {
					key_i = key_container[key_i];
					if($.inArray(key_i, stuff) == -1){
						stuff.push(key_i);
						var q = $("<div/>", {	
									id: key_i,
									class: 'q-box',
									html: '<span class="user-tits">'+data[key_i].user+'</span><br/><span class="mess">'+data[key_i].question+'</span>'})
						q.appendTo(".right").show('bounce',1000);
					}
				}
			setTimeout(ajaxData, 1000);

			}
		});
	};
	//setTimeout(ajaxData, 5000);
	ajaxData();
	
	var calculate_grade = function(){
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "grade_avg.php",
			data: { classroomID: '<?php echo $cID; ?>' },
			success: function(data) {
				var sum = 0;
				tot = data.length;
				$.each(data,function(key,val) {
					sum += parseInt(val);
				})
				avg = sum/tot;
				if (avg > 89 ) {
					$("#thegrade").text("A");
				} else if (avg > 85 && avg < 90) {
					$("#thegrade").text("B+");
				} else if (avg > 82 && avg < 86) {
					$("#thegrade").text("B");
				} else if (avg > 79 && avg < 83) {
					$("#thegrade").text("B-");
				} else if (avg > 75 && avg < 80) {
					$("#thegrade").text("C+");
				} else if (avg > 72 && avg < 76) {
					$("#thegrade").text("C");
				} else if (avg > 69 && avg < 73) {
					$("#thegrade").text("C-");
				} else if (avg > 65 && avg < 70) {
					$("#thegrade").text("D+");
				} else if (avg > 62 && avg < 66) {
					$("#thegrade").text("D");
				} else if (avg > 59 && avg < 63) {
					$("#thegrade").text("D-");
				}
				else {
					$("#thegrade").text("F");
				}
				
				setTimeout(calculate_grade, 3000);
			}
		});
	}
	calculate_grade();
</script>
</body>
</html>