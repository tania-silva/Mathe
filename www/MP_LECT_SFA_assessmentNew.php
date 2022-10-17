	<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_time.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="./impianto/addons/calendar1/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>

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

$title=Pulisci_INS($_GET["title"]);
$description=Pulisci_INS($_GET["description"]);
$duration=Pulisci_INS($_GET["duration"]);

if (!$duration) $duration=120;

if ($_GET["act"]=="reg" AND $usrId) {

	$title=Pulisci_INS($_POST["title"]);
	$description=Pulisci_INS($_POST["description"]);
	$duration=Pulisci_INS($_POST["duration"]);
		$dt_emissione01=explode("/",$_POST["dc"]);
		$dt_emissione_gg=$dt_emissione01[0];
		$dt_emissione_mm=$dt_emissione01[1];
		$dt_emissione02=explode(" ",$dt_emissione01[2]);
		$dt_emissione_aa=$dt_emissione02[0];
		$dt_emissione_ora=$dt_emissione02[1].":00";
	$FA_date=$dt_emissione_aa."-".$dt_emissione_mm."-".$dt_emissione_gg." ".$dt_emissione_ora;


	$FA_date=Date("Y-m-d H:i:s",strtotime($FA_date));
	$date = date_create($FA_date, timezone_open($uniTimezone));
	$Dt1=$date->format('Y-m-d H:i:s');
	//date_timezone_set($date, timezone_open('Europe/Rome'));
	date_timezone_set($date, timezone_open('UTC'));
	$FA_date=$date->format('Y-m-d H:i:s');
	
	
	
	$today=Date("Y-m-d H:i:s");

	$sql = "
		INSERT INTO `platform__SFA__assestment` 
		(`id_lect`, `date`, `title`, `description`, `FA_date`, `duration`)  
		VALUES ('$usrId', '$today', '$title', '$description', '$FA_date', '$duration')";
	$result=mysqli_query($conn,$sql);
	$assId=mysqli_insert_id($conn);

	if ($assId) {

		// Redirect
		$redirectUrl="./MP_LECT_SFA_assessmentNew1.php?assId=".$assId;
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

	} else {

		// Redirect
		$redirectUrl="./MP_LECT_SFA_assessmentNew.php?msg=K0&title=".$title."&description=".$description."&duration=".$duration;
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

	}

}
?>
	

					<p class="rsvPage_Title">Insert New Final Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" name="demoform" action="./MP_LECT_SFA_assessmentNew.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Title of the Final Assessment</label>
							<textarea name="title" required /><?=$title?></textarea>
						</div>
					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Description</label>
							<textarea name="description" style="height: 100px;" /><?=$description?></textarea>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Date and Time when it will take place</label>
							<div>
								<?php 
									$adesso=Date("Y-m-d H:i:s");
									$date = date_create($adesso, timezone_open('Europe/Rome'));
									//$Dt1=$date->format('Y-m-d H:i:s I');
									date_timezone_set($date, timezone_open($uniTimezone));
									$Dt2=$date->format('d/m/Y H:i');

								?>
								<input class="plain" name="dc" value="<?=$Dt2?>" size="19" onfocus="this.blur()" readonly style="float: left;width: 120px;padding: 2px;border: solid 1px #999;" readonly /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc);return false;" ><img name="popcal" align="absmiddle" src="./impianto/addons/calendar1/calbtn.gif" width="34" height="22" border="0" alt="" style="float: left;margin: 0 0 0 5px;"></a>
								<div class="clear"></div>
							</div>
						</div>
					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Duration of the test - MAX 300 minutes</label>
							<textarea name="duration" required style="width: 50px;height: 1.5em;" required /><?=$duration?></textarea>
						</div>


						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_SFA_assessmentManage.php?assId=<?=$assId?>"><button type="button" class="abort" style="width: 100px;margin-left: 200px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="PROCEED" class="proceed" style="width: 150px;margin-left: 20px;padding: 5px;" />
						</div>



					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>