<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
////error_reporting(E_ALL);
////error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
//error_reporting(E_ERROR | E_PARSE);
error_reporting(0);

if (session_status() == PHP_SESSION_NONE) session_start();

if (substr(file_name(),0,4)=="rsv_" OR file_name()=="reserved") {
	include('./impianto/inc/protected.php'); //Se non loggato esci...
}

$siteTitle="MathE";
$root="https://".$_SERVER['HTTP_HOST'];
$rand_n=md5(microtime().date("r").rand(10000, 32000));

!isset($_SESSION["doc_id_partner"]) ? '' : $_SESSION["doc_id_partner"];
!isset($_SESSION["lng"]) ? $_SESSION["lng"] = '' : $_SESSION["lng"];

//decommentare per accedere all'area riservata
//$_SESSION["usr_level"] = 5;
//$_SESSION["id_user"] = 1;

$id_partner_func = '';

/* Connessione a MySQL */
//$dbuser="h1allyou";
//$userpass="Y89Io?09III";
//$db="h4allyou";

$dbuser="mathe";
$userpass="Math3!SiP";
$db="mathe";		
$dbserver="127.0.0.1";

$conn = mysqli_connect($dbserver, $dbuser, $userpass,$db)  or die("Connessione al database fallita");
mysqli_select_db($conn, $db) or die("Passaggio al database Fallito");
mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


/* Accesso db Forum */
        
$dbuser1="teacherforum";
$userpass1="forum-Teacher";
$db1="teacherforum";

$connTchForum = mysqli_connect($dbserver, $dbuser1, $userpass1,$db1)  or die("Connessione al database fallita");
mysqli_select_db($connTchForum, $db1) or die("Passaggio al database Fallito");
mysqli_query($connTchForum, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$dbuser2="studentforum";
$userpass2="forum-Student";
$db2="studentforum";

$connStuForum = mysqli_connect($dbserver, $dbuser2, $userpass2,$db2)  or die("Connessione al database fallita");
mysqli_select_db($connStuForum, $db2) or die("Passaggio al database Fallito");
mysqli_query($connStuForum, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");





/* PhpMailer Parameters */
	$mailHost="mail.ipb.pt";
	$mailUsername="mathe";
	$mailPassword="e;Uew1S%A";
	$mailPort="587";





/* MathE Platform - Login GUEST */

//echo $_SESSION["guest"];

$guest_ar=explode("|",base64_decode($_SESSION["guest"]));	
$usrId=$guest_ar[0];
$usrCode=$guest_ar[1];
$usrTypology=$guest_ar[2];
$usrProfile=$guest_ar[3];

// Accesso delle portoghesi
$userPT=0;
if (
	$usrId==26 OR // Francesco Pinzani
	$usrId==28 OR // Lorenzo Martellini
	$usrId==37 OR // Ana Pereira
	$usrId==38 OR // Florbela Fernandes
	$usrId==64 // Maria de Fátima Pacheco
) $userPT=1; else $userPT=0;


if ($usrProfile=="admin") $userProfileTr="Administrator"; else  $userProfileTr="Lecturer";

/* Ricavo i dati dell'utente loggato */
	
	$sql = "
		SELECT * 
		FROM  platform__user 
		WHERE (id='$usrId' AND (checkcode='$usrCode' OR guid='$usrCode')) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	if ($result) $find=mysqli_num_rows($result);
		
	if ($find==1) {

		while ($row=mysqli_fetch_array($result)) {
			$usr_name=$row["name"];
			$usr_surname=$row["surname"];
			$usr_typology=$row["typology"];
			$usr_verifyEmail=$row["verifyEmail"];
			$usr_completeProfile=$row["completeProfile"];
			$usr_banned=$row["ban"];
		}
	}

/* START Timezone */
/* Ricavo il timezone dell'Università di appartenenza dello user */
	
	$uni_name=0;
	if ($usr_typology=="lecturer") {
		$sql = "
			SELECT * 
			FROM  platform__lecturers 
			WHERE id_lect='$usrId' 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		if ($result) $find=mysqli_num_rows($result);
			
		if ($find==1) {
			while ($row=mysqli_fetch_array($result)) {
				$uni_name=$row["uni_name"];
			}
		}
	} elseif ($usr_typology=="student") {
		$sql = "
			SELECT * 
			FROM  platform__students 
			WHERE id_stud='$usrId' 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		if ($result) $find=mysqli_num_rows($result);
			
		if ($find==1) {
			while ($row=mysqli_fetch_array($result)) {
				$uni_name=$row["uni_name"];
			}
		}
	}

	$uniTimezone="UTC";
	if ($uni_name) {
		$sql = "
			SELECT * 
			FROM  platform__university 
			WHERE id='$uni_name' 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		if ($result) $find=mysqli_num_rows($result);
			
		if ($find==1) {
			while ($row=mysqli_fetch_array($result)) {
				$uniTimezone=$row["timezone"];
			}
		}
	}
/* END Timezone */


function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    } else {
        mt_srand((double)microtime()*10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}

/* Ricavo i dati del partner*/
$sql = "Select * from user WHERE id_user='".(isset($_SESSION["id_user"]) ? $_SESSION["id_user"] :'' )."' LIMIT 1";
$result=mysqli_query($conn, $sql);

while ($row=mysqli_fetch_array($result)) {
    $usr_name_func = $row["usr_name"];
    $id_partner_func = $row["id_partner"];
}
$sql = "Select * from partner WHERE id_partner='".(isset($id_partner_func) ? $id_partner_func :'')."' LIMIT 1";
$result=mysqli_query($conn, $sql);

while ($row=mysqli_fetch_array($result)) {
    $ptn_name_func=$row["name"];
    $ptn_country_func=$row["country"];
}

if ($_SESSION["id_user"]) {
	// Accesso delle portoghesi
	$partnerPT=0;
	if (
		$_SESSION["id_user"]==1 OR // Francesco Pinzani
		$_SESSION["id_user"]==8 OR // Lorenzo Martellini
		$_SESSION["id_user"]==81 // Maria de Fátima Pacheco
	) $partnerPT=1; else $partnerPT=0;
}

/* Ricavo i WorkInProgress caricati dal Partner */
$wps_str = "|";
$sql = 'SELECT * FROM pm__workinprogress WHERE id_partner="'.(isset($id_partner_func) ? $id_partner_func : '').'"';
$result = mysqli_query($conn,$sql);

while ($row = mysqli_fetch_array($result)) {
    $wps_str .= $row["wps"]."|";
}


//var_dump($_SESSION);die();

// GESTIONE DELLE LINGUE
///////////////////////////////////////////////////

if (isset($_SESSION["lng"]) && $_SESSION["lng"] == '') {
    $lng_file="EN.php";
    $table_lng="lang__en";
} elseif(isset($_SESSION["lng"]))  {
    $lng_file= $_SESSION["lng"].".php";
    $table_lng="lang__".strtolower($_SESSION["lng"]);
}

get_included_files();
if (isset($lng_file)) $file2incl = "./impianto/inc/lang/".$lng_file;
if (file_exists($file2incl)) include_once($file2incl);


// Ricavo L'inglese
$sql_EN = "
	SELECT o.*,c.*
	FROM lang__pages as o
	LEFT JOIN lang__en as c
	ON o.id = c.id_page
	WHERE o.page='".file_name()."'";
$result_EN=mysqli_query($conn, $sql_EN);

$main_txt_EN = '';
while ($row_EN=mysqli_fetch_array($result_EN)) {
    $var_name_EN=$row_EN["var_name"];
    if ($var_name_EN=="main_text") $main_txt_EN=Pulisci_READ($row_EN["text"]);
}

// Ricavo il testo tradotto
$sql = "
	SELECT o.*,c.*
	FROM lang__pages as o
	LEFT JOIN ".$table_lng." as c
	ON o.id = c.id_page
	WHERE (o.page='".file_name()."' OR LOCATE('".file_name()."',similar))";
$result=mysqli_query($conn, $sql);

$main_txt = '';
while ($row=mysqli_fetch_array($result)) {
    $var_name=$row["var_name"];
    if ($var_name=="main_text") $main_txt=Pulisci_READ($row["text"]);
}


// Se il testo non è tradotto riporto il testo in inglese
if ($main_txt == "") $main_txt = $main_txt_EN;

// Se non esiste la versione inglese la pagina è in costruzione
//if ($main_txt=="") $main_txt="<p class=\"uc\">This page in under construction</p>";


///////////////////////////////////////////////////
// FINE GESTIONE DELLE LINGUE


function file_name() {
    $CurPathfile=$_SERVER["SCRIPT_FILENAME"];
    //	$Nomefile=substr($CurPathfile,strrpos($CurPathfile,"\\")+1);       //ricavo il nome del file
    $Nomefile=substr($CurPathfile,strrpos($CurPathfile,"/")+1); /* AMEEE.IT*/
    $Nomefile=str_replace(".php","",$Nomefile);
    return $Nomefile;
}

function sel($pag,$classe,$oldname) {
    $silly=0;
    $pages=explode("|",$pag);
    foreach ($pages as $filename) {
        if (file_name()==$filename) $silly=1;
    }
    if ($oldname) {
        if ($silly==1) return "class=\"$classe\"";
        else return "class=\"$oldname\"";
    } else {
        if ($silly==1) return "class=\"$classe\"";
    }
}

function Pulisci_INS($str) {
    //$str=utf8_encode($str);
    $str=addslashes($str);
    return $str;
}

function Pulisci_READ($str) {
    //$str=utf8_decode ($str);
    $str=stripslashes($str);
    return $str;
}

function Pulisci_READ_lnk($str) {
    //$str=utf8_decode ($str);
    $str=stripslashes($str);
    $str=nl2br($str);
    $str=replaceLinks($str);
    return $str;
}

function Pulisci_READ_email($str) {
    //$str=utf8_decode ($str);
    $str=stripslashes($str);
    $str=trim($str);
    $str=nl2br($str);
    $str=str_replace("<br />", " <br /> ", $str);
    $str=replaceEmails($str);
    return $str;
}

function replaceLinks($text) {
    //$text = preg_replace("#\/[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]#","\<a href=\"\\0\" class=\"nw\">\\0</a>", $text);
	$text = preg_replace('"\b(https?://\S+)"', '<a href="$1" target=\"_blank\">$1</a>', $text);
    return $text;
}

function replaceEmails($text)
{
    $regex = '/(\S+@\S+\.\S+)/i';
    $replace = "<a href='mailto:$1'>$1</a>";
    $result = preg_replace($regex, $replace, $text);
    return $result;
}

function Date1($dd,$mm,$aaaa) {
  $mm_long = '';
    if ($mm=='01') $mm_long="January";
    elseif ($mm=='02') $mm_long="February";
    elseif ($mm=='03') $mm_long="March";
    elseif ($mm=='04') $mm_long="April";
    elseif ($mm=='05') $mm_long="May";
    elseif ($mm=='06') $mm_long="June";
    elseif ($mm=='07') $mm_long="July";
    elseif ($mm=='08') $mm_long="August";
    elseif ($mm=='09') $mm_long="September";
    elseif ($mm=='10') $mm_long="October";
    elseif ($mm=='11') $mm_long="November";
    elseif ($mm=='12') $mm_long="December";

    return $dd." ".$mm_long." ".$aaaa;
}

function cancella_file($directory = FALSE,$id) {

    $dirs= array();
    $files = array();

    if ($handle = opendir("./" . $directory)) {
        while ($file = readdir($handle)) {
            if (is_dir("./{$directory}/{$file}")) {
                if ($file != "." & $file != "..") $dirs[] = $file;
            }
            else {
                $silly=explode("_", $file);
                if ($silly[0]==$id) {

                    if(file_exists("./{$directory}/{$file}")) {
                        unlink("./{$directory}/{$file}");
                    }
                }
            }
        }
    }
    closedir($handle);
}

function Conta_Consonanti($str,$num) {
    $spam=0;
    $count=1;
    $count_max=$num;
    $str_len=strlen($str);
    $pattern = '/[bcdfghjklmnpqrstvxywzBCDFGHJKLMNPQRSTVXYWZ]/';

    for ($i=0;$i<=$str_len;$i++) $str_ar[$i]=substr($str, $i, 1);
    for ($i=0;$i<=$str_len-1;$i++) {
        if(preg_match($pattern,$str_ar[$i])) $count+=1; else $count=1;
        if ($count==$count_max) $spam=1;
    }
    return $spam;
}

function chkPassword($str) {
	/* Devo controllare i caratteri della stringa che siano soltanto alfanumerici */
	/* inoltre non sono ammessi spazi vuoti */
	/* inoltre deve contenere almeno otto caratteri */

	$check=0;
	if (strpos($str," ")===false AND strlen($str)>=8 AND preg_match('#^[a-z0-9\. _-]+$#i',$str)) $check=1;
	
	return $check;
}


function dir_list_GE($directory = FALSE,$id) {

    $dirs= array();
    $files = array();

    if ($handle = opendir("./" . $directory)) {
        while ($file = readdir($handle)) {
            if (is_dir("./{$directory}/{$file}")) {
                if ($file != "." & $file != "..") $dirs[] = $file;
            }
            else {
                $silly=explode("_", $file);
                if ($silly[0]==$id) {
                    //					if ($file != "." & $file != "..") $files[] = $silly[1];
                    if ($file != "." & $file != "..") $files[] = str_replace($silly[0]."_","",$file);
                }
            }
        }
    }
    closedir($handle);

    reset($files);
    sort($files);
    reset($files);

    $count=1;
    foreach($files as $key => $value) {

        echo "<p style=\"margin: 5px 0 5px; 0;\">{$count}. <a href=\"{$directory}/{$id}_{$value}\" onclick=\"this.target='_blank'\">{$value}</a><p>";

        $count++;
    }

    // if (!$d) $d = "0";
    // if (!$f) $f = "0";
}



function cancella_foto_GE($directory = FALSE,$id) {

    $dirs= array();
    $files = array();

    if ($handle = opendir("./" . $directory)) {
        while ($file = readdir($handle)) {
            if (is_dir("./{$directory}/{$file}")) {
                if ($file != "." & $file != "..") $dirs[] = $file;
            }
            else {
                $silly=explode("_", $file);
                if ($silly[0]==$id) {

                    if(file_exists("./{$directory}/{$file}")) {
                        unlink("./{$directory}/{$file}");
                    }
                }
            }
        }
    }
    closedir($handle);
}

function resize($pict, $dest_pict, $max_size){

    $handle = @imagecreatefromjpeg("./data/".$pict);

    $x=imagesx($handle);
    $y=imagesy($handle);

    $max = $x;

    //      if($x > $y){
    //               $max = $x;
    //               $min = $y;
    //       }
    //       if($x <= $y){
    //               $max = $y;
    //               $min = $x;
    //       }

    //$size_in_pixel : Size max of the label in pixel.  The size of the picture being
    //proportional to the original, this value define maximum size
    //of largest side with dimensions of the picture. Sorry for my english !

    //Here $size_in_pixel = 100 for a thumbnail.
    $size_in_pixel = $max_size;

    $rate = $max/$size_in_pixel;
    $final_x = $x/$rate;
    $final_y = $y/$rate;

    if($final_x > $x) {
        $final_x = $x;
        $final_y = $y;
    }

    $final_x = ceil($final_x);
    $final_y = ceil($final_y);

    $black_picture = imageCreatetruecolor($final_x,$final_y);
    imagefill($black_picture,0,0,imagecolorallocate($black_picture, 255, 255, 255));
    imagecopyresampled($black_picture, $handle, 0, 0, 0, 0,$final_x, $final_y, $x, $y);

    if(!@imagejpeg($black_picture,$dest_pict.'/'.$pict, $size_in_pixel))
        imagestring($black_picture, 1, $final_x-4, $final_y-8, ".", imagecolorallocate($black_picture,0,0,0));

    //The number is the quality of the result picture
    //header("Content-type: image/jpeg");
    //imagejpeg($black_picture,'', '100');
    imagedestroy($handle);
    imagedestroy($black_picture);
}


/* Protezione Password */
$bfPsw="@|Hy|49HG56@F#rde8397e";
$afPsw="7|66@4hg48#5383|876@7h";

function Genera_Password() {
	$alfa=array("a","b","c","d","e","f","g","h","i","j","l","m","n","o","p","q","r","s","t","u","v","w","y","z","A","B","C","D","E","F","G","H","I","J","L","M","N","P","Q","R","S","T","U","V","W","Y","Z","0","1","2","3","4","5","6","7","8","9");
	$i=0;
	$password="";
	while ($i<10) { 
		$password=$password.$alfa[rand(0, count($alfa)-1)];
		$i=$i+1;
	}
	return $password;
}

function generate_timezone_list() {
	static $regions = array(
		DateTimeZone::AFRICA,
		DateTimeZone::AMERICA,
		DateTimeZone::ANTARCTICA,
		DateTimeZone::ASIA,
		DateTimeZone::ATLANTIC,
		DateTimeZone::AUSTRALIA,
		DateTimeZone::EUROPE,
		DateTimeZone::INDIAN,
		DateTimeZone::PACIFIC
	);

	$timezones = array();
	foreach( $regions as $region )
	{
		$timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
	}

	$timezone_offsets = array();
	foreach( $timezones as $timezone )
	{
		$tz = new DateTimeZone($timezone);
		$timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
	}

	// sort timezone by offset
	asort($timezone_offsets);

	$timezone_list = array();
	foreach( $timezone_offsets as $timezone => $offset )
	{
		$offset_prefix = $offset < 0 ? '-' : '+';
		$offset_formatted = gmdate( 'H:i', abs($offset) );

		$pretty_offset = "UTC${offset_prefix}${offset_formatted}";

		$timezone_list[$timezone] = "(${pretty_offset}) $timezone";
	}

	return $timezone_list;
}

function utc_offset_dst($time_zone="Europe/Rome") {
	// Set UTC as default time zone.
	date_default_timezone_set("UTC");
	$utc = new DateTime();
	// Calculate offset.
	$current   = timezone_open( $time_zone );
	$offset_s  = timezone_offset_get( $current, $utc ); // seconds
	$offset_h  = $offset_s / ( 60 * 60 ); // hours
	// Prepend “+” when positive
	$offset_h  = (string) $offset_h;
	if ( strpos( $offset_h, '-' ) === FALSE ) {
		$offset_h = "+".$offset_h; // prepend +
	}
	return "UTC".$offset_h;
}

function loginTeacherForum($usrStudent,$token) {
global $connTchForum,$connStuForum;

	

  // Prendo il token corrispondente al suo ultimo login dalla tabella access_tokens del db studentforum

        $query = "SELECT token, user_id, last_activity_at, lifetime_seconds, created_at FROM access_tokens WHERE token = '".$token."' ORDER BY created_at DESC LIMIT 1";
	$res = mysqli_query($connStuForum, $query);
        $row = mysqli_fetch_assoc($res);
//        $token = $row['token'];
        $lastActivityAt = $row['last_activity_at'];
        $lifetimeSeconds = $row['lifetime_seconds'];
        $createdAt = $row['created_at'];




   // Prendo il suo id nella tabella users del db teacherforum

        $query = "SELECT id FROM users WHERE email = '$usrStudent'";
        $res = mysqli_query($connTchForum, $query);
        $row = mysqli_fetch_assoc($res);
        $idTeacher = $row['id'];



    // Inserisco il token nel db teacherforum

        $query = "INSERT INTO access_tokens (token, user_id, last_activity_at, lifetime_seconds, created_at) VALUES ('".$token."', '".$idTeacher."', '".$lastActivityAt."', '".$lifetimeSeconds."', '".$createdAt."')";
        $res = mysqli_query($connTchForum, $query);
}
?>
