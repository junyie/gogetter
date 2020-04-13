<?php
/* Password reset process, updates database with new user password */
require 'db.php';
session_start();

$email =$_POST['email'];
$hash = "";
// Make sure the form is being submitted with method="post"
if (!isset($_POST['newpassword']) || !isset($_POST['confirmpassword']) ||!isset($_POST['email'])){
    header("location: error.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $results1 ="0";

    if ($_POST['hash']==""){
        header("location: error.php"); 
    }
    // Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) { 
        $v1 =$_POST['newpassword'];
        $v2 =$_POST['confirmpassword'];
        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
        
        // We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
        try {
            
            $stmt_s = $conn->prepare("UPDATE user SET upassword=:new_password, verifying_hash=:hash WHERE uemail=:email");
            $stmt_s->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_s->bindParam(':new_password', $new_password, PDO::PARAM_STR);
            $stmt_s->bindParam(':hash', $hash, PDO::PARAM_STR);
            $stmt_s->execute();
            $results1 = $stmt_s->rowCount();
            echo"checked"; //debug
        
            if ( $results1 >0 ) {
                // reset the hash for sucurity purpose    
                $_SESSION['message'] = "Your password has been reset successfully!";
                header("location: success.php");
                echo "pass 1"; //debug
                }
            }
        catch(PDOException $e){
                {
                echo "Error: " . $e->getMessage();
                }
            }

    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: error.php");    
    }
    header("location: error.php");
}
?>