<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include_once($root.'/impianto/settings.php');
session_start();
!isset($_SESSION["doc_id_partner"]) ? '' : $_SESSION["doc_id_partner"];
!isset($_SESSION["lng"]) ? $_SESSION["lng"] = '' : $_SESSION["lng"];
$root="http://".$_SERVER['HTTP_HOST'];
$title="Smild";
$rand_n=md5(microtime().date("r").rand(10000, 32000));

$_SESSION["usr_level"] = 5;

$id_partner_func = '';

/* Connessione a MySQL */

//$dbuser="smild";
//$userpass="7&rtyU9=";
//$db="smild";
$dbuser="h1allyou";
$userpass="Y89Io?09III";
$db="h1allyou";

$conn = mysqli_connect("127.0.0.1", $dbuser, $userpass,$db)  or die("Connessione al database fallita");
mysqli_select_db($conn, $db) or die("Passaggio al database Fallito");
mysqli_query($conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


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
    //$str=addslashes($str);
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
    $text = preg_replace("#\/[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]#","\<a href=\"\\0\" class=\"nw\">\\0</a>", $text);
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
    while(list($key, $value) = each($files)) {
        echo "<p style=\"margin: 5px 0 5px; 0;\">{$count}. <a href=\"{$directory}/{$id}_{$value}\" onclick=\"this.target='_blank'\">{$value}</a><p>";

        $count++;
    }

    if (!$d) $d = "0";
    if (!$f) $f = "0";
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
?>
