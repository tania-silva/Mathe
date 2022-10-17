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
	require_once($root."librerie".$DS."sanitize".$DS."sanitize.lib.php");
	require_once($root."librerie".$DS."upload".$DS."conf".$DS."config.php");
	require_once($root."librerie".$DS."upload".$DS."classes".$DS."class.check.php");
	$var_get=array(
			'id_act'=>'int',
			'id_name'=>'sql',
			'wps'=>'sql',
			'partner'=>'sql'
	);
	if ($_GET["id_act"]){
		sanitize($_GET, $var_get);
		sanitize($_POST, $var_get);
	}
	$id_act = $_GET["id_act"];
	$id_name = $_GET["id_name"];
	$wps=$_GET["wps"];
	$partner=$_GET["partner"];

	if ($_SESSION["id_user"]) {

		// Ricavo i dati relativi al documento

		$sql = "SELECT * FROM pm__dissemination WHERE id_dis=".$id_act;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$id_partner1=Pulisci_READ($row["id_partner"]);
			$data=$row["data"];
				$dt_gg=substr($data,6,2);
				$dt_mm=substr($data,4,2);
				$dt_aa=substr($data,0,4);
			$contact=Pulisci_READ($row["contact"]);
			$date_event=Pulisci_READ($row["date_event"]);
			$type_event=Pulisci_READ($row["type_event"]);
			$type_event_other=Pulisci_READ($row["type_event_other"]);
			$description=Pulisci_READ($row["description"]);
			$target=Pulisci_READ($row["target"]);
			$n_people=Pulisci_READ($row["n_people"]);
			$held_in=Pulisci_READ($row["held_in"]);
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
			$id_partner=Pulisci_READ($row["id_partner"]);
			$usr_level=Pulisci_READ($row["usr_level"]);
		}

		$par_permit="off";
		if ($usr_level==5) $par_permit="on";
		elseif ($id_partner==$id_partner1 AND $usr_level>=2) $par_permit="on";

	}

?>
	<!-- Calendar -->
	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="./impianto/addons/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>

					<hr />
					<h1>Dissemination</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_diss.php">Dissemination</a> > Edit Document</p>
					<br>

					<?php if ($par_permit=="on") {

						////////////////////////////////////////////////////
						// INVIO ALLEGATO
						$check= new CheckUpload($_FILES["filex"]);
						if ($check->isOk() )  {
							// CERCO IL NUMERO PROGRESSIVO
							//$path=ereg_replace("rsv_pm_diss_upload.php","",$_SERVER["PATH_TRANSLATED"]);

			//				$id_art="52";
			//				$num_prg=1;
							$upload_dir = "./data/dissemination";
							$file_ext = strtolower(substr($_FILES["filex"]['name'],-3));
			//				$file_name = $id_art."_".$num_prg.".".$file_ext;
							$file_name = $id_act."_".$_FILES["filex"]['name'];

			//				if($file_ext=="doc") {
								move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name);
								chmod($upload_dir."/".$file_name, 0777);
			//				}
			//				else {
			//					echo "Formato del file non consentito";
			//				}

						}else {
							if (is_uploaded_file($_FILES["filex"]["tmp_name"]))
								echo("<font color='red'>".$check->getLog()."</font>");
						}

						if ($id_name) { // CANCELLO IL FILE
							if(file_exists("./data/dissemination/".$id_name)) unlink("./data/dissemination/".$id_name);
						}

						?>

						<form method="post" enctype="multipart/form-data" action="./rsv_pm_diss_upload.php?id_act=<?=$id_act?>&partner=<?=$partner?>">
							<input type="hidden" name="qst00" value="<?=$id_user?>" />
							<input type="hidden" name="qst11" value="<?=$id_partner?>" />

							<p class="titpar">DISSEMINATION FORM</p>
							<div class="txt">
								The document you have to upload can't be bigger than 1.5 Mb<br /> You can upload more than one document but one by one.</a><br /><strong>When you have done <a href="./rsv_pm_diss.php?partner=<?=$partner?>"><img src="./impianto/img/confirm.gif" width="108" height="24" alt="click here" style="vertical-align: middle;" /></a></strong>
							</div>
						<hr>
							<p class="titpar"><?=strtoupper("Supporting Documents")?> <span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(e.g. photos; videos etc.)</span></p>
							<input type="file" size="20" name="filex" style="font: 8pt tahoma #444;border: solid 1px #666;">&nbsp;<input type="submit" value=" Send document " style="font: 8pt tahoma #444;border: solid 1px #666;">

						</form>


						<br />
						<p>List of supporting documents available:</p>
						<div><?php dir_list_diss("./data/dissemination",$id_act); ?></div>



					<?php } else { ?>
						<?php include('./impianto/inc/sorry.php'); //PIEDE?>
					<?php } ?>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>

<?php

function dir_list_diss($directory = FALSE,$id) {

	$dirs= array();
	$files = array();

	if ($handle = opendir("./" . $directory)) {
		while ($file = readdir($handle)) {
			if (is_dir("./{$directory}/{$file}")) {
				if ($file != "." & $file != "..") $dirs[] = $file;
			}
			else {
				$silly=explode("_", $file);
				if ($silly[0]==$id) {
					if ($file != "." & $file != "..") $files[] = str_replace($silly[0]."_","",$file);
				}
			}
		}
	}
	closedir($handle);

	reset($files);
	sort($files);
	reset($files);

	$count=1;
	while(list($key, $value) = each($files)) {
		echo "<p style=\"margin: 5px 0 5px; 0;\">{$count}. <a href=\"{$directory}/{$id}_{$value}\" onclick=\"this.target='_blank'\">{$value}</a> - [<a href=\"./rsv_pm_diss_upload.php?id_act={$id}&id_name={$id}_{$value}\" style=\"color: #990000;\">delete <img src=\"./impianto/img/delete.jpg\" style=\"border: none;width: 16px;height: 16px;vertical-align: middle;\"/></a>]<p>";
		$count++;
	}

	if (!$d) $d = "0";
	if (!$f) $f = "0";
}

?>
