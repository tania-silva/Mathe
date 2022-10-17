<hr />
<div style="padding-left: 10px;">
	<p id="rsv01"><a href="./reserved.php">RESERVED AREA</a></p>
	<div id="rsv02">
		Welcome <em><?=$usr_name?> <?=$usr_surname?></em>
	</div>

	<?php if ($usr_completeProfile==1) {?>
		<ul id="rsv03" style="margin: 5px 0 0 0;">
			<li style="margin: 0 0 0 -5px;"><a href="./MP_STUD_completeProfile.php?userId=<?=$usrId?>">Update your Profile</a></li>
			<li style="margin: 0 0 0 -5px;"><a href="./MP_STUD_changePassword.php?userId=<?=$usrId?>">Change Password</a></li>
			<li style="margin: 0 0 10px -5px;"><a href="./impianto/inc/logout.php">Logout</a></li>

			<p class="title7">Student Final Assessment</p>
			<li><a href="./MP_STUD_SFA_assessmentManage.php">List of Final Assessment</a></li>
		</ul>

	<?php } else {?>
		<p style="padding: 25px 35px 0 0;">Thanks for registering to the Mathe Portal.</p>
		<p><br />Before start working on the platform, you need to complete your profile.</p>
	<?php }?>
</div>