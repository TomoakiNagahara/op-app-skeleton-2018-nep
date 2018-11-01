<?php
/**
 * unit-test:/unit/layout/action.php
 *
 * @creation  2018-06-05
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$layout = $_GET['layout'] ?? 'white';

//	...
App::Layout($layout);

//	...
foreach(['white','dark','chameleon'] as $layout){
	$nav['label'] = $layout;
	$nav['url']   = '?layout='.$layout;
	$navs[] = $nav;
}
__navigation($navs);

//	...
App::Template('index.phtml');

//	Suppress 304 Not Modifiers header.
Html( Time::Datetime() );
