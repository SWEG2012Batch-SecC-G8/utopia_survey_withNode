<?php
require "../config/db_connect.php";
$i=1;
$survey_title =array();
$description= array ();
$category= array ();
array_push($survey_title,"title");
array_push($description,"description");
array_push($category,"category");
if (isset($_GET["search_title"])|| isset($_GET["recommended"])||isset($_GET["recent"]))
{
    if ($_GET["search_title"]!='')
    {
         $sql = "SELECT * FROM utopia.created_survey";
        $result =mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result))
        {
                if ($row["survey_title"]==$_GET["search_title"])
                {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                     array_push($category,$row['category']);
                    $i++;
                }else if ($row["category"]==$_GET["search_title"])
                {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                     array_push($category,$row['category']);
                    $i++;
                }
                else if ($row["description"]==$_GET["search_title"])
                {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                     array_push($category,$row['category']);
                    $i++;
                } else if ($row["target_place"]==$_GET["search_title"])
                {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                     array_push($category,$row['category']);
                    $i++;
                }
                else if ($row["target_age"]==$_GET["search_title"])
                {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                     array_push($category,$row['category']);
                    $i++;
                }else if ($row["preferd"]==$_GET["search_title"])
                {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                     array_push($category,$row['category']);
                    $i++;
                }
        }
    }else if ($_GET["recommended"]=="recommended"){
                 $sql = "SELECT * FROM utopia.created_survey where survey_title NOT IN (SELECT survey_title FROM utopia.answered_survey)";
                 $result =mysqli_query($conn, $sql); 
                 while ($row = mysqli_fetch_assoc($result))
                 {
                    array_push($survey_title,$row['survey_title']);
                    array_push($description,$row['description']);
                    array_push($category,$row['category']);
                    $i++;
                }
    }else if ($_GET["recent"]=="recent")
             {
                $date = date_create(date('Y-m-d H:i:s'));
                $tdate=date_modify($date,'-2 days');
                $tdate = $tdate->format('d/m/Y');
                // $recency = $currentDate->sub(new DateInterval('P2D'));
                $sql = "SELECT * FROM utopia.created_survey WHERE created_date >= '$tdate'order by created_date";
                if ($result =mysqli_query($conn, $sql)){
                while ($row = mysqli_fetch_assoc($result))
                    {
                        array_push($survey_title,$row['survey_title']);
                        array_push($description,$row['description']);
                        array_push($category,$row['category']);
                        $i++;
                    }
                }

    }else if ($_GET["nearBy"]=="nearBy"){
        $email=$_SESSION["email"];
            $sql = "SELECT * FROM utopia.created_survey where survey_title WHERE target_place in (SELECT address FROM utopia.customer where email ='$email'";
            $result =mysqli_query($conn, $sql); 
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($survey_title,$row['survey_title']);
                array_push($description,$row['description']);
                array_push($category,$row['category']);
                $i++;
            }
    }else{
            echo '<script>alert("sorry we couldnt find your search");</script>';
        }
  
        
    $title = http_build_query($survey_title);
    $desc = http_build_query($description);
    $cate = http_build_query($category);
    header ("location:../pages/take_survey.php?survey_title=$title&description=$desc&category=$cate");
}else{
    $sql = "SELECT * FROM utopia.created_survey order by survey_title";
    $result =mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result))
    {
    array_push($survey_title,$row['survey_title']);
    array_push($description,$row['description']);
    array_push($category,$row['category']);
    $i++;
    }
    $title = http_build_query($survey_title);
    $desc = http_build_query($description);
    $cate = http_build_query($category);
    header ("location:../pages/take_survey.php?survey_title=$title&description=$desc&category=$cate");
}
?>
