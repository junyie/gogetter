<?php
echo "hai sasa";
require_once("sessionchecker.php");

if (isset($_POST["subject"])){
    echo $_POST["subject"];
    $a = $_POST["subject"];
    echo "<br>yess";
    $updatebiodata = "UPDATE `user` SET `bio_data`=:biod WHERE `user_id` =:usid";
    $updateBD=$conn->prepare($updatebiodata);
    $updateBD->bindParam(':biod', $a, PDO::PARAM_STR);
    $updateBD->bindParam(':usid', $s_id, PDO::PARAM_INT);
    $updateBD->execute();
    $count = $updateBD->rowCount();
    echo $result;
   if ($count == true){ $result = 1; echo $result;} else {
    $result = 0; echo $result;}
}
?>