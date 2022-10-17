<?
include('./impianto/inc/function.php'); // funzioni PHP

$part_id=$_GET["part_id"];
$par=$_GET["par"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
<head>
	<title><?=$title?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="Generator" content="AmeeIV" />
	<meta name="Author" content="Ing. Francesco Pinzani" />
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/struttura.css" />
	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
</head>

<body>
	<div id="container">
		<? include('./impianto/cappello.php'); //PIEDE?>
		<? include('./impianto/testa.php'); //PIEDE?>
		<div id="cnt1">
			<div id="corpo">

			
				<h1><?=$lnk06m?></h1>
				<p id="crumbs"><a href="./index.php">Homepage</a> > <?=strip_tags($lnk05)?> > <?=$lnk05d?></p>

				<div id="page_sx">
					<!-- <p class="tit">Schools</p> -->
					<img src="./impianto/img/sx_schools.jpg" width="190" height="103" alt="" class="ntr" />
					<div class="intro"><?=$main_txt?></div>
				</div>
				<div id="page_crp" style="padding-top: 0px;">

					<div>
						<? 
						if ($part_id==8 OR $part_id==51 OR $part_id==52) $nation="Italy"; 
						elseif ($part_id==42 OR $part_id==44 OR $part_id==50) $nation="Lithuania"; 
						elseif ($part_id==54 OR $part_id==55) $nation="Romania"; 
						else $nation="All"; 
						?>
						<div class="titpar">
							<p style="float: left;width: 290px;padding: 0;">Country in focus: <?=$nation?></p>
							<p style="float: right;width: 450px;text-align: right;color: #666;">
								Click on the country of Interest: 
								<a href="./schools.php?part_id=8_51_52&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Italy"><img src="./impianto/img/flag/flag_it.jpg" width="18" height="12" alt="" /></a> 
								<a href="./schools.php?part_id=42_44_50&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Lithuania"><img src="./impianto/img/flag/flag_lituania.jpg" width="18" height="12" alt="" /></a>
								<a href="./schools.php?part_id=54_55&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Romania"><img src="./impianto/img/flag/flag_romania.jpg" width="18" height="12" alt="" /></a> 
								<!-- <a href="./schools.php?part_id=54_56&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Turkey"><img src="./impianto/img/flag/flag_turkey.jpg" width="18" height="12" alt="" /></a>
								<a href="./schools.php?part_id=55&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from United Kingdom"><img src="./impianto/img/flag/flag_uk.jpg" width="18" height="12" alt="" /></a> -->
								<a href="./schools.php?doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>"><img src="./impianto/img/flag/flag_eu.jpg" width="18" height="12" alt="Select All Schools " title="" /></a>
							</p>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>

					<div style="padding: 3px 3px 6px 3px;background-color: #7E3314;text-align: right;border-bottom:solid 1px #fff;">
						<!-- <select name="country" onchange='javascript:document.location.href="./schools.php?par="+this.options[this.selectedIndex].value+"&part_id=<?=$part_id?>";'>
							<option value="">Select Partner</option>
							<?
							$sql55 = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
							$result55=mysql_query($sql55,$conn);

							while ($row55=mysql_fetch_array($result55)) { 
								?>
								<option value="<?=$row55["id_partner"]?>" <?if ($par==$row55["id_partner"]) echo "selected"?>><?=Pulisci_READ($row55["name"])?></option>
								<?
							}
							?>
						</select> -->
					</div>
					
							
					<?
					if ($part_id OR $par) {
						$where=" WHERE ((";
	//					if ($str_search1) $where.="(doc_title like '%".$str_search1."%' OR doc_keywords like '%".$str_search1."%') AND ";
	//					if ($doc_lang) $where.="language='".$doc_lang."' AND ";
	//					if ($str_search_langreview) $where.="langcom='".$str_search_langreview."' AND ";
						if ($part_id) {
							$part_id_ar= explode("_",$part_id);
							for ($k=0;$k<count($part_id_ar);$k++) {
								$where.="id_partner=".$part_id_ar[$k]." OR ";
							}
							$where=substr($where,0,-4);
							$where.=") AND ";
						}
						if ($par) $where.="id_partner=".$par.") AND ";
						$where=substr($where,0,-5);
						$where.=")";
					} else {
						$where="";
					}

					$sql = "SELECT * FROM members_school".$where." ORDER BY sch_name ASC";

					$result=mysql_query($sql,$conn);
					$n_doc=mysql_num_rows($result);

					if ($n_doc) {

						?>
						<table class="for2" style="font-size: 1.1em;">
							<thead>
								<tr>
									<td style="width: 100%">Name of the school</td>
									<td><img src="./wiztr.gif" width="150" height="1" />Country</td>
									<td><img src="./wiztr.gif" width="300" height="1" />School Typology</td>
								</tr>
							</thead>
							<tbody>
						<?

						while ($row=mysql_fetch_array($result)) { 
							$sch_id=$row["id_sch"];
							$sch_id_partner=$row["id_partner"];
							
							$sch_name=Pulisci_READ($row["sch_name"]);
							$sch_address=Pulisci_READ($row["sch_address"]);
							$sch_type=Pulisci_READ($row["sch_type"]);
							$sch_type_other=Pulisci_READ($row["sch_type_other"]);
							if ($sch_type!="Other") $sch_type_tr=$sch_type; else echo $sch_type_tr=$sch_type_other;

							$par_permit="off";
							if (($id_partner==$row["doc_id_partner"] && $_SESSION["usr_level"]>=2) || $_SESSION["usr_level"]==5) $par_permit="on";
							$adm_permit="off";
							if ($_SESSION["usr_level"]==5) $adm_permit="on";

							$sql33 = "SELECT * FROM partner WHERE id_partner=".$sch_id_partner;
							$result33=mysql_query($sql33,$conn);

							while ($row33=mysql_fetch_array($result33)) { 
								$prt_name=$row33["name"];
								$prt_country=$row33["country"];
							}




							?>
								<tr>
									<td class="bold" style="font-size: 1.0em;line-height: 1.1em;"><a href="./schools_scheda.php?id_sch=<?=$sch_id?>&part_id=<?=$part_id?>&par=<?=$par?>"><?=$sch_name?></a></td>
									<td><?=$prt_country?></td>
									<td><?=$sch_type_tr?></td>
								</tr>
							<?
						}
						?>
							</tbody>
						</table>
						<?
					} else {?>
						<p style="text-align: center;padding: 20px 0 0 0;">No schools available</p>
					<? } ?>


				</div> <!-- page_crp


				<div class="clear"></div>
			</div> <!-- corpo rsv -->
			<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->
	<? include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
