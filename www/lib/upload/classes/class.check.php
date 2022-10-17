<?php

class CheckUpload{
	private $fileName;
	private $mimeType;
	private $size;
	private $isInit=false;
	private $log;
	//---------------------------------
	// @ $theFile=$_FILES['filename']
	//---------------------------------
	function __construct($theFile){
				$this->log='Attached error : ';
				$this->isInit=true;
				$this->fileName=$theFile["name"];
				$this->nameTmp=$theFile["tmp_name"];
				$this->mimeType=$theFile["type"];
				$this->size=$theFile["size"];
	}
	function isOk(){
			if ($this->isInit)
				return  ($this->checkSize()
						&& $this->checkName()
							&& $this->checkTransaction()
								&& $this->checkExt()
									&& $this->checkMime());
			else
				return false;
	}
	private function checkTransaction(){
		// verifica che il file sia stato caricato nel server
		if(@is_uploaded_file($this->nameTmp))
			return true;
		else{
			$this->log.="il file non &egrave stato caricato nella cartella temporanea del server ".$_this->nameTmp;
			return false;
		}
	}
	private function checkName(){
		// verifica solo che sia stato immesso il nome del file nella form
		if (trim($this->fileName) != "" && $this->fileName){
			// $this->log.= " - info : name [".$this->fileName."] "; // no verbose log if is ok
			return true;
			}
		else{
			$this->log.="non &egrave; stato immesso nessun nome del file ";
			return false;
			}
	}
	private function checkExt(){
		// see config file (conf/config.php)
		if(in_array(strtolower(end(explode('.',$this->fileName ))), Config::$UPLOAD['EXTS']))
			return true;
		else {
			$this->log.="estensione non valida ";
			return false;
			}
	}
	private function checkMime(){
		//

		if (in_array($this->mimeType,Config::$UPLOAD['MIMES']))
			return true;
		else {
			$this->log.="tipo MIME non consentito [".$this->mimeType."] ";
			return false;
			}

	}
	private function checkSize(){
		// limiti di php.ini ...
		$limit=Config::$UPLOAD['SIZE_LIMIT']*1024*1024; // da MB ritorna in byte
		if ($this->size<$limit){
			// $this->log.= " info size [".$this->size."]"; // no verbose log if is ok
			return true;
			}
		$this->log.=" file oltre le dimensioni massime consentite = ".$limit." bytes";
		return false;
	}
	function getLog(){
		return $this->log;
	}
}
