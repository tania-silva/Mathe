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

$vidId=$_GET["id_act"];
$page=$_GET["page"];
if (!$page) $page=1;
$srcValidation=$_GET["srcValidation"];
$queryStr="page={$page}&srcValidation={$srcValidation}";


if ($_GET["act"]=="reg" AND $vidId) {

	$_SESSION['post_data']=$_POST;

	$videoTitle=Pulisci_INS($_POST["videoTitle"]);
	$videoAuthor=Pulisci_INS($_POST["videoAuthor"]);
	$videoDescription=Pulisci_INS($_POST["videoDescription"]);
	$videoLink=Pulisci_INS($_POST["videoLink"]);
	$delAttach=Pulisci_INS($_POST["delAttach"]);

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
		$videoLink AND 
		$videoLang!="key_"
	) $checkStatus=1;

	if ($checkStatus) {

		/* Modifico il video */
		$sql = "
			UPDATE `platform__SNA__VID_lessons` 
			SET 
				title='$videoTitle', 
				author='$videoAuthor', 
				description='$videoDescription', 
				link='$videoLink', 
				languages='$videoLang', 
				validate='$validateValue'
			WHERE id=$vidId";
		$result=mysqli_query($conn,$sql);

//		if ($delAttach) {
//			// Cancello il file allegato
//			$sql = "
//				SELECT *
//				FROM platform__SNA__VID_lessons 
//				WHERE (id='$vidId' AND id_lect=$usrId) 
//				LIMIT 1";
//			$result=mysqli_query($conn,$sql);
//
//			while ($row=mysqli_fetch_array($result)) { 
//				$fileExt=$row["file_ext"];
//			}
//			
//			$sql = "
//				UPDATE `platform__SNA__VID_lessons` 
//				SET 
//					file_ext=''
//				WHERE id=$vidId";
//			$result=mysqli_query($conn,$sql);
//
//			// Cancello il file associato
//			$pict="./data/mathePlatform/SNA/vdLessons/{$vidId}.{$fileExt}";
//			if(file_exists($pict)) unlink($pict);
//		}

//		// Upload document
//		$check= new CheckUpload($_FILES["filex"]);
//		if ($check->isOk()) {
//
//			// Cancello il vecchio file allegato
//			$sql = "
//				SELECT *
//				FROM platform__SNA__VID_lessons 
//				WHERE (id='$vidId' AND id_lect=$usrId) 
//				LIMIT 1";
//			$result=mysqli_query($conn,$sql);
//
//			while ($row=mysqli_fetch_array($result)) { 
//				$fileExt=$row["file_ext"];
//			}
//			
//			$sql = "
//				UPDATE `platform__SNA__VID_lessons` 
//				SET 
//					file_ext=''
//				WHERE id=$vidId";
//			$result=mysqli_query($conn,$sql);
//
//			// Cancello il file associato
//			$pict="./data/mathePlatform/SNA/vdLessons/{$vidId}.{$fileExt}";
//			if(file_exists($pict)) unlink($pict);
//
//			// Upload del nuovo allegato
//			//$path=ereg_replace("MP_LECT_SNA_videoLesEdit.php","",$_SERVER["PATH_TRANSLATED"]);
//			$upload_dir = "./data/mathePlatform/SNA/vdLessons"; 
//			$fileName=$_FILES['filex']['name'];
//			$file_ext = pathinfo($_FILES['filex']['name'], PATHINFO_EXTENSION);
//			$file_name = $vidId.".".$file_ext;
//
//			move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name); 
//			chmod($upload_dir."/".$file_name, 0777);
//
//			$sql = "
//				UPDATE `platform__SNA__VID_lessons` 
//				SET 
//					file_ext='$file_ext'
//				WHERE id=$vidId";
//			$result=mysqli_query($conn,$sql);
//
//		}
		
		$redirectUrl="./MP_LECT_SNA_videoLesManage.php?".$queryStr;

	} else $redirectUrl="./MP_LECT_SNA_videoLesEdit.php?msg=KO&".$queryStr;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

} else {

	$sql = "
		SELECT *, p.id AS vidId 
		FROM platform__SNA__VID_lessons AS p 
		WHERE (p.id='$vidId' AND p.id_lect=$usrId) 
		ORDER BY p.date DESC";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$vidId=$row["vidId"];
		$videoTitle=$row["title"];
		$videoAuthor=$row["author"];
		$videoDescription=$row["description"];
		$videoLink=$row["link"];
		$videoLang=$row["languages"];
		$videoTopic=$row["topic"];
		$videoSubTopic=$row["subtopic"];
		$videoKeywords=$row["keywords"];
		$videoQuestions=$row["questions"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
	}
	
	$validateReq=0;
	if (
		(strlen($videoTopic)>4 OR strlen($videoSubTopic)>4) AND 
		strlen($videoKeywords)>4 AND 
		strlen($videoQuestions)>4
	) $validateReq=1;

	// File allegato alla question
	$pict="./data/mathePlatform/SNA/vdLessons/".$vidId.".".$fileExt;
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

MathJax.Hub.Config({
  tex2jax: {
    inlineMath: [ ['$','$'], ['\\(','\\)'] ]
  }
});		  
//		  MathJax.Hub.Config({
//			jax: ["input/TeX","output/HTML-CSS"],
//			extensions: ["tex2jax.js"],
//			tex2jax: {
//			  inlineMath: [ ['$','$'] ],
//			  displayMath: [ ['$$','$$'] ]
//			}
//		  });
	</script>

					<p class="rsvPage_Title">Edit Video Lesson</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>


					<form method="post" action="./MP_LECT_SNA_videoLesEdit.php?act=reg&id_act=<?=$vidId?>&<?=$queryStr?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<p style="padding: 0 0 0 25px;">If you want to edit the Topic(s)/Subtopic(s) for this Video Lesson <a href="./MP_LECT_SNA_videoLesAdd1.php?idVideo=<?=$vidId?>&from=edit">click here</a>.</p>
						<p style="padding: 0 0 0 25px;">If you want to edit the Keyword(s) for this Video Lesson <a href="./MP_LECT_SNA_videoLesAdd2.php?idVideo=<?=$vidId?>&from=edit">click here</a>.</p>
						<p style="padding: 0 0 0 25px;">If you want to edit the Question(s) for this Video Lesson <a href="./MP_LECT_SNA_videoLesAdd3.php?idVideo=<?=$vidId?>&from=edit">click here</a>.</p>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Title of the Lesson</label>
							<textarea name="videoTitle" id="videoTitle" style="height: 50px;" required /><?=$videoTitle?></textarea>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Author of the Lesson</label>
							<textarea name="videoAuthor" id="videoAuthor" style="height: 20px;" required /><?=$videoAuthor?></textarea>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Description</label>
							<span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(Please describe the main contents of the lesson using 20 to 50 words)</span>
							<textarea name="videoDescription" id="videoDescription" style="height: 100px;" required /><?=$videoDescription?></textarea>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Video</label>
							<span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(Please indicate the last 11 characters of the YouTube link)</span>
							<textarea name="videoLink" id="videoLink" style="height: 50px;" required /><?=$videoLink?></textarea>
						</div>

						<!-- <div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Screen shoot (JPG)</label>
							<span style="font-size: 8pt;font-weight: normal;line-height: 1em;">(If the video is not on YouTube, please upload a screen shoot of the video in JPG format.)</span>
							<input type="file" name="filex" />
							<?php if (file_exists($pict)) {?>
								<p style="padding: 10px 0 10px 0;">Current Photo:</p>
								<p style="float: left;width: 160px;margin: 0 0 0 0;"> <a href="<?=$pict?>" target="_blank" style="font-size: 1.0em;color: #900;"><img src="<?=$pict?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="" /></a></p>
								<input type="checkbox" name="delAttach" style="display: inline;width: 15px;height: 15px;" /> Check to delete current photo</p>
								<div class="clear"></div>
							<?php }?>
						</div> -->

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Language(s)</label>
							<div class="data">
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
										<p style="float: left;width: 100px;padding: 10px 0 0 0;font-weight: normal;"><input type="checkbox" style="float: left;width: 10px;height: 10px;margin. 15px 0 0 0;" name="videoLang_<?=$id_key?>" value="<?=$id_key?>" <?php if (strrpos($videoLang,"_".$id_key."_")) echo "checked=\"checked\"";?> /> <label class="radiobutt" style="float: left;margin: -4px 0 0 5px;" ><?=$nome?></label></p>
									<?php 
								}
								?>
							</div>
						</div>

						<div class="clear"></div>
						<div class="signup_submit" style="width: auto;padding-left: 30px;">
							<a href="./MP_LECT_SNA_videoLesManage.php?<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;font-size: 1.3em;padding: 5px 20px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 100px;font-size: 1.3em;padding: 5px 20px;" />
							<?php if ($validateReq==1) {?>
								<input type="submit" name="examine" value="SEND FOR VALIDATION" class="proceed" style="width: 250px;margin-left: 5px;font-size: 1.3em;padding: 5px 20px;" />
							<?php } else {?>
								<div style="float: right;width: 250px;margin: 30px 30px 0 0;padding: 5px;text-align: center;border: solid 1px #f00;border-radius: 5px;">To "SEND FOR VALIDATION this video you have to choose topic/subtopic, keywords and questions.</div>
							<?php }?>
						</div>




					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>