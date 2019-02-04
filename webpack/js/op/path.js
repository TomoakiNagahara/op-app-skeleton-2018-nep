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
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
$OP.Path.Convert = function( path ){
	return $OP.URL.Convert(path);
};

/**
 * @creation  2018-11-03
 * @version   1.0
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
(function(){
	/** Local scope value.
	 *
	 */
	var __meta = {};

	/** Register meta path.
	 *
	 */
	$OP.Path.Register = function( meta, path ){
		__meta[meta] = path;
	};

	/** Compress path.
	 *
	 * @param   string  path
	 * @return  string  path
	 */
	$OP.Path.Compress = function( path ){
		//	...
		if(!path ){
			return false;
		};

		//	...
		for(var meta in __meta){
			//	...
			if( path.indexOf( __meta[meta] ) === 0 ){
				path = path.replace(__meta[meta], meta+':/');
				break;
			};
		};

		//	...
		return path;
	};

	/** Add meta path.
	 *
	 */
	/* <?php if( \Env::isAdmin() ): ?> */
	//	Execute just admin only.
	$OP.Path.Register('app'  , "<?= ConvertPath('app:/') ?>"  );
	$OP.Path.Register('alias', "<?= ConvertPath('alias:/') ?>");
	/* <?php endif; ?> */
})();
