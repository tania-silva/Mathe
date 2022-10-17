<?php include('top.php'); ?>
	<!-- Calendar -->
	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="./impianto/addons/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






<?php

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
	require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
	////////////////////////////////////////////////////
	$act=isset($_GET["act"]) ? isset($_GET["act"]) : '';

	if ($act=="reg") {

		$qst00=$_POST["qst00"];
		$qst01=$_POST["qst01"];
		$qst02=$_POST["qst02"];

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

		$qst04=Pulisci_INS($_POST["qst04"]);
		$qst04_1=Pulisci_INS($_POST["qst04_1"]);
		$qst05=Pulisci_INS($_POST["qst05"]);
		$qst06=Pulisci_INS($_POST["qst06"]); //Target Group
		$qst07=Pulisci_INS($_POST["qst07"]);
		$qst08=Pulisci_INS($_POST["qst08"]);
		$qst081=Pulisci_INS($_POST["qst081"]);
		$qst09=Pulisci_INS($_POST["qst09"]);
		$qst10=Pulisci_INS($_POST["qst10"]);
		$qst11=Pulisci_INS($_POST["qst11"]);

		if (strlen($qst031)==1) $qst031="0".$qst031;
		if (strlen($qst032)==1) $qst032="0".$qst032;
		$data=$qst033.$qst032.$qst031;

		// Target Group additional information //daniele chiedere delucidazioni su questa variabile
		$qst06 = "key_";
		$sql = "SELECT * FROM db_TGR_app ORDER BY id_key";
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$id_key=$row["id_key"];
			$keyword=$row["keyword"];

			if ($_POST["qst06_".$id_key]==$id_key) $qst06.=$id_key."_";
		}


		if ($qst00 && $qst01) $chk_status=1;

		if ($chk_status==1) {

			///////////////////////////////////////////////////////////
			/////////////// Registro su database MySql /////////////////

				$sql = "INSERT INTO `pm__dissemination` (`id_user` , `id_partner` , `partner` , `contact` , `date_event_from` , `date_event_to` , `type_event` , `type_event_other` , `description` , `target` , `n_people` , `held_in_town` , `held_in_country` , `outcomes`)  VALUES ('$qst00', '$qst11', '$qst01', '$qst02', '$qst02_1','$qst02_2',  '$qst04', '$qst04_1', '$qst05', '$qst06', '$qst07', '$qst08', '$qst081', '$qst09')";
				$result=mysqli_query($conn, $sql);

				$id_act=mysqli_insert_id($conn);

			//Redirect su messaggio
			$strpas11="./rsv_pm_diss_upload.php?id_act={$id_act}";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();

		} else {

			//Redirect su messaggio
			$strpas11="./rsv_pm_diss.php";
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

					<hr />
					<h1>Dissemination</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_diss.php">Dissemination</a> > Insert new Document</p>
					<br>



					<form method="post" name="demoform" action="./rsv_pm_diss_new.php?act=reg" onreset="return confirm('Are you sure you want to reset the document?')">
						<input type="hidden" name="qst00" value="<?=$id_user?>" />
						<input type="hidden" name="qst11" value="<?=$id_partner?>" />

						<p class="titpar">ACTIVITIES REPORT FORM</p>
						<div class="txt">
							Fill in infomation about dissemination event then press "Send" button. Please <strong>write down your contents in a word document first and then copy and paste on this form</strong>. If you want to see all the dissemination event yet uploaded <a href="./rsv_pm_diss.php">click here</a>
						</div>
						<br /><br />

						<p class="titpar"><?=strtoupper("Partners' Institution")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<input class="ar_inp01" type="text" name="qst01" value="<?=$ptn_name_func?>" readonly style="width: 500px;border: none;" />
						</div>

						<p class="titpar"><?=strtoupper("Name of the person involved in the event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst02" rows="" cols=""></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Date of the event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							&nbsp;&nbsp;from: <input class="plain" name="dc1" value="" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							&nbsp;&nbsp;to: <input class="plain" name="dc2" value="" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>

						<p class="titpar"><?=strtoupper("Type of Dissemination event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<select name="qst04">
								<option value="">Select Type of Dissemination</option>
								<option value="Training Seminar">Training Seminar</option>
								<option value="Transnational Meetings">Transnational Meetings</option>
								<option value="National Meeting">National Meeting</option>
								<option value="Article in newspaper">Article in newspaper</option>
								<option value="Article in magazine">Article in magazine</option>
								<option value="Conference or Fair">Conference or Fair</option>
								<option value="Newsletters">Newsletters</option>
								<option value="Article on website">Article on website</option>
								<option value="Informative Mailing">Informative Mailing</option>
								<option value="Other">Other, please specify:</option>
							</select>
							<input type="text" name="qst04_1" class="ar_inp01" style="width: 450px;margin-top: 10px;" />
						</div>

						<p class="titpar"><?=strtoupper("Target group")?> <span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(specify the audience)</span></p>
						<div class="lbl023">
							<?php
							$sql = "SELECT * FROM db_TGR_app ORDER BY ord";
							$result=mysqli_query($conn, $sql);


							while ($row=mysqli_fetch_array($result)) {
								$id_key = $row["id_key"];
								$nome = $row["nome"];
								?>
									<em style="float: left;width: 180px;padding: 3px 0 0 0;font-weight: normal;"><input type="checkbox" name="qst06_<?=$id_key?>" value="<?=$id_key?>" <?php if (strrpos($qst06,"_".$id_key."_")) echo 'checked="checked"';?> /> <?=$nome?></em>
								<?php
							}
							?>
							<div class="clear"></div>
						</div>

						<p class="titpar"><?=strtoupper("Number of people reached by event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<input style="width: 50px;" class="ar_inp01" type="text" name="qst07" />
						</div>

						<p class="titpar"><?=strtoupper("Held in")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							City: <input style="width: 250px;" class="ar_inp01" type="text" name="qst08" />
							<select name="qst081" style="width: 200px;">
								<option value="">Choose Country</option>
								<?php
								$sql = "
									SELECT *
									FROM countries
									ORDER BY name";
								$result=mysqli_query($conn, $sql);


								while ($row=mysqli_fetch_array($result)) {
									$id_stato=$row["id"];
									$sigla_stato2=$row["alpha_2"];
									$sigla_stato3=$row["alpha_3"];
									$nome__stato=$row["name"];
									?>
									<option value="<?=$id_stato?>"> <?=$nome__stato?> (<?=strtoupper($sigla_stato2)?>)</option>
									<?php
								}

								?>
							</select>
						</div>

						<p class="titpar"><?=strtoupper("Description of Dissemination Event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst05" rows="" cols="" style="height: 250px;"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Outcomes and Results")?> <span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(follow-up actions to be taken etc.)</span></p>
						<div class="lbl023">
							<textarea name="qst09" rows="" cols="" style="height: 250px;"></textarea>
						</div>







						<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

					</form>









			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
