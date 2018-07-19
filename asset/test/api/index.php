<?php
/**
 * unit-test:/api/action.php
 *
 * @creation  2018-07-02
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
App::Layout(false);

//	...
$json = [
	'status' => true,
	'errors' => [],
	'result' => null,
];

//	...
if( $_REQUEST['ping'] ?? null ){
	$json['result']['ping'] = true;
}

//	...
echo json_encode($json);
