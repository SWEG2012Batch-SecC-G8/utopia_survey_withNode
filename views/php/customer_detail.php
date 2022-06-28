<?php
include "../config/db_connect.php";
if (isset($_REQUEST['email'])){
  $form_email=mysqli_real_escape_string($conn, $_REQUEST['email']);
}
$result = mysqli_query($conn, "SELECT * FROM utopia.customer");
while ($row=mysqli_fetch_assoc($result)){
     $useremail= $row['email'];
    if ($useremail==$form_email){
      $emailv=$row["email"];
      $firstname=$row["firstname"];
      $lastname=$row["lastname"];
      $job=$row["job"];
      $phonenumber=$row["phonenumber"];
      $gender=$row["gender"];
      $birthdate=$row["birthdate"];
      if (!empty($row["profile_photo_path"])){
        $profile_photo_path=$row["profile_photo_path"];
      }
      else {
        $profile_photo_path="default_photo";
      }
    }
  }
?>
