<?
/* ---------------------------------------------

Marco zinno
10/10/2012
class.mailer.php

costruisce ed invia mail tramite server SMTP 

------------------------------------------------ */

class Mailer{
	private $body;
	private $subject;
	private $address;
	
	function __construct(){}
	
	function initMailer($body,$subject,$address){
			$this->body=htmlentities($body, ENT_QUOTES); // txt to HTML 
			$this->subject=$subject;
			if (preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',$address)) 
			{
				$this->address=$address;
				return true;
			}
			else{
				return false;
			}
	}
	function sendEmail(){
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = Config::$SMTP["SERVER"]; // SMTP server
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->Port       = Config::$SMTP['PORT']; // set the SMTP port
		$mail->SetFrom(Config::$SMTP["FROM"],Config::$SMTP["FROM_NAME"]);
		$mail->AddReplyTo(Config::$SMTP["REPLY_TO"],Config::$SMTP["REPLY_TO_NAME"]);
		$mail->Subject    = $this->subject;
		$mail->MsgHTML($this->body);
		$mail->AddAddress($this->address, $this->address);

		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
		
		if (Config::$SMTP["AUTH_REQUIRED"]){
			// SMTP con autenticazione
			$mail->Username   = Config::$SMTP["USER"]; 					// SMTP account username
			$mail->Password   = Config::$SMTP["PASSWORD"];        		// SMTP account password
		}
		// invio 
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			return false;
		} else 
			return true;
		



}
}
