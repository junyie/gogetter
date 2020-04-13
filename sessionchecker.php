<?php
 date_default_timezone_set('Asia/Kuala_Lumpur');
 require_once('db.php');
 session_start();
 require_once("csrf.php");
 //$old_sessionid = session_id();
//session_regenerate_id();

 function debugPost(){
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>&nbsp";
        echo $key;
        echo "</td>";
        echo "<td>&nbsp";
        echo $value;
        echo "</td>";
        echo "</tr><br>";
    }
 }

 if ( isset($_SESSION["username1"]) && isset($_SESSION["identity"] ))  
 {
    $stmt2 = $conn->prepare("SELECT * FROM user WHERE username=:username1 AND verified_status ='1'");
    $stmt2->bindParam(":username1",$_SESSION["username1"]);
    $stmt2->execute();
    $s_id = $_SESSION["identity"];
   // $_biodata = $_SESSION["biodata"];
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $mypoints =  $result['upoints'];
    $mybiodata =  $result['bio_data'];
    $myprofilepic = "uploads/".$result['uprof_pic']; //need to add if file not exist , change default pic ... later
    if (isset($_GET['get']) && $_GET['get'] == "time") {
        echo $mypoints;
    }
 }
 else if ( isset($_SESSION["admin_username"]) && isset($_SESSION["admin_identity"] )) 
 {
    $stmt2 = $conn->prepare("SELECT * FROM administrator WHERE username=:admin_username AND verified_status ='1'");
    $stmt2->bindParam(":admin_username",$_SESSION["admin_username"]);
    $stmt2->execute();
    $s_id = $_SESSION["admin_identity"];
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
 }
 else  
 {  
    session_destroy();
    header("location:index.php");
 }
 //$new_sessionid = session_regenerate_id(true);
?>