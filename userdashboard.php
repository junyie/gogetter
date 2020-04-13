<?php  
 //login_success.php 
 require_once("sessionchecker.php");
 //var_dump($_SESSION);
$target_path   = 'uploads/';

if (isset($_POST["submit"])){
  if (hash_equals($csrf, $_POST['csrf'])) {
  //DEBUG   echo "running";
    try{
        if (true){

           echo "Hi";
            }
        }
    catch(PDOException $e){
        {
            echo "Error: " . $e->getMessage();
        }
      }
    } else{
  echo 'CSRF Token Failed!';
}
}
 ?>  


 <html>
 <?php require_once("userdashheader.html");?>   
<head>
  <title>Dashboard - GoGetter</title>
</head>
<body>
<?php require_once("userdashnav2.html"); ?>
  <div style="margin-right: 89px; margin-left: 89px; margin-bottom: 5px;">
    <ul class="breadcrumb" style="margin: 0px !important">
      <li><a href="index.php"><i class="fa fa-home"></i></a></li>
    </ul>
  </div>
<?php require_once("userdashnav.php"); ?>


        
<?php require_once("userdashtab.php"); ?>      
<style>
.errorFeedback {
	visibility: hidden;
}
</style>
<hr style="border-top: 1px solid #000;">
<!-- Footer -->
<?php require_once('footer.html'); ?>
</body>
</html>


<!-- Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, .
when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
 but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of 
 Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. -->