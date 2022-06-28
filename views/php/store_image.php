<?php
include '../config/db_connect.php';
$statusMsg = '';
if (isset($_REQUEST["email"])){
    $editted_name=$_REQUEST["email"];
}
else {
    echo '<script> alert("you have not logged in properly please log in again");
        windows.open(../pages/log in.php);</script>';
}
$targetDir = "../images/user_profile_image/";
$fileName = basename($_FILES["profile"]["name"]);
$targetFilePath = $targetDir.$editted_name;
$fileType = pathinfo($fileName,PATHINFO_EXTENSION);
if(isset($_POST["submit"]) && !empty($_FILES["profile"]["name"])){
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        if(move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFilePath)){
            $sql = "UPDATE utopia.customer SET profile_photo_path='$targetFilePath' WHERE email='$editted_name'";
           $sta= mysqli_query($conn,$sql);
            if ($sta==1){
                // header("Location:../php/login_authenticate.php?email=$editted_name&photo_uploaded=$true");
                echo "<script> alert('you changed your profile');
                window.open('../pages/profile1.php?email=$editted_name');
                </script>";
                // header("Location:../pages/profile1.php?email='$_SESSION['email']");
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, ';
    }
    echo "accepted successfully";
}else{
    $statusMsg = 'Please select a file to upload.';
}
//Display status message
echo $statusMsg;
?>