<?php
/**
 * app-skeleton-2018-nep:/index.php
 *
 * @creation  2016-11-22
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
 /***********************************************/
//	.htaccess file has not been initialized.	//
global $_OP;
if(!isset($_OP)){
	include(__DIR__.'/asset/app.php');
	return;
}
//	You should leave this logic. It's for you.	//
/***********************************************/

//	Get route table.
$args = App::Args();

//	Checking 404 page.
if( count($args) === 0 ){
	//	Access is top page.
	//	Welcome page is sample page
	//	 --> ./asset/template/welcome.phtml
	App::Template('welcome.phtml');
}else{
	//	Non existent page.
	App::Template('404.php');
}
