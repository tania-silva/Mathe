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

if ($_GET["act"]=="reg" AND $_GET["stuID"]) {

	$stuID=$_GET["stuID"];
		
	$sql = "
		SELECT * 
		FROM `platform__user` 
		WHERE id=$stuID";
	$result=mysqli_query($conn,$sql);
	while ($row=mysqli_fetch_array($result)) { 
		$stuBan=$row["ban"];
	}

	if ($stuBan==1) $stuBan=0; else $stuBan=1;
		
	$sql = "
		UPDATE `platform__user` 
		SET 
			ban=$stuBan
		WHERE id=$stuID";
	$result=mysqli_query($conn,$sql);

	// Redirect
	$redirectUrl="./MP_LECT_SNA_studentList.php#stu".$stuID;
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

}

?>
	<!-- <script type="text/x-mathjax-config">
	  MathJax.Hub.Config({
		tex2jax: {
		  inlineMath: [ ['$','$'], ["\\(","\\)"] ],
		  processEscapes: true
		}
	  });
	</script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script> -->

					<p class="rsvPage_Title">List of Students</p>

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
							p.id AS studId,
							p.name AS studName, 
							p.surname AS studSurname, 
							p.ban AS studBan, 
							q.email AS studEmail, 
							q.profile AS studProfile, 
							q.uni_department AS studUniDepartment, 
							q.uni_degree AS studUniDegree, 
							q.uni_study_programme AS studUniProgramme, 
							q.uni_city AS studUniCity, 
							q.uni_address AS studUniAddress, 
							k.name AS studUniName, 
							k.country AS studUniCountry 
						FROM platform__user AS p 
						LEFT JOIN platform__students AS q 
						ON p.id=q.id_stud 
						LEFT JOIN platform__university AS k 
						ON q.uni_name=k.id 
						WHERE (p.typology='student' AND verifyEmail=1 AND completeProfile=1) 
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
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> students</p>
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
								<th class="tdtit" style="width: 70px;"></th>
								<th class="tdtit">Name</th>
								<th class="tdtit">University</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$count=1;
						while ($row=mysqli_fetch_array($resultP)) { 

							//$pict_id=$row["id"];
							$studId=$row["studId"];
							$studName=$row["studName"];
							$studSurname=$row["studSurname"];
							$studBan=$row["studBan"];
							$studEmail=$row["studEmail"];
							$studProfile=$row["studProfile"];
							$studUniName=$row["studUniName"];
							$studUniCountry=$row["studUniCountry"];
							$studUniDepartment=$row["studUniDepartment"];
							$studUniDegree=$row["studUniDegree"];
							$studUniProgramme=$row["studUniProgramme"];
							$studUniCity=$row["studUniCity"];
							$studUniAddress=$row["studUniAddress"];

							$studName.=" ".$studSurname;
							$uniAddress=$studUniAddress." - ".$studUniCity." (".$studUniCountry.")";

							if ($studBan==1) $btIco="btOFF"; else $btIco="btON";
							?>
							<tr>
								<td style="font-size: 0.9em;"><?=$count?></td>
								<td>
									<?php if ($usrId!=586) {?><a href="./MP_LECT_SNA_studentList.php?act=reg&stuID=<?=$studId?>" name="stu<?=$studId?>"><img src="./impianto/img/<?=$btIco?>.png" width="100" alt="" /></a><?php }?>
								</td>
								<td style="font-size: 0.9em;">
									<p style="font-size: 1.1em;font-weight: 400;"><?=$studName?></p>
									<p><?=$studProfile?></p>
									<p><a href="mailto:<?=$studEmail?>"><?=$studEmail?></a></p>
								</td>
								<td style="font-size: 0.9em;">
									<p style="font-size: 1.1em;font-weight: 400;"><?=$studUniName?></p>
									<p><?=$studUniDepartment?></p>
									<p><?=$uniAddress?></p>
								</td>
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