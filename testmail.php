<?php

sendActiveMail("yikyekgo@gmail.com","usernamr","hash");

function sendActiveMail($email,$usrn,$hash){
    $_SESSION['active'] = 0; //0 until user activates their account with verify.php
    $_SESSION['logged_in'] = true; // So we know the user has logged in
    $_SESSION['message'] =
                
                 "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";


        // Send registration confirmation link (verify.php)
        require_once("mail.php");
        $mail->setFrom('spammerking12345@gmail.com');
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
        $mail->send();

        //mail( $to, $subject, $message_body );

}

?>