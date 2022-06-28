<?php
include '../config/db_connect.php';

    if ((isset($_GET['forget_password'])) && isset($_GET['email']))
    {
   
             $email=$_GET['email'];
             $forget_password=$_GET['forget_password'];
             $to = $email; 
             $subject = 'forget password | recover your account';
             $message = '
  
You are trying to recover your account!
you can reset your password by clicking the following link.
   

  
Please click this link to reset  your password:
http://www.php/verification.php?email='.$email.'&forget_password='.$forget_password.'; 

But if you are running the wesite in your loclal server (local host) please copy and pasete the following url in URL address bar!:

    localhost/pages/forget_password.php?email='.$email.'&forget_password='.$forget_password.''; 
// Our message above including the link
                $headers = 'From:utopiaSurvey@gmail.com'."\r\n"; // Set from headers
                if (mail($to, $subject, $message, $headers)){
                     echo '<script>alert("we have sent email verification code to your email");
                    window.open("https://mail.google.com/");</script>';
                }else {
                    echo '<script>alert("whoooops! Something went wrong! try another time");
                    window.open("google.com");</script>';
                     }
     }else if ((isset($_GET['email'] )) && !(isset($_GET['forget_password'])))
     {
            $email=$_GET['email'];
             $hash = md5( $email ); 
            $to = $email; // Send email to our user
            $subject = 'Signup | Verification'; // Give the email a subject 
            $message = '
  
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below.
   

  
Please click this link to activate your account:
http://www.php/verification.php?email='.$email.'&hash='.$hash.'; 

But if you are running the wesite in your loclal server (local host) please copy and pasete the following url in URL address bar!:

localhost/php/verification.php?email='.$email.'&hash='.$hash.'';

            $headers = 'From:utopiaSurvey@gmail.com' . "\r\n"; // Set from headers// Our message above including the link
            if (mail($to, $subject, $message, $headers))
            {
                header("Location:https://mail.google.com/"); //
            }else{echo "chould not send";}

    }
?>




