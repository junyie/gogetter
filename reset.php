<?php
require_once('db.php');
session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  try {
    $email = $_POST["email"];
    $stmt_semail = $conn->prepare("SELECT * FROM user WHERE uemail=:email AND verified_status ='1'");
  
     $stmt_semail->bindParam(':email', $email, PDO::PARAM_STR);
     $stmt_semail->execute();

     $results1 = $stmt_semail-> fetch(PDO::FETCH_ASSOC);

}
catch(PDOException $e){
    {
    echo "Error: " . $e->getMessage();
    }
}
    
if ($results1 >0){

    $hashing = md5( rand(0,1000) ) ;
    if ($results1 >0){
      try {  
          // prepare sql and bind parameters
          $stmt = $conn->prepare("UPDATE user SET verifying_hash='$hashing' WHERE uemail=:_email AND verified_status='1'");
          $stmt->bindParam(':_email', $email,PDO::PARAM_STR);
          //Update the hash and sent to mail to user use for reset password
          $stmt->execute();

          $email = $results1['uemail'];
          $hash =  $hashing;
          sendResetMail($email,$hash);
          header('location: reset.php?success=1');
        }
        catch(PDOException $e)
        {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;
        }
    }
   if (!$results1 >0){
    header('location: reset.php?fail=1');
   }
    
}else {
  echo "‌‌ ";
}


function sendResetMail($email,$hash){
  // Session message to display on success.php
  $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
  . " for a confirmation link to complete your password reset!</p>";
  
  // Send registration confirmation link (reset.php)
  //$headers .= "Content-type: text/html";
  // Send registration confirmation link (reset.php) 
  require_once("mail.php");
  $mail->setFrom('spammerking12345@gmail.com');
  $mail->isHTML(true);
  $mail->addAddress($email);
  $mail->Subject = 'Requesting Link For Reset Password ( GoGetter.com )';
  $Msg = "<html><head> </head><body>";
  $Msg .= '<img src="https://i.imgur.com/aHNsYHX.png" style="width:180px; height:40px" title="GoGetter" alt="24hrs Tutor"> </body></html>
  Hello '.$email.',<br><br>

  You have requested password reset!<br>

  Please click this link to reset your password:<br><br>

  http://localhost:8081/gogetter/resetpass.php?email='.$email.'&hash='.$hash;  
  //http://student.kdupg.edu.my/xx/xx/resetpass.php?email='.$email.'&hash='.$hash;
  $mail->Body = $Msg;
  $mail->send();
echo "found";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password - GoGetter</title>
</head>
<?php require_once('header.html'); ?>
  <?php include 'css/css.html'; ?>
  <style>
    body {
    background-image: url("https://cdn-images-1.medium.com/max/1600/0*AhQ1F4hEelt6Zz6s.jpg");
    background-repeat: no-repeat;
    background-position: center bottom;
}
    </style>


<body>
<?php require_once('navbar.html'); ?>


<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
<?php
       if(isset($_SESSION["username1"]) && isset($_SESSION["identity"]) && $_SESSION["actype"])  
        {
          echo "<a href='login_success.php' class='w3-bar-item w3-button w3-padding-large'>Main Menu</a>";
        }else{
          echo "<a href='registering.php' class='w3-bar-item w3-button w3-padding-large'>Register</a>";
          echo "<a href='loging.php' class='w3-bar-item w3-button w3-padding-large'>Login</a>";
          echo "<a href='reset.php' class='w3-bar-item w3-button w3-padding-large'>?</a>";
        }
       ?>
</div>
<div style="margin-top: -20px;">
  <ul class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i></a></li>
    <li><a href="reset.php">RESET PASSWORD</a></li>
  </ul>
</div>
<!--<br><br><br><br><br><br><br><br><br>-->
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="reset.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Sent Reset link</button>
    <a href="forgetusrn.php">Click Here if Forget Username</a>
    </form>
    <?php
        if ( isset($_GET['success']) && $_GET['success'] == 1 )
          {
	        $msg = '<font color="white">Account validate, please go reset by link that we just sent to your Email</font>';
          echo "<h3>$msg.<h3>";
        }
        if ( isset($_GET['fail']) && $_GET['fail'] == 1 )
        {
        $msg = '<font color="white">Sorry this email address is not exist</font>';
        echo "<h3>$msg.<h3>";
      }
    ?>

  </div>
          
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<!-- Footer -->
<?php require_once('footer.html'); ?>
</body>

</html>
