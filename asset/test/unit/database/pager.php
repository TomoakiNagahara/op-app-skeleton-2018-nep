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
if(!$db->isConnect() ){
	return;
}

//	...
$config = [];
$config['table'] = 't_orm';
$config['where']['ai']['evalu'] = '!=';
$config['where']['ai']['value'] = null;
$count = $db->Count($config);

//	...
$ppr  = 10;
$page = ifset($_GET['page'], 1);
$max  = ceil($count / $ppr);

//	...
if( $page > $max ){
	$page = $max;
}

//	...
if( $page < 1 ){
	$page = 1;
}

//	...
$offset = ($page -1) * $ppr;

//	...
$config['limit']  = $ppr;
$config['offset'] = $offset;

//	...
D( $db->Select($config) );

//	...
print '<div class="pager">'.PHP_EOL;
printf('<span class="page"><a href="?%s"></a></span>'.PHP_EOL, http_build_query(array_merge($_GET, ['page'=>1])) );
for( $i=1; $i<=$max; $i++ ){
	if( $i === $page ){
		printf('<span class="page current">%s</span>'.PHP_EOL, $i);
	}else{
		printf('<span class="page"><a href="?page=%s">%s</a></span>'.PHP_EOL, $i, $i);
	}
}
printf('<span class="page"><a href="?%s"></a></span>'.PHP_EOL, http_build_query(array_merge($_GET, ['page'=>$max])) );
print '</div>'.PHP_EOL;

//	...
D('total record number', $count);
D('current page',		 $page);
D('page per record',	 $ppr);
D('maximum page',		 $max);
