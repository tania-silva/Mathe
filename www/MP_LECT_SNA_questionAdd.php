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

	$description=Pulisci_INS($_POST["description"]);
	$topic=Pulisci_INS($_POST["topic"]);
	$subTopic=Pulisci_INS($_POST["subtopic"]);
	$question=Pulisci_INS($_POST["question"]);
	$level=Pulisci_INS($_POST["level"]);
	$answer1=Pulisci_INS($_POST["answer1"]);
	$answer2=Pulisci_INS($_POST["answer2"]);
	$answer3=Pulisci_INS($_POST["answer3"]);
	$answer4=Pulisci_INS($_POST["answer4"]);
	$keywords=$_POST["keywords"];

	$checkStatus=0;
	if (
		$usrId AND 
		$usrTypology=="lecturer" AND 
		$usr_completeProfile==1 AND 
		$topic AND 
		$question AND 
		$answer1 AND 
		$answer2 AND 
		$answer3 AND 
		$keywords AND
		$answer4
	) $checkStatus=1;

	
	if ($checkStatus) {

		/* Registro il nuovo esercizio */
		$date=Date("Y-m-d H:i:s");
		$validate=0;

		$sql = "
			INSERT INTO `platform__SNA__questions` 
			(`id_lect`, `description`, `topic`, `subtopic`, `question`, `level`, `answer1`, `answer2`, `answer3`, `answer4`, `date`, `validate`)  
			VALUES ('$usrId', '$description', '$topic', '$subTopic', '$question', '$level', '$answer1', '$answer2', '$answer3', '$answer4', '$date', '$validateValue')";
		$result=mysqli_query($conn,$sql);
		$qstId=mysqli_insert_id($conn);

		//IPB: INSERT into platform_keywords_snaquestions table
		foreach($keywords as $key){
			$sql="
			INSERT INTO `platform_keyword_snaquestion`(`id_keyword`, `id_sna_question`) VALUES ('$key','$qstId')";
			$resultKeyword=mysqli_query($conn,$sql);
		}

		// Upload document
		$check= new CheckUpload($_FILES["filex"]);
		if ($check->isOk()) {
			// Upload dell'allegato
			//$path=ereg_replace("MP_LECT_SNA_questionAdd.php","",$_SERVER["PATH_TRANSLATED"]);
			$upload_dir = "./data/mathePlatform/SNA/attach"; 
			$fileName=$_FILES['filex']['name'];
			$file_ext = pathinfo($_FILES['filex']['name'], PATHINFO_EXTENSION);
			$file_name = $qstId.".".$file_ext;

			move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name); 
			chmod($upload_dir."/".$file_name, 0777);

			$sql = "
				UPDATE `platform__SNA__questions` 
				SET 
					file_name='$fileName', 
					file_ext='$file_ext'
				WHERE id=$qstId";
			$result=mysqli_query($conn,$sql);

		}

		$redirectUrl="./MP_LECT_SNA_questionManage.php";

	} else $redirectUrl="./MP_LECT_SNA_questionAdd.php?msg=KO";

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

	</script>



					<p class="rsvPage_Title">Insert New Question</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" action="./MP_LECT_SNA_questionAdd.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

					
						
						<!-- <div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Description</label>
							<textarea name="description" required /></textarea>
						</div> -->
						<p style="padding: 0 0 0 20px;">Please download and read these supporting document before starting to upload the questions and answers:<br /><a href="./files/MathE Platform Help!.pdf" class="nw" style="font-weight: 400;">MathE Platform Help!</a></p>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Topic</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #00aeef;border-radius: 5px;">
								<div id="topic" style="float: left;margin: 1px 0 0 0;">
									<select name="topic" style="float: left;width: 250px;" onchange="keywordsQuestions(this.options[this.selectedIndex].value);" required>
										<option value=""> Select Topic</option>
										<?php
										$sql = "
											SELECT * 
											FROM platform__topic 
											WHERE hidden=0 
											ORDER BY name ASC";
										$result=mysqli_query($conn,$sql);

										while ($row=mysqli_fetch_array($result)) { 
											$topicId=($row["id"]);
											$topicName=($row["name"]);
											?><option value="<?=$topicId?>"><?=$topicName?></option><?php
										}
										?>
									</select>
								</div>
								<div id="subtopic" style="display: none;float: left;margin: 0 0 0 20px;">
									<!-- SubTopic Area -->
								</div>
								<div class="clear"></div>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Question [<a href="javascript: void()" onclick="doPreview('','question','questionPreview')">Preview</a>]</label>
							<textarea name="question" id="question" style="height: 150px;" required /></textarea>
							<div id="questionPreviewBlk" style="display: none;width: 636px;margin-top: 5px;border: solid 1px #900;border-radius: 5px;">
								<p style="padding: 5px;font-weight: 400;color: #fff;background-color: #900;">Preview of the Question</p>
								<p id="questionPreview" style="padding: 10px;">&nbsp;</p>
							</div>
						</div>
					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Level</label>
							<p><input type="radio" name="level" class="radiobutt" value="Basic" style="width: 30px;" checked /><label class="radiobutt">Basic</label></p>
							<p><input type="radio" name="level" class="radiobutt" value="Advanced" style="width: 30px;margin-left: 30px;" /><label class="radiobutt">Advanced</label></p>
							<div class="clear"></div>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Answer n. 1 (TRUE) [<a href="javascript: void()" onclick="doPreview('','answer1','answer1Preview')">Preview</a>]</label>
							<textarea name="answer1" id="answer1" style="height: 150px;" required /></textarea>
							<div id="answer1PreviewBlk" style="display: none;width: 636px;margin-top: 5px;border: solid 1px #900;border-radius: 5px;">
								<p style="padding: 5px;font-weight: 400;color: #fff;background-color: #900;">Preview of Answer n. 1</p>
								<p id="answer1Preview" style="padding: 10px;">&nbsp;</p>
							</div>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Answer n. 2 (FALSE) [<a href="javascript: void()" onclick="doPreview('','answer2','answer1Preview')">Preview</a>]</label>
							<textarea name="answer2" id="answer2" style="height: 150px;" required /></textarea>
							<div id="answer2PreviewBlk" style="display: none;width: 636px;margin-top: 5px;border: solid 1px #900;border-radius: 5px;">
								<p style="padding: 5px;font-weight: 400;color: #fff;background-color: #900;">Preview of Answer n. 2</p>
								<p id="answer2Preview" style="padding: 10px;">&nbsp;</p>
							</div>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Answer n. 3 (FALSE) [<a href="javascript: void()" onclick="doPreview('','answer3','answer1Preview')">Preview</a>]</label>
							<textarea name="answer3" id="answer3" style="height: 150px;" required /></textarea>
							<div id="answer3PreviewBlk" style="display: none;width: 636px;margin-top: 5px;border: solid 1px #900;border-radius: 5px;">
								<p style="padding: 5px;font-weight: 400;color: #fff;background-color: #900;">Preview of Answer n. 3</p>
								<p id="answer3Preview" style="padding: 10px;">&nbsp;</p>
							</div>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Answer n. 4 (FALSE) [<a href="javascript: void()" onclick="doPreview('','answer4','answer1Preview')">Preview</a>]</label>
							<textarea name="answer4" id="answer4" style="height: 150px;" required /></textarea>
							<div id="answer4PreviewBlk" style="display: none;width: 636px;margin-top: 5px;border: solid 1px #900;border-radius: 5px;">
								<p style="padding: 5px;font-weight: 400;color: #fff;background-color: #900;">Preview of Answer n. 4</p>
								<p id="answer4Preview" style="padding: 10px;">&nbsp;</p>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">&nbsp;&nbsp;&nbsp;&nbsp;Attachment</label>
							<input type="file" name="filex" />
						</div>

						<!--KeyWords div-->
						 <div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Keywords</label>
							<div style="width: 625px;height: 400px;padding: 10px 0 10px 10px;border: dotted 1px #00aeef;border-radius: 5px;overflow: auto;">
								<div id="keywords" style=" display: inline-block; padding-right: 10px; white-space: nowrap;margin: 1px 0 0 0;">
									<!-- Keyword Area -->
								</div>
								<div class="clear"></div>
							</div>
						</div>

						<!-- <div class="signup_submit" style="padding-left: 70px;">
							<a href="./MP_LECT_SNA_questionManage.php"><button type="button" class="abort" />Abort</button></a>
							<input type="submit" value="Proceed" class="proceed" style="margin-left: 20px;" />
						</div> -->


						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_SNA_questionManage.php<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;font-size: 1.2em;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 100px;padding: 5px;font-size: 1.2em;" />
							<input type="submit" name="examine" value="SEND FOR VALIDATION" class="proceed" style="width: 250px;margin-left: 5px;padding: 5px;font-size: 1.2em;" />
						</div>



					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>