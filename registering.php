
<?php
 require_once('db.php');
 session_start();
 require_once("csrf.php");
 $old_sessionid = session_id();
 session_regenerate_id();

 if ( isset($_SESSION["username1"]) && isset($_SESSION["identity"] ))  
 {
     header("location: userdashboard.php");
 }
 else  
 {  
      session_destroy();
 }
 $new_sessionid = session_regenerate_id(true);
?>

<!DOCTYPE html>
<html>
<!-- Header -->
<head>
	<title>Registry - GoGetter</title>
</head>
<style>
	body {
		background-image: url('uploads/run.jpg');
  		background-repeat: no-repeat;
  		background-attachment: fixed;
  		background-size: cover;
	}
</style>
<?php require_once('header.html'); ?>
<body>

<!-- Navbar -->
<?php require_once('navbar.html'); ?>

<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
<?php
       if(isset($_SESSION["username1"]) && isset($_SESSION["identity"]))  
	   {
		 echo "<a href='index.php' class='w3-bar-item w3-button w3-padding-large'>Main Menu</a>";
		 echo "<a href='userdashboard.php' class='w3-bar-item w3-button w3-padding-large'>Login</a>";
	   }else{
		 echo "<a href='registering.php' class='w3-bar-item w3-button w3-padding-large'>Register</a>";
		 echo "<a href='loging.php' class='w3-bar-item w3-button w3-padding-large'>Login</a>";
		 echo "<a href='reset.php' class='w3-bar-item w3-button w3-padding-large'>?</a>";
	   }
?>
</div>
<div>
	<ul class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i></a></li>
        <li><a href="registering.php">REGISTRING ACCOUNT</a></li>
    </ul>
</div>
<!--<br><br><br>-->
<!-- Page content -->
<div class="w3-content" style="/*max-width:2000px;*/margin-top:24px;">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title register-title">Register Your Accounts</h3>
</div>
<div class="panel-body">
<form id="signupForm1" method="post" class="form-horizontal" action="register1.php">

<div class="form-group">
<label class="col-sm-4 control-label" for="username1">Username: </label>
<div class="col-sm-5">
<input type="text" class="form-control" id="username1" name="username1" placeholder="Username" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label" for="email1">Email: </label>
<div class="col-sm-5">
<input type="text" class="form-control" id="email1" name="email1" placeholder="Email" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label" for="password1">Password: </label>
<div class="col-sm-5">
<input type="password" class="form-control" id="password1" name="password1" placeholder="Password" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label" for="confirm_password1">Confirm password: </label>
<div class="col-sm-5">
<input type="password" class="form-control" id="confirm_password1" name="confirm_password1" placeholder="Confirm password" />
</div>
</div>

<div class="form-group">
<div class="col-sm-5 col-sm-offset-4">
<div class="checkbox">
<label>
<input type="checkbox" id="agree1" name="agree1" value="agree" />Please agree to our <a href="policy.php">Terms & Conditions</a>
</label>
</div>
<input type="hidden" name="csrf" value="<?php echo $csrf ?>">
</div>
</div>
<div class="form-group">
<div class="col-sm-9 col-sm-offset-4">
<button type="submit" class="btn btn-primary" name="signup1" value="Sign up">Sign up</button>
<?php
if ( isset($_GET['success']) && $_GET['success'] == 1 )
{
	$msg = 'Your account was created successfully, please go active by Email before login';
     echo "<br>Success<br>  <h3>$msg.<h3>";
}
if ( isset($_GET['fail']) && $_GET['fail'] == 1 )
{
	$msg = 'Your account not created, please user other email address';
     echo "<br>Sorry  <br>  <h3>$msg.<h3>";
}
if ( isset($_GET['fail']) && $_GET['fail'] == 2 )
{
	$msg = 'Your account not created, please user other username';
     echo "<br>Sorry  <br>  <h3>$msg.<h3>";
}
if ( isset($_GET['fail']) && $_GET['fail'] == 3 )
{
	$msg = 'Your account not created, please user other username and email address';
     echo "<br>Sorry  <br>  <h3>$msg.<h3>";
}

?>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<!--<br><br><br><br>-->
<script type="text/javascript">
		$.validator.setDefaults( {
			submitHandler: function () {
				$('#signupForm1').submit();
			}
		} );

		$( document ).ready( function () {
			$( "#signupForm" ).validate( {
				rules: {
					firstname: "required",
					lastname: "required",
					username: {
						required: true,
						minlength: 5
					},
					password: {
						required: true,
						minlength: 5
					},
					confirm_password: {
						required: true,
						minlength: 5,
						equalTo: "#password"
					},
					email: {
						required: true,
						email: true
					},
					agree1: {required: true},
                    radio:{ required:true }
				},
				messages: {
					firstname: "Please enter your firstname",
					lastname: "Please enter your lastname",
					username: {
						required: "Please enter a username",
						minlength: "Your username must consist of at least 2 characters"
					},
					password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long"
					},
					confirm_password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					},
					email: "Please enter a valid email address",
					agree1: "Please accept our policy"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				}
			} );

			$( "#signupForm1" ).validate( {
				rules: {
					firstname1: "required",
					lastname1: "required",
					username1: {
						required: true,
						minlength: 2
					},
					password1: {
						required: true,
						minlength: 5
					},
					confirm_password1: {
						required: true,
						minlength: 5,
						equalTo: "#password1"
					},
					email1: {
						required: true,
						email: true
					},
					agree1: "required",
                    radio:"required"
				},
				messages: {
					firstname1: "Please enter your firstname",
					lastname1: "Please enter your lastname",
					username1: {
						required: "Please enter a username",
						minlength: "Your username must consist of at least 2 characters"
					},
					password1: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long"
					},
					confirm_password1: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					},
					email1: "Please enter a valid email address",
                    radio:"Choose one account type"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-5" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
			} );
		} );
	</script>

<!-- Footer -->
<?php require_once('footer.html'); ?>

</body>
</html>
