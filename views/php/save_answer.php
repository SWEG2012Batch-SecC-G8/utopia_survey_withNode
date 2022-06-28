<?php
SESSION_START();

include '../config/db_connect.php';
$survey_title=$_SESSION["survey_title"];
$survey_taker=$_SESSION["email"];
$title1=str_replace(".html","",$survey_title);
$path="../pages/answerd_survey/".$title1."/";
mkdir($path);

$truePath=$path.$survey_taker;
$write_to=fopen($truePath,'a');
$i=1;
while (isset($_REQUEST[$i])){
    $i++;
}
$truepath1=str_replace("/","@",$truePath);
$sql="INSERT INTO utopia.answered_survey (file_url,survey_title,survey_taker,number_of_question) VALUES('$truepath1','$title1','$survey_taker','$i-1')";
if (mysqli_query($conn, $sql)){
   
}else 

$i=1;
// $title1=str_replace(".html","",$survey_title);
$question_path="../pages/created_survey/pages/".$title1;
$truequestion_path=str_replace('/','@',$question_path);
while (isset($_REQUEST[$i])){
    $answer=$_REQUEST[$i];

    fwrite($write_to,$_REQUEST[$i].PHP_EOL);
    $sql="SET FOREIGN_KEY_CHECKS=0";
    $sql="INSERT INTO utopia.answeres(answer_id,answer,survey_title,answered_by,file_url,question_number)
     VALUES('','$answer','$title1','$survey_taker','$truequestion_path','$i')";
    
    if ($result=mysqli_query($conn, $sql)){
        echo "it is successfully";
    }else{
       var_dump(mysqli_query($conn, $sql));
    }
    
    $i++;   
}
$sql="SET FOREIGN_KEY_CHECKS=1";
mysqli_close($conn);
header("Location:../pages/take_survey.php");
?>