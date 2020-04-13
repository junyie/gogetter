<?php 
 require_once("userdashheader.html");
 
 require_once('db.php');
 require_once("challengecontroller.php");
 require_once("relationshipcontroller.php");
 $counttodayNewC = "";
 $resName = $_SESSION["username1"];
 if ($mytotalfriend >0){
	$showmytotalfriend = $mytotalfriend;
	$counttodayNewC = countTotalofNewchallange($conn, $s_id);
 }else {$showmytotalfriend ="";}

$countrewardsgoal = countRewardsgoal($conn, $s_id);
$countrewardschal = countRewardChallenge($conn, $s_id);
$countRequestforaccept = findCountFriendRequest($conn, $s_id);
$countAllCurrentChallenge = countAllcurrentChallenges($conn, $s_id);
$countRequestforaccept_ = ''; $countAllCurrentChallenge_ ='';
if ( $countRequestforaccept != false){
	$countRequestforaccept_ = '<p class="announcement-heading  label label-danger">'.$countRequestforaccept.'+</p>';
}else{$countRequestforaccept_ = '';}

$countsRewardtotal = $countrewardsgoal + $countrewardschal;
if ($countsRewardtotal > '0'){
	$countsRewardtotal_ ='<p class="announcement-heading  label label-success">'.$countsRewardtotal.'</p>';
}else{
	$countsRewardtotal_ ='';
}

if ($countAllCurrentChallenge > '0'){
	$countAllCurrentChallenge_ ='<p class="announcement-heading  label label-success">'.$countAllCurrentChallenge.'</p>';
}else{
	$countAllCurrentChallenge_ ='';
}
// .$mypoints.
echo '
<div class="container" style="background-color: #f2f2f2; padding-top: 20px;">
<div class="row">
    <div class="col-sm-3">
    
        <ul class="nav nav-pills nav-stacked nav-email shadow mb-20">
			<li class="active">
				<a href="userdashboard.php">
				'.$resName.'<div id="div_refresh">'.$mypoints.'</div>  Points <i class="fas fa-coins"></i><!--span class="label pull-right">7</span-->
				</a>
			</li>
			<li>
				<a href="searching.php"><i class="fa fa-search"></i>Friend Searcher</a>
			</li>
			<li>
				<a href="goallist.php"> <i class="fa fa-plus-square"></i>Goals List</a>
			</li>
			<li>
				<a href="createchallenge.php"> <i class="fa fa-calendar-o"></i> Create New Challenge</a>
			</li>
			<li>
				<a href="challengeshow.php"> <i class="fas fa-list-ul"></i>Challenges List '.$countAllCurrentChallenge_.'</a>
			</li>
			<li>
				<a href="logout.php"> <i class="fa fa-sign-out"></i> Exit</a></li>
			<li>
           
        </ul><!-- /.nav -->
    </div>
    <div class="col-sm-9">

        <!--  Another part for Nav -->
        <div class="row">
            <div class="col-lg-3">
            	<div class="panel panel-info">
        			<div class="panel-heading">
        				<div class="row">
        					<div class="col-xs-6">
        						<i class="fa fa-envelope-o fa-5x"></i>
        					</div>
        					<div class="col-xs-6 text-right">
                            <p class="announcement-heading label label-success">'.$counttodayNewC.'</p>
        					<!--	<p class="announcement-text">Users</p> -->
        					</div>
        				</div>
        			</div>
        			<a href="challengenotify.php" title="show my chats">
        				<div class="panel-footer announcement-bottom">
        					<div class="row">
        						<div class="col-xs-6">
        							Notifications
        						</div>
        						<div class="col-xs-6 text-right">
        							<i class="fa fa-arrow-circle-right"></i>
        						</div>
        					</div>
        				</div>
        			</a>
        		</div>
			</div>
			
        	<div class="col-lg-3">
        		<div class="panel panel-warning">
        			<div class="panel-heading">
        				<div class="row">
        					<div class="col-xs-6">
        						<i class="fas fa-trophy fa-5x"></i>
        					</div>
        					<div class="col-xs-6 text-right">
                            '.$countsRewardtotal_.'
        						<!-- <p class="announcement-text"> Items</p> -->
        					</div>
        				</div>
        			</div>
        			<a href="rewardnotify.php">
        				<div class="panel-footer announcement-bottom">
        					<div class="row">
        						<div class="col-xs-6">
        							Rewards
        						</div>
        						<div class="col-xs-6 text-right">
        							<i class="fa fa-arrow-circle-right"></i>
        						</div>
        					</div>
        				</div>
        			</a>
        		</div>
			</div>

			<div class="col-lg-3">
        		<div class="panel panel-success">
        			<div class="panel-heading">
        				<div class="row">
        					<div class="col-xs-6">
        						<i class="fas fa-user-friends fa-5x"></i>
        					</div>
        					<div class="col-xs-6 text-right">
							
							'.$countRequestforaccept_.'
        						<!-- <p class="announcement-text"> Items</p> -->
        					</div>
        				</div>
        			</div>
        			
        			
        			<a href="userdashfriend.php">
        				<div class="panel-footer announcement-bottom">
        					<div class="row">
        						<div class="col-xs-6">
        							'.$showmytotalfriend.' Friends 
        						</div>
        						<div class="col-xs-6 text-right">
        							<i class="fa fa-arrow-circle-right"></i>
        						</div>
        					</div>
        				</div>
        			</a>
        		</div>
        	</div>
			
        </div><!-- /.row -->  ';

 function countRewardsgoal($conn, $s_id){
	$query = "SELECT * FROM `challenges` WHERE `winner_fk` = :s_id AND `chall_due_date` <= CURDATE() AND `reward_accepted` = '0'";
	$searchc_=$conn->prepare($query);
    $searchc_->bindParam(':s_id', $s_id, PDO::PARAM_STR);
    $searchc_->execute();
    $searchedResuult = $searchc_->fetchALL(PDO::FETCH_ASSOC);
    $totalresultc = $searchc_->rowCount(); 

    if ($totalresultc ==TRUE){
        return $totalresultc;
    }else{
        return 0;
    }
 }

 function countRewardChallenge($conn, $s_id){
	$query = "
	SELECT * FROM goal_target tgt join goals_followed tgf
	ON tgt.following_goal_fk = tgf.goal_followed_id join common_goals tcg ON tgf.goals_fk = tcg.goals_id
	WHERE tgf.goals_follower_fk = :s_id AND tgt.goal_rewarded = '0' AND tgt.end_date < CURDATE()";
	$searchc_=$conn->prepare($query);
    $searchc_->bindParam(':s_id', $s_id, PDO::PARAM_STR);
    $searchc_->execute();
    $searchedResuult = $searchc_->fetchALL(PDO::FETCH_ASSOC);
    $totalresultc = $searchc_->rowCount(); 

    if ($totalresultc ==TRUE){
        return $totalresultc;
    }else{
        return 0;
    }
 }


 ?>
 <script>

function fetchdata(){
$.ajax({
url: 'sessionchecker.php?get=time',
type: 'get',
success: function(response){
// Perform operation on the return value
$("#div_refresh").load('sessionchecker.php?get=time');
}
});
}

$(document).ready(function(){
setInterval(fetchdata,1234);
});

</script>