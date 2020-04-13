<?php
 require_once('db.php');
 session_start();
 require_once("csrf.php");

 if ( isset($_SESSION["username1"]) && isset($_SESSION["identity"] ))  
 {
     header("location: userdashboard.php");
 }
 else  
 {  
      session_destroy();
 }
?>


<!DOCTYPE html>
<html>
<!-- Header -->
<?php require_once('header.html'); ?>
<body>
<br><br><br><br><br><br><br><br><br>
<!-- Navbar -->
<?php require_once('navbar.html'); ?>
<style>
body {
  background-image: url('uploads/run.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
p {
    opacity:1;
    transition:opacity 500ms;
}
p.waa {
    opacity:0;
}
</style>

<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
<?php
       if(isset($_SESSION["username1"]) && isset($_SESSION["identity"]))  
        {
          echo "<a href='login_success.php' class='w3-bar-item w3-button w3-padding-large'>Main Menu</a>";
          echo "<a href='userdashboard.php' class='w3-bar-item w3-button w3-padding-large'>Welcome</a>";
        }else{
          echo "<a href='registering.php' class='w3-bar-item w3-button w3-padding-large'>Register</a>";
          echo "<a href='loging.php' class='w3-bar-item w3-button w3-padding-large'>Login</a>";
          echo "<a href='reset.php' class='w3-bar-item w3-button w3-padding-large'>?</a>";
        }
?>
</div>

<!-- Page content -->
<div class="w3-content w3-opacity-min" style="max-width:1100px;margin-top:46px">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title login-title">Login</h3>
</div>
<div class="panel-body">
<form id="signupForm1" method="post" class="form-horizontal" action="logintest.php">
<div class="form-group">
<label class="col-sm-4 control-label login-username" for="username1">Username: </label>
<div class="col-sm-5">
<input type="text" class="form-control login-input" id="username1" name="username1" placeholder="Username" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label login-password" for="password1">Password: </label>
<div class="col-sm-5">
<input type="password" class="form-control login-input" id="password1" name="password1" placeholder="Password" />
</div>
<input type="hidden" name="csrf" value="<?php echo $csrf ?>">
</div>
<div class="form-group">
<div class="col-sm-9 col-sm-offset-4" style="padding-left: 51px; font-weight: bold;">
  <button type="submit" class="btn btn-primary" name="login" value="Sign up">Sign In</button>
  <a href="registering.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Register</a>
  <a href="reset.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Forget</a>
  <a href="admin_logging.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Admin</a>
</div>
</div>
</form>
<?php
if ( isset($_GET['fail']) && $_GET['fail'] == 1 )
{
	$msg = '<h3><p id="aap1">Username or Password does not exist</p><h3>';
     echo "<p id='aap'><br>Sorry  <br></p>";
     echo $msg;
}
?>
</div>
</div>
</div>
</div>
</div>
<br><br><br><br>
<script type="text/javascript">
		$.validator.setDefaults( {
			submitHandler: function () {
				alert( "submitted!" );
			}
		} );
    setTimeout(function(){
    document.getElementById('aap').className = 'waa';
}, 3000);
setTimeout(function(){
    document.getElementById('aap1').className = 'waa';
}, 4000);
</script>

<!-- Footer -->
<?php require_once('footer.html'); ?>

</body>
</html>
