<?php
require_once('db.php');
session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  try {
      $email = $_POST["email"];
      $stmt_semail = $conn->prepare("SELECT * FROM user WHERE uemail=:email AND verified_status ='1'");
      $stmt_semail->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt_semail->execute();
      echo "checked";
      $results1 = $stmt_semail-> fetch(PDO::FETCH_ASSOC);
      }
  catch(PDOException $e){
      {
      echo "Error: " . $e->getMessage();
      }
  }

  if ($results1 >0){
    try {  
        $email = $results1['uemail'];
        $usrn = $results1['username'];
        sendForgetusrnMail($email,$usrn);
        header('location: forgetusrn.php?success=1');
        }
    catch(PDOException $e)
        {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }
  if (!$results1 >0){
    echo "fail";
    header('location:forgetusrn.php?fail=1');
  }        
}else {
    echo "‌‌ ";
}

function sendForgetusrnMail($email,$usrn){
  // Session message to display on success.php
  $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
  . " for recover back your username!</p>";
  //$headers .= "Content-type: text/html";
  // Send registration confirmation link (reset.php)
  require_once("mail.php");
  $mail->setFrom('spammerking12345@gmail.com');
  $mail->isHTML(true);
  $mail->addAddress($email);
  $mail->Subject = 'Requesting Forgot Username ( GoGetter.com )';
  $Msg = "<html><head> </head><body>";
  $Msg .= '<img src="https://ci5.googleusercontent.com/proxy/q1c7-9sC5IJC5VEmr2znCyQ5XDrfRVP63npODHE-j9fiCMOHMjRIIeYvUe-rYyUZw1I=s0-d-e1-ft#https://i.imgur.com/aHNsYHX.png" style="width:180px; height:40px" title="24hrs Tutor" alt="24hrs Tutor"> </body></html>
  Hello '.$email.',

  You have requested to check your username!<br>

  Your Username is :'.$usrn.'

  http://localhost:8081/gogetter/loging.php';  
  //http://student.kdupg.edu.my/xxx/xx/loging.php'; 

  $mail->Body = $Msg;
  $mail->send();
  //print_r(error_get_last());
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Recover Username - GoGetter</title>
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
</head>

<body>
<?php require_once('navbar.html'); ?>
<div style="margin-top: -20px;">
  <ul class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i></a></li>
    <li><a href="forgetusrn.php">RECOVER USERNAME</a></li>
  </ul>
</div>
<!--<br><br><br><br><br><br><br><br><br>-->
  <div class="form">

    <h1>Recover Your Username</h1>

    <form action="forgetusrn.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Send to my Mail</button>
    <a href="reset.php">Click Here if Forget Password</a>
    </form>
    <?php
        if ( isset($_GET['success']) && $_GET['success'] == 1 )
          {
	        $msg = '<font color="white">Account validate, please go check your Email</font>';
          echo " <h3>$msg.<h3>";
        }
        if ( isset($_GET['fail']) && $_GET['fail'] == 1 )
        {
        $msg = '<font color="white">Sorry this email address is not exist</font>';
        echo " <h3>$msg.<h3>";
      }
    ?>

  </div>
<?php require_once('footer.html'); ?>         
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
