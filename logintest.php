<?php
 session_start();
 require_once('db.php');
 require_once("csrf.php");
if (isset($_POST['login'])) {

	if (hash_equals($csrf, $_POST['csrf'])) {
	
	$username = ($_POST['username1']);
	$password = ($_POST['password1']);
//echo "Runned";
$stmt2 = $conn->prepare("SELECT * FROM user WHERE username=:username1 AND verified_status ='1'");
$stmt2->bindParam(":username1",$username);
$stmt2->execute();

$result = $stmt2->fetch(PDO::FETCH_ASSOC);
}else{
	echo "fail";
	header("location:index.php");
}
$exit ='1';
if ($result >0){
   //echo "horray";	
	if(password_verify($password,$result['upassword'])){
		$_SESSION["username1"] = $result['username'];
		$_SESSION["identity"] = $result['user_id'];
	//	$_SESSION["biodata"] =  $result['bio_data'];
		//$_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
		//$stmt3 = $conn->prepare("UPDATE `user` SET `t_lastin`=CURRENT_TIMESTAMP WHERE `_id` =:id");
		//$stmt3->bindParam(":id",$_SESSION["identity"]);
		//$stmt3->execute();
		$exit ='0';
		//echo "success";
		header("location:userdashboard.php");
	}
}
if ($exit =='1'){
	echo "fail";
	session_destroy();	
    header('location: loging.php?fail=1');
}
}
?>