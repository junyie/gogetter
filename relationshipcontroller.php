<?php
require_once("sessionchecker.php");
//$ Search invited Friend
$querySearchinvitedFriend = "SELECT DISTINCT  a.addperson_fk, b.username , b.uprof_pic FROM
relationship a, user b WHERE a.inviter_fk =:sid AND 
a.addperson_fk = b.user_id AND a.inviter_status = 'A' AND a.acceptbyperson = 'A' 
  GROUP BY a.addperson_fk    ";

$search_=$conn->prepare($querySearchinvitedFriend);
$search_->bindParam(':sid', $s_id, PDO::PARAM_STR);
$search_->execute();
$totalresult = $search_->rowCount(); 
$result = $search_->fetchAll(PDO::FETCH_ASSOC);


//Search accepted Friend
$querySearchacceptedFriend = "SELECT DISTINCT  a.inviter_fk, b.username , b.uprof_pic FROM
relationship a, user b WHERE a.inviter_fk =b.user_id AND 
a.addperson_fk = :sid AND a.inviter_status = 'A' AND a.acceptbyperson = 'A' 
  GROUP BY a.inviter_fk";

$search2_=$conn->prepare($querySearchacceptedFriend);
$search2_->bindParam(':sid', $s_id, PDO::PARAM_STR);
$search2_->execute();
$totalresult2 = $search2_->rowCount(); 
$result2 = $search2_->fetchAll(PDO::FETCH_ASSOC);

$mytotalfriend = $totalresult + $totalresult2;

function showListOfFriends($result,$result2){
  foreach ($result as $row) {
    $usr_id = $row['addperson_fk'];
    $usr_name = $row['username'];
    echo "<option value='".$usr_id."'>".$usr_name."</option>";}
  foreach ($result2 as $row) {
        $usr_id = $row['inviter_fk'];
        $usr_name = $row['username'];
        echo "<option value='".$usr_id."'>".$usr_name."</option>";}
}

function checkRelationshipEach($conn,$usrN, $s_id){
  $querySearchinvitedFriend = "SELECT DISTINCT  a.addperson_fk, b.username , b.uprof_pic FROM
  relationship a, user b WHERE a.inviter_fk =:sid AND 
  a.addperson_fk = :usrN AND a.inviter_status = 'A' AND a.acceptbyperson = 'A' 
  GROUP BY a.addperson_fk    ";

  $search_=$conn->prepare($querySearchinvitedFriend);
  $search_->bindParam(':sid', $s_id, PDO::PARAM_STR);
  $search_->bindParam(':usrN', $usrN, PDO::PARAM_STR);
  $search_->execute();
  $totalresult = $search_->rowCount(); 

  $querySearchacceptedFriend = "SELECT DISTINCT  a.inviter_fk, b.username , b.uprof_pic FROM
  relationship a, user b WHERE a.inviter_fk =:usrN AND 
  a.addperson_fk = :sid AND a.inviter_status = 'A' AND a.acceptbyperson = 'A' 
    GROUP BY a.inviter_fk";

  $search2_=$conn->prepare($querySearchacceptedFriend);
  $search2_->bindParam(':usrN', $usrN, PDO::PARAM_STR);
  $search2_->bindParam(':sid', $s_id, PDO::PARAM_STR);
  $search2_->execute();
  $totalresult2 = $search2_->rowCount(); 

  $foundvalid = $totalresult + $totalresult2;
  if ($foundvalid >'0'){
    return true;
  }else{return false;}
}

function findNewFriendRequest($conn, $s_id){
  $querySearchFriendwhoSentmeRequest = "SELECT DISTINCT  a.inviter_fk, b.username , b.uprof_pic FROM
  relationship a, user b WHERE a.inviter_fk =b.user_id AND 
  a.addperson_fk = :sid AND a.inviter_status = 'A' AND a.acceptbyperson = 'P' 
  GROUP BY a.inviter_fk";

  $search3_=$conn->prepare($querySearchFriendwhoSentmeRequest);
  $search3_->bindParam(':sid', $s_id, PDO::PARAM_STR);
  $search3_->execute(); 
  $totalresult3 = $search3_->rowCount(); 
  $result3 = $search3_->fetchAll(PDO::FETCH_ASSOC);

  if ($totalresult3 >'0'){
    return $result3;
  }else{return false;}
}

//search for  opposite site which in  pending for the friends request
function findNewFriendRpending($conn, $s_id){
  $querySearchFriendwhoPendingt = "SELECT DISTINCT  a.addperson_fk, b.username , b.uprof_pic FROM
  relationship a, user b WHERE a.inviter_fk =:sid AND 
  a.addperson_fk = b.user_id AND a.inviter_status = 'A' AND a.acceptbyperson = 'P' 
    GROUP BY a.addperson_fk    ";

  $search4_=$conn->prepare($querySearchFriendwhoPendingt);
  $search4_->bindParam(':sid', $s_id, PDO::PARAM_STR);
  $search4_->execute(); 
  $totalresult4 = $search4_->rowCount(); 
  $result4 = $search4_->fetchAll(PDO::FETCH_ASSOC);

  if ($totalresult4 >'0'){
    return $result4;
  }else{return false;}
}


function findCountFriendRequest($conn, $s_id){
  $querySearchacceptedFriend = "SELECT DISTINCT  a.inviter_fk, b.username , b.uprof_pic FROM
  relationship a, user b WHERE a.inviter_fk =b.user_id AND 
  a.addperson_fk = :sid AND a.inviter_status = 'A' AND a.acceptbyperson = 'P' 
    GROUP BY a.inviter_fk";

  $search5_=$conn->prepare($querySearchacceptedFriend);
  $search5_->bindParam(':sid', $s_id, PDO::PARAM_STR);
  $search5_->execute();
  $totalresult5 = $search5_->rowCount(); 
  if ($totalresult5 > '0'){
    return $totalresult5;
  }else{ return false;}
}

//show friends for pending or accepted in status
function showallMyFriends($result,$result2){
  if ($result !='0' && $result >'0'){
    foreach ($result as $row) {
      $usr_id = $row['addperson_fk'];

      $usr_name = $row['username'];
      $usr_pic = $row['uprof_pic'];
    // echo "<br>UserID1".$usr_id."<br>USERID2".$usr_id2;
      //echo "<br>".$usr_id."<br>".$usr_name;

      echo "<div class='box box1'>
      <a href='profile.php?profile=".$usr_id."'>
          <img src='uploads/".$usr_pic."'  height='80' width='80'>
          </a></div><div class='box box2'>
              <a href='profile.php?profile=".$usr_id."'
              ><b>".$usr_name."</b>
              </a><br></div>";
    }
  }
  if ($result2 !='0' && $result2 >'0'){
    foreach ($result2 as $row) {
      $usr_id = $row['inviter_fk'];

      $usr_name = $row['username'];
      $usr_pic = $row['uprof_pic'];
    // echo "<br>UserID1".$usr_id."<br>USERID2".$usr_id2;
      //echo "<br>".$usr_id."<br>".$usr_name;

      echo "<div class='box box1'>
      <a href='profile.php?profile=".$usr_id."'>
          <img src='uploads/".$usr_pic."'  height='80' width='80'>
          </a></div><div class='box box2'>
              <a href='profile.php?profile=".$usr_id."'
              ><b>".$usr_name."</b>
              </a><br></div>";
    }
  }
}


?>