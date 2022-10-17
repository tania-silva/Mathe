<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






<?php

$id_asch=$_GET["id_asch"];
$id_partner=$_GET["id_partner"];

if ($_GET["com"]=="reg" AND $id_asch AND $id_partner) {

	$sql = "DELETE FROM `members_apartners` WHERE id_asch=".$id_asch;
	$result=mysqli_query($conn, $sql);

	//Redirect su messaggio
	$strpas11="./rsv_asspartners.php";
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";



} else {
	$sql = "SELECT * FROM members_apartners WHERE id_asch=".$id_asch;
	$result=mysqli_query($conn, $sql);

	while ($row=mysqli_fetch_array($result)) {
		$sch_name=Pulisci_READ($row["sch_name"]);
	}
}

?>

						<hr />
						<h1>Associated Partners</h1>
						<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_asspartners.php">Associated Partners</a> > Delete partner</p>
						<br>
						<div class="el_msg">
							<p class="p01">Do you want to delete this Associated Partners?</p>

							<p class="titpar">NAME OF THE ASSOCIATED PARTNER</p>
							<p class="p03"><?=$sch_name?></p>

							<div style="margin: 35px 0 0 0;">
								<a href="./rsv_asspartners_del.php?com=reg&id_asch=<?=$id_asch?>&id_partner=<?=$id_partner?>"><img src="./impianto/img/confirm.png" width="122" height="37" alt="" border="0" /></a>
								&nbsp;&nbsp;&nbsp;
								<a href="./rsv_asspartners.php"><img src="./impianto/img/abort.png" width="122" height="37" alt="" border="0" /></a>
							</div>
						</div>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
