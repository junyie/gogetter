<link rel="stylesheet" type="text/css" href="css/listcss.css">
    <!--https://s3.amazonaws.com/com.lift.rails.assets/assets/application-35400003393e5a998b7c2f4de98f746c.css-->

    <ul class="dashboard-list"><!--Start-->
<?php
$player1 ="";$player2 ="";$player3 ="";$player4 ="";$player5 ="";

require_once("sessionchecker.php");
require_once("challengecontroller.php");

$player1 = searchPendingPlayer($conn, $s_id, "1st");
$player2 = searchPendingPlayer($conn, $s_id, "2nd");
$player3 = searchPendingPlayer($conn, $s_id, "3rd");
$player4 = searchPendingPlayer($conn, $s_id, "4th");
$player5 = searchPendingPlayer($conn, $s_id, "5th");

showNowNewChallenge($player2,$player3,$player4,$player5);
//echo "<br>player2<br>";print_r($player2); 
//echo "<br>player3<br>";print_r($player3); 
//echo "<br>player4<br>";print_r($player4); 
//echo "<br>player5<br>";print_r($player5); 
//print_r($todaysgoal); 
//Array ( [goals_follower_fk] => 20 [goal_followed_id] => 120 [reminder_time] => 12:29:00 [goals_id] => 3 [goals_name] => rope jumping )
 function showAllnewChallange($challangeplayerN){
    foreach ($challangeplayerN as $row) {
      $chall_name = $row['chall_name'];
      $chall_exp = $row['chall_invite_expire'];
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
        Participate Due
        <span class="streak" ng-show="subscription.progress.streak > 1">
        <i class="svg-icon icon-flame-circled-white" ng-class="{\'icon-flame-circled-white\': checkin, \'icon-flame-circled-gray\': !checkin}"></i>
        '.$chall_exp.'
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

  function showNowNewChallenge($player2,$player3,$player4,$player5){
    if ($player2 !=""){showAllnewChallange($player2);}
    if ($player3 !=""){showAllnewChallange($player3);}
    if ($player4 !=""){showAllnewChallange($player4);}
    if ($player5 !=""){showAllnewChallange($player5);}
  }

//under construction showing beside the today goallist in userdash main page, could be move to anothor file
  function showTODAYChallanges($challangeplayerN){
    foreach ($challangeplayerN as $row) {
      $chall_name = $row['chall_name'];
      $chall_end = $row['chall_due_date'];
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
        Challange End Date
        <span class="streak" ng-show="subscription.progress.streak > 1">
        <i class="svg-icon icon-flame-circled-white" ng-class="{\'icon-flame-circled-white\': checkin, \'icon-flame-circled-gray\': !checkin}"></i>
        '.$chall_end.'
        </span>
      </span>
    </span>
    <span class="subtitle ng-hide" ng-show="plan.has_instructions">
      '.$chall_name.'
      <span ng-include="\'instruction-indicators.tpl.html\'"><span class="instruction-indicators">
<i class="media-indicator ng-hide" ng-show="instruction.media_type ==\'youtube\'"></i>
<span ng-show="subscription.progress">⚔️</span>
</span></span>
    </span>
  </a>
</li>';
    }
  }
//under construction showing beside the today goallist in userdash main page, could be move to anothor file
    function listNowAlltodayChallenge($player1,$player2,$player3,$player4,$player5){
      if ($player1 !=""){showTODAYChallanges($player1);}
      if ($player2 !=""){showTODAYChallanges($player2);}
      if ($player3 !=""){showTODAYChallanges($player3);}
      if ($player4 !=""){showTODAYChallanges($player4);}
      if ($player5 !=""){showTODAYChallanges($player5);}
    }
  

?>
<!--End-->
    </ul>