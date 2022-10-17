<?php
	// Se scaduta la sessione si esce dal pannello
	if (!$_SESSION["id_user"] OR $_SESSION["usr_level"]<2) {
		$strpas11="./denied.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
	}

?>
