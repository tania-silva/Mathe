<?php include('top.php'); ?>
<!-- INCOLLA START -->






	<!-- Calendar -->
	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="./impianto/addons/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>
	<div class="container" id="sottomenu">
		<div id="cnt1" class="row">

			<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
			<div id="rsv_crp" class="col-md-9">
				
				<hr>


<?php

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
	require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
	////////////////////////////////////////////////////
	$act=$_GET["act"];

	if ($act=="reg") {

		$data= $id_set=date("Ymd");
		$qst00=$_POST["qst00"];
		$qst01=$_POST["qst01"];
		//$qst02=$_POST["qst02"];

		$qst02_1=$_POST["dc1"];
		$qst02_1d=substr($qst02_1, 0, 2);
		$qst02_1m=substr($qst02_1, 3, 2);
		$qst02_1a=substr($qst02_1, -4);
		$qst02_1=$qst02_1a.$qst02_1m.$qst02_1d;

		$qst02_2=$_POST["dc2"];
		$qst02_2d=substr($qst02_2, 0, 2);
		$qst02_2m=substr($qst02_2, 3, 2);
		$qst02_2a=substr($qst02_2, -4);
		$qst02_2=$qst02_2a.$qst02_2m.$qst02_2d;

		$qst03=Pulisci_INS($_POST["qst03"]);
		$qst04=Pulisci_INS($_POST["qst04"]);
		//$qst05=Pulisci_INS($_POST["qst05"]);
		$qst06=Pulisci_INS($_POST["qst06"]);
		$qst07=Pulisci_INS($_POST["qst07"]);
		$qst08=Pulisci_INS($_POST["qst08"]);
		$qst09=Pulisci_INS($_POST["qst09"]);

		if ($qst00 && $qst01) $chk_status=1;

		if ($chk_status==1) {

			//////////////////////////////////////////////////////////
			/////////////// Registro su database MySql /////////////////

			$sql = "INSERT INTO `pm__workinprogress` (`data` , `id_user` , `id_partner` , `partner` , `period_from` , `period_to` , `wps` , `objectives` , `time` , `description` , `outcomes` , `evaluation`)  VALUES ('$data' ,'$qst00' ,'$qst09' ,'$qst01' ,'$qst02_1' ,'$qst02_2' ,'$qst03' ,'$qst04' ,'$qst05' ,'$qst06' ,'$qst07' ,'$qst08')";
			$result=mysqli_query($conn, $sql);


			//Redirect su messaggio
			$strpas11="./rsv_pm_wip.php";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();
			

		} else {
			//Redirect su messaggio
			$strpas11="./rsv_pm_wip.php";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();
		}

	} else {

		if ($_SESSION["id_user"]) {
			$sql = "SELECT * FROM user WHERE id_user=".$_SESSION["id_user"];
			$result=mysqli_query($conn, $sql);

			while ($row=mysqli_fetch_array($result)) {
				$id_user=Pulisci_READ($row["id_user"]);
				$id_partner=Pulisci_READ($row["id_partner"]);
				$usr_level=Pulisci_READ($row["usr_level"]);
			}
		}
	}

?>

					<h1>Work in Progress</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_wip.php">Work in Progress</a> > Insert new Document</p>
					<br>



					<form method="post" name="demoform" action="./rsv_pm_wip_new.php?act=reg" onreset="return confirm('Are you sure you want to reset the document?')">
						<input type="hidden" name="qst00" value="<?=$id_user?>" />
						<input type="hidden" name="qst09" value="<?=$id_partner?>" />

						<p class="titpar">ACTIVITIES REPORT FORM</p>
						<div class="txt">
							Fill in infomation about activities then press "Send" button. Please <strong>write down your contents in a word document first and then copy and paste on this form</strong>. This will avoid the loss of your contents in case of problems in the uploading phase. If you want to see all the activities yet uploaded <a href="./rsv_pm_wip.php">click here</a>
						</div>
						<br /><br />
						<hr>
						<p class="titpar"><?=strtoupper("Partners' Institution")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<input class="ar_inp01" type="text" name="qst01" value="<?=$ptn_name_func?>" readonly style="width: 500px;border: none;" />
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Project's period")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							&nbsp;&nbsp;from: <input class="plain" name="dc1" value="" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							&nbsp;&nbsp;to: <input class="plain" name="dc2" value="" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Activity concerned")?></p>
						<p style="padding: 0 0 15px 0;font-size: 10pt;font-weight: normal;color: #900;line-height: 1.2em;">If the activity you are looking for is not included in the drop down menu, it is because you have already created the related record.<br />This means that you do not need to create a new one, but just to edit the one you created updating the information.</p>
						<div class="lbl023">
							<select name="qst03" style="min-width: 150px;width: auto !important;width: 150px;" required>
								<?php if (strpos($wps_str, "IO1")===False) {?><option value="IO1">IO1 - Student Assessment Toolkit</option><?php }?>
								<?php if (strpos($wps_str, "IO2")===False) {?><option value="IO2">IO2 - Math Library</option><?php }?>
								<?php if (strpos($wps_str, "IO3")===False) {?><option value="IO3">IO3 - Community of Practice</option><?php }?>
								<?php if (strpos($wps_str, "ME")===False) {?><option value="ME">ME - Multiplier Events</option><?php }?>
								<?php if (strpos($wps_str, "PM")===False) {?><option value="PM">PM - Project Management</option><?php }?>
							</select>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Objectives of activities carried out")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst04" rows="" cols="" style="height: 250px; width: 600px;"></textarea>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Description of activities carried out")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst06" rows="" cols="" style="height: 250px; width: 600px;"></textarea>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Results Achieved")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst07" rows="" cols="" style="height: 250px; width: 600px;"></textarea>
						</div>

						<!-- <p class="titpar"><?=strtoupper("Evaluation of the work undertaken")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst08" rows="" cols="" style="height: 250px;"></textarea>
						</div> -->

						<div class="lbl04" style="margin-bottom: 3%"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>
						<hr>
					</form>

			</div>
		</div> <!-- cnt1 -->
	</div> <!-- container -->






<!-- INCOLLA END -->
<?php include('bottom.php'); ?>
