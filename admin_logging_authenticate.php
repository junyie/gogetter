<?php
 session_start();
 require_once('db.php');
 require_once("csrf.php");
if (isset($_POST['admin_login'])) {

	if (hash_equals($csrf, $_POST['csrf'])) {
	
		$admin_username = ($_POST['admin_username']);
		$admin_password = ($_POST['password']);
	//echo "Runned";
	$stmt2 = $conn->prepare("SELECT * FROM administrator WHERE username=:admin_username AND verified_status ='1'");
	$stmt2->bindParam(":admin_username",$admin_username);
	$stmt2->execute();
	
	$result = $stmt2->fetch(PDO::FETCH_ASSOC);
	print_r(result);
	}else{
		echo "fail";
		header("location:index.php");
	}
	$exit ='1';
	if ($result >0){
	//    echo "horray";exit;
		if(password_verify($admin_password,$result['password'])){
			$_SESSION["admin_username"] = $result['username'];
			$_SESSION["admin_identity"] = $result['id'];

			$exit ='0';
			
			header("location:admin_dashboard.php");
		}
	}
	if ($exit =='1'){
		echo "fail";
		session_destroy();	
		header('location: admin_logging.php?fail=1');
	}
	}
	?>