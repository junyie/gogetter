<?php
require_once("sessionchecker.php");
if ( isset($_GET['follow'])){ $equal = $_GET['follow'];}

$query1 = "SELECT * FROM `goals_followed` WHERE `goals_fk` = :g_fk AND `goals_follower_fk` = :gf_fk"; 

$search=$conn->prepare($query1);
$search->bindParam(':g_fk', $equal, PDO::PARAM_STR);
$search->bindParam(':gf_fk', $_SESSION["identity"] , PDO::PARAM_STR);
$search->execute();
$total = $search->rowCount();
$result = $search->fetch(PDO::FETCH_ASSOC);;


if (isset($_POST['id']) && isset($_POST['text']) && isset($_POST['column_name'])){
    $id = $_POST["id"];  
    $text = $_POST["text"];  
    $column_name = $_POST["column_name"]; 

    if ($column_name =="time" && $id == $result['goal_followed_id']){ 
        $update_time = "UPDATE `goals_followed` SET `reminder_time`=':receivedtime' WHERE `goal_followed_id` = :goal_followid";

    $updatetime=$conn->prepare($update_time);
    $updatetime->bindParam(':receivedtime', $text, PDO::PARAM_STR);
    $updatetime->bindParam(':goal_followid', $result$_SESSION["identity"], PDO::PARAM_STR);
    $updatetime->execute();
    }
}

?>