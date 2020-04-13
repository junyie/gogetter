<link rel="stylesheet" type="text/css" href="css/listcss.css">
    <!--https://s3.amazonaws.com/com.lift.rails.assets/assets/application-35400003393e5a998b7c2f4de98f746c.css-->

    <ul class="dashboard-list"><!--Start-->
<?php
$player1 ="";

require_once("sessionchecker.php");
require_once("challengecontroller.php");

$player1 = searchPendingPlayer($conn, $s_id, "1st");
//echo "player1".$player1;
showMyCreatedChallange($player1);

//print_r($todaysgoal); 
//Array ( [goals_follower_fk] => 20 [goal_followed_id] => 120 [reminder_time] => 12:29:00 [goals_id] => 3 [goals_name] => rope jumping )
 function showMyCreatedChallange($challangeplayerN){
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
  

?>
<!--End-->
    </ul>