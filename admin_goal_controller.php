<?php
//require_once("sessionchecker.php");
require_once("db.php");

//for creating new goal
if (isset($_POST['submit']) && isset($_POST['goals_name'])){
    $goal_name  = $_POST['goals_name'];
    $goal_description  = $_POST['goal_description'];
    $goal_category  = $_POST['category'];
	
	$file_name = basename($_FILES["file"]["name"]);
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["file"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
    try{
        $conn->beginTransaction();
        $insertNewGoal = insertNewGoal($conn, $goal_name, $goal_description, $goal_category, $file_name);
        if ($insertNewGoal[0]=="false"){
            $conn->rollBack();     
        }else{
            $goalid = $insertNewGoal[1];
            $_SESSION['post_goal_id'] = $insertNewGoal[1];
            $conn->commit();
            header("location:admin_goal_list.php?csuccess=1");
			
        }
    }
    catch(PDOException $e){
        $conn->rollback();
        echo "Error Occur>".$e;
    }
}

if (isset($_POST['update'])){
    $goal_name  = $_POST['goals_name'];
    $goal_description  = $_POST['goal_description'];
    $goal_category  = $_POST['category'];
    $goal_id = $_POST['updateid'];
	$file_name = basename($_FILES["file"]["name"]);
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["file"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
    try{
        $conn->beginTransaction();
        $updateGoal = updateGoal($conn, $goal_name, $goal_description, $goal_category, $goal_id, $file_name);
        if ($updateGoal[0]=="false"){
			echo '<script>alert("No updates");</script>';
            $conn->rollBack();     
        }else{
			echo '<script>alert("Record Updated!");</script>';
            $conn->commit();
            header("location:admin_goal_list.php?usuccess=1");
        }
    }
    catch(PDOException $e){
		echo '<script>alert("ERROR");</script>';
        $conn->rollback();
        echo "Error Occur>".$e;
    }

}

if (isset($_POST['deleteid'])){
    $goal_id  = $_POST['deleteid'];
	
    try{
        $conn->beginTransaction();
        $deleteCategory = deleteGoal($conn, $goal_id);
        if ($deleteCategory[0]=="false"){
            $conn->rollBack();     
        }else{
            $conn->commit();
        }
    }
    catch(PDOException $e){
        $conn->rollback();
        echo "Error Occur>".$e;
    }	
}


function insertNewGoal($conn, $goal_name, $goal_description, $goal_category, $goal_image){

    $date_created = date("Y-m-d H:i:s"); 
    $queryIns = "INSERT INTO `common_goals`( `goals_name`, `category`, `goals_desc`, `date_created`, `goals_picture`) VALUES (:goals_name, :goal_category, :goal_description, :date_created, :goal_image)"; 
    $insert=$conn->prepare($queryIns);
    $insert->bindParam(':goals_name', $goal_name, PDO::PARAM_STR);
    $insert->bindParam(':goal_description', $goal_description, PDO::PARAM_STR);
    $insert->bindParam(':goal_category', $goal_category, PDO::PARAM_STR);
    $insert->bindParam(':date_created', $date_created, PDO::PARAM_STR);
    $insert->bindParam(':goal_image', $goal_image, PDO::PARAM_STR);

    $insert->execute();
    if($insert == true){ 
        $lastinsertedrow = $conn->lastInsertId();
        return  array("true", $lastinsertedrow);
    }else{
        array("false", $lastinsertedrow); $conn->rollBack();
    }   
}

function listAllGoal($conn, $sessionid){
    $query1= "SELECT * FROM common_goals";
    $search=$conn->prepare($query1);
    $search->bindParam(':sid', $sessionid, PDO::PARAM_STR);
    $search->execute();
    $search1 = $search->fetchAll(PDO::FETCH_ASSOC);
    return $search1;
}

function updateGoal($conn, $goal_name, $goal_description, $goal_category, $goal_id, $target){
    $updateGoal = "UPDATE `common_goals` SET `goals_name`=:goal_name , `category`=:goal_category, `goals_desc`=:goal_description, `goals_picture`=:target WHERE `goals_id` =:goal_id";

        $updateTT_=$conn->prepare($updateGoal);
        $updateTT_->bindParam(':goal_name', $goal_name, PDO::PARAM_STR);
        $updateTT_->bindParam(':goal_category', $goal_category, PDO::PARAM_STR);
        $updateTT_->bindParam(':goal_description', $goal_description, PDO::PARAM_STR);
        $updateTT_->bindParam(':target', $target, PDO::PARAM_STR);
        $updateTT_->bindParam(':goal_id', $goal_id, PDO::PARAM_INT);
        $updateTT_->execute();
}

function deleteGoal($conn, $goal_id){
    $deleteGoal = "DELETE FROM `common_goals` WHERE `goals_id` =:goal_id";
    $deleteTT_=$conn->prepare($deleteGoal);
    $deleteTT_->bindParam(':goal_id', $goal_id, PDO::PARAM_INT);
    $deleteTT_->execute();
}

?>