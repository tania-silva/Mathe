<?php
session_start();

include_once('./function.php');

//////////////////////////////////////////////////  Sanitize and crypt  library
$DS=DIRECTORY_SEPARATOR;
//require_once("../../librerie".$DS."sanitize".$DS."sanitize.lib.php");
require_once("../../librerie".$DS."crypt".$DS."crypt.lib.php");

//$var_post=array(
//		'usr'=>'sql',
//		'psw'=>'sql',
//);
//// $usr = '';
//$var_get=[];
//// $var_post=[];
//
//sanitize($_POST, $var_post);
//if(isset($_GET)) sanitize($_GET, $var_get);
////////////////////////////////////////////////////


$usr = isset($_POST["usr"]) ? $_POST["usr"] : ''; //echo $_POST["usr"];
$psw = isset($_POST["psw"]) ? $_POST["psw"] : ''; //echo $_POST["psw"];

$sql = "
	SELECT *
	FROM user";
$result=mysqli_query($conn, $sql);

$stato=0;
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

////////////////////////////////////// to case sensitive --> add passwordMatch($usr_password,$psw) ////////////////////////////////////
	if ($usr_username && strtolower($usr_username)==strtolower($usr) && $usr_password && passwordMatch($usr_password,$psw) && $usr_abilitato==1) {

		$_SESSION["id_user"] = $id_user;
		$_SESSION["id_partner"] = $id_partner;
		$_SESSION["usr_level"] = $usr_level;

		if ($usr_level >= 2) {
			echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
			echo "document.location.href='../../reserved.php?str=".$stato."';";
			echo "</SCRIPT>";
		} else {
			echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
			echo "document.location.href='../../index.php';";
			echo "</SCRIPT>";
		}

		$stato=1;

	}
}

if ($stato != "1") {
	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='../../denied.php?str=".$stato."';";
	echo "</SCRIPT>";
}

?>
