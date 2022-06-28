<?php
// ob_start();
include '../config/db_connect.php';
if (isset($_GET["delete"])){
	$bol=true;
	if ($bol){
	echo '<script> alert("Are you sure you want to delete this?  you will no longer be able to see this survey!!")
	window.open("../pages/mySurvey.php")</script>';
	$bol=false;
	}
	 if(!$bol){
	$survey_title=$_GET['survey_title'];
	$sql = "SET FOREIGN_KEY_CHECKS=0";
    mysqli_query($conn, $sql);
     $sql = "DELETE FROM utopia.created_survey  WHERE survey_title='$survey_title'";
    mysqli_query($conn, $sql);
    $sql = "SET FOREIGN_KEY_CHECKS=1";
	$bol=true;
	}else if ($bol){
	header('Location:../pages/mySurvey.php');
	exit();
	echo '<script>window.open("../pages/mySurvey.php")</script>';
	}
}else {
// echo $_GET["survey_title"];
$title = $_GET["survey_title"];
$sql="SET GLOBAL FOREIGN_KEY_CHECKS=0";
$sql="SELECT number_of_question FROM answered_survey WHERE survey_title='$title'";
$result=mysqli_query($conn,$sql);
$number_of_question=mysqli_fetch_assoc($result);
$number_of_question1=$number_of_question["number_of_question"];
// echo '<br>';
mysqli_query($conn, $sql);
$sql="SELECT COUNT(*) AS total  FROM utopia.answeres WHERE survey_title='$title' and question_number='1'";
if ($result1=mysqli_query($conn,$sql)){
   
    $row1=mysqli_fetch_assoc($result1);
    $number_of_answers=$row1["total"];
    // echo "number of answers" . $number_of_answers;
}
$sql="SELECT file_url FROM utopia.answeres WHERE survey_title='$title' and question_number='1'";
if ($result1=mysqli_query($conn,$sql)){
    $row1=mysqli_fetch_assoc($result1);
    $file_url=$row1["file_url"];
    // echo $file_url;
}

        $num=1;
		$choice= array();
		$question_arr=array();
		$choice1_arr=array();
		$choice2_arr= array ();
		$choice3_arr= array ();
		$choice4_arr= array ();
		$analayz= array ();
        while ($num<=$number_of_question1 && $num>0){
            for ($ch=1; $ch<=4;$ch++){
                $answer="choice ".$ch;
                // echo $answer;
                $sql="SELECT COUNT(*) AS total  FROM utopia.answeres WHERE survey_title='$title' and question_number='$num' and answer='$answer'";
						$number3[0]=0;
                   if ($result1=mysqli_query($conn,$sql)){
                    if ($row1=mysqli_fetch_assoc($result1)){ 
                        $number2[$ch]=$row1['total'];
                        if ( $number2[$ch]==0){
                            $number2[$ch]=0.0001;
                        }
                }
			}
		}		
				$analayz[0]=$number3;
				$analayz[$num]=$number2;
				$dom= new DOMDocument(); 
				$dom->preserveWhiteSpace = false;
				$dom->formatOutput       = true;
				$file_path=str_replace("@","/",$file_url);
				$file_path.=".html";
			  $dom->loadHTML(file_get_contents($file_path));
				   
			  
			   $question_number="question_num".$num;
			   $choice1="choice 1".$num;
			   $choice2="choice 2".$num;
			   $choice3="choice 3".$num;
			   $choice4="choice 4".$num;
			   $question=$dom->getElementById($question_number)->nodeValue;
			  
			//    if (
				   $el_choice1=$dom->getElementById($choice1)->nodeValue;
				//    {
			//    echo "working...";
			// }else {
			// 	echo '<script> alert("your survey can not be analyzed!")</script>
			// 		  <script> window.open("../pages/mySurvey.php");</script>';
			// }
			   $el_choice2=$dom->getElementById($choice2)->nodeValue;
			   $el_choice3=$dom->getElementById($choice3)->nodeValue;
			   $el_choice4=$dom->getElementById($choice4)->nodeValue;
			
			$question_arr[0]="0";
			$question_arr[$num]=$question; 
			$choice1_arr[0]="0";
			$choice1_arr[$num]["ch1"]=$el_choice1;
			if ($choice1_arr[$num]["ch1"]==""){
				$choice1_arr[$num]["ch1"]="choice 1";
			}
			$choice2_arr[0]="0";
			$choice2_arr[$num]["ch2"]=$el_choice2;
			if ($choice2_arr[$num]["ch2"]==""){
				$choice2_arr[$num]["ch2"]="choice 2";
			}
			
			$choice3_arr[0]="0";
			$choice3_arr[$num]["ch3"]=$el_choice3;
			if ($choic3_arr[$num]["ch3"]==""){
				$choice3_arr[$num]["ch3"]="choice 3";
			}
			$choice4_arr[0]="0";
			$choice4_arr[$num]["ch4"]=$el_choice4;
			if ($choice4_arr[$num]["ch4"]==""){
				$choice4_arr[$num]["ch4"]="choice 4";
			}
			
				   $num++;
        }
		$count=http_build_query($analayz);
		$ques= http_build_query($question_arr);
		$ch1=http_build_query($choice1_arr);
		$ch2 = http_build_query($choice2_arr);
		$ch3=http_build_query($choice3_arr);
		$ch4=http_build_query($choice4_arr);
		header("Location:../pages/Result.php?survey_title=$title&count=$count&ques=$ques&ch1=$ch1&ch2=$ch2&ch3=$ch3&ch4=$ch4");  
		exit();
	}
	