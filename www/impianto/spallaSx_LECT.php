<hr />

<p id="rsv01"><a href="./reserved.php">RESERVED AREA</a></p>
<div id="rsv02">
	Welcome <em><?=$usr_name?> <?=$usr_surname?></em>
	<strong><?=$userProfileTr?></strong>
</div>

<?php if ($usr_completeProfile==1 AND $usr_banned==0) {
	
	?>

	<ul id="rsv03" style="margin: 5px 0 0 0;">
		<li style="margin: 0 0 0 -5px;"><a href="./MP_LECT_completeProfile.php?userId=<?=$usrId?>">Update your Profile</a></li>
		<li style="margin: 0 0 0 -5px;"><a href="./MP_LECT_changePassword.php?userId=<?=$usrId?>">Change Password</a></li>
		<li style="margin: 0 0 10px -5px;"><a href="./impianto/inc/logout.php">Logout</a></li>

		<p class="title7">Student Need Assessment</p>
		<li><a href="./MP_LECT_SNA_questionAdd.php">Insert new Question</a></li>
		<li><a href="./MP_LECT_SNA_questionManage.php">Manage your Questions</a></li>
		<?php if ($usrProfile=="admin") {?><li><a href="./MP_LECT_SNA_questionValidateList.php">Validate Questions</a></li><?php }?>
		<?php if ($usrProfile=="admin") {?><li><a href="./MP_LECT_SNA_questionApprovedList.php">All Validated Questions</a></li><?php }?>

		<p class="title7">Student Final Assessment</p>
		<li><a href="./MP_LECT_SFA_questionAdd.php">Insert new Question</a></li>
		<li><a href="./MP_LECT_SFA_questionManage.php">Manage your Questions</a></li>
		<li><a href="./MP_LECT_SFA_assessmentNew.php">Create new Final Assessment</a></li>
		<li><a href="./MP_LECT_SFA_assessmentManage.php">Manage Final Assessment</a></li>
		<?php if ($usrProfile=="admin") {?><li><a href="./MP_LECT_SFA_questionValidateList.php">Validate Questions</a></li><?php }?>
		<?php if ($usrProfile=="admin") {?><li><a href="./MP_LECT_SFA_questionApprovedList.php">All Validated Questions</a></li><?php }?>

		<p class="title7">Video Reviews</p>
		<li><a href="./MP_LECT_SNA_videoRevAdd.php">Insert new Video Review</a></li>
		<li><a href="./MP_LECT_SNA_videoRevManage.php">Manage your Video Reviews</a></li>
		<?php if ($userPT) {?><li><a href="MP_LECT_SNA_videoRevValidateList.php">Validate Video Reviews</a></li><?php }?>
		<?php if ($userPT) {?><li><a href="MP_LECT_SNA_videoRevApprovedList.php">All Validated Video Reviews</a></li><?php }?>
			
		<p class="title7">Video Lessons</p>
		<li><a href="./MP_LECT_SNA_videoLesAdd.php">Insert new Video Lesson</a></li>
		<li><a href="./MP_LECT_SNA_videoLesManage.php">Manage your Video Lessons</a></li>
		<?php if ($userPT) {?><li><a href="MP_LECT_SNA_videoLesValidateList.php">Validate Video Lessons</a></li><?php }?>
		<?php if ($userPT) {?><li><a href="MP_LECT_SNA_videoLesApprovedList.php">All Validated Video Lessons</a></li><?php }?>
			
		<p class="title7">Teaching Material</p>
		<li><a href="./MP_LECT_SNA_TchMatAdd.php">Insert new Teaching Material</a></li>
		<li><a href="./MP_LECT_SNA_TchMatManage.php">Manage your Teaching Materials</a></li>
		<?php if ($userPT) {?><li><a href="MP_LECT_SNA_TchMatValidateList.php">Validate Teaching Materials</a></li><?php }?>
		<?php if ($userPT) {?><li><a href="MP_LECT_SNA_TchMatApprovedList.php">All Validated Teaching Materials</a></li><?php }?>
		
		<?php if ($userPT) {?>			
			<p class="title7">Topics and Subtopics</p>
			<li><a href="./MP_LECT_topicManage.php">Manage Topics and Subtopics</a></li>
			<li><a href="./MP_LECT_topicAssign.php">Assign Topics and Subtopics</a></li>
			<li><a href="./MP_LECT_keywordsManage.php">Manage Keywords</a></li>
		<?php }?>

		<?php if ($userPT) {?>	
			<p class="title7">University</p>
			<li><a href="./MP_UNI_manageList.php">Manage Universities</a></li>
			<li><a href="./MP_UNI_add.php">Insert new University</a></li>
		<?php }?>
			
		<p class="title7">Users</p>
		<?php if ($userPT) {?>	
			<li><a href="./MP_LECT_SNA_adminList.php">List of Admins</a></li>
			<li><a href="./MP_LECT_SNA_lecturerList.php">List of Lecturers</a></li>
		<?php }?>
		<li><a href="./MP_LECT_SNA_studentList.php">List of Students</a></li>
	</ul>

<?php } else {?>
	<p style="padding: 25px 0 0 0;">Thanks for registering to the Mathe Portal.</p>
	<p><br />Before start working on the platform, you need to complete your profile.</p>
<?php }?>

