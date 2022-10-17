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

$page=1;
if (isset($_GET["page"])) $page=$_GET["page"];

$srcLevel=$_POST["srcLevel"];
if (!$srcLevel) $srcLevel=$_GET["srcLevel"];
$srcTopic=$_POST["srcTopic"];
if (!$srcTopic) $srcTopic=$_GET["srcTopic"];
$srcValidation=$_POST["srcValidation"];
if (!$srcValidation) $srcValidation=$_GET["srcValidation"];

$act=$_GET["act"];
$lectId=$_GET["lectId"];

if ($act=="del" AND $lectId) {

		
	$sql = "
		UPDATE `platform__user` 
		SET 
			profile=Null
		WHERE id=$lectId";
	$result=mysqli_query($conn,$sql);

	// Redirect
	$redirectUrl="./MP_LECT_SNA_adminList.php";
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

}

?>

					<p class="rsvPage_Title">List of Universities</p>
					<p class="rsvPage_Title1">MathE Platform</p>

					<?php 

					$sqlP = "
						SELECT *
						FROM platform__university 
						ORDER BY name ASC";
					$resultP=mysqli_query($conn,$sqlP);
					if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

					?>
					<div style="margin: 25px 0 5px 5px;">
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> universities</p>
						<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SNA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
						<div class="clear"></div>
					</div>

					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit">University</th>
								<th class="tdtit">Country</th>
								<th class="tdtit">Timezone</th>
								<th class="tdtit"></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$count=1;
						while ($row=mysqli_fetch_array($resultP)) { 

							//$pict_id=$row["id"];
							$uniId=$row["id"];
							$uniName=$row["name"];
							$uniCountry=$row["country"];
							$uniTimezone=$row["timezone"];
							$uniVis=$row["vis"];

							$UTCtmzOffset=utc_offset_dst($uniTimezone);

							$uniTimezone_tr="";
							if ($uniTimezone) $uniTimezone_tr=$uniTimezone." (".$UTCtmzOffset.")";
							?>
							<tr>
								<td style="font-size: 0.9em;"><?=$count?></td>
								<td style="font-size: 0.9em;">
									<p style="font-size: 1.1em;font-weight: 400;"><?=$uniName?></p>
								</td>
								<td><?=$uniCountry?></td>
								<td><?=$uniTimezone_tr?></td>
								<td><a href="./MP_UNI_edit.php?uniId=<?=$uniId?>">edit</a></td>
							</tr>
							<?php 
							$count+=1;
						}
						?>
						</tbody>
					</table>					

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>