<hr />

<p id="rsv01"><a href="./reserved.php">RESERVED AREA</a></p>
<?php if ($_SESSION["usr_level"]>=2) {  ?>
	<div id="rsv02">
		Welcome <em><?=$usr_name_func?></em>
		<strong><?=$ptn_name_func?></strong>
	</div>
	<ul id="rsv03">
		<li style="margin: 0 0 10px -5px;"><a href="./impianto/inc/logout.php" style="color: #c00;">Logout</a></li>
		<p class="title7">Project Management</p>
		<li><a href="./rsv_pm_wip.php">Work in Progress</a></li>
		<li><a href="./rsv_pm_diss.php">Dissemination</a></li>
		<p class="title7">Lecturers</p>
		<li><a href="./rsv_lecturers.php">Manage Lecturers</a></li>
		<li><a href="./rsv_lecturers_nuovo.php">Insert new Lecturer</a></li>
		<!-- <p class="title7" style="color: #900;">Students</p>
		<li><a href="./rsv_students.php">Manage Students</a></li>
		<li><a href="./rsv_students_nuovo.php">Insert new Student</a></li> -->
		<p class="title7">Associated Partners</p>
		<li><a href="./rsv_asspartners.php">Manage Partners</a></li>
		<li><a href="./rsv_asspartners_nuovo.php">Insert new Partner</a></li>
		
		<?php if ($_SESSION["usr_level"]==5) {?>
			<p class="title7">News</p>
			<li><a href="./rsv_news.php">Manage News</a></li>
			<p class="title7">Press Review</p>
			<li><a href="./rsv_press.php">Manage Press Review</a></li>
		<?php }?>
		<hr />
		
		<p class="title7">Translate into</p>
		<?php
		if ($_SESSION["usr_level"]==5) {
			echo "<li class=\"sec\"><a href=\"./rsv_translation.php?lng=EN\">English</a></li>";
		}
		if ($_SESSION["usr_level"]==5 OR $_SESSION["id_partner"]==8 OR $_SESSION["id_partner"]==50 OR $_SESSION["id_partner"]==51) {
			echo "<li class=\"sec\"><a href=\"./rsv_translation.php?lng=IT\">Italian</a></li>";
		}
		if ($_SESSION["usr_level"]==5 OR $_SESSION["id_partner"]==42 OR $_SESSION["id_partner"]==55) {  
			echo "<li class=\"sec\"><a href=\"./rsv_translation.php?lng=SE\">Swedish</a></li>";
		}
		?>
	</ul>
<?php } else { ?>
	<ul id="rsv03">
		<li id="lgt"><a href="./impianto/inc/logout.php">Logout</a></li>
	</ul>
<?php }?>
