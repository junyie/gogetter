<?php
//test for stash
if ( isset($_GET['goal']) )
{ 
       $results1 = searchcommongoal($conn, $_GET['goal']);
       $res = $results1['goals_id'];$res2 = $results1['goals_name'];
       $res3 = $results1['category'];$res4 = $results1['goals_desc'];
       $res5 = $results1['goals_picture'];
      
       if ($res5 =="" || !file_exists( $target_path."/".$res5 )){
         $res5 = $target_path."default.png";                                   //for showing basic profile of tutor
       }

       //check wheter user have add it to list
        $search1 = searchFollowedgoal($conn, $res, $_SESSION["identity"]);
        //echo $total."&nbsp&nbsp >>SessionIdentity>>>".$_SESSION['identity'];
		//echo $search1;
		if($search1 > 0) {
		
        $goalde_id=    $search1['goal_followed_id'];
        $sun=    $search1['sunday'];    $mon= $search1['monday'];    $tue=  $search1['tuesday'];
        $wed=    $search1['wednesday']; $thus= $search1['thusday'];  $fri=  $search1['friday'];
        $sat=    $search1['saturday'];  $set_time = $search1['reminder_time'];

        $sun1=$mon1=$tue1=$wed1=$thus1=$fri1=$sat1=""; 
        //echo 'sun'.$sun.'mon'.$mon.'frid'.$fri;
        $sun1 = ($sun == 0 ? '' : 'style="background-color:#fec608;"');     $mon1 = ($mon == 0 ? '' : 'style="background-color:#fec608;"');
        $tue1 = ($tue == 0 ? '' : 'style="background-color:#fec608;"');     $wed1 = ($wed == 0 ? '' : 'style="background-color:#fec608;"');
        $thus1 = ($thus == 0 ? '' : 'style="background-color:#fec608;"');   $fri1 = ($fri == 0 ? '' : 'style="background-color:#fec608;"');
        $sat1 = ($sat == 0 ? '' : 'style="background-color:#fec608;"');
		}
        //echo "<br>Sun >".$sun1."Mon  >".$mon1."Fri >".$fri1;
        if ($search1 >0){
            $restoday = date('Y-m-d');
            $recresult = checktoday($conn,$restoday,$goalde_id);
            $checkcurrentTarget = searchTargetgoal($conn, $goalde_id); //`start_date``end_date``expected_times``targeted_times`
			if($checkcurrentTarget>0){
				$targetstart = $checkcurrentTarget['start_date'];
				$targetend = $checkcurrentTarget['end_date'];
				$targetexptime = $checkcurrentTarget['expected_times'];
				$target_done = $checkcurrentTarget['targeted_times'];
			}
        }
        
   if ($results1 ==0){
     print_r( $results1 );
    header("error.php");  
   }
  }
  function searchcommongoal($conn,  $getgoal){
    $stmt_ = $conn->prepare("SELECT * FROM `common_goals` WHERE `goals_id`=:id");
    $stmt_->bindParam(':id',  $getgoal, PDO::PARAM_STR);
    $stmt_->execute();
    $results1 = $stmt_->fetch(PDO::FETCH_ASSOC);
    return $results1 ;
  }
  function searchFollowedgoal($conn, $res, $sid){
    $query1 = "SELECT * FROM `goals_followed` WHERE `goals_fk` = :g_fk AND `goals_follower_fk` = :gf_fk"; 

    $search=$conn->prepare($query1);
    $search->bindParam(':g_fk', $res, PDO::PARAM_STR);
    $search->bindParam(':gf_fk', $sid , PDO::PARAM_STR);
    $search->execute();
    $count = $search->rowCount(); 
    //$total = $search->rowCount();
    if ($count >0){
      $search1 = $search->fetch(PDO::FETCH_ASSOC);
      return $search1;
    }else {$count = 0; return $count;}
  }
  function checktoday($conn,$restoday,$goalde_id){
    $searchforToday = "SELECT * FROM `goal_record` WHERE `checked_date` = :date AND `following_goal_fk` = :fg_fk";
    $searchforRec=$conn->prepare($searchforToday);
    $searchforRec->bindParam(':date', $restoday, PDO::PARAM_STR);
    $searchforRec->bindParam(':fg_fk', $goalde_id , PDO::PARAM_STR);
    $searchforRec->execute();
    $recresult = $searchforRec->rowCount();
    return $recresult;
  }
  function searchTargetgoal($conn, $goalde_id){
    $query1= "SELECT * from `goal_target` WHERE `following_goal_fk`=:followed_goalID ORDER BY `end_date` DESC LIMIT 1";
    $search=$conn->prepare($query1);
    $search->bindParam(':followed_goalID', $goalde_id, PDO::PARAM_STR);
    $search->execute();
    //$total = $search->rowCount(); 
    $search1 = $search->fetch(PDO::FETCH_ASSOC);
    return $search1;
  }
  function listAllTodayGoal($conn, $sessionid){
    $todayy = checktodayInUserdash();

    $query1= "SELECT goals_followed.goals_follower_fk, goals_followed.goal_followed_id,
              goals_followed.reminder_time, common_goals.goals_id, common_goals.goals_name 
              FROM goals_followed INNER JOIN common_goals ON common_goals.goals_id=goals_followed.goals_fk
              WHERE goals_followed.".$todayy."= '1' AND goals_followed.goals_follower_fk =:sid";
    $search=$conn->prepare($query1);
    $search->bindParam(':sid', $sessionid, PDO::PARAM_STR);
    $search->execute();
    //$total = $search->rowCount(); 
    $search1 = $search->fetchAll(PDO::FETCH_ASSOC);
    return $search1;        
  }

  function checktodayInUserdash(){
    $todayis = date("D");
    switch ($todayis) {
      case "Sun":
          $todayis ='sunday';
          break;
      case "Mon":
          $todayis  ='monday';
          break;
      case "Tue":
          $todayis ='tuesday';
          break;
      case "Wed":
          $todayis ='wednesday';
          break;
      case "Thu":
          $todayis ='thusday';
          break;
      case "Fri":
          $todayis ='friday';
          break;
      case "Sat":
          $todayis ='saturday';
          break;
      default:
          $todayis ='';
    }
    return $todayis;
  }

//here calling updateTargetedTimes($conn, $targetID, $followingID);
  function findTargetAndUpdateTargetedTimes($conn, $followinggoalId){
    $searchForTheLastTargetID = "SELECT * FROM `goal_target` WHERE `following_goal_fk`= :gf_id ORDER BY `goal_target_id` DESC LIMIT 1";
    $searchTT_id=$conn->prepare($searchForTheLastTargetID);
    $searchTT_id->bindParam(':gf_id', $followinggoalId, PDO::PARAM_STR);
    $searchTT_id->execute();
    $searched_tt_idResuult = $searchTT_id->fetch(PDO::FETCH_ASSOC);
    $totalresultTT_id = $searchTT_id->rowCount(); 
	
    //echo "TargetId".$targetID;
    if ($totalresultTT_id >0){
	  $targetID = $searched_tt_idResuult['goal_target_id'];
      $todaydate = date("Y-m-d"); 
      if (($searched_tt_idResuult['end_date'] >= $todaydate) && ($searched_tt_idResuult['start_date'] <= $todaydate)){
        updateTargetedTimes($conn, $targetID, $followinggoalId);
      }
    }
  }

    //update the Targeted Times to goal target table
  function updateTargetedTimes($conn, $targetID, $followingID){
    $searchTargetedTimes = "SELECT `goal_target_id`,`targeted_times`,`start_date`,`end_date` 
                            FROM `goal_target` WHERE `goal_target_id` =:gt_id";
    $searchTT_=$conn->prepare($searchTargetedTimes);
    $searchTT_->bindParam(':gt_id', $targetID, PDO::PARAM_STR);
    $searchTT_->execute();
    $searched_ttResuult = $searchTT_->fetch(PDO::FETCH_ASSOC);
    $totalresultTT = $searchTT_->rowCount(); 

    $startDate  = $searched_ttResuult['start_date'];
    $endDate = $searched_ttResuult['end_date'];
 
    if ($searchTT_ > '0'){
        $countGoalRecordedTimesWithTargetPeriod =
        "SELECT *  FROM `goal_record` WHERE `following_goal_fk` =:followingID AND 
        `checked_date` >= :startdate AND `checked_date` <= :enddate";
        $countTT_=$conn->prepare($countGoalRecordedTimesWithTargetPeriod);
        $countTT_->bindParam(':followingID', $followingID, PDO::PARAM_STR);
        $countTT_->bindParam(':startdate', $startDate, PDO::PARAM_STR);
        $countTT_->bindParam(':enddate', $endDate, PDO::PARAM_STR);
        $countTT_->execute();
        $count_ttResuult = $countTT_->fetchALL(PDO::FETCH_ASSOC);
        $countTT = $countTT_->rowCount(); 
    }else{$countTT_ = '0'; }
    
    $numberOfdidFromTargettable = $searched_ttResuult['targeted_times'];
    $goal_targetid = $searched_ttResuult['goal_target_id'];

    if ($numberOfdidFromTargettable != $countTT ){
        $updateTheTargetedNumber_In_goalTarget =
        "UPDATE `goal_target` SET `targeted_times`=:newValue WHERE `goal_target_id` =:gt_id";
        $updateTT_=$conn->prepare($updateTheTargetedNumber_In_goalTarget);
        $updateTT_->bindParam(':newValue', $countTT, PDO::PARAM_STR);
        $updateTT_->bindParam(':gt_id', $goal_targetid, PDO::PARAM_STR);
        $updateTT_->execute();
    }
  }
//Undone
  function getGoalRewardList($conn, $s_id){
    $query2 = "
    SELECT tgt.goal_target_id, tgt.targeted_times, tcg.goals_name FROM goal_target tgt join goals_followed tgf
     ON tgt.following_goal_fk = tgf.goal_followed_id join common_goals tcg ON tgf.goals_fk = tcg.goals_id
      WHERE tgf.goals_follower_fk = :sessionid AND tgt.goal_rewarded = '0' AND tgt.end_date < CURDATE()
    ";
    $search=$conn->prepare($query2);
    $search->bindParam(':sessionid', $s_id, PDO::PARAM_STR);
    $search->execute();
    $search1 = $search->fetchALL(PDO::FETCH_ASSOC);
    $count = $search->rowCount(); 
    //$total = $search->rowCount();
    //print_r($count);
    if ($count >0){ return $search1; }else { return 0; }

}
function appendListofgoalReward($challangesReward){
    foreach ($challangesReward as $row) {
      $goaltarget_id = $row['goal_target_id'];
      $goal_name = $row['goals_name'];
      $goal_points = $row['targeted_times'];
      echo '
      <!--card start-->
      <h3 class="title"><a style="color:#FFFFFF;font: larger Arno Pro, Tribun ADF Std, serif; font-style: oblique" href=goalprofile.php?goal='.$goaltarget_id.'>'.$goal_name.'</a><br><br>&nbsp&nbsp&nbsp'.$goal_points.' Points</h3>
      <div class="bar">
        <div class="emptybar"></div>
        <div class="filledbar"></div>
      </div>
      <div class="circle">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
        <circle class="stroke" cx="60" cy="60" r="50"/>
      </svg> <a href="goalshandler.php?redeem='.$goaltarget_id.'"><h3 style="color:#FFFFFF;font: larger Arno Pro, Tribun ADF Std, serif; font-style: oblique" class="title">&nbsp&nbsp&nbsp Claim</h3></a><br>
      </div>
    </div><!--card end-->';
  
      //echo "goaltarget_id".$goaltarget_id."&nbsp &nbsp Chall name".$goal_name;
    }
}

function retrieveallGoalRecords($conn, $goalfollowing){
  $query = "SELECT `goal_record_id`,`following_goal_fk`,`checked_date`,`goal_desc` FROM `goal_record` WHERE `following_goal_fk`= :following";
  $search=$conn->prepare($query);
  $search->bindParam(':following', $goalfollowing, PDO::PARAM_STR);
  $search->execute();
  $search1 = $search->fetchALL(PDO::FETCH_ASSOC);
  $count = $search->rowCount(); 
  //$total = $search->rowCount();
  //print_r($count);
  if ($count >0){ return $search1; }else { return 0; }
}

?>