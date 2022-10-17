<?
/* ---------------------------------------------

Marco zinno
10/10/2012
config.php

configurazione  SMTP 

------------------------------------------------ */

class Config{
	public static $SMTP=array(
					SERVER=>'127.0.0.1',
					PORT=>'25',
					AUTH_REQUIRED=>false,
					USER=>'',
					PASS=>'',
					REPLY_TO=>'marco_z_71@tiscali.it',
					REPLY_TO_NAME=>'marco Zinno',
					FROM=>'marco_z_71@tiscali.it',
					FROM_NAME=>'Marco Zinno'	
				);
}
