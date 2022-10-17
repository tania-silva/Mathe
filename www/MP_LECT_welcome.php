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



					<div style="margin-top: 85px;">
						<a href="./STAS_SNA.php" style="color: #444;">
							<img src="./impianto/img/sx_STAS_SNA.jpg" width="120" alt="" style="float: left;margin: 0 10px 0 0;" />
							<div>
								<p style="font-size: 1.3em;">Self Need Assessment</p>
								<p style="font-size: 1.1em;">This toolkit allows students to carry out a self-evaluation of their knowledge on 10 selected Math topics</p>
							</div>
						</a>
						<div class="clear"></div>
					</div>

					<div style="margin-top: 25px;">
						<a href="./STAS_FA.php" style="color: #444;">
							<img src="./impianto/img/sx_STAS_FA.jpg" width="120" alt="" style="float: left;margin: 0 10px 0 0;" />
							<div>
								<p style="font-size: 1.3em;">Final Assessment</p>
								<p style="font-size: 1.1em;">This toolkit provides teachers with the possibility to organize for their students an online test on selected Math topics.</p>
							</div>
						</a>
						<div class="clear"></div>
					</div>
					
					<div style="margin-top: 25px;">
						<a href="./MALI_VC.php" style="color: #444;">
							<img src="./impianto/img/sx_MALI_VC.jpg" width="120" alt="" style="float: left;margin: 0 10px 0 0;" />
							<div>
								<p style="font-size: 1.3em;">Video Collection</p>
								<p style="font-size: 1.1em;">A collection of reviewed video lessons on selected Math topics.</p>
							</div>
						</a>
						<div class="clear"></div>
					</div>
					
					<div style="margin-top: 25px;">
						<a href="./MALI_TM.php" style="color: #444;">
							<img src="./impianto/img/sx_MALI_TM.jpg" width="120" alt="" style="float: left;margin: 0 10px 0 0;" />
							<div>
								<p style="font-size: 1.3em;">Teaching Materials</p>
								<p style="font-size: 1.1em;">A collection of teaching and Learning material in order to support students in the acquisition of competences on Math selected topics</p>
							</div>
						</a>
						<div class="clear"></div>
					</div>



					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>