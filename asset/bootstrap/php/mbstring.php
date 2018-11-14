<?php
/**
 * app-skeleton-2018-nep:/asset/bootstrap/php/mbstring.php
 *
 * @creation  2016-01-01
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$t = explode('.', PHP_VERSION);
$v = $t[0].$t[1];
$server_software = explode('/', $_SERVER['SERVER_SOFTWARE'])[0];
?>
<!doctype html>
<html>
	<head>
		<style>
		pre {
			margin:0 1em;
			padding:0.5em;
			background-color:#dfdfdf;
			border: 1px solid #cfcfcf;
			border-radius: 0.25em;
		}
		</style>
	</head>
	<body>
		<h1>Does not install php-mbstring module.</h1>
		<p>Please install php-mbstring module.</p>
		<?php
		switch( PHP_OS ){ // PHP 7.2.0 --> PHP_OS_FAMILY
			case 'MacOS':
			case 'Darwin':
				include('mbstring-osx.phtml');
				break;

			case 'WIN32':
			case 'WINNT':
				include('mbstring-win.phtml');
				break;

			case 'AIX':
			case 'Linux':
			case 'SunOS':
				include('mbstring-unix.phtml');
				break;

			default:
				exit(__FILE__.', '.__LINE__.', '.PHP_OS);
				break;
		}
		?>
	</body>
</html>
<?php
exit();
