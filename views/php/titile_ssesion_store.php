<?php
SESSION_START();
echo "it come here";

$date = date_create(date('Y-m-d H:i:s'));
                $tdate=date_modify($date,'-2 days');
                $tdate = $tdate->format('d/m/Y');
echo '<br>';
                echo $tdate;
if (isset($_GET["survey_title"])){
$_SESSION["survey_title"] = $_GET["survey_title"];
    $path="Location:../pages/created_survey/pages/".$_GET["survey_title"];
    // $path="survey_analysis.php";
    header($path);
}
?>