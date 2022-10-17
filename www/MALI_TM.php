<?php
include('./top.php'); // funzioni PHP
?>


<?php 


$page=1;
if (isset($_GET["page"])) $page=$_GET["page"];

$page=1;
if (isset($_GET["page"])) $page=$_GET["page"];
$getTopic=$_POST["Topic"];
if (!$getTopic) $getTopic=$_GET['srcTopic'];
$getSubTopic=$_POST["SubTopic"];
if (!$getSubTopic) $getSubTopic=$_GET['srcSubTopic'];


if ($getTopic OR $getSubTopic) {
	//print_r($_POST);

	$getTopic=$_POST["Topic"];
	$getSubTopic=$_POST["SubTopic"];

	// Keywords
	$getKeywords="key_";
	$sql = "
		SELECT * 
		FROM platform__keywords 
		ORDER BY id";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id"];
		if ($_POST["key".$id_key]==$id_key) $getKeywords.=$id_key."_";
	}

	$getKeywords1=str_replace("key_","",$getKeywords);
	$getKeywords1=substr($getKeywords1,0,-1);
	if ($getKeywords1) $getKeywordsAr=explode("_",$getKeywords1);

	$where="WHERE validate=1 AND ";
	if ($getSubTopic) $where.="LOCATE('_".$getSubTopic."_', subtopic)>0 AND ";
	else $where.="LOCATE('_".$getTopic."_', topic)>0 AND ";
//	if ($getSubTopic) $where.="subtopic LIKE '%_{$getSubTopic}_%' AND ";
//	else $where.="topic LIKE '%_{$getTopic}_%' AND ";

	if (count($getKeywordsAr)>0) {
		$wherekey.="(";
		foreach ($getKeywordsAr as &$value) {
			$wherekey.="LOCATE('_".$value."_',keywords) OR ";
		}		
		$wherekey=substr($wherekey,0,-4);
		$wherekey.=") AND ";
		$where.=$wherekey;
	}

	$wherePage=substr($where,0,-5);
}

$str_query="&srcTopic=".$getTopic."&srcSubTopic=".$getSubTopic;
?>


	<main>

        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Teaching material</h1>
                    </div>
                </div>
            </div>
        </section>
	
	
        <!-- Blog detail -->
        <section class="single section-padding-large">
            <div class="container">
                <div class="row">
					<div class="col-1"></div>
			
                    <div class="col-10">
                        <div class="single-content">
				      
							<nav aria-label="breadcrumb">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item">MathE Library</li>
								</ul>
							</nav>

							<h2 class="single-title">
								<?php if ($_SESSION["guest"]) {?>
									Please select a math topic, subtopic and keyword to access the available teaching material.
								<?php } else {?>
									A collection of teaching and learning material to support students in the acquisition of competences on selected Math topics.
								<?php }?>
							</h2>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Teaching material
									</span>
								</div>
							</div> -->
				
				<!-- START contenuto pagina -->
				
				<div id="page_crp">
					<div class="txt">

						<?php //if ($userPT) {?>
						<?php if ($_SESSION["guest"]) {?>

							<form method="post" action="./MALI_TM.php" style="padding: 10px;font-size: 0.9em;background-color: #e1f7ff;border: solid 1px #00AEEF;border-radius: 5px;">
								<p style="font-size: 1.0em;">Search By:</p>
								<div style="width: 95%;">
									<div id="topic" style="float: left;width: 250px;margin: 0 15px 5px 0;">
										Topic:<br />
										<select name="Topic" onchange="subTopic4(this.options[this.selectedIndex].value);">
											<option value="">All Topics</option>
											<?php
											$sql = "
												SELECT * 
												FROM platform__topic
												WHERE hidden=0 
												ORDER BY name ASC";
											$result=mysqli_query($conn,$sql);
											
											while ($row=mysqli_fetch_array($result)) { 
												$topId=$row["id"];
												$topName=$row["name"];
												?><option value="<?=$topId?>" <?php if ($getTopic==$topId) echo "selected";?>><?=$topName?></option><?php
											}
									
											$sql = "
												SELECT * 
												FROM platform__subtopic 
												WHERE (id_top=$getTopic AND hidden=0) 
												ORDER BY name ASC";
											$result=mysqli_query($conn,$sql);
											$nSubTopic=mysqli_num_rows($result);
											?>
										</select>
									</div>
									<?php if ($getSubTopic OR $nSubTopic) $dsplSubTopic="block"; else $dsplSubTopic="none"; ?>
									<div id="subtopic" style="display: <?=$dsplSubTopic?>;float: left;margin: 0 0 5px 0;">
										<!-- SubTopic Area -->
											SubTopic:<br />
											<select name="SubTopic" style="width: 250px;" onchange="keywords1(this.options[this.selectedIndex].value, '<?=$getTopic?>');">
												<option value="">All SubTopics</option>
												<?php
												$sql = "
													SELECT * 
													FROM platform__subtopic 
													WHERE (id_top=$getTopic AND hidden=0) 
													ORDER BY name ASC";
												$result=mysqli_query($conn,$sql);
												
												while ($row=mysqli_fetch_array($result)) { 
													$subtopicId=($row["id"]);
													$subtopicName=($row["name"]);
													?><option value="<?=$subtopicId?>" <?php if ($getSubTopic==$subtopicId) echo "selected";?>><?=$subtopicName?></option><?php
												}
												?>
											</select>
									</div>
									<div class="clear"></div>
									<div id="keywords" style="display: block;margin: 20px 0 0 0;">
										<?php if ($getTopic) {?>
											<!-- Keywords Area -->
											Keywords<br />
											<div>
												<?php
												if ($getSubTopic) $where="WHERE (hidden=0 AND id_top=$getTopic AND id_sub=$getSubTopic) ";
												else $where="WHERE (hidden=0 AND id_top=$getTopic AND id_sub=0) ";
												$sql1 = "
													SELECT *  
													FROM platform__keywords 
													".$where." 
													ORDER BY name ASC";
												$result1=mysqli_query($conn,$sql1);

												while ($row1=mysqli_fetch_array($result1)) { 
													$keyId=($row1["id"]);
													$keyName=($row1["name"]);
													?><div style="float: left;width: 300px;margin: 2px 5px 0 0;"><input type="checkbox" name="key<?=$keyId?>" value="<?=$keyId?>" <?php if (strpos($getKeywords, "_".$keyId."_")) echo "checked=\"checked\"";?> /> <label style="font-size: 1.0em;font-weight: 300;"><?=$keyName?></label></div><?php
												}
												?>
												<div class="clear"></div>
												<p style="width: auto;margin: 20px auto;"><input type="submit" value="Find Resources" class="filter" id="filter" style="display: block;padding: 5px 15px;" /></p>
											</div>
										<?php }?>
									</div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
								
								<!-- <a href="./MALI_TM.php"><button type="button" class="abort" style="margin-left: 600px;" />All</button></a>
								<input type="submit" value="find teaching materials" class="filter" id="filter" style="display: none;margin: 20px 0 0 300px;padding: 5px 15px;" /> -->
								
								<div class="clear"></div>

							</form>

							<?php
							if (!empty($_POST)) {

								//echo $wherePage;

								$sqlP = "
									SELECT * 
									FROM platform__SNA__tchmaterials
									".$wherePage." 
									ORDER BY date DESC";
								$resultP=mysqli_query($conn,$sqlP);
								if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

								$q_pag=10; //quanti per pagina
								$pagine1=bcdiv($totale,$q_pag,3);
								$pagine = ceil($pagine1); //arrotonda all'intero maggiore
								$page_from=($page-1)*$q_pag;

								$sqlP = $sqlP." LIMIT ".$page_from.",".$q_pag.";";
								$resultP=mysqli_query($conn,$sqlP);
								

								if ($totale>0) {?>
									<table class="table table-hover" style="margin-top: 25px;">
										<thead>
											<tr>
												<th class="tdtit" style="width: 250px;">Teaching Material</th>
												<th class="tdtit" style="width: 250px;"></th>
												<th class="tdtit"></th>
											</tr>
										</thead>
										<tbody>
										<?php
										$count=1;
										while ($row=mysqli_fetch_array($resultP)) { 

											//$pict_id=$row["id"];
											$vidId=$row["id"];
											$videoTitle=$row["title"];
											$videoAuthor=$row["author"];
											$videoDescription=$row["description"];
											$videoType=$row["type"];
											$videoLink=$row["link"];
											$videoLang=$row["languages"];
											$fileName=$row["file_name"];
											$fileExt=$row["file_ext"];
											$date=$row["date"];
											$validate=$row["validate"];
											$validate_date=$row["validate_date"];
											$validate_by=$row["validate_by"];

											$puntini="";
											if (strlen($videoDescription)>250) $puntini="...";
											$videoDescription=substr($videoDescription,0,250).$puntini;

											if ($date!="" AND $date!="0000-00-00 00:00:00") {
												$ins_data_expl=explode("-",$date);
												$ins_data_aa=$ins_data_expl[0];
												$ins_data_mm=$ins_data_expl[1];
												$ins_data_expl1=explode(" ",$ins_data_expl[2]);
												$ins_data_gg=$ins_data_expl1[0];
												$ins_data_expl2=explode(":",$ins_data_expl1[1]);
												$ins_data_ora=$ins_data_expl2[0];
												$ins_data_min=$ins_data_expl2[1];
												$date=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa;
											} else $date="";

											// Type of Product
											$sql7 = "SELECT * FROM db_tch_app ORDER BY nome";
											$result7=mysqli_query($conn, $sql7);

											$typeNameStr="";
											while ($row7=mysqli_fetch_array($result7)) {
												$id_key = $row7["id_key"];
												$typeName = $row7["nome"];
												if (strrpos($videoType,"_".$id_key."_")) {
													$typeNameStr.=$typeName.", ";
												}
											}
											$typeNameStr=substr($typeNameStr,0,-2);
								
								
											// Languages
											$sql7 = "SELECT * FROM VID_lang ORDER BY ord";
											$result7=mysqli_query($conn,$sql7);

											$langNameStr="";
											while ($row7=mysqli_fetch_array($result7)) { 
												$id_key=$row7["id_key"];
												$langName=$row7["nome"];
												if (strrpos($videoLang,"_".$id_key."_")) {
													$langNameStr.=$langName.", ";
												}
											}
											$langNameStr=substr($langNameStr,0,-2);

											?>
											<tr>
												<td style="font-size: 0.9em;line-height: 1.0em;">
													<div style="font-size: 1.1em;font-weight: 600;line-height: 1.3em;"><?=nl2br($videoTitle)?></div>
													<div style="padding-top: 2px;font-size: 0.9em;line-height: 1.3em;"><em><?=$videoAuthor?></em></div>
													<?php if ($typeNameStr) {?><div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;">Type of Product: <?=$typeNameStr?></div><?php }?>
													<?php if ($langNameStr) {?><div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;">Languages: <?=$langNameStr?></div><?php }?>
												</td>
												<td style="font-size: 0.8em;line-height: 1.0em;">
													<?php if (file_exists("./data/mathePlatform/SNA/tchMaterials/".$vidId.".".$fileExt)) {?>
														<em style="display: block;font-style: normal;padding: 0 0 2px 0;">Files:</em>
														<a href="./data/mathePlatform/SNA/tchMaterials/<?=$vidId?>.<?=$fileExt?>" target="_blank"><?=$fileName?></a><br />
													<?php }?>
													<?php if ($videoLink) {?>
														<em style="display: block;font-style: normal;padding: 5px 0 2px 0;">Useful Links:</em>
														<?=nl2br(replaceLinks($videoLink))?>
													<?php }?>
												</td>
												<td style="font-size: 0.9em;line-height: 1.0em;">
													<div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;"><?=$videoDescription?></div>
												</td>
											</tr>
											<?php
											$count+=1;
										}
										?>
										</tbody>
									</table>					


									<?php if ($pagine>1) include('./impianto/paginazione2.php'); //paginazione?>
								
								<?php } else {?>	
									<p style="padding: 25px 0 0 0;font-size: 1.5em;font-weight: 400;color: #090;text-align: center;">No teaching materials available</p>
								<?php }?>
						<?php }?>




					<?php } else {?>
						<style>
							input.submit {
								padding: 1px 15px;
								font-size: 1em;
								font-weight: 400;
								color: #fff;
								text-align: center;

								/* verde */
								border-top: 1px solid #ccc;
								background: #006600;
								background: -webkit-gradient(linear, left top, left bottom, from(#33cc33), to(#006600));
								background: -webkit-linear-gradient(top, #33cc33, #006600);
								background: -moz-linear-gradient(top, #33cc33, #006600);
								background: -ms-linear-gradient(top, #33cc33, #006600);
								background: -o-linear-gradient(top, #33cc33, #006600);

								-webkit-border-radius: 6px;
								-moz-border-radius: 6px;
								border-radius: 6px;
							}

						</style>

						<div style="padding: 15px 0 35px 0;font-size: 1.2em;text-align: center;">
							<p>Here you can find a collection of teaching materials about several math topics.</p>
							<p style>To view the teaching materials you need to login:</p>
							<!-- <form method="post" action="./impianto/inc/check_mathePlatform.php" style="padding: 15px 0 15px 0;">
								<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 3px;" />
								<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 3px;" />
								<input type="submit" class="submit" value="" style="width: 27px;height: 22px;margin: 0 12px 0 5px;padding: 2px 5px;cursor: pointer;border: solid 1px #777;border-radius: 7;background: url('./impianto/img/icone/ra_submit.png') #f4d19d no-repeat 5px 4px;" />
							</form> -->
							<form method="post" action="./impianto/inc/check_mathePlatform.php" style="padding: 15px 0 15px 0;">
								<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 8px;" />
								<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 8px;" />
								<input type="submit" class="submit" value="Login" style="display: block;width: 250px;margin: 10px auto;" />
							</form>

							<p>If you do not have username and password, please <a href="./MP_signIn.php">register to the portal</a>.</p>
						</div>
						<hr />
							<div style="float: left;width: 450px;margin-right: 100px;margin-bottom: 25px;">
								<p>Video tutorial for lecturers on how to register</p>
								<iframe width="450" height="253" src="https://www.youtube.com/embed/W9CuBl97SRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div style="float: left;width: 450px;margin-bottom: 25px;">
								<p>Video tutorial for lecturers on how to register</p>
								<iframe width="450" height="253" src="https://www.youtube.com/embed/W9CuBl97SRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div class="clear"></div>
							<div style="padding-top: 5px;"><a href="./files/MathE_Guidebook.pdf" class="nw"><img src="./impianto/img/pdf1.png" width="50" height="50" border="0" alt="" /></a> For more information, please consult the <a href="./files/MathE_Guidebook.pdf" class="nw">MathE Guidebook</a></div>
							<hr />
						<p style="padding-top: 15px;font-size: 1.2em;">In this section you can find a collection of teaching materials  on the following math topics/subtopics:</p>
						<div>
							<ul>
							<?php
							$sql = "
								SELECT * 
								FROM platform__topic 
								WHERE (hidden=0) 
								ORDER BY name";
							$result=mysqli_query($conn,$sql);

							while ($row=mysqli_fetch_array($result)) { 
								$topicId=($row["id"]);
								$topicName=($row["name"]);

								$sql1 = "
									SELECT * 
									FROM platform__SNA__questions 
									WHERE (topic=$topicId AND validate=1)";
								$result1=mysqli_query($conn,$sql1);
								$qstNb=mysqli_num_rows($result1);

								if ($qstNb>0) {
									?><li style="font-size: 1.2em;font-weight: 600;"><?=$topicName?></li><?php


									$sql3 = "
										SELECT * 
										FROM platform__subtopic 
										WHERE (id_top=$topicId AND hidden=0)";
									$result3=mysqli_query($conn,$sql3);

									while ($row3=mysqli_fetch_array($result3)) { 
										$qstNb2=0;
										$subtopicName="";
										
										$subtopicId=$row3["id"];
										$subtopicName=$row3["name"];
										
										$sql2 = "
											SELECT * 
											FROM platform__SNA__questions 
											WHERE (topic=$topicId AND subtopic=$subtopicId AND validate=1)";
										$result2=mysqli_query($conn,$sql2);
										$qstNb2=mysqli_num_rows($result2);

										if ($subtopicName AND $qstNb2>0) {
											?><li style="font-size: 1.2em;margin-left: 25px;font-style: italic;"><?=$subtopicName?></li><?php
										}
									}



								}
							}

							?>
							</ul>
						</div>


					<?php }?>






					</div>			
				</div> <!-- page_crp -->
				
				<!-- END contenuto pagina -->
				
				
			</div> <!-- single-content -->
		    </div>
			
			<div class="col-1"></div>
		</div>
	    </div>
	</section>
	</main>
			    
			    
    <!-- Footer page -->
	<?php include('./impianto/piede.php'); //PIEDE?>

    <!-- Back to top -->
    <div id="back-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- JS -->

    <!-- Jquery and Boostrap library -->
    <script src="vendor/bootstrap/js/popper.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Other js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEmXgQ65zpsjsEAfNPP9mBAz-5zjnIZBw"></script>
    <script src="js/theme-map.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.js"></script>
    <script src="js/isotope-docs.min.js"></script>

    <!-- Vendor JS -->
    <script src="vendor/slick/slick.min.js"></script>
    <script src='vendor/jquery-ui/jquery-ui.min.js'></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src='vendor/fullcalendar/lib/moment.min.js'></script>
    <script src='vendor/fullcalendar/fullcalendar.min.js'></script>
    <script src='vendor/wow/dist/wow.min.js'></script>

    <!-- REVOLUTION JS FILES -->
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Form JS -->
    <script src="js/validate-form.js"></script>
    <script src="js/config-contact.js"></script>

    <!-- Main JS -->
    <script src="js/main.js"></script> 
</body>
</html>
