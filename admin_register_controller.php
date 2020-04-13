<?php
require_once('db.php');
session_start();
require_once("csrf.php");

function sendActiveMail($email,$usrn,$hash){
    $_SESSION['active'] = 0; //0 until user activates their account with verify.php
    $_SESSION['logged_in'] = true; // So we know the user has logged in
    $_SESSION['message'] =
                
                 "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";


        // Send registration confirmation link (verify.php)
        require_once("mail.php");
        $mail->setFrom('spammerking12345@gmail.com');
        $mail->IsSMTP();
        $mail->isHTML(true);
        $mail->addAddress($email);
        $mail->Subject = 'Account Verification ( GoGetter.com )';
        $Msg = '
        Hello '.$usrn.',

        Thank you for signing up!<br>

        Please click this link to activate your account:<br>

        http://localhost:8081/gogetter/verify.php?email='.$email.'&hash='.$hash; 
        //http://student.kdupg.edu.my/xxx/xx/verify.php?email='.$email.'&hash='.$hash.'&type='.$str;
        $mail->Body = $Msg;
        if(!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } 
        else {
            echo "Message has been sent successfully";
        }

}
            
// Value that use to process
$email = $_POST["email"];
$usrn = $_POST["admin_username"];
$pass =  $_POST["admin_password"];

//Hash the password as we do NOT want to store our passwords in plain text.
$passwordHash = password_hash($pass, PASSWORD_BCRYPT);
$hash = md5( rand(0,1000) ) ; //use to let user active account with email
if (isset($_POST['signup1'])) {

if (hash_equals($csrf, $_POST['csrf'])) {
try {

    $stmt_semail = $conn->prepare("SELECT * FROM administrator WHERE email=:email");
    $stmt_susrn = $conn->prepare("SELECT * FROM administrator WHERE username=:usrn");

  
     $stmt_semail->bindParam(':email', $email, PDO::PARAM_STR);
     $stmt_susrn->bindParam(':usrn', $usrn, PDO::PARAM_STR);
     $stmt_semail->execute();
     $stmt_susrn->execute();
     $results1 = $stmt_semail-> fetch();
     $results3 = $stmt_susrn-> fetch();
}
catch(PDOException $e){
    {
    echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

    
//redirect user back to register form if result found that username or email already exist
if ($results1 >0 ||  $results3 >0){

    header('location: admin_register.php?fail=3');
    if ($results1 >0){
        header('location: admin_register.php?fail=1');
    }
    if ($results3 >0){
        header('location: admin_register.php?fail=2');
    }
    if($results1 >0 && $results3 >0){
        header('location: admin_register.php?fail=3');
    }
    
}else {
        try {  
        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO administrator (username, email, password, verifying_hash) 
        VALUES (:_usrn, :_email, :_pass, :_hash)");
        $stmt->bindParam(':_usrn', $usrn,PDO::PARAM_STR);
        $stmt->bindParam(':_email', $email,PDO::PARAM_STR);
        $stmt->bindParam(':_pass', $passwordHash,PDO::PARAM_STR);
        $stmt->bindParam(':_hash', $hash,PDO::PARAM_STR);
        // insert a row
        $stmt->execute();
        sendActiveMail($email,$usrn,$hash);
        //header('location: registering.php?success=1');
        }
    catch(PDOException $e)
        {
        echo "Error: " . $e->getMessage();
        }
        $conn = null;
}
}else{
	session_destroy();
	header('location: admin_register.php?fail=1');  
}
}else {
    echo "‌‌ ";
}

?>