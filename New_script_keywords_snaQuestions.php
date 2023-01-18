<?php include('www/impianto/inc/function.php'); ?>

<?php 
//Delete the data on the tables
$sql = "
DELETE FROM `platform_keyword_snaquestion`";
$deleteSNAquestion=mysqli_query($conn,$sql);

$sql="
SELECT `id` FROM `platform__sna__questions`";
$sqlResult=mysqli_query($conn,$sql);

$idQuestion = [];


while ($row1=mysqli_fetch_array($sqlResult)) { 
    array_push($idQuestion, $row1["id"]);
}

foreach($idQuestion as $id){
    $stringArray = [];
    $keysArray=[];

    $sql="
    SELECT `keywords` FROM `platform__sna__tchmaterials` WHERE (INSTR(questions, '_{$id}_')>0)";
    $tchResults=mysqli_query($conn,$sql);

    while ($row2=mysqli_fetch_array($tchResults)) { 
        array_push($stringArray, $row2["keywords"]);
    }

    $sql="
    SELECT `keywords` FROM `platform__sna__vid_lessons`  WHERE (INSTR(questions, '_{$id}_')>0)";
    $vLessonResults=mysqli_query($conn,$sql);

    while ($row3=mysqli_fetch_array($vLessonResults)) { 
        array_push($stringArray, $row3["keywords"]);
    }

    $sql="
    SELECT `keywords` FROM `platform__sna__vid_reviews` WHERE (INSTR(questions, '_{$id}_')>0)";
    $vReviewResults=mysqli_query($conn,$sql);

    while ($row4=mysqli_fetch_array($vReviewResults)) { 
        array_push($stringArray, $row4["keywords"]);
    }

    foreach($stringArray as $string){
        $keyExplode = explode("_",$string);
        array_shift($keyExplode);
        array_pop($keyExplode);
        foreach($keyExplode as $key){
            array_push($keysArray, $key);
        }
    }
    if(count($stringArray) > 2){
        $keyIntersection = array_count_values($keysArray);
        foreach($keyIntersection as $key=>$value){
            if($value > 1){
                //var_dump($id."->".$key);
                //echo "<br></br>";
                $sql="
                INSERT INTO `platform_keyword_snaquestion`(`id_keyword`, `id_sna_question`) VALUES ($key, $id)";
                $snaQuestion=mysqli_query($conn,$sql);
            
                //var_dump($conn->error);
                //echo"<br><br>";
            }
        }  
    }else{  
        foreach($keysArray as $k){
            $sql="
                INSERT INTO `platform_keyword_snaquestion`(`id_keyword`, `id_sna_question`) VALUES ($k, $id)";
            $snaQuestionOne=mysqli_query($conn,$sql);
            var_dump($conn->error);
            echo"<br><br>";
        }
    }
  
}

?>