<?php
SESSION_START();
include '../config/db_connect.php';

$job=$_SESSION['job'];
// $sql = "select * from created_survey where target_job='$job'";
$sql = "select * from customer where job='$job'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

while($row = mysqli_fetch_assoc($result)){    
    
    $email=$row['email'];   
     $first_name=$row['firstname'];    
     $last_name=$row['lastname'];   
    //   $job= $row['job'];   
    //    $job= $row['gender'];

       $msg = "hey ".$first_name." ".$last_name."\nwe hope this email finds  you well \n
    we are sending you this email to inform you that there is Survey which has just been created that you can fill and enjoy the reward , CHECK IT OUT\nThank you for using Our platform";

    

    $msg = wordwrap($msg,100);
  if (mail($email,"informing you",$msg)){
    echo "<div class=\"d-flex justify-content-center \"><h1 class=\"ms-5 mt-5\">Notification sent succesfully! </h1></div>"." to ".$first_name;
  }
}





if (isset($_GET["created_survey"])|| isset($_GET["survey_title"])){
    $created_survey=$_GET["created_survey"];
   $survey_title=$_SESSION["survey_title"];
    $file_form=str_replace("@","<",$created_survey);
}
    $filPath="../pages/created_survey/pages/". $survey_title.".html";
    $file_storing=fopen($filPath,'a');
   fwrite($file_storing,$file_form,);
    echo '<script>alert("your survey has been published"); </script>';
    echo '<script> window.location.assign("../pages/create_survey.php")</script>';
    
?>