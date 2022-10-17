<?php include('top.php'); ?>
<?php include('./impianto/inc/protectedGuest.php'); //Se non loggato esci...?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-2">
			<?php //include('./impianto/rsv_menu.php'); //Menu?>
			<?php  include('./impianto/spallaSx_LECT.php'); // funzioni PHP ?>
		</div>
		<div id="rsv_crp" class="col-md-10">
			<hr />					
			<!-- INCOLLA START -->





<?php 

$idTP=$_GET["idTP"];
$idSTP=$_GET["idSTP"];

if ($idTP) $objTitle="Topic";
if ($idSTP) $objTitle="Subtopic";

if ($_GET["act"]=="delTP_proceed" AND ($idTP OR $idSTP) AND $usrProfile=="admin") {

	if ($idTP) {
		/* Calcello il topic */
		$sql = "
			DELETE 
			FROM `platform__topic` 
			WHERE id='$idTP'";
		$result=mysqli_query($conn,$sql);
	}

	if ($idSTP) {
		/* Calcello il subtopic */
		$sql = "
			DELETE 
			FROM `platform__subtopic` 
			WHERE id='$idSTP'";
		$result=mysqli_query($conn,$sql);
	}

	$redirectUrl="./MP_LECT_topicManage.php";

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

} else {

	if ($idTP) {
		$sql = "
			SELECT *
			FROM platform__topic 
			WHERE id=$idTP 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$topicName=$row["name"];
		}
	}

	if ($idSTP) {
		$sql = "
			SELECT *
			FROM platform__subtopic 
			WHERE id=$idSTP 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$topicName=$row["name"];
		}
	}

}
?>

					<p class="rsvPage_Title">Delete <?=$objTitle?></p>
					<p class="rsvPage_Title1">MathE Platform</p>


					<form method="post" action="./MP_LECT_topicDelete.php?act=delTP_proceed&idTP=<?=$idTP?>&idSTP=<?=$idSTP?>" enctype="multipart/form-data" style="display: block;margin-top: 25px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<p style="padding: 5px 15px 0 15px;font-size: 1.2em;">Do you confirm to delete this <?=$objTitle?>?</p>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;"><?=$objTitle?> Name</label>
							<div style="font-size: 1.2em;"><?=$topicName?></div>
						</div>

						

						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_topicManage.php"><button type="button" class="abort" style="width: 150px;margin-left: 150px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="DELETE" class="proceed" style="width: 150px;margin-left: 10px;padding: 5px;" />
						</div>




					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>