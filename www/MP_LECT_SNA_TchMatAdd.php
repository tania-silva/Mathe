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

//////////////////////////////////   sanitize var $_get e $_post /////////////////////
$DS=DIRECTORY_SEPARATOR;
$root=".".$DS;
//require_once($root."lib".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
//require_once($root."lib".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
require_once($root."lib".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."lib".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////

$validateValue=0;
if (isset($_POST['examine'])) $validateValue=4;

if ($_GET["act"]=="reg" AND $usrId) {

	$_SESSION['post_data']=$_POST;

	$videoTitle=Pulisci_INS($_POST["videoTitle"]);
	$videoAuthor=Pulisci_INS($_POST["videoAuthor"]);
	$videoDescription=Pulisci_INS($_POST["videoDescription"]);
	$videoLink=Pulisci_INS($_POST["videoLink"]);


	// Type of Product
	$videoType="key_";
	$sql = "
		SELECT * 
		FROM db_tch_app 
		ORDER BY id_key";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id_key"];
		$keyword=$row["keyword"];
		
		if ($_POST["videoType_".$id_key]==$id_key) $videoType.=$id_key."_";
	}

	// Language
	$videoLang="key_";
	$sql = "
		SELECT * 
		FROM VID_lang 
		ORDER BY id_key";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id_key"];
		$keyword=$row["keyword"];
		
		if ($_POST["videoLang_".$id_key]==$id_key) $videoLang.=$id_key."_";
	}


	$checkStatus=0;
	if (
		$usrId AND 
		$usrTypology=="lecturer" AND 
		$usr_completeProfile==1 AND 
		$videoTitle AND 
		$videoAuthor AND 
		$videoDescription AND 
		($videoLink OR $_FILES['filex']) AND 
		$videoLang!="key_"
	) $checkStatus=1;

	if ($checkStatus) {

		/* Registro il nuovo video */

		$date=Date("Y-m-d H:i:s");
		$validate=0;

		$sql = "
			INSERT INTO `platform__SNA__tchmaterials` 
			(`id_lect`, `title`, `author`, `type`, `description`, `link`, `languages`, `date`, `validate`)  
			VALUES ('$usrId', '$videoTitle', '$videoAuthor', '$videoType', '$videoDescription', '$videoLink', '$videoLang', '$date', '$validateValue')";
		$result=mysqli_query($conn,$sql);
		$videoId=mysqli_insert_id($conn);

		// Upload document
//		print_r($_FILES["filex"]);
//		$check= new CheckUpload($_FILES["filex"]);
//		if ($check->isOk()) {
			// Upload dell'allegato
			//$path=ereg_replace("MP_LECT_SNA_TchMatAdd.php","",$_SERVER["PATH_TRANSLATED"]);
			$upload_dir = "./data/mathePlatform/SNA/tchMaterials"; 
			$fileName=$_FILES['filex']['name'];
			$file_ext = pathinfo($_FILES['filex']['name'], PATHINFO_EXTENSION);
			$file_name = $videoId.".".$file_ext;

			move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name); 
			chmod($upload_dir."/".$file_name, 0777);

			$sql = "
				UPDATE `platform__SNA__tchmaterials` 
				SET 
					file_name='$fileName',
					file_ext='$file_ext'
				WHERE id=$videoId";
			$result=mysqli_query($conn,$sql);
//		}

		$redirectUrl="./MP_LECT_SNA_TchMatAdd1.php?idVideo=".$videoId;

	} else $redirectUrl="./MP_LECT_SNA_TchMatAdd.php?msg=KO";

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
}
?>
	<script type="text/x-mathjax-config">
	  MathJax.Hub.Config({
		tex2jax: {
		  inlineMath: [ ['$','$'], ["\\(","\\)"] ],
		  processEscapes: true
		}
	  });
	</script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
	<script type="text/javascript">
		function doPreview(mode,source) {
		  var textAreaId = source;
		  var previewAreaId = source+"Preview";
		  var previewAreaBlk = source+"PreviewBlk";
		  
//		  if (!getElementPreview(textAreaId) || !getElementPreview(previewAreaId)) {
//			return;
//		  } else if (mode == 'init') {
//			getElementPreview(previewAreaId).innerHTML = 'Preview Area';
//			return;
//		  }

			if (document.getElementById(previewAreaBlk).style.display=='block') {
				//document.getElementById(previewAreaBlk).style.display='none';
			} else {
				document.getElementById(previewAreaBlk).style.display='block';
			}
			var s = getStringPreview(textAreaId);

			if (getElementPreview(previewAreaId)) {
				getElementPreview(previewAreaId).innerHTML = s;
			}
			MathJax.Hub.Queue(["Typeset",MathJax.Hub],previewAreaId);
					  
		}

		function getStringPreview(e) {
		  var s = '';
		  s = nl2br(getElementPreview(e).value);
//		  s = s.split('&').join('&amp;');
//		  s = s.split('<').join('&lt;');
//		  s = s.split('>').join('&gt;');
//		  s = s.split('\'').join('&#92;');
		  return s;
		}

		function getElementPreview(e, f) {
		  var l = (document.layers) ? 1 : 0;
		  if(l) {
			f=(f) ? f : self;
			var a = f.document.layers;
			if (a[e]) return a[e];
			  for (var w = 0; w < a.length;) {
			  return getElementPreview(e, a[w++]);
			}
		  }
		  if (document.all) return document.all[e];
		  return document.getElementById(e);
		}

		function nl2br (str, is_xhtml) {
		  // http://kevin.vanzonneveld.net
		  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		  // +   improved by: Philip Peterson
		  // +   improved by: Onno Marsman
		  // +   improved by: Atli Þór
		  // +   bugfixed by: Onno Marsman
		  // +      input by: Brett Zamir (http://brett-zamir.me)
		  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		  // +   improved by: Brett Zamir (http://brett-zamir.me)
		  // +   improved by: Maximusya
		  // *     example 1: nl2br('Kevin\nvan\nZonneveld');
		  // *     returns 1: 'Kevin<br />\nvan<br />\nZonneveld'
		  // *     example 2: nl2br("\nOne\nTwo\n\nThree\n", false);
		  // *     returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
		  // *     example 3: nl2br("\nOne\nTwo\n\nThree\n", true);
		  // *     returns 3: '<br />\nOne<br />\nTwo<br />\n<br />\nThree<br />\n'
		  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

		  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
		}

		//doPreview('init');
	</script>

					<p class="rsvPage_Title">Insert New Teaching Material</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" action="./MP_LECT_SNA_TchMatAdd.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Title of the teaching material</label>
							<textarea name="videoTitle" id="videoTitle" style="height: 50px;" required /></textarea>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Author of the teaching material</label>
							<textarea name="videoAuthor" id="videoAuthor" required /></textarea>
						</div>
 
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Type of Product</label>
							<div class="lbl023">
								<?php
								$sql = "SELECT * FROM db_tch_app ORDER BY nome";
								$result=mysqli_query($conn, $sql);


								while ($row=mysqli_fetch_array($result)) {
									$id_key = $row["id_key"];
									$nome = $row["nome"];
									?>
										<em style="float: left;width: 250px;padding: 3px 0 0 0;font-weight: normal;"><input type="checkbox" style="float: left;width: 10px;height: 10px;margin: 1px 5px 5px 0;" name="videoType_<?=$id_key?>" value="<?=$id_key?>" <?php if (strrpos($videoType,"_".$id_key."_")) echo "checked=\"checked\"";?> /> <?=$nome?></em>
									<?php
								}
								?>
								<div class="clear"></div>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Description</label>
							<span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please describe the main contents of the teaching material using 20 to 50 words</span>
							<textarea name="videoDescription" id="videoDescription" style="height: 100px;" required /></textarea>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Language(s)</label>
							<div class="data" style="padding: 0 0 0 25px;">
								<?php 
								$sql = "
									SELECT * 
									FROM VID_lang 
									ORDER BY ord";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$id_key=$row["id_key"];
									$nome=$row["nome"];
									?>
										<p style="float: left;width: 100px;padding: 10px 0 0 0;font-weight: normal;"><input type="checkbox" style="float: left;width: 10px;height: 10px;margin: 1px 0 0 0;" name="videoLang_<?=$id_key?>" value="<?=$id_key?>" <?php if (strrpos($videoLang,"_".$id_key."_")) echo "checked=\"checked\"";?> /> <label class="radiobutt" style="float: left;margin: -9px 0 0 0;" ><?=$nome?></label></p>
									<?php 
								}
								?>
							</div>
						</div>
						<div class="clear"></div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Upload</label>
							<span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Upload the created teaching material</span>
							<input type="file" name="filex" />
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Link</label>
							<span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If available on the Internet put the link</span>
							<textarea name="videoLink" id="videoLink" style="height: 50px;" /></textarea>
						</div>

						<div class="signup_submit" style="width: 240px;margin: 25px auto;">
							<a href="./MP_LECT_SNA_TchMatManage.php<?=$queryStr?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
							<input type="submit" value="Proceed" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
						</div>


						<!-- <div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_SNA_TchMatManage.php<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 100px;padding: 5px;" />
							<input type="submit" name="examine" value="SEND FOR VALIDATION" class="proceed" style="width: 250px;margin-left: 5px;padding: 5px;" />
						</div> -->



					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>