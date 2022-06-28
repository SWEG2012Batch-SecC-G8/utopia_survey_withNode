<?php
include '../config/db_connect.php';
if ((isset($_GET["email"]))&& ($_GET['forget_password']==null)){
   $email = $_GET["email"];
   $hash=$_GET["hash"];
   echo '<script>alert("your account has been activated you can log in now! enjoy the service");
   window.open("logout.php");</script>';

}

if ($hash=== md5( $email )){
mysqli_query($conn,"UPDATE customer SET cust_status =1 WHERE email = '$email'");
}
if (isset($_POST['forget_password'])){
   $email = $_POST['email'];
   $password=$_POST['password'];
   $password=password_hash($password,PASSWORD_DEFAULT);
   mysqli_query($conn,"UPDATE utopia.customer SET password = '$password' WHERE email = '$email'");
   echo '<script>alert("your account has been recoverd! enjoy the service");
   window.open("logout.php")</script>';

}
 ?>