<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






				<hr />
				<?php if ($partnerPT) { ?> 

					<p style="font-size: 1.1;font-weight: 600;">UTILITY</p>
					<ol class="lore01">
						<li><a href="./utility/dissemination.php" class="nw">Dissemination</a></li>
						<p>...............................................</p>
						<li><a href="./utility/SNA_questions.php" class="nw">SNA Questions</a></li>
						<li><a href="./utility/SNA_videoReviews.php" class="nw">SNA Video Reviews</a></li>
						<li><a href="./utility/SNA_videoLessons.php" class="nw">SNA Video Lessons</a></li>
						<li><a href="./utility/SNA_Qst2Videos.php" class="nw">SNA Question and related videos lessons and reviews</a></li>
						<li><a href="./utility/SNA_VideoREV2Qsts.php" class="nw">Video Reviews and related SNA Questions</a></li>
						<li><a href="./utility/SNA_VideoLES2Qsts.php" class="nw">Video Lessons and related SNA Questions</a></li>
						<li><a href="./utility/SNA_TchMaterial.php" class="nw">SNA Teaching Material</a></li>
						<p>...............................................</p>
						<li><a href="./utility/SFA_questions.php" class="nw">SFA Questions</a></li>
						<p>...............................................</p>
                        <li><a href="./statistics/questions.php" class="nw">Download CSV with Question Statistics</a></li>
					</ol>

					<br /><br />
					<strong>Online Evaluation</strong><br />
					<a href="./SURVEY_list.php">Evaluation</a>.
				
				
				
				
				
				<?php }?>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
