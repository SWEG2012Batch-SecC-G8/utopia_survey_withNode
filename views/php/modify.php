<?php
include '../config/db_connect.php';
if (isset($_POST["modify_input"])) 
{
    echo "submitted";
      $modify =$_POST["modify"];
      if ($modify=="add_data")
       {
           echo "add_data";
           echo '<br>';
            $filename=$_FILES["file"]["tmp_name"]; 
            if($_FILES["file"]["size"] > 0)
             {
                echo "file_accepted";         
                $file = fopen($filename, "r");
                echo '<br>';
                var_dump($_FILES["file"]["size"]);
                echo '<br>';
                if($_POST["modify_what"]==1)
                {
                    echo "customer to be modify";
                    echo '<br>';
                    while (($getData = fgetcsv($file, 10000, ",")) != FALSE && fgetcsv($file, 10000, ",")!=NULL)
                        {
                            $sql = "INSERT INTO utopia.customer (email, firstname, lastname,password, phonenumber,job,gender,birthdate ) 
                                values ('$getData[0]','$getData[1]','$getData[2]','$getData[3]','$getData[4]','$getData[5]','$getData[6]','$getData[7]')";
                            $result = mysqli_query($conn, $sql);
                        }
                }else if ($_POST["modify_what"]==2){
                         while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
                        {
                            $sql = "INSERT into utopia.created_survey (survey_title, survey_creater, description, participant_limit,created_date,dead_line,target_job,target_age,target_place,category) 
                                     values ('$getData[0]','$getData[1]','$getData[2]','$getData[3]','$getData[4]','$getData[5]','$getData[6]','$getData[7]','$getData[8]','$getData[9]')";
                                $result = mysqli_query($conn, $sql);
                        }

                }else if ($_POST["modify_what"]==3){
                         while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
                         {
                                    $sql = "INSERT into  utopia.answered_survey (emial,survey_title,file_path) 
                                     values ('$getData[0]','$getData[1]','$getData[2]')";
                                        $result = mysqli_query($conn, $sql);
                         }
                }
            }else{
                echo '<script> alert("file is empty");';
                }
        }else if ($modify=="delete_data")
            { 
                echo "delete_data";
                echo '<br>';
                    $delete_word=$_POST["delete_name"];
                if($_POST["modify_what"]==1)
                 {
                          $sql = "SET FOREIGN_KEY_CHECKS=0";
                            mysqli_query($conn, $sql);
                            $sql = "DELETE FROM utopia.customer  WHERE email='$delete_word'";
                            mysqli_query($conn, $sql);
                            $sql = "SET FOREIGN_KEY_CHECKS=1";
                }else if ($_POST["modify_what"]==2){
                          
                            $sql = "SET FOREIGN_KEY_CHECKS=0";
                            $sql = "DELETE FROM utopia.created_survey WHERE survey_title='$delete_word'" ;
                            $result = mysqli_query($conn, $sql);
                            $sql = "SET FOREIGN_KEY_CHECKS=1";
                }else if ($_POST["modify_what"]==3)
                                    $sql = "SET FOREIGN_KEY_CHECKS=0";
                                    $sql = "DELETE  FROM utopia.answered_survey WHERE email='$delete_word' OR survey_title='$delete_word'";
                                        $result = mysqli_query($conn, $sql);
                                        $sql = "SET FOREIGN_KEY_CHECKS=0";
                                        $sql = "SET FOREIGN_KEY_CHECKS=1";
                         
            }
        
}
?>
