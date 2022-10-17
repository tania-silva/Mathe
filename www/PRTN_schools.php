<?php
include('./impianto/inc/function.php'); // funzioni PHP


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
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
</head>
<body>
    
    <?php include("header.php"); ?>
    
    <main>
        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Schools</h1>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
			    <li class="breadcrumb-item"><a href="index.php">Project Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Schools</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>

        <!-- Blog detail -->
        <section class="single section-padding-large">
            <div class="container">
                <div class="row">
			<div class="col-2"></div>
			
                    <div class="col-8">
                        <div class="single-content">
                            <article class="item">
                                <h1 class="single-title">
                                      From this section it is possible to access to the information related to the schools involved in the Fiction project in the 4 European partner countries.
                                </h1>
				
                                <div class="info">
                                    <div class="entry">
                                        <span class="categories">
                                            <i class="fas fa-tag"></i>Project Management
                                        </span>
                                    </div>
                                </div>
				
                                <div class="blog-content">
				    
				    
				
				<div id="page_crp" style="padding-top: 0px;">

					<div>
						<?php  
						if ($part_id==8 OR $part_id==51 OR $part_id==54) $nation="Italy"; 
						elseif ($part_id==42 OR $part_id==55) $nation="Sweden"; 
						elseif ($part_id==50 OR $part_id==44) $nation="Ireland"; 
						else $nation="All"; 
						?>
						<div class="titpar">
							<p style="float: left;width: 290px;padding: 0;">Country in focus: <?=$nation?></p>
							<p style="float: right;width: 450px;text-align: right;color: #666;">
								Click on the country of Interest: 
								<a href="./PRTN_schools.php?part_id=8_51_54&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Italy"><img src="./impianto/img/flag/flag_it.jpg" width="18" height="12" alt="" /></a> 
								<a href="./PRTN_schools.php?part_id=42_55&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Sweden"><img src="./impianto/img/flag/flag_sweden.jpg" width="18" height="12" alt="" /></a>
								<a href="./PRTN_schools.php?part_id=50_44&doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>" title="Select the schools from Ireland"><img src="./impianto/img/flag/flag_ireland.jpg" width="18" height="12" alt="" /></a>
								<a href="./PRTN_schools.php?doc_lang=<?=$doc_lang?>&str_search_langreview=<?=$str_search_langreview?>&str_search=<?=$str_search?>"><img src="./impianto/img/flag/flag_eu.jpg" width="18" height="12" alt="Select All Schools " title="" /></a>
							</p>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>

					<div style="padding: 3px 3px 6px 3px;background-color: #446170;text-align: right;border-bottom:solid 1px #fff;"></div>
					
							
					<?php
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

				$sql = "SELECT * FROM members_school ".$where." ORDER BY sch_name ASC";

				$result = mysqli_query($conn, $sql);
				$n_doc = mysqli_num_rows($result);

				if ($n_doc) {

					?>
					<table class="table table-hover">
						<thead>
							<tr class="table_header" style="background-color: #446170; color:#fff;">
								<th>Name of the school</th>
								<th>Country</th>
								<th>School Typology</th>
							</tr>
						</thead>
						<tbody>
							<?php

							while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
								$sch_id = $row["id_sch"];
								$sch_id_partner = $row["id_partner"];

								$sch_name = Pulisci_READ($row["sch_name"]);
								$sch_address = Pulisci_READ($row["sch_address"]);
								$sch_type = Pulisci_READ($row["sch_type"]);
								$sch_type_other = Pulisci_READ($row["sch_type_other"]);
								if ($sch_type!="Other") $sch_type_tr = $sch_type; else echo $sch_type_tr = $sch_type_other;

								// $par_permit="off";
								// if (($id_partner_func == $row["id_partner"] && $_SESSION["usr_level"] >= 2) || $_SESSION["usr_level"] == 5) $par_permit = "on";
								// $adm_permit="off";
								// if ($_SESSION["usr_level"]==5) $adm_permit="on";

								$sql33 = "SELECT * FROM partner WHERE id_partner=".$sch_id_partner;
								$result33=mysqli_query($conn, $sql33);

								while ($row33=mysqli_fetch_array($result33)) {
									$prt_name=$row33["name"];
									$prt_country=$row33["country"];
								}

								?>
								<tr>
									<td class="bold" style="font-size: 1.0em;line-height: 1.1em;"><a href="./PRTN_schools_scheda.php?id_sch=<?=$sch_id?>&part_id=<?=$part_id?>&par=<?=$par?>"><?=$sch_name?></a></td>
									<td><?=$prt_country?></td>
									<td><?=$sch_type_tr?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<?php
				} else { ?>
					<p style="text-align: center;padding: 20px 0 0 0;">No schools available</p>
				<?php } ?>



<div class="clear"></div>

                                </div>
			</div>
		    </div>
		<div class="col-2"></div>
		</div>
	    </div>
	</div>
    </section>
</main>

	
	<?php  include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
