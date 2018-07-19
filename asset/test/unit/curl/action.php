<?php
/**
 * unit-test:/unit/curl/action.php
 *
 * @creation  2018-07-02
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
Nav::Set('GET',  ['method'=>'get'] );
Nav::Set('POST', ['method'=>'post']);
Nav::Out();

//	...
$io = Unit::Load('curl') ? true: false;

//	...
D('Unit load', $io);

//	...
if(!$io ){ return; }

//	...
$host = $_SERVER['HTTP_HOST'];

//	...
$uri = ConvertURL('testcase:/api/');

//	...
$url = "http://{$host}{$uri}";

//	...
$data['ping'] = true;

//	...
Html($url);
Json($data, 'OP_DUMP');

//	...
switch( $method = $_GET['method'] ?? null ){
	case 'get':
		$result = \OP\UNIT\Curl::Get($url, $data);
		break;

	case 'post':
		$result = \OP\UNIT\Curl::Post($url, $data);
		break;

	default:
		D('Please choose method.');
}

//	...
Html($result);
Json(json_decode($result, true), 'OP_DUMP');
