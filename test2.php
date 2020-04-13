<?php
require_once("db.php");

    $query1= "SELECT goals_followed.goals_follower_fk, goals_followed.goal_followed_id,
              goals_followed.reminder_time, common_goals.goals_id, common_goals.goals_name 
              FROM goals_followed INNER JOIN common_goals ON common_goals.goals_id=goals_followed.goals_fk
              WHERE goals_followed.monday= '1' AND goals_followed.goals_follower_fk ='20'";
    $search=$conn->prepare($query1);
    $search->execute();
    //$total = $search->rowCount(); 
    $search1 = $search->fetchAll(PDO::FETCH_ASSOC);
    $count =$search->rowCount();
    print_r($search1);        

  echo $count ;
?>