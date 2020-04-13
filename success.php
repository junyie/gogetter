<?php
/* Displays all successful messages */
session_start();
?>
<!DOCTYPE html>
<html>
<style>
body {
  background-image: url('uploads/run.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>
<?php require_once('header.html'); ?>
  <?php include 'css/css.html'; ?>
</head>
<body>
<?php require_once('navbar.html'); ?>
<br><br><br><br><br><br><br><br><br>
<div class="form">
    <h1><?= 'Success'; ?></h1>
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
        echo $_SESSION['message'];    
    else:
        header( "location: loging.php" );
    endif;
    ?>
    </p>
    <a href="loging.php"><button class="button button-block"/>Home</button></a>
</div>
<!-- Footer -->
<?php require_once('footer.html'); ?>
</body>
</html>
