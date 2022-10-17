	
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

$assId=Pulisci_INS($_GET["assId"]);
$titleSFA=Pulisci_INS($_GET["titleSFA"]);
$description=Pulisci_INS($_GET["description"]);
$duration=Pulisci_INS($_GET["duration"]);
$status=Pulisci_INS($_GET["status"]);

if (!$duration) $duration=120;

if ($_GET["act"]=="reg" AND $usrId) {

	$titleSFA=Pulisci_INS($_POST["titleSFA"]);
	$description=Pulisci_INS($_POST["description"]);
	$duration=Pulisci_INS($_POST["duration"]);
	$status=Pulisci_INS($_POST["status"]);
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
	date_timezone_set($date, timezone_open('UTC'));
	$FA_date=$date->format('Y-m-d H:i:s');




	$today=Date("Y-m-d H:i:s");
		
	$sql = "
		UPDATE `platform__SFA__assestment` 
		SET 
			title='$titleSFA', 
			description='$description', 
			FA_date='$FA_date', 
			duration='$duration', 
			status='$status'
		WHERE (id='$assId' AND id_lect=$usrId)"; 
	$result=mysqli_query($conn,$sql);

	// Redirect
	$redirectUrl="./MP_LECT_SFA_assessmentNew1.php?assId=".$assId;
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

} else {

	$sql = "
		SELECT * 
		FROM platform__SFA__assestment
		WHERE (id='$assId' AND id_lect=$usrId) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$titleSFA=$row["title"];
		$description=$row["description"];
		$FA_date=$row["FA_date"];
		$duration=$row["duration"];
		$status=$row["status"];
		$qst01FA=$row["qst01"];
		$qst02FA=$row["qst02"];
		$qst03FA=$row["qst03"];
		$qst04FA=$row["qst04"];
		$qst05FA=$row["qst05"];
		$qst06FA=$row["qst06"];
		$qst07FA=$row["qst07"];
		$qst08FA=$row["qst08"];
		$qst09FA=$row["qst09"];
		$qst10FA=$row["qst10"];
		$qst11FA=$row["qst11"];
		$qst12FA=$row["qst12"];
		$qst13FA=$row["qst13"];
		$qst14FA=$row["qst14"];
		$qst15FA=$row["qst15"];
		$qst16FA=$row["qst16"];
		$qst17FA=$row["qst17"];
		$qst18FA=$row["qst18"];
		$qst19FA=$row["qst19"];
		$qst20FA=$row["qst20"];
	}
	
	$FA_date=Date("Y-m-d H:i:s",strtotime($FA_date));
	$date = date_create($FA_date, timezone_open('UTC'));
	$Dt1=$date->format('Y-m-d H:i:s');
	date_timezone_set($date, timezone_open($uniTimezone));
	$FA_date=$date->format('Y-m-d H:i:s');
								
	if ($FA_date!="" AND $FA_date!="0000-00-00 00:00:00") {
		$ins_data_expl=explode("-",$FA_date);
		$ins_data_aa=$ins_data_expl[0];
		$ins_data_mm=$ins_data_expl[1];
		$ins_data_expl1=explode(" ",$ins_data_expl[2]);
		$ins_data_gg=$ins_data_expl1[0];
		$ins_data_expl2=explode(":",$ins_data_expl1[1]);
		$ins_data_ora=$ins_data_expl2[0];
		$ins_data_min=$ins_data_expl2[1];
		$FA_date=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa." ".$ins_data_ora.":".$ins_data_min;
	} else $FA_date="";

}
?>

					<p class="rsvPage_Title">Edit Final Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" name="demoform" action="./MP_LECT_SFA_assessmentEdit.php?assId=<?=$assId?>&act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Status</label>
							<select name="status">
								<option value="0" <?php if (!$status) echo "selected";?>>NOT PUBLISHED</option>
								<option value="1" <?php if ($status==1) echo "selected";?>>PUBLISHED</option>
							</select>
						</div>
						<div style="padding: 5px 0 0 17px;">
							NOT PUBLISHED: nobody about you can view the assessment.<br />
							PUBLISHED: students of your university can register to the assessment
						
						</div>

						<hr style="margin: 10px 50px 25px 18px;"/>
					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Title of the Final Assessment</label>
							<textarea name="titleSFA" required /><?=$titleSFA?></textarea>
						</div>
					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Description</label>
							<textarea name="description" style="height: 100px;" /><?=$description?></textarea>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Date and Time when it will take place</label>
							<div>
								<input class="plain" name="dc" value="<?=$FA_date?>" size="19" onfocus="this.blur()" readonly style="float: left;width: 120px;padding: 2px;border: solid 1px #999;" readonly /><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc);return false;" ><img name="popcal" align="absmiddle" src="./impianto/addons/calendar1/calbtn.gif" width="34" height="22" border="0" alt="" style="float: left;margin: 0 0 0 5px;"></a>
								<div class="clear"></div>
							</div>
						</div>
					
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Duration of the test - MAX 300 minutes</label>
							<textarea name="duration" required style="width: 50px;height: 25px;" required /><?=$duration?></textarea>
						</div>


						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_SFA_assessmentNew1.php?assId=<?=$assId?>"><button type="button" class="abort" style="width: 100px;margin-left: 200px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="PROCEED" class="proceed" style="width: 150px;margin-left: 20px;padding: 5px;" />
						</div>



					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>