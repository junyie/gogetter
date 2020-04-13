
  <?php 

function finduserid($conn, $usrid){
    $query =" SELECT `user_id`, `username` FROM `user` WHERE `user_id` =:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id",$usrid, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results['user_id'];
 }

function searchPendingPlayer($conn, $s_id, $playerN){
    switch ($playerN) {
      case "1st":
      $query1= "SELECT * FROM `challenges` WHERE `chall_creator_fk` =:sid AND `chall_accept1`= 'A' AND `chall_invite_expire` >= :date";
          break;
      case "2nd":
          $query1= "SELECT * FROM `challenges` WHERE `chall_invite2` =:sid AND `chall_accept2`= 'P' AND `chall_invite_expire` >= :date";
          break;
      case "3rd":
          $query1= "SELECT * FROM `challenges` WHERE `chall_invite3` =:sid AND `chall_accept3`= 'P' AND `chall_invite_expire` >= :date";
          break;
      case "4th":
          $query1= "SELECT * FROM `challenges` WHERE `chall_invite4` =:sid AND `chall_accept4`= 'P' AND `chall_invite_expire` >= :date";
          break;
      case "5th":
          $query1= "SELECT * FROM `challenges` WHERE `chall_invite5` =:sid AND `chall_accept5`= 'P' AND `chall_invite_expire` >= :date";
          break;
      default:
          return "Encounter error";
    }
    //$query1= "SELECT * FROM `challenges` WHERE `chall_invite2` =:sid AND `chall_accept2`= 'P' AND `chall_invite_expire` >= :date";
    $today = date("Y-m-d");
    $searchPlayer=$conn->prepare($query1);
    $searchPlayer->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $searchPlayer->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer->execute();
    //$total = $searchPlayer->rowCount(); 
    $searchPlayer1 = $searchPlayer->fetchAll(PDO::FETCH_ASSOC);
    return $searchPlayer1;
}

function searchtodayChallenge($conn, $s_id, $playerN){
    switch ($playerN) {
        case "1st":
        $query1= "SELECT * FROM `challenges` WHERE `chall_creator_fk` =:sid AND `chall_accept1`= 'A' AND `chall_due_date` >= :date";
            break;
        case "2nd":
            $query1= "SELECT * FROM `challenges` WHERE `chall_invite2` =:sid AND `chall_accept2`= 'A' AND `chall_due_date` >= :date";
            break;
        case "3rd":
            $query1= "SELECT * FROM `challenges` WHERE `chall_invite3` =:sid AND `chall_accept3`= 'A' AND `chall_due_date` >= :date";
            break;
        case "4th":
            $query1= "SELECT * FROM `challenges` WHERE `chall_invite4` =:sid AND `chall_accept4`= 'A' AND `chall_due_date` >= :date";
            break;
        case "5th":
            $query1= "SELECT * FROM `challenges` WHERE `chall_invite5` =:sid AND `chall_accept5`= 'A' AND `chall_due_date` >= :date";
            break;
        default:
            return "Encounter error";
    }

    //$query1= "SELECT * FROM `challenges` WHERE `chall_invite2` =:sid AND `chall_accept2`= 'P' AND `chall_invite_expire` >= :date";
    $today = date("Y-m-d");
    $searchPlayer=$conn->prepare($query1);
    $searchPlayer->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $searchPlayer->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer->execute();
    //$total = $searchPlayer->rowCount(); 
    $searchPlayer1 = $searchPlayer->fetchAll(PDO::FETCH_ASSOC);
    return $searchPlayer1;
}

function countTotalofNewchallange($conn, $s_id){
    $today = date("Y-m-d");
    $totalcount = '0';
    $count1 = $count2 = $count3 = $count4 = $count5 ='0';
    $searchPlayer1=$conn->prepare("SELECT * FROM `challenges` WHERE `chall_creator_fk`=:id AND `chall_accept1` = 'A' AND `chall_invite_expire` >= :date");
    $searchPlayer1->bindParam(':id', $s_id, PDO::PARAM_STR);
    $searchPlayer1->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer1->execute();
    $count1 = $searchPlayer1->rowCount();

    $searchPlayer2=$conn->prepare("SELECT * FROM `challenges` WHERE `chall_invite2`=:id AND `chall_accept2` = 'P' AND `chall_invite_expire` >= :date");
    $searchPlayer2->bindParam(':id', $s_id, PDO::PARAM_STR);
    $searchPlayer2->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer2->execute();
    $count2 = $searchPlayer2->rowCount();

    $searchPlayer3=$conn->prepare("SELECT * FROM `challenges` WHERE `chall_invite3`=:id AND `chall_accept3` = 'P' AND `chall_invite_expire` >= :date");
    $searchPlayer3->bindParam(':id', $s_id, PDO::PARAM_STR);
    $searchPlayer3->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer3->execute();
    $count3 = $searchPlayer3->rowCount();

    $searchPlayer4=$conn->prepare("SELECT * FROM `challenges` WHERE `chall_invite4`=:id AND `chall_accept4` = 'P' AND `chall_invite_expire` >= :date");
    $searchPlayer4->bindParam(':id', $s_id, PDO::PARAM_STR);
    $searchPlayer4->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer4->execute();
    $count4 = $searchPlayer4->rowCount();

    $searchPlayer5=$conn->prepare("SELECT * FROM `challenges` WHERE `chall_invite5`=:id AND `chall_accept5` = 'P' AND `chall_invite_expire` >= :date");
    $searchPlayer5->bindParam(':id', $s_id, PDO::PARAM_STR);
    $searchPlayer5->bindParam(':date', $today, PDO::PARAM_STR);
    $searchPlayer5->execute();
    $count5 = $searchPlayer5->rowCount();

    $totalcount = $count1 + $count2 + $count3 + $count4 + $count5;//
    return $totalcount;
  }

  function checkTodayHad_RatedNot($conn, $s_id, $challengeID){
        //echo "chall_id".$challengeID."<br>rater_id".$s_id;
        $checkingTodayRated = "SELECT * FROM `challenge_record` WHERE `fk_challenge_id`=:chall_id AND
        `fk_rater_id`=:rater_id ORDER BY `rating_id` DESC LIMIT 1";
        $search = $conn->prepare($checkingTodayRated);
        $search->bindParam(':chall_id', $challengeID, PDO::PARAM_STR);
        $search->bindParam(':rater_id', $s_id, PDO::PARAM_STR);
        $search->execute();
        $count1 = $search->rowCount();
		if($count1>0) {
			$searchResult = $search->fetch(PDO::FETCH_ASSOC);
			$fetchdatetime = $searchResult['recorded_time'];
			$fetchdate = substr($fetchdatetime,0,-9);
			$todaydate = date('Y-m-d');
			//echo "<br>Date time i get from DB".$fetchdatetime;
			//echo "<br>Fetchdate".$fetchdate."<br>Todays date".$todaydate;
			
			if($fetchdate == $todaydate && $count1 >0)
			{
				return "0";
			}else {
				return "1";
			}
		}
  }

  function returnAllChallengeScore($conn,$chall_id){
    $querySearchallScoreinChall = "
    SELECT SUM(`player1_score`) AS 'ppl1' ,SUM(`player2_score`) AS 'ppl2',SUM(`player3_score`) AS 'ppl3',
    SUM(`player4_score`) AS 'ppl4',SUM(`player5_score`) AS 'ppl5'
     FROM challenge_record WHERE `fk_challenge_id` = :cid";
     $search3_=$conn->prepare($querySearchallScoreinChall);
     $search3_->bindParam(':cid', $chall_id, PDO::PARAM_STR);
     $search3_->execute();
     $searchedResuult = $search3_->fetch(PDO::FETCH_ASSOC);
     $totalresult3 = $search3_->rowCount(); 
  
     if ($search3_ >'0'){
      return json_encode($searchedResuult);
     }else{
       return FALSE;
     }
  }

  function countChallengersTotal($retrievename1,$retrievename2,$retrievename3,$retrievename4,$retrievename5){
      $totalnum = "0";
      if ($retrievename1 !=""){
        $totalnum = $totalnum +1;
      }
      if ($retrievename2 !=""){
        $totalnum = $totalnum +1;
      }
      if ($retrievename3 !=""){
        $totalnum = $totalnum +1;
      }
      if ($retrievename4 !=""){
        $totalnum = $totalnum +1;
      }
      if ($retrievename5 !=""){
        $totalnum = $totalnum +1;
      }
      return $totalnum;
  }

  function checkHowmanyRatings($conn, $chall_id){
    $querySearchallRecords = "
    SELECT COUNT(*) AS 'countR' FROM challenge_record WHERE `fk_challenge_id` = :cid";
     $search4_=$conn->prepare($querySearchallRecords);
     $search4_->bindParam(':cid', $chall_id, PDO::PARAM_STR);
     $search4_->execute();
     $searchedResuult = $search4_->fetch(PDO::FETCH_ASSOC);
     $totalresult4 = $search4_->rowCount(); 
  
     if ($search4_ >'0'){
      return json_encode($searchedResuult);
     }else{
       return 0;
     }
  }

function listAllcurrentChallenges($conn, $s_id){
    $today = date("Y-m-d H:i:s");
    $query =
    "   SELECT * FROM `challenges` WHERE `chall_creator_fk` = :sid AND `chall_accept1` ='A'  AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite2`= :sid AND `chall_accept2` ='A'   AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite3`= :sid AND `chall_accept3` ='A'   AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite4`= :sid AND `chall_accept4` ='A'   AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite5`= :sid AND `chall_accept5` ='A'   AND `chall_due_date` >= CURDATE() 
    "; //OPTIONAL HERE ADD ORDER BY START OR END DATE

    $searchc_=$conn->prepare($query);
    $searchc_->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $searchc_->execute();
    $searchedResuult = $searchc_->fetchALL(PDO::FETCH_ASSOC);
    $totalresultc = $searchc_->rowCount(); 

    if ($searchc_ >'0'){
        return $searchedResuult;
    }else{
        return 0;
    }
}


function countAllcurrentChallenges($conn, $s_id){
    $today = date("Y-m-d H:i:s");
    $query =
    "   SELECT * FROM `challenges` WHERE `chall_creator_fk` = :sid AND `chall_accept1` ='A'  AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite2`= :sid AND `chall_accept2` ='A'   AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite3`= :sid AND `chall_accept3` ='A'   AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite4`= :sid AND `chall_accept4` ='A'   AND `chall_due_date` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite5`= :sid AND `chall_accept5` ='A'   AND `chall_due_date` >= CURDATE() 
    "; //OPTIONAL HERE ADD ORDER BY START OR END DATE

    $searchc_=$conn->prepare($query);
    $searchc_->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $searchc_->execute();
    $totalresultc = $searchc_->rowCount(); 

    if ($searchc_ >'0'){
        return $totalresultc;
    }else{
        return 0;
    }
}

function listAllpastChallenges($conn, $s_id){
    $today = date("Y-m-d H:i:s");
    $query =
    "   SELECT * FROM `challenges` WHERE `chall_creator_fk` = :sid AND `chall_accept1` ='A'  AND `chall_due_date` < CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite2`= :sid AND `chall_accept2` ='A'   AND `chall_due_date` < CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite3`= :sid AND `chall_accept3` ='A'   AND `chall_due_date` < CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite4`= :sid AND `chall_accept4` ='A'   AND `chall_due_date` < CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite5`= :sid AND `chall_accept5` ='A'   AND `chall_due_date` < CURDATE() 
    "; //OPTIONAL HERE ADD ORDER BY START OR END DATE

    $searchc_=$conn->prepare($query);
    $searchc_->bindParam(':sid', $s_id, PDO::PARAM_STR);
    $searchc_->execute();
    $searchedResuult = $searchc_->fetchALL(PDO::FETCH_ASSOC);
    $totalresultc = $searchc_->rowCount(); 

    if ($searchc_ >'0'){
        return $searchedResuult;
    }else{
        return 0;
    }
}


function appendChallangeList($challanges){
    foreach ($challanges as $row) {
    $chall_name = $row['chall_name'];
    $chall_start = $row['chall_start_day'];
    $chall_end = $row['chall_due_date'];
    $chall_inviter = $row['chall_creator_fk'];
    $chall_id = $row['chall_id'];
    
      echo '    
      <li ng-class="{checked: checkin, active: isActive}" class="dashboard-cell checked" ng-repeat="subscription in subscriptions" index="$index" selected-date="selectedDate">
  <div ng-click="handleCheckinButton()" class="checkin-button"><i class="svg-icon icon-checkin-white"></i></div>
  <a class="cell-inner" ng-href="challengeprofile.php?challengeprofile='.$chall_id.'" href="challengeprofile.php?challengeprofile='.$chall_id.'">
    <span class="title plan-name">
      <span class="goal-indicators">
      <i ng-show="subscription.private" class="svg-icon ng-hide icon-lock-white" ng-class="{\'icon-lock-white\': checkin, \'icon-lock-gray\': !checkin}"></i>
      </span>
      '.$chall_name.'
    </span>
    <span class="indicators" ng-switch="" on="!!currentWeekTarget">
      <span ng-switch-default="" class="counts">
        <i class="svg-icon icon-checkmark-circled-white" ng-class="{\'icon-checkmark-circled-white\': checkin, \'icon-checkmark-circled-gray\': !checkin}"></i>
        Started Date
        <span class="streak" ng-show="subscription.progress.streak > 1">
        <i class="svg-icon icon-flame-circled-white" ng-class="{\'icon-flame-circled-white\': checkin, \'icon-flame-circled-gray\': !checkin}"></i>
        '.$chall_start.' &nbsp&nbsp End Date: '.$chall_end.'
        </span>
      </span>
    </span>
    <span class="subtitle ng-hide" ng-show="plan.has_instructions">
      Inviter ID &nbsp'.$chall_inviter.'
      <span ng-include="\'instruction-indicators.tpl.html\'"><span class="instruction-indicators">
<i class="media-indicator ng-hide" ng-show="instruction.media_type ==\'youtube\'"></i>
<span ng-show="subscription.progress">⚔️</span>
</span></span>
    </span>
  </a>
</li>';
    }
  }

  /*"   Query for challenge list without checking start & end date
        SELECT * FROM `challenges` WHERE `chall_creator_fk` = :sid AND `chall_accept1` ='A' UNION
        SELECT * FROM `challenges` WHERE `chall_invite2`= :sid AND `chall_accept2` ='A' UNION
        SELECT * FROM `challenges` WHERE `chall_invite3`= :sid AND `chall_accept3` ='A' UNION
        SELECT * FROM `challenges` WHERE `chall_invite4`= :sid AND `chall_accept4` ='A' UNION
        SELECT * FROM `challenges` WHERE `chall_invite5`= :sid AND `chall_accept5` ='A' 
    "; */

    /*  Query for checking today
    "   SELECT * FROM `challenges` WHERE `chall_creator_fk` = :sid AND `chall_accept1` ='A' AND  `chall_start_day` <= CURDATE() AND `chall_invite_expire` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite2`= :sid AND `chall_accept2` ='A'  AND  `chall_start_day` <= CURDATE() AND `chall_invite_expire` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite3`= :sid AND `chall_accept3` ='A'  AND  `chall_start_day` <= CURDATE() AND `chall_invite_expire` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite4`= :sid AND `chall_accept4` ='A'  AND  `chall_start_day` <= CURDATE() AND `chall_invite_expire` >= CURDATE() UNION
        SELECT * FROM `challenges` WHERE `chall_invite5`= :sid AND `chall_accept5` ='A'  AND  `chall_start_day` <= CURDATE() AND `chall_invite_expire` >= CURDATE()
    ";
    */

/*TEST QUERY FOR the goal record to count targeted times
SELECT count(`following_goal_fk`) FROM `goal_record` WHERE `following_goal_fk` =121 AND 
`checked_date` >= '2020-03-01' AND `checked_date` <= '2020-03-25'*/

function getChallengeRewardList($conn, $s_id){
    $query =
    "   SELECT `chall_id`, `chall_name`, `chall_reward_points` FROM `challenges` WHERE `winner_fk` = :s_id  AND `chall_due_date` <= CURDATE() AND `reward_accepted` = '0'
    "; //OPTIONAL HERE ADD ORDER BY START OR END DATE

    $searchc_=$conn->prepare($query);
    $searchc_->bindParam(':s_id', $s_id, PDO::PARAM_STR);
    $searchc_->execute();
    $searchedResuult = $searchc_->fetchALL(PDO::FETCH_ASSOC);
    $totalresultc = $searchc_->rowCount(); 

    if ($totalresultc ==TRUE){
        return $searchedResuult;
    }else{
        return 0;
    }

}
function appendListofchallReward($challangesReward){
    foreach ($challangesReward as $row) {
        $chall_id = $row['chall_id'];
        $chall_name = $row['chall_name'];
        $chall_points = $row['chall_reward_points'];
        echo '
        <!--card start-->
        <h3 class="title"><a style="color:#FFFFFF;font: larger Arno Pro, Tribun ADF Std, serif; font-style: oblique" href=challengeprofile.php?challengeprofile='.$chall_id.'>'.$chall_name.'</a><br><br>&nbsp&nbsp&nbsp'.$chall_points.' Points</h3>
        <div class="bar">
          <div class="emptybar"></div>
          <div class="filledbar"></div>
        </div>
        <div class="circle">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
          <circle class="stroke" cx="60" cy="60" r="50"/>
        </svg> <a href="challengehandler.php?redeem='.$chall_id.'"><h3 style="color:#FFFFFF;font: larger Arno Pro, Tribun ADF Std, serif; font-style: oblique" class="title">&nbsp&nbsp&nbsp Claim</h3></a><br>
        </div>
      </div><!--card end-->';

        //echo "Chall_id".$chall_id."&nbsp &nbsp Chall name".$chall_name;
    }
}

//Begin of display result of past challenge
function showAllPastChallange($challanges){
  foreach ($challanges as $row) {
  $chall_name = $row['chall_name'];
  $chall_start = $row['chall_start_day'];
  $chall_end = $row['chall_due_date'];
  $chall_inviter = $row['chall_creator_fk'];
  $chall_id = $row['chall_id'];
  
    echo '    
    <li ng-class="{checked: checkin, active: isActive}" class="dashboard-cell checked" ng-repeat="subscription in subscriptions" index="$index" selected-date="selectedDate">
<div ng-click="handleCheckinButton()" class="checkin-button"><i class="svg-icon icon-checkin-white"></i></div>
<a class="cell-inner" ng-href="challengeprofile.php?challengeprofile='.$chall_id.'" href="challengeprofile.php?challengeprofile='.$chall_id.'">
  <span class="title plan-name">
    <span class="goal-indicators">
    <i ng-show="subscription.private" class="svg-icon ng-hide icon-lock-white" ng-class="{\'icon-lock-white\': checkin, \'icon-lock-gray\': !checkin}"></i>
    </span>
    '.$chall_name.'
  </span>
  <span class="indicators" ng-switch="" on="!!currentWeekTarget">
    <span ng-switch-default="" class="counts">
      <i class="svg-icon icon-checkmark-circled-white" ng-class="{\'icon-checkmark-circled-white\': checkin, \'icon-checkmark-circled-gray\': !checkin}"></i>
      Started Date
      <span class="streak" ng-show="subscription.progress.streak > 1">
      <i class="svg-icon icon-flame-circled-white" ng-class="{\'icon-flame-circled-white\': checkin, \'icon-flame-circled-gray\': !checkin}"></i>
      '.$chall_start.' &nbsp&nbsp End Date: '.$chall_end.'
      </span>
    </span>
  </span>
  <span class="subtitle ng-hide" ng-show="plan.has_instructions">
    Inviter ID &nbsp'.$chall_inviter.'
    <span ng-include="\'instruction-indicators.tpl.html\'"><span class="instruction-indicators">
<i class="media-indicator ng-hide" ng-show="instruction.media_type ==\'youtube\'"></i>
<span ng-show="subscription.progress">⚔️</span>
</span></span>
  </span>
</a>
</li>';
  }
}


?>

