<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * app-skeleton-2018-nep:/asset/config.php
 *
 * @creation  2018-03-27
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Set local host ip-address. (Using by local network.)
Env::Set('localhost', getHostByName( getHostName() ));

//	Time
Time::Timezone('Asia/Tokyo');

//	Layout
OP\UNIT\NEWWORLD\Layout::Directory(__DIR__.'/layout/');
OP\UNIT\NEWWORLD\Layout::Execute(true);
OP\UNIT\NEWWORLD\Layout::Name('white');
Env::Set('layout', [
	'directory' =>  __DIR__.'/template/',
	'execute'   =>  true,
	'name'      => 'white'
]);

//	Template
OP\UNIT\NEWWORLD\Template::Directory(__DIR__.'/template/');
Env::Set('template', [
	'directory'=>__DIR__.'/template/'
]);

//	Cache
Env::Set('cache', [
	'directory'=>__DIR__.'/.cache/'
]);

//	Unit of NotFound
Env::Set('notfound', [
	'dsn' => 'mysql://notfound:password@localhost:3306?database=onepiece&charset=utf8'
]);

//	Cache settings.
Env::Set('cache', [
	'directory'=>__DIR__.'/.cache/'
]);

//	Application settings.
App::Title('onepiece-framework');

//	Overwrite headers.
header('Server: httpd', true);
header('X-Powered-By: onepiece-framework', true);
