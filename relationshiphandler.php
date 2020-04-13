<?php
 require_once("sessionchecker.php");
// Pending =P, Accept = A, Block = B
if ( isset($_GET['profile'])){ $equal = $_GET['profile'];}
if ( isset($_GET['request'])){$equal = $_GET['request'];}
if ( isset($_GET['block'])){$equal = $_GET['block'];}
if ( isset($_GET['unblock'])){$equal = $_GET['unblock'];}
if ( isset($_GET['accept'])){$equal = $_GET['accept'];}
if ( isset($_GET['remove'])){$equal = $_GET['remove'];}

$stmt = $conn->prepare("SELECT  * FROM `relationship` WHERE `inviter_fk` = :myself AND `addperson_fk` =:thatprofile or `inviter_fk` = :thatprofile AND `addperson_fk`=:myself");
$stmt->bindParam(":thatprofile",$equal, PDO::PARAM_STR);
$stmt->bindParam(":myself",$_SESSION["identity"], PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->rowCount();
$Relationresults = $stmt->fetch(PDO::FETCH_ASSOC);
if($Relationresults > 0) {
	$relation_id  = $Relationresults['friend_id']; 
	$fk_1 = $Relationresults['inviter_fk'];
	$fk_2 = $Relationresults['addperson_fk'];
	$fk_status1 = $Relationresults['inviter_status'];
	$fk_status2 = $Relationresults['acceptbyperson'];
}
 if ( isset($_GET['accept']) && $count >0)
{ //echo "accept";
    if ($fk_2 == $_SESSION["identity"]){
        // 
        $stmt = $conn->prepare("UPDATE `relationship` SET  `acceptbyperson`='A' WHERE `addperson_fk`=:mee AND `friend_id` =:relation");
        $stmt->bindParam(":mee",$_SESSION["identity"], PDO::PARAM_STR);
        $stmt->bindParam(":relation",$relation_id, PDO::PARAM_STR);
        $stmt->execute();
    }else{
        
    }
    //UPDATE relationship to accept
}else{
    $link ="error.php";
}

 if ( isset($_GET['remove']) && $count >0)
{ 	
	/*
	echo "remove"."<br>";
	echo $fk_1."<br>";
	echo $fk_2."<br>";
	echo $_SESSION["identity"]."<br>";
	*/
	$currentid = ($fk_1 == $_SESSION["identity"])? $fk_1 : $fk_2;
    if ($currentid == $_SESSION["identity"]){
        $stmt = $conn->prepare("DELETE FROM `relationship` WHERE `friend_id`=".$relation_id);
        $stmt->execute();
    }else{
        echo "FAIL";
    }
    //UPDATE relationship to accept
}else{
    $link ="error.php";
}

if ( isset($_GET['block']) && $count >0)
{  //echo "block";
    if ($fk_1 == $_SESSION["identity"]){
        $stmt = $conn->prepare("UPDATE `relationship` SET  `inviter_status`='B' WHERE  `friend_id` =:relation");
        //$stmt->bindParam(":mee",$_SESSION["identity"], PDO::PARAM_STR);
        $stmt->bindParam(":relation",$relation_id, PDO::PARAM_STR);
        $stmt->execute();
    }else{
        $stmt = $conn->prepare("UPDATE `relationship` SET  `acceptbyperson`='B' WHERE `friend_id` =:relation");
       // $stmt->bindParam(":mee",$_SESSION["identity"], PDO::PARAM_STR);
        $stmt->bindParam(":relation",$relation_id, PDO::PARAM_STR);
        $stmt->execute();
    }
    //UPDATE relationship to block
}

if ( isset($_GET['unblock']) && $count >0)
{  //echo "unblock";
    if ($fk_1 == $_SESSION["identity"]){
        $stmt = $conn->prepare("UPDATE `relationship` SET  `inviter_status`='A' WHERE  `friend_id` =:relation");
        //$stmt->bindParam(":mee",$_SESSION["identity"], PDO::PARAM_STR);
        $stmt->bindParam(":relation",$relation_id, PDO::PARAM_STR);
        $stmt->execute();
    }else{
        $stmt = $conn->prepare("UPDATE `relationship` SET  `acceptbyperson`='A' WHERE  `friend_id` =:relation");
        //$stmt->bindParam(":mee",$_SESSION["identity"], PDO::PARAM_STR);
        $stmt->bindParam(":relation",$relation_id, PDO::PARAM_STR);
        $stmt->execute();
    }
    //UPDATE relationship to unblock
}

if ( isset($_GET['request']) && $count ==0 && $_GET['request'] !=$_SESSION["identity"])
{ 
    //echo "adding request sent";
    $stmt = $conn->prepare("INSERT INTO `relationship`( `inviter_fk`, `addperson_fk`, `inviter_status`,
     `acceptbyperson`) VALUES (:me,:him,'A','P')");
    $stmt->bindParam(":me",$_SESSION["identity"], PDO::PARAM_STR);
    $stmt->bindParam(":him",$_GET['request'], PDO::PARAM_STR);
    $stmt->execute();
    //INSERT  create a request
}

$link = "profile.php?profile= ".$equal;
header("Refresh: 1;URL=$link");
?>