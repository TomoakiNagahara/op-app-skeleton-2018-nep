<?php
/**
 * core:/Template/Introduction/Php/Mbstring.phtml
 *
 * @creation  2016-01-01
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	Execute.
php_mbstring();

/** Main
 *
 */
function php_mbstring(){
	//	PHP version.
	$t = explode('.', PHP_VERSION);
	$v = $t[0].$t[1];

	print '<h1>Does not install php-mbstring module.</h1>';
	print '<p>Please install php-mbstring module.</p>';
	print '<pre style="margin:0 1em; padding:0.5em; background-color:#dfdfdf;"><code>';

	switch (true) {
		case stristr(PHP_OS, 'DAR'):
			php_mbstring_osx($v);
			break;
		case stristr(PHP_OS, 'WIN'):
			php_mbstring_win($v);
			break;
		case stristr(PHP_OS, 'LINUX'):
			php_mbstring_linux($v);
			break;
		default:
			php_mbstring_other($v);
		break;
	}

	print '</code></pre>';
	print '<hr/>';
	print '<p style="color:#ccc;">'.__FILE__.' ('.__LINE__.')</p>';
}

/** For macOS
 *
 * @param integer $v
 */
function php_mbstring_osx($v){
	print <<< "EOL"
sudo port install php{$v}-mbstring
sudo /opt/local/apache2/bin/apachectl restart
EOL;
}

/** For Windows
 *
 * @param integer $v
 */
function php_mbstring_win($v){

}

/** For linux
 *
 * @param integer $v
 */
function php_mbstring_linux($v){
	if( file_exists('/etc/redhat-release') ){
		if( $v > 53 ){
			php_mbstring_linux_redhat($v);
			return;
		}
	}
	print <<< "EOL"
sudo yum install php-mbstring
sudo service httpd restart
EOL;
}

/** For linux redhat
 *
 * @param integer $v
 */
function php_mbstring_linux_redhat($v){
	print <<< "EOL"
sudo yum --enablerepo=remi-php{$v} install php-mbstring
sudo service httpd restart
EOL;
}

/** For Others
 *
 * @param integer $v
 */
function php_mbstring_other($v){

}

/**
 * Finish
 */
exit();
