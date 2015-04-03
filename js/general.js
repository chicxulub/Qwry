/* Stuff to do on dom load */

$( function(){
	// make the classroom text box visible if student was checked before
    if($("#stud").is(":checked")){
	    $("#if-student").show("bounce",500);
	} else {
	    $("#if-student").hide("blind",200);
	}
	// check window size and load the font size before showing it 
	$("header span").css("font-size",$("header").height()-10);
	$("header span").show("fade");
	
	// check to see if we were redirected due to a username error, then alert the user to choose a new username 
	var alert_username = (window.location.href).split('myclass=')[1];
	if(alert_username) {
		$("label[for='user']").html("username <span style='color:red;'>*</span>");
		$(".main-container").append("<span style='font-family:sans-serif;font-size:1.3em;margin:5px;'>Sorry, that username already exists.</span>");
	}
	
	// check to see if we were redirected due to a classroom error, then alert the user to choose a new classroom 
	var alert_classroom = (window.location.href).split('myuser=')[1];
	if(alert_classroom) {
		$("label[for='class']").html("classroom ID <span style='color:red;'>*</span>");
		$(".main-container").append("<span style='font-family:sans-serif;font-size:1.3em;margin:5px;'>Sorry, that classroom doesn't exist.</span>");
	}

});

/* fix header font sizes on window resize */
$( window ).resize(function() {
	$("header span").css("font-size",$("header").height()-10);
});

/* 
	Rotate the gear on hover 
	Just for style B) 
*/

$("#gear").rotate({ 
	bind: 
	{ 
	    mouseover : function() { 
		$(this).rotate({animateTo:180})
		    },
		mouseout : function() { 
		$(this).rotate({animateTo:0})
		    }
	} 
});

/* 
	If the user chooses 'student', show them the input for the classroom ID 
	As always, make it pretty! 
*/
$("input:radio").change( function(){
	if($("#stud").is(":checked")){
	    $("#if-student").show("bounce", 1000);
	} else {
	    $("#if-student").hide("blind",200);
	}
});

/* 
	This is javascript form validation
	Just make sure everything's filled out before sending them to their designated classroom 
	If not, alert them, send them back, and the $_Post array will take care of repopulating 
*/
function selectAction(){
    if($("#usertype input[type=radio]:checked").length){
		if($("#teach").is(":checked")){
			if($("#user").val()){
			document.getElementById("usertype").action = "teacher.php?classroomID=" + classroomId(5);
			} else {
			$("#user").css("background-color","pink");
			alert("Please choose a username.");
			document.getElementById("usertype").action = "index.php";
			}	       
		} else {
			if($("#class").val()){
				if($("#user").val()){
					document.getElementById("usertype").action = "student.php?classroomID=" + $("#class").val();
					
				} else {
					$("#user").css("background-color","pink");
					alert("Please choose a username.");
					document.getElementById("usertype").action = "index.php";
				}
			} else {
				$("#class").css("background-color", "pink")
				alert("Please ask your lecturer for the classroom ID.");
				document.getElementById("usertype").action = "index.php";
			}
		}
    } else {
		alert("Are you a lecturer or a student?");
	}
}

/* This little guy makes our classroom IDs <3 */
function classroomId(length){
     var result = '';
     chars = '0123456789abcdefghijklmnopqrstuvwxyz';
     for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
     return result;
}

