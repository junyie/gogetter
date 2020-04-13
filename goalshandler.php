<?php
require_once("sessionchecker.php");
if ( isset($_GET['follow'])){ $equal = $_GET['follow'];}
if ( isset($_GET['record'])){ $equal = $_GET['record'];}
if ( isset($_POST['follow'])){ $equal = $_POST['follow'];}
if ( isset($_POST['set_target'])){ $equal = $_POST['set_target'];}

$query1 = "SELECT * FROM `goals_followed` WHERE `goals_fk` = :g_fk AND `goals_follower_fk` = :gf_fk"; 

$search=$conn->prepare($query1);
$search->bindParam(':g_fk', $equal, PDO::PARAM_STR);
$search->bindParam(':gf_fk', $_SESSION["identity"] , PDO::PARAM_STR);
$search->execute();
$total = $search->rowCount();
$result = $search->fetch(PDO::FETCH_ASSOC);;

$gobacklink = "goalprofile.php?goal=".$equal;
if ($total ==0){
    //insert a newone in goals_followed
    if ( isset($_GET['follow'])){
        insertNewTogoalsFollowed($conn,$equal,$_SESSION["identity"]);
    }
   
}else{

     //update the goals_followed setting
    if (isset($_GET['sun'])||isset($_GET['mon'])||isset($_GET['tue'])
    ||isset($_GET['wed'])||isset($_GET['thus'])||isset($_GET['fri'])||isset($_GET['sat'])){
        //echo "hello";
        $update_day = "";
        if (isset($_GET['sun']) && $result['sunday']== '0' && $_GET['sun']=='0'){
            $update_day = "UPDATE `goals_followed` SET `sunday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['sun']) && $result['sunday']== '1' && $_GET['sun']=='1'){
            $update_day = "UPDATE `goals_followed` SET `sunday`=0 WHERE `goal_followed_id` = :goal_following";}else{}

        if (isset($_GET['mon']) && $result['monday']== '0' && $_GET['mon']=='0'){
            $update_day = "UPDATE `goals_followed` SET `monday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['mon']) && $result['monday']== '1' && $_GET['mon']=='1'){
            $update_day = "UPDATE `goals_followed` SET `monday`=0 WHERE `goal_followed_id` = :goal_following";}else{}

        if (isset($_GET['tue']) && $result['tuesday']== '0' && $_GET['tue']=='0'){
            $update_day = "UPDATE `goals_followed` SET `tuesday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['tue']) && $result['tuesday']== '1' && $_GET['tue']=='1'){
            $update_day = "UPDATE `goals_followed` SET `tuesday`=0 WHERE `goal_followed_id` = :goal_following";}else{}

        if (isset($_GET['wed']) && $result['wednesday']== '0' && $_GET['wed']=='0'){
            $update_day = "UPDATE `goals_followed` SET `wednesday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['wed']) && $result['wednesday']== '1' && $_GET['wed']=='1'){
            $update_day = "UPDATE `goals_followed` SET `wednesday`=0 WHERE `goal_followed_id` = :goal_following";}else{}

        if (isset($_GET['thus']) && $result['thusday']== '0' && $_GET['thus']=='0'){
            $update_day = "UPDATE `goals_followed` SET `thusday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['thus']) && $result['thusday']== '1' && $_GET['thus']=='1'){
            $update_day = "UPDATE `goals_followed` SET `thusday`=0 WHERE `goal_followed_id` = :goal_following";}else{}

        if (isset($_GET['fri']) && $result['friday']== '0' && $_GET['fri']=='0'){
            $update_day = "UPDATE `goals_followed` SET `friday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['fri']) && $result['friday']== '1' && $_GET['fri']=='1'){
            $update_day = "UPDATE `goals_followed` SET `friday`=0 WHERE `goal_followed_id` = :goal_following";}else{}

        if (isset($_GET['sat']) && $result['saturday']== '0' && $_GET['sat']=='0'){
            $update_day = "UPDATE `goals_followed` SET `saturday`=1 WHERE `goal_followed_id` = :goal_following";
        }else if (isset($_GET['sat']) && $result['saturday']== '1' && $_GET['sat']=='1'){
            $update_day = "UPDATE `goals_followed` SET `saturday`=0 WHERE `goal_followed_id` = :goal_following";}else{}
        
        echo "update_day".$update_day;
        if (!empty($update_day)){
            updategoalsFollowedSetting($conn,$result['goal_followed_id'],$update_day);
            //echo "query &nbsp".$update_day;
            unset($update_day);
            header("location:$gobacklink");
        }
    }
    //delete everythings
    //echo "Yes";
    
    //insert a new goal record
    echo "no";
}

function insertNewTogoalsFollowed($conn,$equal,$session1){
    $queryIns = "INSERT INTO `goals_followed`( `goals_fk`, `goals_follower_fk`) VALUES (:value2, :value3)"; 
    $insert=$conn->prepare($queryIns);
    $insert->bindParam(':value2', $equal, PDO::PARAM_STR);
    $insert->bindParam(':value3', $session1 , PDO::PARAM_STR);
    $insert->execute();
    header("location:$gobacklink");
}

function updategoalsFollowedSetting($conn,$goal_followedID,$quertUpdategoalsetting){

    $update=$conn->prepare($quertUpdategoalsetting);
    $update->bindParam(':goal_following', $goal_followedID, PDO::PARAM_STR);
    $update->execute();
}

function insertNewTarget($conn, $result_goal_followed_id, $startday, $endday, $exp){
    /*INSERT INTO `goal_target`( `following_goal_fk`, `start_date`, 
    `end_date`, `expected_times`, `targeted_times`) 
    VALUES ([value-2],[value-3],[value-4],[value-5],[value-6])*/
    $queryIns = "INSERT INTO `goal_target`( `following_goal_fk`, `start_date`, `end_date`, `expected_times`) 
    VALUES (:value2,:value3,:value4,:value5)"; 
    $insert=$conn->prepare($queryIns);
    $insert->bindParam(':value2', $result_goal_followed_id, PDO::PARAM_STR);
    $insert->bindParam(':value3', $startday , PDO::PARAM_STR);
    $insert->bindParam(':value4', $endday , PDO::PARAM_STR);
    $insert->bindParam(':value5',  $exp , PDO::PARAM_STR);
    $insert->execute();
}

//save the record after certain goal was done

if (isset($_POST['notes']) && $total >0){
    $date = date('Y-m-d');// H:i:s
    $queryInsnewRecord = "INSERT INTO `goal_record`(`following_goal_fk`, `checked_date`, `goal_desc`) VALUES (:value2,:value3,:value4)"; 
    $insertR=$conn->prepare($queryInsnewRecord);
    $insertR->bindParam(':value2', $result['goal_followed_id'], PDO::PARAM_STR);
    $insertR->bindParam(':value3', $date, PDO::PARAM_STR);
    $insertR->bindParam(':value4', $_POST['notes'], PDO::PARAM_STR);
    $insertR->execute();
    //echo "Insert a new row &nbsp received notes>".$_POST['notes'];
    header("location:$gobacklink");
}

//update the time setting to remind user check
if (isset($_POST['id']) && isset($_POST['text']) && isset($_POST['column_name'])){
    $id = $_POST["id"];  
    $text = $_POST["text"];  
    $column_name = $_POST["column_name"]; 

    //if ($column_name =="time"){ 
    $update_time = "UPDATE `goals_followed` SET `reminder_time`=:receivedtime WHERE `goal_followed_id` = :goal_followid AND `goals_follower_fk`= :sessionid";

    $updatetime=$conn->prepare($update_time);
    $updatetime->bindParam(':receivedtime', $text, PDO::PARAM_STR);
    $updatetime->bindParam(':goal_followid', $id, PDO::PARAM_STR);
    $updatetime->bindParam(':sessionid', $_SESSION["identity"] , PDO::PARAM_STR);
    $updatetime->execute();
    echo "session_id". $_SESSION["identity"]."&nbsp passed_id &nbsp".$id." &nbsp text receive &nbsp".$text;
    //}
    //here i havent add checking befor inserting to this one new record ,
    // should be check if today done the note then not able to record again
}


if (isset($_POST['exp']) && $total >0){
    echo "mama miyaaa mieooow<br>goal followed ID".$result['goal_followed_id'];
    $result_goal_followed_id = $result['goal_followed_id'];
    $myStr = $_POST['date1'];
    $date1day = mb_substr($myStr, 0, 2);
    $date1month = mb_substr($myStr, 3, 2);
    $date1year = mb_substr($myStr, 6, 4); //start day check
    $myStr = $date1year."-".$date1month."-".$date1day;

    $myStr2 = $_POST['date2'];
    $date2day = mb_substr($myStr2, 0, 2);
    $date2month = mb_substr($myStr2, 3, 2);
    $date2year = mb_substr($myStr2, 6, 4); //end day check
    $myStr2 = $date2year."-".$date2month."-".$date2day;

    $getexp = $_POST['exp'];
     //checkdate( MM, DD, YY)checkdate($date2month, $date2day, $date2year);
        if (is_numeric($_POST['exp']) && is_numeric($_POST['durationdays'])
        && checkdate($date2month, $date2day, $date2year) && checkdate($date1month, $date1day, $date1year)){ 
            if (strlen(trim($_POST['exp'])) > strlen(trim($_POST['durationdays'])) && $getexp < '0' ||  $getexp == '0'){
                $getexp = $_POST['durationdays'];
            }else{
                insertNewTarget($conn, $result_goal_followed_id, $myStr, $myStr2, $getexp);
            }
        }else { echo "<br>No is not numeric"; }
        //echo "<br>Yes is numeric =".$_POST['exp']; //echo "<br>date1".$_POST['date1']; }
        header("location:$gobacklink");
}


//updateTargetGoalstatustoRewarded($conn, $s_id, $chall_id)
if (isset($_GET['redeem'])){
    if (isset($_GET['redeem']) && ctype_digit($_GET['redeem']) && $_GET['redeem'] > "0" ){
        //echo "the get".$_GET['redeem'];

       $query =
       "  SELECT tgt.goal_target_id, tgt.targeted_times
       FROM goal_target tgt join goals_followed tgf ON tgt.following_goal_fk = tgf.goal_followed_id
                        join common_goals tcg ON tgf.goals_fk = tcg.goals_id
                         WHERE tgf.goals_follower_fk = :s_id  AND tgt.goal_rewarded = '0'
                         AND tgt.end_date < CURDATE() AND  tgt.goal_target_id = :goaltarget_id ;  
       "; //OPTIONAL HERE ADD ORDER BY START OR END DATE
   
       $searchc_=$conn->prepare($query);
       $searchc_->bindParam(':s_id', $s_id, PDO::PARAM_STR);
       $searchc_->bindParam(':goaltarget_id', $_GET['redeem'], PDO::PARAM_STR);
       $searchc_->execute();
       $searchedResuult = $searchc_->fetch(PDO::FETCH_ASSOC);
       $totalresultc = $searchc_->rowCount(); 
   
       if ($totalresultc >'0'){
           echo "Yeaaashh";
           print_r($totalresultc);
           
        try{
            $conn->beginTransaction();
            $updatedestatus = updateGoalTargetRewarded($conn, $_GET['redeem']);
            echo "Update status =".$updatedestatus;
            $redeemStatus = addpointstoUser($conn, $s_id,$searchedResuult['targeted_times'], $mypoints );
            //echo "Transacted Succesfully".$deduct.$insertNewChallenge;
            if ($updatedestatus ==FALSE|| $redeemStatus==FALSE){//
                echo "rolled back";
                    $conn->rollBack();     
            }else{
                $conn->commit();
                header("location:rewardlist2.php");
            }
        }
        catch(PDOException $e){
            $conn->rollback();
            echo "Error Occur>".$e;
        }
           //print_r($searchedResuult);
           
           //echo "<br>status of update ".$updatedestatus;
           //echo "<br>points".$searchedResuult['chall_reward_points'];
       }else{
        //header("location:error.php");
       }
    }else{
        header("location:error.php");
    }
}


function updateGoalTargetRewarded($conn, $gt_id){
    //check the user account in the challenge first
    if ($conn != ""  && $gt_id !="" ){
        $a = '1';
        $update_redeemStatus = "UPDATE `goal_target` SET `goal_rewarded`=:one WHERE `goal_rewarded`='0' AND `goal_target_id` = :gtid";
        $updateredeemStatus=$conn->prepare($update_redeemStatus);
        $updateredeemStatus->bindParam(':one', $a, PDO::PARAM_INT);
        $updateredeemStatus->bindParam(':gtid', $gt_id , PDO::PARAM_INT); 
        $updateredeemStatus->execute();
        $count = $updateredeemStatus->rowCount();

        if ($count == true){ return TRUE; } else {
            echo "Fail Update";
            return FALSE; }//updateredeemStatus == true $count > '0'
    }else{
        return 0;
    }
}

function addpointstoUser($conn, $s_id, $rewardpoints, $mypoints){
    $update_Points = "UPDATE `user` SET `upoints`=:currentPoint WHERE `user_id`=:sessionid";//&& $chall_reward_point !=""
    $currentPoint =  $rewardpoints + $mypoints;
    $updateP=$conn->prepare($update_Points);
    $updateP->bindParam(':currentPoint', $currentPoint, PDO::PARAM_STR);
    $updateP->bindParam(':sessionid', $s_id , PDO::PARAM_STR);
    $updateP->execute();
    $count = $updateP->rowCount();
    if ($updateP = TRUE){ return true; }else { return false; }
}

?>