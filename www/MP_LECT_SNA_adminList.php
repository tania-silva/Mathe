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

$page=1;
if (isset($_GET["page"])) $page=$_GET["page"];

$srcLevel=$_POST["srcLevel"];
if (!$srcLevel) $srcLevel=$_GET["srcLevel"];
$srcTopic=$_POST["srcTopic"];
if (!$srcTopic) $srcTopic=$_GET["srcTopic"];
$srcValidation=$_POST["srcValidation"];
if (!$srcValidation) $srcValidation=$_GET["srcValidation"];

$act=$_GET["act"];
$lectId=$_GET["lectId"];

if ($act=="del" AND $lectId) {

		
	$sql = "
		UPDATE `platform__user` 
		SET 
			profile=Null
		WHERE id=$lectId";
	$result=mysqli_query($conn,$sql);

	// Redirect
	$redirectUrl="./MP_LECT_SNA_adminList.php";
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

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

					<p class="rsvPage_Title">List of Admins</p>

					<?php 
//					$where=" WHERE (p.id_lect=$usrId AND ";
//					if ($srcLevel) $where.="p.level='$srcLevel' AND ";
//					if ($srcTopic) $where.="p.topic=$srcTopic AND ";
//					if ($srcValidation) {
//						if ($srcValidation==3) $where.="p.validate=0 AND ";
//						else $where.="p.validate=$srcValidation AND ";
//					}
//					$where=substr($where,0,-5);
//					$where.=")";

					$sqlP = "
						SELECT *,
							p.id AS lectId,
							p.name AS lectName, 
							p.surname AS lectSurname, 
							q.email AS lectEmail, 
							q.field_of_research AS lectFieldOfResearch, 
							q.subject_taught AS lectSubjectTaught, 
							q.years_of_experience AS lectYearsOfExperience, 
							q.profile AS lectProfile, 
							q.uni_department AS lectUniDepartment, 
							q.uni_city AS lectUniCity, 
							q.uni_address AS lectUniAddress, 
							k.name AS lectUniName, 
							k.country AS lectUniCountry 
						FROM platform__user AS p 
						LEFT JOIN platform__lecturers AS q 
						ON p.id=q.id_lect 
						LEFT JOIN platform__university AS k 
						ON q.uni_name=k.id 
						WHERE (p.typology='lecturer' AND p.profile='admin') 
						ORDER BY surname ASC";
					$resultP=mysqli_query($conn,$sqlP);
					if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

//					$q_pag=10; //quanti per pagina
//					$pagine1=bcdiv($totale,$q_pag,3);
//					$pagine = ceil($pagine1); //arrotonda all'intero maggiore
//					$page_from=($page-1)*$q_pag;
//
//					$sqlP = $sqlP." LIMIT ".$page_from.",".$q_pag.";";
//					$resultP=mysqli_query($conn,$sqlP);
					?>
					<div style="margin: 25px 0 5px 5px;">
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> admins</p>
						<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SNA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
						<div class="clear"></div>
					</div>
	
					<!-- <form method="post" action="./MP_LECT_SNA_adminList.php" style="padding: 10px;background-color: #e1f7ff;border: solid 1px #00AEEF;border-radius: 5px;">
						<p style="float: left;width: 60px;">Search By:</p>
						<div style="float: left;width: 100px;">
							Level:<br />
							<select name="srcLevel">
								<option value="">All Level</option>
								<option value="Basic" <?php if ($srcLevel=="Basic") echo "selected";?>>Basic</option>
								<option value="Advanced" <?php if ($srcLevel=="Advanced") echo "selected";?>>Advanced</option>
							</select>
						</div>
						<div style="float: left;width: 250px;">
							Topic:<br />
							<select name="srcTopic">
								<option value="">All Topic</option>
								<?php 
								$sql = "
									SELECT * 
									FROM platform__topic
									ORDER BY name ASC";
								$result=mysqli_query($conn,$sql);
								
								while ($row=mysqli_fetch_array($result)) { 
									$topId=$row["id"];
									$topName=$row["name"];
									?><option value="<?=$topId?>" <?php if ($srcTopic==$topId) echo "selected";?>><?=$topName?></option><?php 
								}
								?>
							</select>
						</div>
						<div style="float: left;width: 190px;">
							Validation:<br />
							<select name="srcValidation">
								<option value="">All Validation</option>
								<option value="3" <?php if ($srcValidation==3) echo "selected";?>>IN PROGRESS</option>
								<option value="4" <?php if ($srcValidation==4) echo "selected";?>>WAITING FOR VALIDATION</option>
								<option value="1" <?php if ($srcValidation==1) echo "selected";?>>APPROVED</option>
								<option value="2" <?php if ($srcValidation==2) echo "selected";?>>NOT APPROVED</option>
							</select>
						</div>
						<div style="float: right;width: 100px;margin-right: 10px;">
							<a href="./MP_LECT_SNA_questionManage.php"><button type="button" class="abort" />All</button></a>
							<input type="submit" value="filter" class="filter" />
						</div>
						<div class="clear"></div>
					</form> -->


					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit">Name</th>
								<th class="tdtit">University</th>
								<th class="tdtit">Admin</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$count=1;
						while ($row=mysqli_fetch_array($resultP)) { 

							//$pict_id=$row["id"];
							$lectId=$row["lectId"];
							$lectName=$row["lectName"];
							$lectSurname=$row["lectSurname"];
							$lectEmail=$row["lectEmail"];
							$lectFieldOfResearch=$row["lectFieldOfResearch"];
							$lectSubjectTaught=$row["lectSubjectTaught"];
							$lectYearsOfExperience=$row["lectYearsOfExperience"];
							$lectProfile=$row["lectProfile"];
							$lectUniName=$row["lectUniName"];
							$lectUniCountry=$row["lectUniCountry"];
							$lectUniDepartment=$row["lectUniDepartment"];
							$lectUniCity=$row["lectUniCity"];
							$lectUniAddress=$row["lectUniAddress"];

							$lectName.=" ".$lectSurname;
							$uniAddress=$lectUniAddress." - ".$lectUniCity." (".$lectUniCountry.")";
							?>
							<tr>
								<td style="font-size: 0.9em;"><?=$count?></td>
								<td style="font-size: 0.9em;">
									<p style="font-size: 1.1em;font-weight: 400;"><?=$lectName?></p>
									<p><?=$lectFieldOfResearch?></p>
									<p><a href="mailto:<?=$lectEmail?>"><?=$lectEmail?></a></p>
								</td>
								<td style="font-size: 0.9em;">
									<p style="font-size: 1.1em;font-weight: 400;"><?=$lectUniName?></p>
									<p><?=$lectUniDepartment?></p>
									<p><?=$uniAddress?></p>
								</td>
								<td><?php if ($lectId!=$usrId AND ($usrId==886 OR $usrId==37 OR $usrId==26 OR $usrId==28 OR $usrId==38)) {?><a href="./MP_LECT_SNA_adminList.php?act=del&lectId=<?=$lectId?>" title="Remove from Admins"><img src="./impianto/img/icone/ico_minus.png" width="24" height="24" border="0" alt="" /></a><?php }?></td>
							</tr>
							<?php 
							$count+=1;
						}
						?>
						</tbody>
					</table>					

					<!-- <?php if ($pagine>1) {?>
						<div class="pageNav">
							<?php 
							for ($i=1;$i<=$pagine;$i++) {
								$str_query="&srcLevel=".$srcLevel."&srcTopic=".$srcTopic."&srcValidation=".$srcValidation;
								$str_pas=basename($_SERVER['PHP_SELF'])."?page=".$i.$str_query;
								if ($i==$page) {
									echo "<a class='sel' href='./".$str_pas."'>".$i."</a>";
								} else {
									echo "<a href='./".$str_pas."'>".$i."</a>";
								}
							}
							?>
							<div class="clear"></div>
						</div>
					<?php }?> -->

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>