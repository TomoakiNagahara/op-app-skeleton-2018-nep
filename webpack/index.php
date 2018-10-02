<?php
/**
 * app-skeleton-webpack:/index.php
 *
 * @creation  2018-04-12
 * @version   1.0
 * @package   app-skeleton-webpack
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
$layout = empty($_GET['layout']) ? 'white': $_GET['layout'];

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

		//	...
		$layout_path = ConvertPath("layout:/");
		$layout_path = realpath($layout_path.'../');
		$layout_path.= "/$layout/$ext/action.php";

		//	...
		$list = array_merge( include($app_path), include($layout_path) );

		//	...
		break;

	default:
		$list = [];
}

//	Load webpack unit.
if(!Unit::Load('webpack') ){
	return;
}

//	Add to head of list.
OP\UNIT\WebPack::Set($ext, $list, true);

//	Output packing string.
OP\UNIT\Webpack::Out($ext);
