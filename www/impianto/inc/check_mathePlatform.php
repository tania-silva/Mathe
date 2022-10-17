<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();

include_once('./function.php');

//////////////////////////////////////////////////  Sanitize and crypt  library 
$DS=DIRECTORY_SEPARATOR;
//require_once("../../lib".$DS."sanitize".$DS."sanitize.lib.php");
require_once("../../lib".$DS."crypt".$DS."crypt.lib.php");

//$var_post=array(
//		'usr'=>'sql',
//		'psw'=>'sql',
//);
//
//sanitize($_POST, $var_post);
//sanitize($_GET, $var_get);
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
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		
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
//			include("/home/mathe/www/forum_login/teacher/Flarum.php");
//			$forum = new Flarum();
//			$forum->login(strtolower($usr), strtolower($usr), $psw);
//
//			loginTeacherForum($usr);

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
			verifyEmail=1 AND 
			(ban=0 OR (typology='lecturer' AND ban=1))
		) LIMIT 1";
	$result=mysqli_query($conn,$sql);
	$usrFind=mysqli_num_rows($result);

	$stato=0;

	if ($usrFind==1) {
		while ($row=mysqli_fetch_array($result)) { 
			
			$usrId=$row["id"];
			$usrGuid=$row["guid"];
			$usrTypology=$row["typology"];
			$usrProfile=$row["profile"];
			$usrCheckcode=$row["checkcode"];
			$usrCompleteProfile=$row["completeProfile"];
			$usrBanned=$row["ban"];

			$usrCode=$usrCheckcode;
			if (!$usrCode) $usrCode=$usrGuid;

			$_SESSION["guest"]=base64_encode($usrId."|".$usrCode."|".$usrTypology."|".$usrProfile);

                        //QUI DEVO FARE IL LOGIN
                                include("/home/mathe/www/forum_login/student/Flarum.php");
                                $forum = new Flarum();
                                $forum->login(strtolower($usr), strtolower($usr), $psw);
			
			//SE SONO LECTURE MI LOGGO ANCHE SUL SECONDO
			 if ($usrTypology=="lecturer") {
				loginTeacherForum($usr,$forum->returnToken());
			} 

			if ($usrCompleteProfile==1) {

				if ($usrTypology=="lecturer") {
					$pageWelcome="../../MP_LECT_welcome.php";
					if ($usrBanned==1) $pageWelcome="../../MP_LECT_completeProfile.php?userId=".$usrId;
				} elseif ($usrTypology=="student") $pageWelcome="../../MP_STUD_welcome.php";
				else $pageWelcome="../../denied.php";
				var_dump($pageWelcome);

				echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
				echo "document.location.href='".$pageWelcome."';";
				echo "</SCRIPT>";

			} else {

				if ($usrTypology=="lecturer") $pageWelcome="../../MP_LECT_completeProfile.php?userId=".$usrId;
				elseif ($usrTypology=="student") $pageWelcome="../../MP_STUD_completeProfile.php?userId=".$usrId;
				else $pageWelcome="../../denied.php";
				var_dump($pageWelcome);

				echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
				echo "document.location.href='".$pageWelcome."';";
				echo "</SCRIPT>";

			}

			$stato=1;

		}
	}

}
echo var_dump($pageWelcome);

if ($stato!="1") {
	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='../../password_forgot.php';";
	echo "</SCRIPT>";
}

?>
