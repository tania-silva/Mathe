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
	require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
	require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
	require_once($root."librerie".$DS."upload".$DS."conf".$DS."config.php");
	require_once($root."librerie".$DS."upload".$DS."classes".$DS."class.check.php");

	////////////////////////////////////////////////////
	$act=isset($_GET["act"]) ? $_GET["act"] : '';

	if ($act=="reg") {

		////////////////////////////////////////////////////
		$title=trim(Pulisci_INS($_POST["qst01"])); // Title
		$text=trim(Pulisci_INS($_POST["qst02"])); // Text
		$link=trim(Pulisci_INS($_POST["qst03"])); // Text

		if ($title AND $text AND $link AND $_SESSION["usr_level"]==5) $chk_status=1;

		if ($chk_status==1) {

			///////////////////////////////////////////////////////////
			/////////////// Registro su database MySql /////////////////

			$sql = "INSERT INTO `press`
				(`title` , `text` , `link`)  VALUES
				('$title', '$text', '$link')";
			$result=mysqli_query($conn, $sql);

			$id_act=mysqli_insert_id($conn);

			// Upload document
			$check= new CheckUpload($_FILES["filex"]);
			if ($check->isOk()) {
				$check=new CheckUpload($_FILES["filex"]);
				//$path=preg_replace("rsv_press_new.php","",$_SERVER["PATH_TRANSLATED"]);

				$nome_file=$_FILES['filex']['name'];
				$estensione = strtolower(substr($nome_file, strrpos($nome_file, "."), strlen($nome_file)-strrpos($nome_file, ".")));
				$estensione = substr($estensione,1);

				$upload_dir = "./data";
				$file_name = $id_act.".jpg";
				if ($estensione=="jpg") {
					move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name);
					chmod($upload_dir."/".$file_name, 0777);

					$upload_dir = "./data/press";

					// Immagine normale
					$file_name_big = $id_act."_big.jpg";
					resize($file_name, $upload_dir, '900');
					chmod($upload_dir."/".$file_name, 0777);
					rename($upload_dir."/".$file_name,$upload_dir."/".$file_name_big);

					// Immagine small
					$file_name_small = $id_act."_ico.jpg";
					$img_width="170";
					resize($file_name, $upload_dir, $img_width);
					chmod($upload_dir."/".$file_name, 0777);
					rename($upload_dir."/".$file_name,$upload_dir."/".$file_name_small);

					if(file_exists("./data/".$file_name)) unlink("./data/".$file_name);
				}
			}

			//Redirect su messaggio
			$strpas11="./rsv_press.php";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();

		} else {
			
			//Redirect su messaggio
			$strpas11="./rsv_press_new.php?msgok=ko0";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();
		}
	}

?>
	<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_time.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="./impianto/addons/calendar1/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>
					<hr />

					<?php if ($_SESSION["usr_level"]==5) {  ?>


						<h1>Press Review</h1>
						<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_press.php">Press Review</a> > Insert Press Review</p>
						<br>

						<form method="post" name="demoform" action="./rsv_press_new.php?act=reg" enctype="multipart/form-data" onreset="return confirm('Are you sure you want to reset the document?')">

							<p class="titpar">PRESS REVIEW FORM</p>
							<div class="txt">
								Fill in infomation about Press Review then press "Send" button. Please <strong>write down your contents in a word document first and then copy and paste on this form</strong>. If you want to see all the Press Reviews yet uploaded <a href="./rsv_press.php">click here</a>
							</div>
							<br /><br />

							<?php if (isset($_GET["msgok"]) && $_GET["msgok"]=="ko0") { ?>

								<div style=" width: 350px;margin: 0 auto 20px auto;font-size: 1.3em;font-weight: 400;text-align: center;border: solid 4px #c00;">
									Sorry, the document was not uploaded.<br />Try again and pay attention to the required fields.
								</div>
							<?php }?>

							<p class="titpar"><?=strtoupper("Title of Press")?> <em style="font-weight: 400;font-style: normal;color: #c00;">* Required</em><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<textarea name="qst01" rows="" cols="" style="height: 50px;"></textarea>
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
									$CKEditor->editor("qst02", "", $config);
								?>
								<!-- <textarea name="qst02" rows="" cols="" style="height: 250px;"></textarea> -->
							</div>

							<p class="titpar"><?=strtoupper("Link")?> <em style="font-weight: 400;font-style: normal;color: #c00;">* Required</em><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<textarea name="qst03" rows="" cols="" style="height: 50px;"></textarea>
							</div>

							<p class="titpar"><?=strtoupper("Image")?> (JPG format) <em style="font-weight: 400;font-style: normal;color: #c00;">* Required</em><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
							<div class="lbl023">
								<input type="file" name="filex" />
								<p><em>Please upload a jpeg format.</em></p>
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
