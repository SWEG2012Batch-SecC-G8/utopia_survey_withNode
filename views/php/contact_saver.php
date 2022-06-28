<?php

if (isset($_POST["fullname"])|| isset($_POST["emailaddress"])|| isset($_POST["subject"])){
    $emailaddress=$_POST["emailaddress"];
    $fullname="Full name:  ".$_POST["fullname"];
    $subject="Subject: ".$_POST["subject"];
    $message="Message :  ".$_POST["message"];
    $subject1="full name :  ".$fullname."|subject : ".$subject."|messages:  ".$messages;
  
    
}
echo $subject;
 echo exec('whoami'); 
$dir="C:/xampp/htdocs/admin_files/contact_messages/";
mkdir($dir);
if (is_dir($dir)){
   echo "Directory";
    }
    $filPath="C:/xampp/htdocs/admin_files/contact_messages/".$emailaddress;
    if ($file_storing=fopen($filPath,'a+')){
        echo "successfully opened file";
    }
    $emailaddress="email :  ".$_POST["emailaddress"];
   fwrite($file_storing,$fullname.PHP_EOL);
   fwrite($file_storing,$emailaddress.PHP_EOL);
   fwrite($file_storing,$subject.PHP_EOL);
   fwrite($file_storing,$message.PHP_EOL);
    echo '<script>alert("we have received your message we will answer sooner"); </script>';
    echo '<script> window.location.assign("../index.php")</script>';
    
?>