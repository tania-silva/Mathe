<?php
include('./impianto/inc/function.php'); // funzioni PHP


	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."librerie".$DS."sanitize".$DS."sanitize.lib.php");

	$var_get=array(
			'id_page'=>'sql',
			'lng'=>'sql',
			'msg'=>'sql',
			'com'=>'sql',
	);
	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////

$id_page=isset($_GET["id_page"]) ? $_GET["id_page"] :'';
$lng=strtolower($_GET["lng"]);
$table_lng="lang__".$lng;
$main_txt_tr = '';

if (isset($_GET["com"]) && $_GET["com"]=="reg") {

	$id_art=$_GET["id_art"];

	$inp01=Pulisci_INS($_POST["inp01"]);

	if ($id_page && $lng) $chk_status=1;

	if ($chk_status==1) {

		$sql = "SELECT * FROM ".$table_lng." WHERE (id_page=".$id_page." AND var_name='main_text')";
		$result=mysqli_query($conn, $sql);

		$tot=0;
		if ($result) $tot=mysqli_num_rows($result);

		if ($tot>0) {
			// Modifico il record presente

			$sql = "UPDATE `".$table_lng."` SET
			text='$inp01'
			WHERE id_page='$id_page'";
			$result=mysqli_query($conn, $sql);

		} else {
			// Creo il record
			$sql = "
			INSERT INTO `".$table_lng."` (`id_page`,`var_name`,`text`)
			VALUES ('$id_page','main_text','$inp01')";
			$result=mysqli_query($conn, $sql);

		}

		//Redirect su messaggio
		$strpas11="./rsv_translation.php?lng=".$lng."&id_page=".$id_page."&msg=1";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

	}

	//Redirect su messaggio
	$strpas11="./rsv_translation.php?lng=".$lng."&id_page=".$id_page."&msg=0";
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";


} elseif ($id_page) {

	$sql = "SELECT * FROM lang__en WHERE id_page=".$id_page;
	$result=mysqli_query($conn, $sql);

	while ($row=mysqli_fetch_array($result)) {
		$var_name_eng=$row["var_name"];
		if ($var_name_eng=="main_text") $main_txt_eng=Pulisci_READ($row["text"]);
	}

	 $sql = "SELECT * FROM ".$table_lng." WHERE id_page=".$id_page;
	$result=mysqli_query($conn, $sql);

	while ($row=mysqli_fetch_array($result)) {
		$var_name=$row["var_name"];
		if ($var_name=="main_text") $main_txt_tr=Pulisci_READ($row["text"]);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiction</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="vendor/revolution/settings.css">
    <link rel="stylesheet" href="vendor/revolution/layers.css">
    <link rel="stylesheet" href="vendor/revolution/navigation.css">
    <link rel="stylesheet" href="vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
	
    <script type="text/javascript" src="./impianto/addons/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="./impianto/addons/ckfinder/ckfinder.js"></script>
</head>

<body>

	<?php include("header2.php"); ?>
	<div class="container">
		<div class="row">

				<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp" class="col-md-9">
		<hr>

					<form method="post" action="rsv_translation.php?com=reg&lng=<?=$lng?>&id_page=<?=$id_page?>" enctype="multipart/form-data">

						<p class="titpar" style="font-size: 0.9em;"><strong>Select the page you have to translate</strong></p>

						<div class="lbl035">
							<div class="lbl" style="padding-top: 4px;"><strong>Title of the page</strong></div>
							<div class="lbl021" style="float: left;width: 390px;">
							<select name="qst14" style="width: 250px;padding-top: 0;"  onchange='javascript:document.location.href="rsv_translation.php?lng=<?=$lng?>&id_page="+this.options[this.selectedIndex].value;'>
								<option value="">Select page</option>
								<?php
								if ($lng="EN") {
									// Visualizzo tutte le pagine
									echo $sql = "SELECT * FROM lang__pages WHERE vis=1 ORDER BY ord ASC";
								} else {
									// Visualizzo ai partner le sole pagine da tradurre
									$sql = "
									SELECT o.*,c.*,o.id AS id
									FROM lang__pages as o
									LEFT JOIN ".$table_lng." as c
									ON o.id = c.id_page
									WHERE (c.text!='' AND o.vis=1)
									ORDER BY o.ord ASC";
								}

								$result=mysqli_query($conn, $sql);


								while ($row=mysqli_fetch_array($result)) {
									$page_id=$row["id"];
									$page_name=Pulisci_READ($row["page"]);
									$page_title=Pulisci_READ($row["title"]);
									?>
										<option value="<?=$page_id?>" <?php if ($id_page==$page_id) echo "selected"?>><?=$page_title?></option>
									<?php
								}
								?>
							</select>
							</div>
							<div class="clear"></div>
						</div>

						<?php if($id_page) {?>

							<?php if (isset($_GET["msg"]) && $_GET["msg"]==1) {?>
								<p class="titpar" style="font-size: 0.9em;">
									<strong style="color: #090;">The page is updated</strong>
								</p>

								<div class="lbl045">
									<div class="lbl"><strong>Translated version</strong></div>
									<div class="data">
										<?=$main_txt_tr?>
									</div>
									<div class="clear"></div>
								</div>

							<?php } elseif (isset($_GET["msg"]) AND $_GET["msg"]==0) {?>
								<p class="titpar" style="font-size: 0.9em;">
									<strong style="color: #900;">An error occur</strong>
								</p>
							<?php } else {?>

								<p class="titpar" style="font-size: 0.9em;">
									<strong>Translate text then press Send button</strong>
								</p>

								<div class="lbl035">
									<div class="lbl"><strong>Translation</strong></div>
									<div class="data">
										<?php
											if ($main_txt_tr=="")
											$main_txt_tr=$main_txt_eng;
										?>
										<?php
											$CKEditor = new CKEditor();
											$CKEditor->config['width'] = 400;
											$CKEditor->config['height'] = 350;

											$config = array();
											$config['language'] = 'en';
											$config['skin'] = 'kama';
											$config['toolbarCanCollapse'] = true;
											$config['toolbarStartupExpanded'] = true;
											//$config['removePlugins'] = 'elementspath';
											$config['toolbar'] = 'Pinzani';
											$CKEditor->editor("inp01", "$main_txt_tr", $config);
										?>
									</div>
									<div class="clear"></div>

									<div class="lbl04"><input type="submit" value=" Submit " style="width: 250px;" /></div>
								</div>

								<div class="lbl045">
									<div class="lbl"><strong>Original<br />English Version</strong></div>
									<div class="data">
										<?=$main_txt_eng?>
									</div>
									<div class="clear"></div>
								</div>
							<?php }?>
						<?php }?>

					</form>

				</div> <!-- rsv_crp -->

		</div> <!-- cnt1 -->

	</div> <!-- container -->
	<?php include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
