<?php
//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
?>
<?php include('top.php'); ?>

<!-- INCOLLA START -->







	<?php
		////////////////////////// SANITIZE VARS ///////////////////////////
		$DS=DIRECTORY_SEPARATOR;
		$root=".".$DS;
		require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
		require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
		////////////////////////////////////////////////////
		$act=isset($_GET["act"]) ? $_GET["act"] :'';
		$act_id=$_GET["id_act"];
		$wps1=$_GET["wps"];
		$partner1=$_GET["partner"];

		if ($act=="edit") {

			////////////////////////////////////////////////////
			$act_id= $_POST["act_id"];
			$qst00=($_POST["qst00"]);
			$qst01=($_POST["qst01"]);
			$qst02=($_POST["qst02"]);

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
			$qst05=Pulisci_INS($_POST["qst05"]);
			$qst06=Pulisci_INS($_POST["qst06"]);
			$qst07=Pulisci_INS($_POST["qst07"]);
			$qst08=Pulisci_INS($_POST["qst08"]);

			if ($qst00 && $qst01 && $qst02_1 && $qst03 && $act_id) $chk_status=1;

			if ($chk_status==1) {
				$sql = "
					UPDATE `pm__workinprogress` 
					SET 
						data='$data', 
						period_from='$qst02_1', 
						period_to='$qst02_2', 
						wps='$qst03', 
						objectives='$qst04', 
						time='$qst05', 
						description='$qst06', 
						outcomes='$qst07', 
						evaluation='$qst08' 
					WHERE id_act='$act_id'";
				$result=mysqli_query($conn, $sql);
			}

			//Redirect su messaggio
			$strpas11="./rsv_pm_wip.php?wps=".$wps1."&partner=".$partner1;
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();

		} else {

			$sql = "SELECT * FROM pm__workinprogress WHERE id_act=".$act_id;
			$result=mysqli_query($conn, $sql);


			while ($row=mysqli_fetch_array($result)) {
				$act_id=$row["id_act"];
				$data=$row["data"];
				$id_user=$row["id_user"];
				$partner=Pulisci_READ($row["partner"]);
				$id_partner=Pulisci_READ($row["id_partner"]);
				$wps=Pulisci_READ($row["wps"]);
				$objectives=Pulisci_READ($row["objectives"]);
				$time=Pulisci_READ($row["time"]);
				$description=Pulisci_READ($row["description"]);
				$outcomes=Pulisci_READ($row["outcomes"]);
				$evaluation=Pulisci_READ($row["evaluation"]);

				if ($row["period_from"]!=0) {
					$period_from=$row["period_from"];
					$period_from_gg=substr($period_from, -2);
					$period_from_mm=substr($period_from, 4, 2);
					$period_from_aa=substr($period_from, 0,4);
					$period_from=$period_from_gg."/".$period_from_mm."/".$period_from_aa;
				} else $period_from="";

				if ($row["period_to"]!=0) {
					$period_to=$row["period_to"];
					$period_to_gg=substr($period_to, -2);
					$period_to_mm=substr($period_to, 4, 2);
					$period_to_aa=substr($period_to, 0,4);
					$period_to=$period_to_gg."/".$period_to_mm."/".$period_to_aa;
				} else $period_to="";
			}


			$sql = "SELECT * FROM user WHERE id_user=".$_SESSION["id_user"];
			$result=mysqli_query($conn, $sql);


			while ($row=mysqli_fetch_array($result)) {
				$id_partner1=Pulisci_READ($row["id_partner"]);
				$usr_level=Pulisci_READ($row["usr_level"]);
			}

			$par_permit="off";
			if ($usr_level==5) $par_permit="on";
			elseif ($id_partner == $id_partner1 && $usr_level>=2) $par_permit="on";
		}

	?>
	<!-- Calendar -->
	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="./impianto/addons/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>
	<div class="container">
		<div class="row">

				<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp" class="col-md-9">					
					
					<hr />
					<h1>Work in Progress</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_wip.php">Work in Progress</a> > Edit Document</p>

					<form method="post" name="demoform" action="./rsv_pm_wip_edit.php?wps=<?=$wps1?>&partner=<?=$partner1?>&act=edit" onreset="return confirm('Are you sure you want to reset the document?')">
						<input type="hidden" name="act_id" value="<?=$act_id?>" />
						<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />

						<p class="titpar">ACTIVITIES REPORT FORM</p>
						<div class="txt">
							Modify infomation about activities then press "Send" button. Please <strong>write down your contents in a word document first and then copy and paste on this form</strong>. This will avoid the loss of your contents in case of problems in the uploading phase. If you want to come back to the activities report list <a href="./rsv_pm_wip.php">click here</a>
						</div>
						<br /><br />

						<p class="titpar"><?=strtoupper("Partners' Institution")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<input class="ar_inp01" type="text" name="qst01" value="<?=$ptn_name_func?>" readonly style="width: 500px;border: none;" />
						</div>

						<p class="titpar"><?=strtoupper("Project's period")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							&nbsp;&nbsp;from: <input class="plain" name="dc1" value="<?=$period_from?>" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							&nbsp;&nbsp;to: <input class="plain" name="dc2" value="<?=$period_to?>" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>

						<p class="titpar"><?=strtoupper("Activity  concerned")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<select name="qst03">
								<option value="IO1" <?php if ($wps=="IO1") echo "selected"?>>IO1 - Student Assessment Toolkit</option>
								<option value="IO2" <?php if ($wps=="IO2") echo "selected"?>>IO2 - Math Library</option>
								<option value="IO3" <?php if ($wps=="IO3") echo "selected"?>>IO3 - Community of Practice</option>
								<option value="ME" <?php if ($wps=="ME") echo "selected"?>>ME - Multiplier Events</option>
								<option value="PM" <?php if ($wps=="PM") echo "selected"?>>PM - Project Management</option>
							</select>
						</div>

						<p class="titpar"><?=strtoupper("Objectives of activities carried out")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst04" rows="" cols="" style="height: 250px;"><?=$objectives?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Description of activities carried out")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst06" rows="" cols="" style="height: 250px;"><?=$description?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Results Achieved")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst07" rows="" cols="" style="height: 250px;"><?=$outcomes?></textarea>
						</div>

						<!-- <p class="titpar"><?=strtoupper("Evaluation of the work undertaken")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst08" rows="" cols="" style="height: 250px;"><?=$evaluation?></textarea>
						</div> -->

						<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

					</form>

				</div> <!-- rsv_crp -->


		</div> <!-- cnt1 -->

	</div> <!-- container -->






<!-- INCOLLA END -->
<?php include('bottom.php'); ?>
