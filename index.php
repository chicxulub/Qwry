<?php
?>
<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="css/qwry.css"/>
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
  <title>Qwry: Questing With Realness, Yo!</title>
</head>

<body id="qwry">
  <header>
    <span>Qwry</span>
  </header>
  <div class="content">
    <div class="main-container">
    <span class="intro">create or join</span>
      <form id="usertype" method="post" onSubmit="return selectAction();">
        <label for="user">username</label><br/>
        <input id="user" type="text" name="username" <?php echo "value=".(isset($_POST["username"]) ? $_POST["username"] : ""); ?>><br/>
        <input id="teach" type="radio" name="designation" value="lecturer" <?php echo ($_POST["designation"]=="lecturer"?"checked":"");?>>
        <label for="teach">lecturer</label><br/>
        <input id="stud" type="radio" name="designation" value="student" <?php echo (($_POST["designation"]=="student"||isset($_GET["myclass"]))?"checked":"");?>>
        <label for="stud">student</label><br/><br/>
        <div id="if-student">
        <label for="class">classroom ID</label><br/> 
        <input id="class" type="text" name="classroom" 
		<?php /*echo "value=".(isset($_POST["classroom"])?$_POST["classroom"]:"");*/
		if(isset($_POST["classroom"])) {echo "value=".$_POST["classroom"];}
		elseif(isset($_GET["myclass"])) {echo "value=".$_GET["myclass"];}?>>
        </div>
        <button onclick="document.getElementById('usertype').submit();" type="submit"><img id="gear" src="images/gear.png"/></button>
      </form>
    </div>
  </div>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>
<script src="js/general.js"></script>