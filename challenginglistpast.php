<link rel="stylesheet" type="text/css" href="css/listcss.css">
    <!--https://s3.amazonaws.com/com.lift.rails.assets/assets/application-35400003393e5a998b7c2f4de98f746c.css-->

    <ul class="dashboard-list"><!--Start-->
<?php 
require_once("sessionchecker.php");
require_once("challengecontroller.php");

$searchAllpastChallenges = listAllpastChallenges($conn, $s_id);

if ($searchAllpastChallenges != 0){
    appendChallangeList($searchAllpastChallenges);
}else{ echo "<h4>no past challenges here</h4>"; }

?>

<!--End-->
</ul>