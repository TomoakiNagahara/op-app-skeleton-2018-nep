<?php
/**
 * app-skeleton-2018-nep:/img/index.php
 *
 * @creation  2018-05-21
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Get "SmartURL" Arguments.
$args = App::Args();

//	Get file name.
$file = $args[0] ?? '404.png';

//	Convert to full file path from meta path.
$path = ConvertPath("layout:/img/$file");

//	Is file exists?
if(!file_exists($path) ){
	//	If not, change file name.
	$path = '404.png';
}

//	Get extension.
$tmp = explode('.', $file);
$ext = strtolower(array_pop($tmp));

//	Generate MIME.
switch( $ext ){
	case 'jpg':
		$mime = 'jpeg';

	case 'gif':
	case 'png':
	case 'jpeg':
		$mime = "image/$ext";
		break;

	default:
		D("This extension is not supported. ($ext)");
		return;
}

//	Layout to off.
App::Layout(false);

//	Set MIME.
Env::Mime($mime);

//	Load image file.
include($path);
