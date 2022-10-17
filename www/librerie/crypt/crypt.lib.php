<?php
/* ------------------------------------
*
*	Marco Zinno
* 	crypt.lib.php
*	17/10/2012
*
*----------------------------------------*/
function passwordMatch($hashNelDB="",$passwordImmessa=""){
	$cryptPass=getHash($passwordImmessa);
	if ($hashNelDB && $cryptPass) // not void
		return ($cryptPass===$hashNelDB);
	else 
		return false;
}
/*
	getHash($password) ritorn l'hash della password data come parametro
*/
function getHash($p){
	if (CRYPT_EXT_DES == 1) { // se possibile usa -des ext 
		/*
		|	CRYPT_EXT_DES - Extended DES-based hash. The "salt" is 
		|	a 9-character string consisting of an underscore followed 
		|	by 4 bytes of iteration count and 4 bytes of salt. 
		|	These are encoded as printable characters, 6 bits per character, 
		|	least significant character first. The values 0 to 63 are encoded as
		|	"./0-9A-Za-z". Using invalid characters in the salt will cause crypt() to fail. 
		*/
		$strong=substr($p,0,4);
		$pattern="/[A-Za-z0-9]{4}/"; 	// "./0-9A-Za-z". Using invalid characters in the salt will cause crypt() to fail. 
		if (preg_match($pattern, $strong))
			return crypt($p,"_J9..".$strong); 
		else return crypt($p,"sl"); 	// altrimenti usa DES standard(primi 8 caratteri)
	}else{
		$strong=substr($p,0,2);
		$pattern="/[A-Za-z0-9]{2}/"; 	// "./0-9A-Za-z". Using invalid characters in the salt will cause crypt() to fail. 
		if (preg_match($pattern, $strong))
			return crypt($p,$strong);  // altrimenti usa DES standard(primi 8 caratteri)
		else return crypt($p,"sl"); 
	}
}