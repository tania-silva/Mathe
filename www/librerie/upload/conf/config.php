<?php
/* ---------------------------------------------

Marco zinno
10/10/2012
config.php

configurazione  UPLOAD

------------------------------------------------

*/

class Config{
	public static $UPLOAD=array(
					EXTS=>array('jpg',
								'png',
								'gif',
								'jpeg',
								'jpg',
								'tiff',
								'tif',
								'pdf',
								'bmp',
								'mpg',
								'mpeg',
								'avi'),
					MIMES=>array(	'image/*',
									'application/pdf',
									'image/bmp',
									'image/gif',
									'image/jpeg',
									'image/pict',
									'image/pjpeg',
									'image/png',
									'image/tiff',
									'image/vnd.wap.wbmp',
									'image/x-icon',
									'image/x-jg',
									'image/x-jps',
									'image/x-niff',
									'image/x-pict',
									'image/x-quicktime',
									'image/x-rgb',
									'image/x-tiff',
									'image/x-windows-bmp',
									'image/x-xbitmap',
									'image/x-xbm',
									'image/x-xpixmap',
									'image/x-xwd',
									'image/x-xwindowdump',
									'application/annodex',
									'application/mp4',
									'application/ogg',
									'application/vnd.rn-realmedia',
									'application/x-matroska',
									'video/3gpp',
									'video/3gpp2',
									'video/annodex',
									'video/divx',
									'video/flv',
									'video/h264',
									'video/mp4',
									'video/mp4v-es',
									'video/mpeg',
									'video/mpeg-2',
									'video/mpeg4',
									'video/ogg',
									'video/ogm',
									'video/quicktime',
									'video/ty',
									'video/vdo',
									'video/vivo',
									'video/vnd.rn-realvideo',
									'video/vnd.vivo',
									'video/webm',
									'video/x-bin',
									'video/x-cdg',
									'video/x-divx',
									'video/x-dv',
									'video/x-flv',
									'video/x-la-asf',
									'video/x-m4v',
									'video/x-matroska',
									'video/x-motion-jpeg',
									'video/x-ms-asf',
									'video/x-ms-dvr',
									'video/x-ms-wm',
									'video/x-ms-wmv',
									'video/x-msvideo',
									'video/x-sgi-movie',
									'video/x-tivo',
									'video/avi',
									'video/x-ms-asx',
									'video/x-ms-wvx',
									'video/x-ms-wmx'
									),

					SIZE_LIMIT=>2 // in  MB
				);
}
