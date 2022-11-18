<?php include('www/impianto/inc/function.php'); ?>

<?php
//Delete the data on the tables
$sql = "
DELETE FROM `platform_keyword_snaquestion`";
$deleteSNAquestion=mysqli_query($conn,$sql);


// Video Review
$sql = "
SELECT `keywords`,`questions` FROM `platform__sna__vid_reviews`";
$resultVidReview=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($resultVidReview)) { 
    $keys=($row1["keywords"]);
    $questions=($row1["questions"]);
    $keyExplode = explode("_",$keys);
    $questionExplode = explode("_",$questions);
    array_shift($keyExplode);
    array_pop($keyExplode);

    array_shift($questionExplode);
    array_pop($questionExplode);

    foreach($questionExplode as $question){
        foreach($keyExplode as $key){
            $sql = "
            INSERT INTO `platform_keyword_snaquestion` (`id_keyword`, `id_sna_question`) VALUES ('$key', '$question')";
            $resultVideoReview=mysqli_query($conn,$sql);
    
            var_dump($conn->error);
            echo"<br><br>";
        }
    } 
}

//Video Lesson

$sql = "
SELECT `keywords`,`questions` FROM `platform__sna__vid_lessons`";
$resultVideoLesson=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($resultVideoLesson)) { 
    $keys=($row1["keywords"]);
    $questions=($row1["questions"]);
    $keyExplode = explode("_",$keys);
    $questionExplode = explode("_",$questions);
    array_shift($keyExplode);
    array_pop($keyExplode);

    array_shift($questionExplode);
    array_pop($questionExplode);

    foreach($questionExplode as $question){
        foreach($keyExplode as $key){
            $sql = "
            INSERT INTO `platform_keyword_snaquestion` (`id_keyword`, `id_sna_question`) VALUES ('$key', '$question')";
            $resultVideoReview=mysqli_query($conn,$sql);
    
            var_dump($conn->error);
            echo"<br><br>";
        }
    } 
}


// Teacher Materials
$sql = "
SELECT `keywords`,`questions` FROM `platform__sna__tchmaterials`";
$resultTeacherMaterials=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($resultTeacherMaterials)) { 
    $keys=($row1["keywords"]);
    $questions=($row1["questions"]);
    $keyExplode = explode("_",$keys);
    $questionExplode = explode("_",$questions);
    array_shift($keyExplode);
    array_pop($keyExplode);

    array_shift($questionExplode);
    array_pop($questionExplode);

    foreach($questionExplode as $question){
        foreach($keyExplode as $key){
            $sql = "
            INSERT INTO `platform_keyword_snaquestion` (`id_keyword`, `id_sna_question`) VALUES ('$key', '$question')";
            $resultVideoReview=mysqli_query($conn,$sql);
    
            var_dump($conn->error);
            echo"<br><br>";
        }
    } 
}
?>