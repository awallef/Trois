<?php

/* default:
****************************/
Configure::write('Trois.media', array(
	
	'fileEngine' => 'local',
	
	'base'=>'files',
	
	'maxsize' => 30 * 1000*1024*1024, // 30MB in octet
	
	'path' => '{$year}{DS}{$month}',//'{$modelName}{DS}{$group}{DS}{$user}{DS}{$year}{DS}{$month}{DS}{$type}{DS}{$subtype}',
	
	'types' => array(
		
		'image/jpeg',
		'image/png',
		'image/gif',
		
		'application/pdf',
            
                'video/mp4',
                'video/ogg',
                'audio/ogg',
	),
	
	'delete' => true

));


/* Cloudfiles exemple:
**************************
Configure::write('Trois.media', array(
	
	'fileEngine' => 'cloudFiles',
	
	'base'=>'test',
	
	'enableCDN' => true,
	
	'maxsize' => 10*1000*1024*1024,
	
	'path' => '{$year}{DS}{$month}',
	
	'types' => array(
		
		'image/jpeg',
		'image/png',
		'image/gif',
		
		'application/pdf'
	),
	
	'delete' => true,
	
	'user' => 'antoine3xwch',
	
	'secret' => '1c8304742c439ed217a2f0dd329fccc7'

));
*/

/* FTP exemple:
***************************
Configure::write('Trois.media', array(
	
	'fileEngine' => 'ftp',
	
	'base'=>'web',
	
	'maxsize' => 10*1000*1024*1024,
	
	'path' => '{$year}{DS}{$month}',
	
	'types' => array(
		
		'image/jpeg',
		'image/png',
		'image/gif',
		
		'application/pdf'
	),
	
	'delete' => true,
	
	'user' => 'username',
	
	'password' => 'secret'

));
*/
