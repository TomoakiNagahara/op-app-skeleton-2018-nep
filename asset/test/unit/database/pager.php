<?php
/**
 * unit-test:/unit/database/pager.php
 *
 * @creation  2018-06-01
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $db OP\UNIT\Database */
include('connect.php');

//	...
$config = [];
$config['table'] = 't_orm';
$config['where']['ai']['evalu'] = '>';
$config['where']['ai']['value'] = '1';
$count = $db->Count($config);

//	...
$ppr  = 10;
$page = (int)($_GET['page'] ?? 1);
$max  = ceil($count / $ppr);

//	...
if( $page < 1 ){
	$page = 1;
}

//	...
if( $page > $max ){
	$page = $max;
}

//	...
$config['limit']  = $ppr;
$config['offset'] = ($page -1) * $ppr;
D( $db->Select($config) );

//	...
for( $i=1; $i<=$max; $i++ ){
	if( $i === $page ){
		printf('<span>%s</span>', $i);
	}else{
		printf('<a href="?page=%s">%s</a>', $i, $i);
	}
}

//	...
D('total record number', $count);
D('current page',		 $page);
D('page per record',	 $ppr);
D('maximum page',		 $max);
