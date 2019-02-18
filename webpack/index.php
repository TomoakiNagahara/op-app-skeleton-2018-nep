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
//	Get route table.
$args = App::Args();

//	Get extension from smart url.
if(!$ext = $args[0] ){
	return;
}

//	Get layout name.
$layout = $_GET['layout'] ?? $_GET['name'] ?? null;

//	Switch work by extension.
switch( $ext ){
	case 'js':
	case 'css':
		//	Generate MIME.
		$mime = 'text/' . ($ext === 'js' ? 'javascript': $ext);

		//	...
		$app_path    = __DIR__."/{$ext}/action.php";

		//	...
		if( $layout ){
			$layout_path = ConvertPath("layout:/../$layout/$ext/action.php");
			$layout_path = realpath($layout_path);
			if(!$io = file_exists($layout_path) ){
				\Notice::Set("This file path has not been exists. ({$layout_path})");
			};
		};

		//	...
		if( $io ?? null ){
			$list = array_merge( include($app_path), include($layout_path) );
		}else{
			$list = include($app_path);
		};

		//	...
		break;

	default:
		$list = [];
}

//	Load webpack unit.
if(!Unit::Load('webpack') ){
	return;
}

//	Change MIME.
Env::Mime($mime);

//	Disable layout.
App::Layout(false);

//	Add to head of list.
OP\UNIT\WebPack::Set($ext, $list, true);

//	Output packing string.
OP\UNIT\Webpack::Out($ext);
