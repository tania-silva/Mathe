<?
session_start();

$lng=trim($_GET["lng"]);
$url2catch=$_SERVER["HTTP_REFERER"];

$_SESSION["lng"]=$lng;

echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
echo "document.location.href='".$url2catch."';";
echo "</SCRIPT>";
?>