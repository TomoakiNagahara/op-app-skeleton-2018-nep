<?php
/**
 * app-skeleton-2018-nep:/asset/bootstrap/op/rewrite.php
 *
 * @creation  2016-11-25
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
global $_OP;

//	Calc rewrite base directory.
$rewrite_base = substr($_OP[APP_ROOT], strlen($_SERVER['DOCUMENT_ROOT']));

?>
<!doctype html>
<html>
	<head>
		<title>Boot to the onepiece-framework</title>

		<!-- JavaScript -->
		<script type="text/javascript" src="https://onepiece-framework.com/webpack/js/"></script>

		<!-- Stylesheet -->
		<link rel="stylesheet" type="text/css" href="https://onepiece-framework.com/webpack/css/?name=white" />
		<style>

		h1 {
			font-size: 1.5vw;
		}

		li {
			margin-bottom: 1em;
		}

		div[role="code"] {
			border: 1px solid #9f9f9f;
			margin:  1em 0;
			padding: 0.7em 1em;
			font-family: monospace;
		}

		pre {
			border: 1px solid #9f9f9f;
			border-radius: 0.25em;
			padding: 0.5em 0.5em;
		}

		code {

		}
		</style>
	</head>
	<body>
		<header>
			Boot to the onepiece-framework
		</header>
		<hr/>
		<div data-i18n="true" data-lang="en">
		<?php
		//	...
		$name = strtolower(explode('/', $_SERVER['SERVER_SOFTWARE'])[0]);
		$path = __DIR__."/rewrite-{$name}.phtml";

		//	...
		if( file_exists($path) ){
			include($path);
		}else{
			echo "<p>Unknown web server. ($name)</p>";
		}
		?>
		</div>
		<hr/>
		<footer>
			Copyright 2018 onepiece-framework all right reserved
		</footer>
	</body>
</html>
<?php
exit();
