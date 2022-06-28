<?php
include '../config/db_connect.php';
if(isset($_POST["generate"])){
    error_reporting(0);
    $report_about=$_POST["report_about"];
    $specific=$_POST["type_select"];
    
    $dir="C:/xampp/htdocs/github/survey/admin_files/".$report_about."/";
    $result;
    $sql;
    $count = 0;
    $header;
    $output;
    $path=$dir.$specific;
    if (!is_dir($dir)){
    mkdir($dir);
    }
     $output = fopen($path, "a+");  

     if ($report_about=="customer"){
         
       
         $header=array('Email','First Name','password', 'Last Name', 'Phone Number','job','gender','birthdate','profile_photo_path','address','customer staus');
        fputcsv($output,$header );  
         switch($specific)
         {
            case 1:  $sql="SELECT email, firstname, lastname,password,phonenumber,job,gender,birthdate,profile_photo_path,address,cust_status FROM utopia.customer";
             break;
            case 2: $sql="SELECT email, firstname, lastname,password, phonenumber,job,gender,birthdate,profile_photo_path,address,cust_status FROM utopia.customer where job='unemployeed'";
            break;
            case 3:$sql="SELECT email, firstname, lastname,password, phonenumber,job,gender,birthdate,profile_photo_path,address,cust_status FROM utopia.customer where job='employeed'";
            break;
            case 4:$sql="SELECT email, firstname, lastname,password, phonenumber,job,gender,birthdate,profile_photo_path,address,cust_status FROM utopia.customer where email In(SELECT email FROM utopia.answered_survey where (SELECT count(email) FROM utopia.answered_survey order by email))>0" ;
            break;
            case 5:$sql="SELECT email, firstname, lastname,password, phonenumber,job,gender,birthdate,profile_photo_path,address,cust_status FROM utopia.customer where email In(SELECT email FROM utopia.created_survey)";
            break;
            
        }
        $result=mysqli_query($conn,$sql); 
        while($row = mysqli_fetch_assoc($result))  
        {   
            
             fputcsv($output, $row);  
             $records[]=$row;
             $count++;
        }
     }else if($report_about=="survey"){
                // $sql;
             $header=array('survey_title', 'email', 'description', 'participant_limit','created_date','dead_line','target_job','target_age','target_place','category');
            fputcsv($output,$header);
            switch($specific)
            {
                case 1:  $sql="SELECT survey_title, survey_creater, description, participant_limit,prefered_gender,created_date,dead_line,target_job,target_age,target_place,category FROM utopia.created_survey";
                     break;
                 case 2:  $sql="SELECT survey_title, survey_creater, description, participant_limit,prefered_gender,created_date,dead_line,target_job,target_age,target_place,category FROM utopia.created_survey where survey_title in(SELECT survey_title FROM utopia.answered_survey)";
                     break;
                 case 3:  $sql="SELECT survey_title, survey_creater, description, participant_limit,prefered_gender,created_date,dead_line,target_job,target_age,target_place,category FROM utopia.created_survey WHERE category='business'";
                     break;
            }
            $result=mysqli_query($conn,$sql); 
           
             while($row = mysqli_fetch_assoc($result))  
            {   
            $count++;
            fputcsv($output, $row);  
            $records[]=$row;
            }
     }else if ($report_about=="payment"){
             echo '<script> alert("whoops! we coudn\'t resolve this");';
     }
     fclose($output); 
     function download($file,$header ){ 
        // _helper->layout()->disableLayout();
        // _helper->viewRenderer->setNoRender(true);
     $filname=$report_about.$specific.".csv";
     $fh = fopen( 'php://output', 'w' );
     fputcsv($fh, $header);
     header("Content-Type: text/csv");
     header("Content-Disposition: attachment; filename=\"$filname\"");	
     header("Content-Transfer-Encoding: binary");
     if(!empty($file)) {
       foreach($file as $record) {		
         fputcsv($fh, array_values($record));
       }
     }
     
} 
if ($count==0){
    echo '<script> alert("there is nothing in database to show this query!");</script>';
}else{
    download($records,$header);
}
}
 ?>