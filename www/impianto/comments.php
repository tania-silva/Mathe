<?
//////////////////////////// SANITIZE VARS ///////////////////////////
//$DS=DIRECTORY_SEPARATOR;
//$root="..".$DS;
//require_once($root."lib".$DS."sanitize".$DS."sanitize.lib.php");
//
//$var_get=array(
//		'act'=>'sql',
//		'id'=>'int',
//		'art_id'=>'int'
//);
//$var_post=array(
//		'name'=>'sql',
//		'country'=>'sql',
//		'email'=>'sql',
//		'msg'=>'sql',
//		'id_elea'=>'int',
//		'id_doc'=>'int'
//
//);
//sanitize($_GET, $var_get);
//sanitize($_POST, $var_post);
//////////////////////////////////////////////////////
$cmm_act=$_GET["cmm_act"];
$cmm_page=file_name();

if ($cmm_act=="reg") {

	$data=date("Ymd");
	$name=$_POST["name"];
	$country=$_POST["country"];
	$msg=$_POST["msg"];
	$area=$_POST["cmm_area"];

	if ($name AND $msg AND $cmm_area) {

		if ($_SESSION["id_user"] AND $_SESSION["usr_level"]>=1) {

			$sql = "
				INSERT INTO `comments` 
				(`area` , `usr_name` , `usr_country` , `comment` , `data` , `filename`)  VALUES 
				('$cmm_area' ,'$name' ,'$country' ,'$msg' ,'$data' ,'$file_name')";
			$result=mysql_query($sql,$conn);
			//$art_id=mysql_insert_id();

			//Redirect su messaggio
			$strpas11="./".$cmm_page.".php#cmm";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
		}
		
		//Redirect su messaggio
		$strpas11="./".$cmm_page.".php#cmm";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
	
	}
}

if ($cmm_act=="del") {

	$id_cmm=$_GET["id_cmm"];

	if ($_SESSION["usr_level"] && $_SESSION["usr_level"]!=-1) {

		$sql = "DELETE FROM `comments` WHERE id_cmm='".$id_cmm."'";
		$result=mysql_query($sql,$conn);

	}

	//Redirect su messaggio
	$strpas11="./".$cmm_page.".php#cmm";
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
	
}

?>

<p style="padding: 5px;border-bottom: solid 1px #ddd;"><? if ($_SESSION["id_user"] AND $_SESSION["usr_level"]>=1 AND $_SESSION["id_user"]!=68) { ?><a href="#comment" style="font-weight: 400;text-decoration: underline;">Your comments are welcome.</a><?}?> In order to post a comment it is compulsory to be logged in.</p>
<?
$sql = "
	SELECT * 
	FROM comments 
	WHERE area='".$cmm_area."' 
	ORDER BY data DESC,id_cmm DESC";
$result=mysql_query($sql,$conn);

if ($result) {
	while ($row=mysql_fetch_array($result)) { 
		$id_comm=$row["id_cmm"];
		$name=stripslashes($row["usr_name"]);
		$country=stripslashes($row["usr_country"]);
		$comment=stripslashes($row["comment"]);
		$data=$row["data"];
		$filename=$row["filename"];

		$dt_pubbl_gg=substr($data,6,2);
		$dt_pubbl_mm=substr($data,4,2);
		$dt_pubbl_aa=substr($data,0,4);
		$dt_pubbl=$dt_pubbl_aa.".".$dt_pubbl_mm.".".$dt_pubbl_gg;

		?>
		<div style="padding: 10px;border: dotted 1px #999;font-size: 1em;border-width: 0 0 2px 0">
			<p style="font: bold 13pt tahoma;"><? if ($_SESSION["id_user"] AND $_SESSION["usr_level"]==5) {  ?><a href="./<?=$cmm_page?>.php?cmm_act=del&id_cmm=<?=$id_comm?>&cmm_area=<?=$cmm_area?>">DELETE THIS MESSAGE</a><?}?></p>
			<p style="width: 100px;float: right;">Date: <?=$dt_pubbl?></p>
			<p>Posted by <strong><?=$name?></strong> - <?=$country?></p>
			<p style="margin: 5px 0 0 0;"><?=nl2br(replaceLinks($comment))?></p>
		</div>
		<?
	}
}
?>

<? if ($_SESSION["id_user"] AND $_SESSION["usr_level"]>=1 AND $_SESSION["id_user"]!=68) {  ?>
	<a name="comment"></a>
	<form method="post" enctype="multipart/form-data" action="./<?=$cmm_page?>.php?cmm_act=reg&cmm_area=<?=$cmm_area?>">
		<div style="margin: 45px 0 5px 15px;">
			<strong>Your comments are welcome</strong>. Fill the form and click "Send message".
		</div>
		<div style="padding: 10px;border: solid 1px #09801b;border-radius: 5px;background: url('./impianto/img/comments.jpg') transparent no-repeat right bottom;">
			<p style="margin: 10px 0 0 0;">Your Name (*required)<br /><input type="text" name="name" style="width: 340px;padding: 5px;border: solid 1px #444;border-radius: 5px;" /></p>
			<p style="margin: 10px 0 0 0;">Country (*required)<br /><input type="text" name="country" style="width: 340px;padding: 5px;border: solid 1px #444;border-radius: 5px;" /></p>
			<div style="margin: 10px 0 0 0;">
				<textarea name="msg" rows="10" cols="50" style="width: 340px;padding: 5px;border: solid 1px #444;border-radius: 5px;"></textarea>
				<input type="hidden" name="cmm_area" value="<?=$cmm_area?>" />
			</div>
			<p style="margin: 10px 0 0 198px;"><input type="submit" value="Send message" style="padding: 10px;font-size: 1.3em;color: #fff;background-color: #5eaa11;border: solid 1px #3a6a0b;border-radius: 5px;cursor: pointer;" /></p>
		</div>
	</form>
<?}?>
			
