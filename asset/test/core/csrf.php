<?php
/**
 * unit-test:/core/csrf.php
 *
 * @creation  2018-06-06
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$session_id  = session_id();

//$session_id = null;

list($uri, $query) = explode('?', $_SERVER['REQUEST_URI'].'?');
$host = $_SERVER['SERVER_NAME'] === $_SERVER['SERVER_ADDR'] ? 'localhost':$_SERVER['SERVER_ADDR'];
$referer = $_SERVER['HTTP_REFERER'] ?? null;
$ua   = $_SERVER['HTTP_USER_AGENT'] ?? null;
$cmd  = sprintf('curl --max-time 3 --cookie "PHPSESSID=%s" -e %s -A "%s" %s/op/7/app-skeleton-2018-nep/_testcase/core/csrf?menu=0', $session_id, $referer, $ua, $host);
$cmd  = 'curl --cookie "PHPSESSID=" localhost/op/7/app-skeleton-2018-nep/_testcase/core/csrf?menu=0';
$cmd  = 'curl --cookie "PHPSESSID='.$session_id.'" --max-time 3 -e "'.$referer.'" -A "'.$ua.'" localhost/op/7/app-skeleton-2018-nep/_testcase/core/csrf?menu=0';

//	...
if( ifset($_GET['execute']) ){
	echo '<textarea style="width:80%; height: 20em;">';
	echo system($cmd);
//	echo `curl --cookie "PHPSESSID=" localhost/op/7/app-skeleton-2018-nep/_testcase/core/csrf?menu=0`;
	echo '</textarea>';
}

//	...
if( isset($_GET['menu']) ){
	App::Layout(false);
}else{
	$d[] = $session_id;
	$d[] = $referer;
	$d[] = $ua;
	$d[] = $cmd;
	D($d);
}
