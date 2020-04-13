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
  <title>Admin Dashboard - GoGetter</title>
</head>
<body>
<?php require_once("userdashnav2.html"); ?>
  <div style="margin-right: 89px; margin-left: 89px; margin-bottom: 5px;">
    <ul class="breadcrumb" style="margin: 0px !important">
      <li><a href="admin_dashboard.php"><i class="fa fa-home"></i></a></li>
    </ul>
  </div>

<?php require_once("admin_sidenav.php"); ?>
              
<style>
.errorFeedback {
	visibility: hidden;
}
</style>

</body>
</html>
