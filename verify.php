<?php 
/* Verifies registered user email, the link to this page
   is included in the register.php email message 
*/
require_once('db.php');
session_start();

// Make sure email and hash variables aren't empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $_GET['email']; 
    $hash = $_GET['hash']; 
    $table ="";
    $active ="";
    $mailtype="";
    $hashtype="";

    $stmt = $conn->prepare("SELECT * FROM user WHERE uemail=:email AND verifying_hash=:hash1 AND verified_status='0'");
    $table = "user";
    $active = "verified_status";
    $mailtype="uemail";
    $hashtype="verifying_hash";
    
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':hash1', $hash, PDO::PARAM_STR);
    // Select user with matching email and hash, who hasn't verified their account yet (active = 0)
    $stmt->execute();
    if ( $stmt=='0' )
    { 
        $_SESSION['message'] = "Account has already been activated or the URL is invalid!";

        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Your account has been activated!";
        
        // Set the user status to active (active = 1)
        $stmt = $conn->prepare("UPDATE $table SET $active='1' WHERE $mailtype=:email AND  $hashtype=:hash1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':hash1', $hash, PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION['$active'] = 1;
        
        header("location: success.php");
    }
}
else {
    $_SESSION['message'] = "Invalid parameters provided for account verification!";
    header("location: loging.php");
}     
?>