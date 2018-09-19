/**
 * app-skeleton-webpack:/js/op/path.js
 *
 * This script user is just developers.
 *
 * @creation  2017-10-05
 * @version   1.0
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Initialized
 *
 */
$OP.Path = {};
$OP.Path.meta = {};

<?php if( Env::isAdmin() ): ?>
$OP.Path.meta.op  = "<?= ConvertPath('op:/')  ?>";
$OP.Path.meta.app = "<?= ConvertPath('app:/') ?>";
$OP.Path.meta.doc = "<?= ConvertPath('doc:/') ?>";
<?php endif; ?>

/** Set meta path.
 *
 */
$OP.Path.Set = function(meta, path){
	$OP.Path.meta[meta] = path;
};

/** Compress to meta path from real path.
 *
 * <pre>
 * $OP.Path.Compress('/var/www/htdocs/app/test'); --> app:/test
 * $OP.Path.Compress('/var/www/htdocs/foo/bar');  --> doc:/foo/bar
 * </pre>
 *
 * @creation  2017-06-07
 * @version   1.0
 * @package   app-webpack-js
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
$OP.Path.Compress = function( path ){
	//	...
	if(!path){
		return '';
	}

	//	...
	for(var key in $OP.Path.meta ){
		var val =  $OP.Path.meta[key];
		if( val === path.substr(0, val.length ) ){
			return key + ':/' + path.substr(val.length);
		}
	}

	//	...
	return path;
}

/** Convert to document-root-url from meta path.
 *
 * <pre>
 * Document root is "/var/www/htdocs";
 * Application root is "/var/www/htdocs/app-foo";
 *
 * $OP.Path.Convert('app:/test1'); --> /app-foo/test1
 * </pre>
 *
 * @creation  2017-06-07
 * @version   1.0
 * @package   app-webpack-js
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
$OP.Path.Convert = function( path ){
	//	Check of variable type.
	if( typeof path !== 'string' ){
		console.log('This argument type is not string. (' + typeof path + ')');
		console.dir(path);
		return;
	}

	//	Get meta label.
	var m = path.match(/^([\w]+):\//);

	//	Replace to real path from meta label.
	if( m && m[1] ){
		//	Convert to real path.
		var r = new RegExp('^'+m[1]+':/');
		path = path.replace(r, $OP.Path.meta[m[1]]);

		//	Remove document-root path.
		var r = new RegExp('^' + $OP.Path.meta.doc);
		path = path.replace(r, '/');
	}

	//	Separate to url query.
	var pos = path.indexOf('?');
	if( pos === -1 ){
		var url = path;
		var que = '';
	}else{
		var url = path.substr(0, pos);
		var que = path.substr(pos);
	};

	//	Search file name from tail of URL.
	var pos = url.lastIndexOf('/');
	var str = url.substr(pos+1);
	var pos = str.indexOf('.');

	//	Add slash. Anti apache's automatically transfer.
	if( str && pos === -1 ){
		url += '/';
	};

	//	Join
	path = url + que;

	//	Return.
	return path;
}
