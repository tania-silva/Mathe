<?php

// Se scaduta la sessione si esce dal pannello
if (!$_SESSION["guest"]) {
	$strpas11="./denied.php";
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
}

?>