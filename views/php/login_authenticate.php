<?php
SESSION_START ();
include ("../config/db_connect.php");
if (isset($_REQUEST['email']) && isset($_REQUEST['password']))
{
   $form_email= $_REQUEST['email'];
   $form_password=$_REQUEST['password'];
}
$result = mysqli_query($conn, "SELECT email,firstname,password ,cust_status FROM customer where email='$form_email'");
$data_sql=mysqli_fetch_assoc($result);

if(password_verify($form_password,$data_sql["password"]))
{
   if ( ($data_sql["cust_status"]==1)){
   mysqli_close($conn);
   setcookie("email",$form_email,time() +3600,'/');
   $_SESSION['email'] = $form_email;
   $_SESSION['firstname'] = $data_sql["firstname"];
   $_SESSION['password'] = $form_password;
   $_SESSION['logged_in'] ="yes";
   $PHOTOPATH="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($PHOTOPATH,"photo_uploaded=true")==true){  
      header("Location:../pages/profile1.php?email=$form_email");
      exit();
   }else {header("Location:../pages/page 3.php?email=$form_email");
   exit();
    }
  
}else {
   header("Location:../pages/log in.php?inactive=yes");
}

}

   mysqli_close($conn);
   // header("Location:logout.php");

?>