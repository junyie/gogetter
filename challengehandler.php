<?php
//require_once("sessionchecker.php");
require_once("relationshipcontroller.php");
require_once("challengecontroller.php");

//require_once("challengecontroller.php");
//for creating new challenges
//debugPost();
if (isset($_POST['submit']) && isset($_POST['c_challangename']) && isset($_POST['c_ppl1'])){
    if (!isset($_POST['c_ppl1']) || !ctype_digit($_POST['c_ppl1'])){  $ppl1 = "None";}else {$ppl1 = $_POST['c_ppl1']; }
    if (!isset($_POST['c_ppl2']) || !ctype_digit($_POST['c_ppl2'])){  $ppl2 = "None";}else {$ppl2 = $_POST['c_ppl2']; }
    if (!isset($_POST['c_ppl3']) || !ctype_digit($_POST['c_ppl3'])){  $ppl3 = "None";}else {$ppl3 = $_POST['c_ppl3']; }
    if (!isset($_POST['c_ppl4']) || !ctype_digit($_POST['c_ppl4'])){  $ppl4 = "None";}else {$ppl4 = $_POST['c_ppl4']; }
/*
    if(!isset($_FILES['uploadedc']) || $_FILES['uploadedc']['error'] == UPLOAD_ERR_NO_FILE) {
        echo "<br>Error no file selected"; 
    } else {
        print_r($_FILES);
    }
    echo "<br>File".$_FILES['uploadedc'];*/
    $c_challangename  = $_POST['c_challangename'];
    $c_payment = $_POST['c_payment'];
    $c_describe  = $_POST['c_describe'];
    $c_expiredate  = $_POST['c_expiredate'];
    $c_startdate = $_POST['c_startdate'];
    $c_duedate = $_POST['c_duedate'];
    $c_ppl1 = (isNone($ppl1) ? '0' : $ppl1);
    $c_ppl2 = (isNone($ppl2) ? '0' : $ppl2);
    $c_ppl3 = (isNone($ppl3) ? '0' : $ppl3);
    $c_ppl4 = (isNone($ppl4) ? '0' : $ppl4); 
    $checktotals = checkNotsameIdforChallengers($conn,$c_ppl1,$c_ppl2,$c_ppl3,$c_ppl4, $s_id); //check if there are same ID pass into the challenge
 
    if ($checktotals >0 && $mypoints >= $c_payment && is_numeric($c_payment) && $c_payment >"0"){
        try{
            $conn->beginTransaction();
            $deduct = deductPointsFromUser($conn, $s_id, $c_payment, $mypoints);
            $insertNewChallenge = insertNewChallenge($conn, $c_challangename, $c_payment, $c_describe, $c_expiredate,
            $c_startdate,$c_duedate,$c_ppl1,$c_ppl2,$c_ppl3,$c_ppl4, $s_id );
            
            //echo "Transacted Succesfully".$deduct.$insertNewChallenge;
            if ($deduct =="false"|| $insertNewChallenge[0]=="false"){
                $conn->rollBack();     
            }else{
                $challengeid = $insertNewChallenge[1];
                $_SESSION['post_challid_result'] = $insertNewChallenge[0]; 
                $_SESSION['post_challid'] = $insertNewChallenge[1];
                require_once("upload_image.php"); // pass the image to the new created challenge id
                $conn->commit();
                unset($_SESSION['post_challid_result']);
                unset($_SESSION['post_challid']);
                header("location:challengeprofile.php?challengeprofile=".$insertNewChallenge[1]);
            }
        }
        catch(PDOException $e){
            $conn->rollback();
            echo "Error Occur>".$e;
        }
    }else{
        echo "You broked";
        header("location:error.php");
    }
}else{  echo "error occur";  header("location:error.php");}

// for accepting new challenge
if (isset($_GET['playerN'])){
    if (isset($_GET['playerN']) && ctype_digit($_GET['playerN']) && $_GET['playerN'] >= "1" || $_GET['playerN'] <= "5"){
        $success_check = false; $redirect_challengprof_id ="";
        if (isset($_GET['acceptchallenge']) && ctype_digit($_GET['acceptchallenge']) && $_GET['acceptchallenge'] > 0){
            //echo "Miewo acceptedChallenge".$_GET['acceptchallenge'];
            //echo "Player playerN &nbsp".$_GET['playerN'];
            $checkPending = checkparticipanteBeforeUpdateChallenge($conn, $s_id, $_GET['acceptchallenge'], $_GET['playerN'], "CheckPending");
            //print_r($checkPending); 
            $playerN ="";
            if ($checkPending['chall_creator_fk'] == $s_id){ $playerN="1"; }
            if ($checkPending['chall_invite2'] == $s_id){ $playerN="2"; }
            if ($checkPending['chall_invite3'] == $s_id){ $playerN="3"; }
            if ($checkPending['chall_invite4'] == $s_id){ $playerN="4"; }
            if ($checkPending['chall_invite5'] == $s_id){ $playerN="5"; } 
            $success_check = updateUserChallengeStatusToAccept($conn, $s_id, $playerN, $_GET['acceptchallenge']);
            $redirect_challengprof_id = $_GET['acceptchallenge'];
            //echo $success_check;
        }else if (isset($_GET['quitchallenge']) && ctype_digit($_GET['quitchallenge']) && $_GET['quitchallenge'] > 0){
            $checkPending = checkparticipanteBeforeUpdateChallenge($conn, $s_id, $_GET['quitchallenge'], $_GET['playerN'], "CheckAccepted");
            //print_r($checkPending); 
            $stmt = $conn->prepare("SELECT * FROM `challenges` WHERE `chall_id` = :thatprofile ");
            $stmt->bindParam(":thatprofile",$_GET['quitchallenge'], PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $challengeresults = $stmt->fetch(PDO::FETCH_ASSOC);
            $playerN ="";
            if ($challengeresults['chall_creator_fk'] == $s_id){ $playerN="1"; }
            if ($challengeresults['chall_invite2'] == $s_id){ $playerN="2"; }
            if ($challengeresults['chall_invite3'] == $s_id){ $playerN="3"; }
            if ($challengeresults['chall_invite4'] == $s_id){ $playerN="4"; }
            if ($challengeresults['chall_invite5'] == $s_id){ $playerN="5"; } 
            $success_check = updateUserChallengeStatusToQuit($conn, $s_id, $playerN, $_GET['quitchallenge']);
            $redirect_challengprof_id = $_GET['quitchallenge'];
        }else { //header("location:error.php");
        }
        if ($success_check == TRUE){ header("location:challengeprofile.php?challengeprofile=".$redirect_challengprof_id); }
    }
}

//insert new rating record for  a challenge
if (isset($_POST['submitarating']) && isset($_GET['rating']) ){//$_POST['challengeprofile']
    // isset($_GET['rating'])
    $challengeresults=$conn->prepare("SELECT * FROM `challenges` WHERE `chall_id`=:id");
    $challengeresults->bindParam(':id', $_GET['rating'], PDO::PARAM_STR);
    $challengeresults->execute();
    $count1 = $challengeresults->rowCount();
    $challengeresult = $challengeresults->fetch(PDO::FETCH_ASSOC);
    $score1 = $score2 = $score3 = $score4 = $score5 =0;
    $challengeID = $challengeresult['chall_id'];
    $player1 = $challengeresult['chall_creator_fk'];
    $player2 = $challengeresult['chall_invite2'];
    $player3 = $challengeresult['chall_invite3'];
    $player4 = $challengeresult['chall_invite4'];
    $player5 = $challengeresult['chall_invite5'];
    $statusppl1 = $challengeresult['chall_accept1'];
    $statusppl2 = $challengeresult['chall_accept2']; 
    $statusppl3 = $challengeresult['chall_accept3'];
    $statusppl4 = $challengeresult['chall_accept4']; 
    $statusppl5 = $challengeresult['chall_accept5']; 

    $currentusergetScoretoo = rand(1,4);
    if (isset($_POST['ratingone']) && is_numeric($_POST['ratingone']) && $player1!="0" && $player1!=$s_id){
        if ($_POST['ratingone'] < 0 ) {$score1 = '5';}else{$score1 =$_POST['ratingone'];}
    }
    if (isset($_POST['ratingtwo']) && is_numeric($_POST['ratingtwo']) && $player2!="0" && $player2!=$s_id){
        if ($_POST['ratingtwo'] < 0 ) {$score2 = '5';}else{$score2 =$_POST['ratingtwo'];}
    }
    if (isset($_POST['ratingthree']) && is_numeric($_POST['ratingthree']) && $player3!="0" && $player3!=$s_id){
        if ($_POST['ratingthree'] < 0) {$score3 = '5';}else{$score3 =$_POST['ratingthree'];}
    }
    if (isset($_POST['ratingfour']) && is_numeric($_POST['ratingfour']) && $player4!="0" && $player4!=$s_id){
        if ($_POST['ratingfour'] < 0 ) {$score4 = '5';}else{$score4 =$_POST['ratingfour'];}
    }
    if (isset($_POST['ratingfive']) && is_numeric($_POST['ratingfive']) && $player5!="0" && $player5!=$s_id){
        if ($_POST['ratingfive'] < 0 ) {$score5 = '5';}else{$score5 =$_POST['ratingfive'];}
    }
    if (!isset($_POST['ratingone']) && $player1 !="0" && $statusppl1 ="A" && $player1 != $s_id){$score1 = '5';}
    if (!isset($_POST['ratingtwo']) && $player2 !="0" && $statusppl2 ="A" && $player2 != $s_id){$score2 = '5';}
    if (!isset($_POST['ratingthree']) && $player3 !="0" && $statusppl3 ="A" && $player3 != $s_id){$score3 = '5';}
    if (!isset($_POST['ratingfour']) && $player4 !="0" && $statusppl4 ="A" && $player4 != $s_id){$score4 = '5';}
    if (!isset($_POST['ratingfive']) && $player5 !="0" && $statusppl5 ="A" && $player5 != $s_id){$score5 = '5';}
    if ($player1 == $s_id){ $score1 = $currentusergetScoretoo;  }
    if ($player2 == $s_id){ $score2 = $currentusergetScoretoo;  }
    if ($player3 == $s_id){ $score3 = $currentusergetScoretoo;  }
    if ($player4 == $s_id){ $score4 = $currentusergetScoretoo;  }
    if ($player5 == $s_id){ $score5 = $currentusergetScoretoo;  }

    $value = "0";
    $value = checkTodayHad_RatedNot($conn, $s_id, $challengeID);
    /* echo $value;*/
    if ($value=="1" && $count1 >0) { 
        echo "Is true";
        $queryInsertChall_record = "INSERT INTO `challenge_record`( `fk_challenge_id`, `fk_rater_id`, `player1_score`, `player2_score`, `player3_score`, `player4_score`, `player5_score`) 
        VALUES (:fk_challenge_id,:fk_rater_id,:score1,:score2,:score3,:score4,:score5)";
        $challengeiNSERTrating=$conn->prepare($queryInsertChall_record);
        $challengeiNSERTrating->bindParam(':fk_challenge_id', $challengeID, PDO::PARAM_STR);
        $challengeiNSERTrating->bindParam(':fk_rater_id', $s_id, PDO::PARAM_STR);
        $challengeiNSERTrating->bindParam(':score1', $score1, PDO::PARAM_STR);
        $challengeiNSERTrating->bindParam(':score2', $score2, PDO::PARAM_STR);
        $challengeiNSERTrating->bindParam(':score3', $score3, PDO::PARAM_STR);
        $challengeiNSERTrating->bindParam(':score4', $score4, PDO::PARAM_STR);
        $challengeiNSERTrating->bindParam(':score5', $score5, PDO::PARAM_STR);
        $challengeiNSERTrating->execute();
        if ($challengeiNSERTrating){header("location:challengeprofile.php?challengeprofile=".$challengeID); }
         else {header("location:error.php");}//challengeprofile
    }

    //echo "retrieveProfID1 &nbsp".$player1." &nbsp retrieveProfID2 &nbsp".$player2." &nbsp retrieveProfID3 &nbsp".$player3.
    //" &nbsp retrieveProfID4 &nbsp".$player4." &nbsp retrieveProfID5 &nbsp".$player5;
}

//Redeem the points from challenge after end to winner
//updateChallengeWinnerRewarded($conn, $s_id, $chall_id)
if (isset($_GET['redeem'])){
    if (isset($_GET['redeem']) && ctype_digit($_GET['redeem']) && $_GET['redeem'] > "0" ){
        //echo "the get".$_GET['redeem'];

       $query =
       "   SELECT `chall_id`, `chall_name`, `chall_reward_points` FROM `challenges` WHERE `winner_fk` = :s_id  
       AND `chall_due_date` <= CURDATE() AND `chall_id` = :chall_id
       "; //OPTIONAL HERE ADD ORDER BY START OR END DATE
   
       $searchc_=$conn->prepare($query);
       $searchc_->bindParam(':s_id', $s_id, PDO::PARAM_STR);
       $searchc_->bindParam(':chall_id', $_GET['redeem'], PDO::PARAM_STR);
       $searchc_->execute();
       $searchedResuult = $searchc_->fetch(PDO::FETCH_ASSOC);
       $totalresultc = $searchc_->rowCount(); 
   
       if ($totalresultc >'0'){
        try{
            $conn->beginTransaction();
            $updatedestatus = updateChallengeWinnerRewarded($conn, $s_id, $_GET['redeem']);
            echo "Update status =".$updatedestatus;
            $redeemStatus = addpointstoUser($conn, $s_id,$searchedResuult['chall_reward_points'], $mypoints );
            //echo "Transacted Succesfully".$deduct.$insertNewChallenge;
            if ($updatedestatus ==FALSE|| $redeemStatus==FALSE){//
                echo "rolled back";
                    $conn->rollBack();     
            }else{
                $conn->commit();
                header("location:rewardlist.php");
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
        header("location:error.php");
       }
    }else{
        header("location:error.php");
    }
}


//Check Each of the challengers is not same to the other 
//  ->//Need Tester for this what if passing all POST the current login user ID  
function checkNotsameIdforChallengers($conn,$c_ppl1,$c_ppl2,$c_ppl3,$c_ppl4, $s_id){
    $cppl1 = checkRelationshipEach($conn,$c_ppl1, $s_id);
    $cppl2 = checkRelationshipEach($conn,$c_ppl2, $s_id);
    $cppl3 = checkRelationshipEach($conn,$c_ppl3, $s_id);
    $cppl4 = checkRelationshipEach($conn,$c_ppl4, $s_id);
    $count =0;
    if (is_numeric($c_ppl1) && $cppl1==1 && $c_ppl1!=$c_ppl2 &&  $c_ppl1!=$c_ppl3 && $c_ppl1!=$c_ppl4){
        $count = $count+1;
    }
    if (is_numeric($c_ppl2) && $cppl2==1 && $c_ppl2!=$c_ppl1 &&  $c_ppl2!=$c_ppl3 && $c_ppl2!=$c_ppl4){
        $count = $count+1;
    }
    if (is_numeric($c_ppl3) && $cppl3==1 && $c_ppl3!=$c_ppl1 &&  $c_ppl3!=$c_ppl2 && $c_ppl3!=$c_ppl4){
        $count = $count+1;
    }
    if (is_numeric($c_ppl4) && $cppl4==1 && $c_ppl4!=$c_ppl1 &&  $c_ppl4!=$c_ppl2 && $c_ppl4!=$c_ppl3){
        $count = $count+1;
    }
    return $count;
}

//check passed value is None
function isNone($value){
    if ($value =="None"){
        return true;
    }else{
        return false;
    }
} 

//decuct the points for creating rewards 
function deductPointsFromUser($conn, $s_id, $c_payment, $mypoints){
    $update_Points = "UPDATE `user` SET `upoints`=:currentPoint WHERE `user_id`=:sessionid";
    $currentPoint = $mypoints - $c_payment;
    $updateP=$conn->prepare($update_Points);
    $updateP->bindParam(':currentPoint', $currentPoint, PDO::PARAM_STR);
    $updateP->bindParam(':sessionid', $s_id , PDO::PARAM_STR);
    $updateP->execute();

    if($updateP == true){ 
        return "true" ;
    }else{return "false";$conn->rollBack();}     
}

function insertNewChallenge($conn, $c_challangename, $c_payment, $c_describe, $c_expiredate,
    $c_startdate, $c_duedate, $c_ppl1, $c_ppl2, $c_ppl3, $c_ppl4, $s_id ){
       // echo "<br>image post in\$value".$c_image;
    echo "<br><br>Bin Miewo";
    $createdate = date("Y-m-d H:i:s"); 
    $queryIns = "INSERT INTO `challenges`( `chall_name`, `chall_desc`, `created_date`, `chall_creator_fk`, 
    `chall_invite2`, `chall_invite3`, `chall_invite4`,`chall_invite5`,  `chall_start_day`,
    `chall_invite_expire`, `chall_due_date`,   `chall_reward_points`)
        VALUES (:chall_name, :chall_desc, :created_date, :chall_creator_fk, :chall_invite2, :chall_invite3, 
        :chall_invite4, :chall_invite5, :chall_start_day,:chall_invite_expire, :chall_due_date,  
        :chall_reward_points)"; 
    $insert=$conn->prepare($queryIns);
    $insert->bindParam(':chall_name', $c_challangename, PDO::PARAM_STR);
    $insert->bindParam(':chall_desc', $c_describe, PDO::PARAM_STR);
    $insert->bindParam(':created_date', $createdate, PDO::PARAM_STR);
    $insert->bindParam(':chall_creator_fk', $s_id, PDO::PARAM_STR);
    $insert->bindParam(':chall_invite2', $c_ppl1, PDO::PARAM_STR);
    $insert->bindParam(':chall_invite3', $c_ppl2, PDO::PARAM_STR);
    $insert->bindParam(':chall_invite4', $c_ppl3, PDO::PARAM_STR);
    $insert->bindParam(':chall_invite5', $c_ppl4, PDO::PARAM_STR);
    $insert->bindParam(':chall_start_day', $c_startdate, PDO::PARAM_STR);
    $insert->bindParam(':chall_invite_expire', $c_expiredate, PDO::PARAM_STR);
    $insert->bindParam(':chall_due_date', $c_duedate, PDO::PARAM_STR);
    $insert->bindParam(':chall_reward_points', $c_payment, PDO::PARAM_STR);
    $insert->execute();

    if($insert == true){ 
        $lastinsertedrow = $conn->lastInsertId();
        return  array("true", $lastinsertedrow);
    }else{
        array("false", $lastinsertedrow); $conn->rollBack();
    }   
}

function checkparticipanteBeforeUpdateChallenge($conn, $s_id, $chall_id, $playerN, $purpose){
    $query1 ="";
    if ($purpose == "CheckPending"){
        switch ($playerN) {
            case "1":
                $query1= "SELECT * FROM `challenges` WHERE `chall_creator_fk` =:sid AND `chall_accept1`= 'P' AND `chall_id` =:c_id";
                break;
            case "2":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite2` =:sid AND `chall_accept2`= 'P' AND `chall_id` =:c_id";
                break;
            case "3":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite3` =:sid AND `chall_accept3`= 'P' AND `chall_id` =:c_id";
                break;
            case "4":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite4` =:sid AND `chall_accept4`= 'P' AND `chall_id` =:c_id";
                break;
            case "5":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite5` =:sid AND `chall_accept5`= 'P' AND `chall_id` =:c_id";
                break;
            default:
                return "Encounter error";
        }
    }else if ($purpose == "CheckAccepted"){
        switch ($playerN) {
            case "1":
                $query1= "SELECT * FROM `challenges` WHERE `chall_creator_fk` =:sid AND `chall_accept1`= 'A' AND `chall_id` =:c_id";
                break;
            case "2":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite2` =:sid AND `chall_accept2`= 'A' AND `chall_id` =:c_id";
                break;
            case "3":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite3` =:sid AND `chall_accept3`= 'A' AND `chall_id` =:c_id";
                break;
            case "4":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite4` =:sid AND `chall_accept4`= 'A' AND `chall_id` =:c_id";
                break;
            case "5":
                $query1= "SELECT * FROM `challenges` WHERE `chall_invite5` =:sid AND `chall_accept5`= 'A' AND `chall_id` =:c_id";
                break;
            default:
                return "Encounter error";
        }
    }else{  return "fifth parameter invalid";}

      $searchPlayer=$conn->prepare($query1);
      $searchPlayer->bindParam(':sid', $s_id, PDO::PARAM_STR);
      $searchPlayer->bindParam(':c_id', $chall_id, PDO::PARAM_STR);
      $searchPlayer->execute();
      //$total = $searchPlayer->rowCount(); 
      $searchPlayer1 = $searchPlayer->fetch(PDO::FETCH_ASSOC);
      return $searchPlayer1;  
}

function updateUserChallengeStatusToAccept($conn, $s_id, $playerN, $challenge_id){
    //echo "Player N &nbsp".$playerN;
    $player ="";
    switch ($playerN) {
        case "1":
            $player= "UPDATE `challenges` SET `chall_accept1`= 'A' WHERE `chall_creator_fk` =:sid AND `chall_id` =:c_id";
            break;
        case "2":
            $player= "UPDATE `challenges` SET `chall_accept2`= 'A' WHERE `chall_invite2` =:sid AND `chall_id` =:c_id";
            break;
        case "3":
            $player= "UPDATE `challenges` SET `chall_accept3`= 'A' WHERE `chall_invite3` =:sid AND `chall_id` =:c_id";
            break;
        case "4":
            $player= "UPDATE `challenges` SET `chall_accept4`= 'A' WHERE `chall_invite4` =:sid AND `chall_id` =:c_id";
            break;
        case "5":
            $player= "UPDATE `challenges` SET `chall_accept5`= 'A' WHERE `chall_invite5` =:sid AND `chall_id` =:c_id";
            break;
        default:
            return "Encounter error IN updateUserChallengeStatusToAccept() in challengehandler.php";
    }

    $updateP=$conn->prepare($player);
    $updateP->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $updateP->bindParam(':c_id', $challenge_id, PDO::PARAM_STR);
    $updateP->execute();

    if($updateP == true){ 
        return "true" ;
    }else{return "false";} 
}

function updateUserChallengeStatusToQuit($conn, $s_id, $playerN, $challenge_id){
    $player ="";
    switch ($playerN) {
        case "1":
            $player= "UPDATE `challenges` SET `chall_accept1`= 'Q' WHERE `chall_creator_fk` =:sid AND `chall_id` =:c_id";
            break;
        case "2":
            $player= "UPDATE `challenges` SET `chall_accept2`= 'Q' WHERE `chall_invite2` =:sid AND `chall_id` =:c_id";
            break;
        case "3":
            $player= "UPDATE `challenges` SET `chall_accept3`= 'Q' WHERE `chall_invite3` =:sid AND `chall_id` =:c_id";
            break;
        case "4":
            $player= "UPDATE `challenges` SET `chall_accept4`= 'Q' WHERE `chall_invite4` =:sid AND `chall_id` =:c_id";
            break;
        case "5":
            $player= "UPDATE `challenges` SET `chall_accept5`= 'Q' WHERE `chall_invite5` =:sid AND `chall_id` =:c_id";
            break;
        default:
            return "Encounter error IN updateUserChallengeStatusToQuit() in challengehandler.php";
    }

    $updateP=$conn->prepare($player);
    $updateP->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $updateP->bindParam(':c_id', $challenge_id, PDO::PARAM_STR);
    $updateP->execute();
    

    if($updateP == true){ 
        return "true" ;
    }else{return "false";} 
}
function updateUserChallengeStatusToExpire($conn, $s_id, $playerN, $challenge_id){
    //procedure lastly create after
}

function updateChallengeWinnerRewarded($conn, $ss_id, $chall_id){
    //check the user account in the challenge first
    if ($conn != "" && $ss_id !="" && $chall_id !="" ){
        $a = '1';
        $update_redeemStatus = "UPDATE `challenges` SET `reward_accepted`=:one WHERE `chall_id`=:challid AND `winner_fk`=:sessionid";
        $updateredeemStatus=$conn->prepare($update_redeemStatus);
        $updateredeemStatus->bindParam(':one', $a, PDO::PARAM_INT);
        $updateredeemStatus->bindParam(':challid', $chall_id , PDO::PARAM_INT);
        $updateredeemStatus->bindParam(':sessionid', $ss_id , PDO::PARAM_INT); 
        $updateredeemStatus->execute();
        $count = $updateredeemStatus->rowCount();
        //echo "<br>Connectionstring=";print_r($conn);
       // ECHO "<br>Yessssssssssssssssssss<br>challid = ".$chall_id."<br>S_ID=".$s_id ."<br>UpdateredeemedStatus=";
       // print_r($updateredeemStatus);
       // $count = $updateredeemStatus->rowCount();
        //echo "<br>count= ".$count;
        //echo "<br>binparam=".$update_redeemStatus;
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