<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<!-- Header -->
<?php require_once('header.html'); ?>
  <?php include 'css/css.html'; ?>
</head>
<body>
    <!-- Navbar -->
<?php require_once('navbar.html'); ?>
<br><br><br><br><br><br><br><br><br>
<div class="form">
    <h1>Error</h1>
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        //header( "location: index.php" );
    endif;
    ?>
    </p>     
    <a href="index.php"><button class="button button-block"/>Home</button></a>
</div>
<!-- Footer -->
<?php require_once('footer.html'); ?>
</body>
</html>
