<?php 
 require_once("sessionchecker.php");
$target_path   = 'uploads/';
?>
 <html>
 <?php require_once("userdashheader.html");?>   
<head><title>Challenges List - GoGetter</title></head>
<body>
<?php require_once("userdashnav2.html"); ?>
	<div style="margin-right: 89px; margin-left: 89px; margin-bottom: 5px;">
    	<ul class="breadcrumb" style="margin: 0px !important">
      		<li><a href="index.php"><i class="fa fa-home"></i></a></li>
      		<li><a href="userdashboard.php">DASHBOARD</a></li>
      		<li><a href="challengeshow.php">CHALLENGES LIST</a></li>
    	</ul>
  	</div>
<?php require_once("userdashnav.php"); ?>
        
<?php require_once("challengingtab.php"); ?>      
<style>
.errorFeedback {
	visibility: hidden;
}
</style>

</body>
</html>