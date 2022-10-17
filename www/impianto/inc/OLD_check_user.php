<?php 
session_start();

include_once('./function.php');

//////////////////////////////////////////////////  Sanitize and crypt  library 
$DS=DIRECTORY_SEPARATOR;
require_once("../../lib".$DS."sanitize".$DS."sanitize.lib.php");
require_once("../../lib".$DS."crypt".$DS."crypt.lib.php");

$var_post=array(
		'usr'=>'sql',
		'psw'=>'sql',
);

sanitize($_POST, $var_post);
sanitize($_GET, $var_get);
////////////////////////////////////////////////////

if (isset($_POST["usr"])) $usr=$_POST["usr"];
if (isset($_POST["psw"])) $psw=$_POST["psw"];

$stato=0;

if ($usr=="partner" OR $usr=="teacher") {
	
	/* Accesso per PARTNER e TEACHER (accesso GUEST) */
	$sql = "
		SELECT * 
		FROM user 
		WHERE usr_username='".strtolower($usr)."'";
	$result=mysql_query($sql,$conn);

	while ($row=mysql_fetch_array($result)) { 
		
		$id_user="";
		$usr_level="";
		$usr_abilitato="";
		$usr_username="";
		$usr_password="";
		
		$id_user=$row["id_user"];
		$id_partner=$row["id_partner"];
		$usr_level=$row["usr_level"];
		$usr_abilitato=$row["usr_abilitato"];
		$usr_username=$row["usr_username"];
		$usr_password=$row["usr_password"];

		if (passwordMatch($usr_password,$psw)) {

			$_SESSION["id_user"]=$id_user;
			$_SESSION["id_partner"]=$id_partner;
			$_SESSION["usr_level"]=$usr_level;

			echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
			echo "document.location.href='".$_SERVER["HTTP_REFERER"]."';";
			echo "</SCRIPT>";

			$stato=1;

		}
	}

} else {

	/* Accesso LECTURER e STUDENT */
	$sql = "
		SELECT * 
		FROM platform__user 
		WHERE (
			username='".strtolower($usr)."' AND 
			password='".md5($psw)."' AND 
			verifyEmail=1
		) LIMIT 1";
	$result=mysql_query($sql,$conn);
	$usrFind=mysql_num_rows($result);

	$stato=0;

	if ($usrFind==1) {
		while ($row=mysql_fetch_array($result)) { 
			
			$usrId=$row["id"];
			$usrGuid=$row["guid"];
			$usrTypology=$row["typology"];
			$usrProfile=$row["profile"];
			$usrCheckcode=$row["checkcode"];
			$usrCompleteProfile=$row["completeProfile"];

			$usrCode=$usrCheckcode;
			if (!$usrCode) $usrCode=$usrGuid;

			$_SESSION["guest"]=base64_encode($usrId."|".$usrCode."|".$usrTypology."|".$usrProfile);


			if ($usrCompleteProfile==1) {

				if ($usrTypology=="lecturer") $pageWelcome="../../MP_LECT_welcome.php";
				elseif ($usrTypology=="student") $pageWelcome="../../MP_STUD_welcome.php";
				else $pageWelcome="../../denied.php";

				echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
				echo "document.location.href='".$pageWelcome."';";
				echo "</SCRIPT>";

			} else {

				if ($usrTypology=="lecturer") $pageWelcome="../../MP_LECT_completeProfile.php?userId=".$usrId;
				elseif ($usrTypology=="student") $pageWelcome="../../MP_STUD_completeProfile.php?userId=".$usrId;
				else $pageWelcome="../../denied.php";

				echo $pageWelcome;

				echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
				echo "document.location.href='".$pageWelcome."';";
				echo "</SCRIPT>";

			}

			$stato=1;

		}
	}

}

if ($stato!="1") {
	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='../../password_forgot.php';";
	echo "</SCRIPT>";
}

?>
