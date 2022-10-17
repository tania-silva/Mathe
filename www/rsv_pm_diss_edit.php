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
	$act=$_GET["act"];
	$act_id=$_GET["id_act"];
	$wps1=$_GET["wps"];
	$partner1=$_GET["partner"];

	if ($act=="edit") {

		$dis_id= $_POST["dis_id"];
		$qst00=$_POST["qst00"];
		$qst01=$_POST["qst01"];
		$qst02=Pulisci_INS($_POST["qst02"]);

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
		$qst06=Pulisci_INS($_POST["qst06"]);
		$qst07=Pulisci_INS($_POST["qst07"]);
		$qst08=Pulisci_INS($_POST["qst08"]);
		$qst081=Pulisci_INS($_POST["qst081"]);
		$qst09=Pulisci_INS($_POST["qst09"]);
		$qst11=Pulisci_INS($_POST["qst11"]);

		// Target Group information
		$qst06="key_";
		$sql = "SELECT * FROM db_TGR_app ORDER BY id_key";
		$result=mysqli_query($conn, $sql);

		while ($row=mysqli_fetch_array($result)) {
			$id_key=$row["id_key"];
			$keyword=$row["keyword"];

			if ($_POST["qst06_".$id_key]==$id_key) $qst06.=$id_key."_";
		}


		if (strlen($qst031)==1) $qst031="0".$qst031;
		if (strlen($qst032)==1) $qst032="0".$qst032;
		$data=$qst033.$qst032.$qst031;


		if ($qst00 && $qst01) $chk_status=1;

		if ($chk_status==1) {

			///////////////////////////////////////////////////////////
			/////////////// Registro su database MySql /////////////////

				$sql = "UPDATE `pm__dissemination` SET contact='$qst02', date_event_from='$qst02_1', date_event_to='$qst02_2', type_event='$qst04', type_event_other='$qst04_1',description='$qst05', target='$qst06', n_people='$qst07', held_in_town='$qst08', held_in_country='$qst081', outcomes='$qst09' WHERE id_dis='$dis_id'";
				$result=mysqli_query($conn, $sql);


		}

		//Redirect su messaggio
		$strpas11="./rsv_pm_diss.php?wps=".$wps1."&partner=".$partner1;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();

	} else {

		$sql = "SELECT * FROM pm__dissemination WHERE id_dis=".$act_id;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$dis_id=$row["id_dis"];
			$id_user=$row["id_user"];
			$id_partner=Pulisci_READ($row["id_partner"]);
			$data=$row["data"];
				$dt_gg=substr($data,6,2);
				$dt_mm=substr($data,4,2);
				$dt_aa=substr($data,0,4);
			$partner=Pulisci_READ($row["partner"]);
			$contact=Pulisci_READ($row["contact"]);
			$date_event=Pulisci_READ($row["date_event"]);
			$type_event=Pulisci_READ($row["type_event"]);
			$type_event_other=Pulisci_READ($row["type_event_other"]);
			$description=Pulisci_READ($row["description"]);
			$target=Pulisci_READ($row["target"]);
			$n_people=Pulisci_READ($row["n_people"]);
			$held_in_town=Pulisci_READ($row["held_in_town"]);
			$held_in_country=Pulisci_READ($row["held_in_country"]);
			$outcomes=Pulisci_READ($row["outcomes"]);
			$documents=Pulisci_READ($row["documents"]);

			if ($row["date_event_from"]!=0) {
				$period_from=$row["date_event_from"];
				$period_from_gg=substr($period_from, -2);
				$period_from_mm=substr($period_from, 4, 2);
				$period_from_aa=substr($period_from, 0,4);
				$period_from=$period_from_gg."/".$period_from_mm."/".$period_from_aa;
			} else $period_from="";

			if ($row["date_event_to"]!=0) {
				$period_to=$row["date_event_to"];
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

					<hr />
					<h1>Dissemination</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_diss.php">Dissemination</a> > Edit Document</p>
					<br>



					<form method="post" name="demoform" action="./rsv_pm_diss_edit.php?partner=<?=$partner1?>&act=edit" onreset="return confirm('Are you sure you want to reset the document?')">
						<input type="hidden" name="dis_id" value="<?=$dis_id?>" />
						<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />

						<p class="titpar">DISSEMINATION FORM</p>
						<div class="txt">
							Modify infomation about dissemination event then press "Send" button. Please <strong>write down your contents in a word document first and then copy and paste on this form</strong>. If you want to come back to the dissemination event list <a href="./rsv_pm_diss.php?partner=<?=$partner1?>">click here</a></a>
						</div>
						<br /><br />
						<hr>
						<p class="titpar"><?=strtoupper("Partners' Institution")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<input class="ar_inp01" type="text" name="qst01" value="<?=$ptn_name_func?>" readonly style="width: 500px;border: none;" />
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Name of the person involved in the event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst02" rows="" cols=""><?=$contact?></textarea>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Date of the event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							&nbsp;&nbsp;from: <input class="plain" name="dc1" value="<?=$period_from?>" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
							&nbsp;&nbsp;to: <input class="plain" name="dc2" value="<?=$period_to?>" onfocus="this.blur()" readonly style="width: 100px;border: solid 1px #999;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.demoform.dc1,document.demoform.dc2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="./impianto/addons/calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Type of Dissemination event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<select name="qst04">
								<option value="">Select Type of Dissemination</option>
								<option value="Training Seminar" <?php if ($type_event=="Training Seminar") echo "selected=\"selected\"";?>>Training Seminar</option>
								<option value="Transnational Meetings" <?php if ($type_event=="Transnational Meetings") echo "selected=\"selected\"";?>>Transnational Meetings</option>
								<option value="National Meeting" <?php if ($type_event=="National Meeting") echo "selected=\"selected\"";?>>National Meeting</option>
								<option value="Article in newspaper" <?php if ($type_event=="Article in newspaper") echo "selected=\"selected\"";?>>Article in newspaper</option>
								<option value="Article in magazine" <?php if ($type_event=="Article in magazine") echo "selected=\"selected\"";?>>Article in magazine</option>
								<option value="Conference or Fair" <?php if ($type_event=="Conference or Fair") echo "selected=\"selected\"";?>>Conference or Fair</option>
								<option value="Newsletters" <?php if ($type_event=="Newsletters") echo "selected=\"selected\"";?>>Newsletters</option>
								<option value="Article on website" <?php if ($type_event=="Article on website") echo "selected=\"selected\"";?>>Article on website</option>
								<option value="Informative Mailing" <?php if ($type_event=="Informative Mailing") echo "selected=\"selected\"";?>>Informative Mailing</option>
								<option value="Other" <?php if ($type_event=="Other") echo "selected=\"selected\"";?>>Other, please specify:</option>
							</select>
							<input type="text" name="qst04_1" value="<?=$type_event_other?>" class="ar_inp01" style="width: 450px;margin-top: 10px;" />
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Target group")?> <span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(specify the audience)</span></p>
						<div class="lbl023">
							<?php
							$sql = "SELECT * FROM db_TGR_app ORDER BY ord";
							$result=mysqli_query($conn, $sql);


							while ($row=mysqli_fetch_array($result)) {
								$id_key=$row["id_key"];
								$nome=$row["nome"];
								?>
									<em style="float: left;width: 180px;padding: 3px 0 0 0;font-weight: normal;"><input type="checkbox" name="qst06_<?=$id_key?>" value="<?=$id_key?>" <?php if (strrpos($target,"_".$id_key."_")) echo "checked=\"checked\"";?> /> <?=$nome?></em>
								<?php
							}
							?>
							<div class="clear"></div>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Number of people reached by event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<input style="width: 50px;" class="ar_inp01" type="text" name="qst07" value="<?=$n_people?>" />
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Held in")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							City: <input style="width: 250px;" class="ar_inp01" type="text" name="qst08" value="<?=$held_in_town?>" />
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
									<option value="<?=$id_stato?>" <?php if ($id_stato==$held_in_country) echo "selected=\"selected\"";?>> <?=$nome__stato?> (<?=strtoupper($sigla_stato2)?>)</option>
									<?php
								}

								?>
							</select>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Description of Dissemination Event")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst05" rows="" cols="" style="height: 250px; width: 350px;"><?=$description?></textarea>
						</div>
						<hr>
						<p class="titpar"><?=strtoupper("Outcomes, Results and Evaluation")?> <span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(follow-up actions to be taken etc.)</span></p>
						<div class="lbl023">
							<textarea name="qst09" rows="" cols="" style="height: 250px; width: 350px;"><?=$outcomes?></textarea>
						</div>

						<div class="lbl04" style="margin-bottom: 3%"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>
						<hr>
					</form>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
