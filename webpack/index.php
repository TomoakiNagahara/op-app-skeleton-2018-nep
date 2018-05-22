<?php
/**
 * app-skeleton-2018-nep:/webpack/index.php
 *
 * @creation  2018-04-12
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Disable layout.
App::Layout(false);

//	Get route table.
$args = App::Args();

//	Get extension from smart url.
if(!$ext = $args[0] ){
	return;
}

//	Get layout name.
$layout = ifset($_GET['layout']);

//	Switch work by extension.
switch( $ext ){
	case 'js':
	case 'css':
		//	Generate MIME.
		$mime = 'text/' . ($ext === 'js' ? 'javascript': $ext);

		//	Change MIME.
		Env::Mime($mime);

		//	...
		$app_path    = "./{$ext}/action.php";
		$layout_path = ConvertPath("layout:/{$ext}/action.php");

		//	...
		$list = array_merge( include($app_path), include($layout_path) );

		//	...
		break;

	default:
		$list = [];
}

//	...
if(!Unit::Load('webpack') ){
	return;
}

//	...
$store = OP\UNIT\Webpack::Get($ext);

//	...
OP\UNIT\WebPack::Set($ext, $list);

//	...
OP\UNIT\Webpack::Out($ext);

//	...
echo $store;
