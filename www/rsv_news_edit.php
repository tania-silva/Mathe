	<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_time.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="./impianto/addons/calendar1/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>
<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






<?php

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
//	require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
//	require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
	require_once($root."librerie".$DS."upload".$DS."conf".$DS."config.php");
	require_once($root."librerie".$DS."upload".$DS."classes".$DS."class.check.php");
	////////////////////////////////////////////////////
	$act=isset($_GET["act"]) ? $_GET["act"] : '';
	$act_id=isset($_GET["id_act"]) ?$_GET["id_act"] : '';
	$wps1=isset($_GET["wps"]) ? $_GET["wps"] : '';
	$partner1=isset($_GET["partner"]) ? $_GET["partner"] : '';

	if ($act=="edit") {

		////////////////////////////////////////////////////
		$nwsTitle=Pulisci_INS($_POST["qst01"]); // Title
		$text=Pulisci_INS($_POST["qst02"]); // Text
			$dt_emissione01=explode("/",$_POST["dc"]);
			$dt_emissione_gg=$dt_emissione01[0];
			$dt_emissione_mm=$dt_emissione01[1];
			$dt_emissione02=explode(" ",$dt_emissione01[2]);
			$dt_emissione_aa=$dt_emissione02[0];
			$dt_emissione_ora=$dt_emissione02[1].":00";
		$date=$dt_emissione_aa."-".$dt_emissione_mm."-".$dt_emissione_gg." ".$dt_emissione_ora;

		if ($nwsTitle AND $text AND $_SESSION["usr_level"]==5) $chk_status=1;

		if ($chk_status==1) {

			///////////////////////////////////////////////////////////
			/////////////// Registro su database MySql /////////////////

				$sql = "UPDATE `news` SET
					title='$nwsTitle',
					text='$text',
					date='$date'
					WHERE id='$act_id'";
				$result=mysqli_query($conn, $sql);


			// Upload document
			$check= new CheckUpload($_FILES["filex"]);
			if ($check->isOk()) {
				$check=new CheckUpload($_FILES["filex"]);
				$path=preg_replace("rsv_news_edit.php","",$_SERVER["PATH_TRANSLATED"]);

				$nome_file=Pulisci_INS($_FILES['filex']['name']);
				$estensione = strtolower(substr($nome_file, strrpos($nome_file, "."), strlen($nome_file)-strrpos($nome_file, ".")));
				$estensione = substr($estensione,1);

				$upload_dir = $path."./data";
				$file_name = $act_id.".jpg";
				if ($estensione=="jpg") {
					move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name);
					chmod($upload_dir."/".$file_name, 0777);



					$upload_dir = $path."./data/news";

					// Immagine normale
					$file_name_big = $act_id."_big.jpg";
					resize($file_name, $upload_dir, '500');
					chmod($upload_dir."/".$file_name, 0777);
					rename($upload_dir."/".$file_name,$upload_dir."/".$file_name_big);

					// Immagine small
					$file_name_small = $act_id."_ico.jpg";
					$img_width="170";
					resize($file_name, $upload_dir, $img_width);
					chmod($upload_dir."/".$file_name, 0777);
					rename($upload_dir."/".$file_name,$upload_dir."/".$file_name_small);

					if(file_exists("../data/".$file_name)) unlink("../data/".$file_name);

				}
			}

		}

		//Redirect su messaggio
		$strpas11="./rsv_news.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();

	} else {

		$sql = "SELECT * FROM news WHERE id=".$act_id;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$pict_id=$row["id"];
			$nwsTitle=stripslashes($row["title"]);
			$text=stripslashes($row["text"]);
			$date=$row["date"];
		}

		if ($date!="" AND $date!="0000-00-00 00:00:00") {
			$fatt_data_expl=explode("-",$date);
			$fatt_data_aa=$fatt_data_expl[0];
			$fatt_data_mm=$fatt_data_expl[1];
			$fatt_data_expl1=explode(" ",$fatt_data_expl[2]);
			$fatt_data_gg=$fatt_data_expl1[0];
			$fatt_data_expl2=explode(":",$fatt_data_expl1[1]);
			$fatt_data_ora=$fatt_data_expl2[0];
			$fatt_data_min=$fatt_data_expl2[1];
			$date=$fatt_data_gg."/".$fatt_data_mm."/".$fatt_data_aa." ".$fatt_data_ora.":".$fatt_data_min;
		} else $date="";


		$pict="./data/news/".$pict_id."_ico.jpg";
	}

?>
					<hr />

					<?php if ($_SESSION["usr_level"]==5) {  ?>


						<h1>News</h1>
						<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_news.php">News</a> > Edit News</p>
						<br>

						<form method="post" name="demoform" action="./rsv_news_edit.php?partner=<?=$partner1?>&id_act=<?=$act_id?>&act=edit" enctype="multipart/form-data" onreset="return confirm('Are you sure you want to reset the document?')">
							<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />

							<p class="titpar">NEWS FORM</p>
							<div class="txt">
								Modify infomation about news then press "Send" button. Please <strong>write down your contents in a word document first and then copy and paste on this form</strong>. If you want to come back to the news list <a href="./rsv_news.php?partner=<?=$partner1?>">click here</a></a>
							</div>
							<br /><br />

							<p class="titpar"><?=strtoupper("Date")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<input class="plain" name="dc" value="<?=$date?>" size="19" onfocus="this.blur()" readonly style="width: 140px;padding: 2px;border: solid 1px #999;" readonly /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc);return false;" ><img name="popcal" align="absmiddle" src="./impianto/addons/calendar1/calbtn.gif" width="34" height="22" border="0" alt="" style="margin: 0 0 0 5px;"></a>
							</div>

							<p class="titpar"><?=strtoupper("Title of News")?> <em style="font-weight: 400;font-style: normal;color: #c00;">* Required</em><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<textarea name="qst01" rows="" cols="" style="height: 50px;width: 350px;"><?=$nwsTitle?></textarea>
							</div>

							<p class="titpar"><?=strtoupper("Text")?> <em style="font-weight: 400;font-style: normal;color: #c00;">* Required</em><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<?php
									$CKEditor = new CKEditor();
									$CKEditor->config['width'] = 600;
									$CKEditor->config['height'] = 350;

									$config = array();
									$config['language'] = 'en';
									$config['skin'] = 'kama';
									$config['toolbarCanCollapse'] = true;
									$config['toolbarStartupExpanded'] = true;
									//$config['removePlugins'] = 'elementspath';
									$config['toolbar'] = 'Pinzani';
									$CKEditor->editor("qst02", $text, $config);
								?>
								<!-- <textarea name="qst02" rows="" cols="" style="height: 250px;"><?=$text?></textarea> -->
							</div>

							<p class="titpar"><?=strtoupper("Image")?> (JPG format) <em style="font-weight: 400;font-style: normal;color: #c00;">* Required</em><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<?php if (file_exists($pict)) {?><img src="<?=$pict?>?rnd=<?=$rand_n?>" width="100" alt="" style="float: right;margin: 0 50px 0 0;" /><?php }?>
								<input type="file" name="filex" />
								<p><em>Please upload a jpeg format.</em></p>
								<div class="clear"></div>
							</div>


							<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

						</form>

					<?php } else { ?>
						<?php include('./impianto/inc/sorry.php'); //PIEDE?>
					<?php } ?>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
