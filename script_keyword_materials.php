<?php include('www/impianto/inc/function.php'); ?>

<?php

//Delete the data on the tables
$sql = "
DELETE FROM `platform_keyword_videoreviews`";
$deleteVideoReview=mysqli_query($conn,$sql);

$sql = "
DELETE FROM `platform_keyword_videolessons`";
$deleteVideoLesson=mysqli_query($conn,$sql);

$sql = "
DELETE FROM `platform_keyword_snatchmaterials`";
$deleteSnatchmaterials=mysqli_query($conn,$sql);

$sql = "
DELETE FROM `platform_keyword_snaquestion`";
$deletesnaquestion=mysqli_query($conn,$sql);

$sql = "
DELETE FROM `platform_keyword_sfaquestions`";
$deletesfaquestion=mysqli_query($conn,$sql);

// Video Review
$sql = "
SELECT `id`,`keywords` FROM `platform__sna__vid_reviews`";
$resultVidReview=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($resultVidReview)) { 
    $videRevId=($row1["id"]);
    $keys=($row1["keywords"]);
    $keyexplode = explode("_",$keys);
    $count = count($keyexplode);

    var_dump($keyexplode);

    for($x=1; $x < $count - 1; $x++){
        $keyvalue= $keyexplode[$x];
        $sql = "
        INSERT INTO `platform_keyword_videoreviews` (`id_keyword`, `id_video_review`) VALUES ('$keyvalue', '$videRevId')";
        $resultVidReview1=mysqli_query($conn,$sql);

        var_dump($conn->error);
        echo"<br><br>";
    }
 
}


// Video Lesson
$sql = "
SELECT `id`,`keywords` FROM `platform__sna__vid_lessons`";
$resultVidLesson=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($resultVidLesson)) { 
    $videoLessonId=($row1["id"]);
    $keys=($row1["keywords"]);
    $keyexplode = explode("_",$keys);
    $count = count($keyexplode);

    var_dump($keyexplode);

    for($x=1; $x < $count - 1; $x++){
        $keyvalue= $keyexplode[$x];
        $sql = "
        INSERT INTO `platform_keyword_videolessons` (`id_keyword`, `id_video_lesson`) VALUES ('$keyvalue', '$videoLessonId')";
        $resultVidLesson1=mysqli_query($conn,$sql);

        var_dump($conn->error);
        echo"<br><br>";
    }
 
}

//Teacher materials
$sql = " 
SELECT `id`, `keywords` FROM `platform__sna__tchmaterials`";
$resultTeachermaterials=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($resultTeachermaterials)) { 
    $teacherMaterialId=($row1["id"]);
    $keys=($row1["keywords"]);
    $keyexplode = explode("_",$keys);
    $count = count($keyexplode);

    var_dump($keyexplode);

    for($x=1; $x < $count - 1; $x++){
        $keyvalue= $keyexplode[$x];
        $sql = "
        INSERT INTO `platform_keyword_snatchmaterials` (`id_keyword`, `id_sna_tchmaterials`) VALUES ('$keyvalue', '$teacherMaterialId')";
        $resultteacherMaterial1=mysqli_query($conn,$sql);

        var_dump($conn->error);
        echo"<br><br>";
    }
}
?>