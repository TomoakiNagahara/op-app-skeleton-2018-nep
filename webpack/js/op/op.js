/**
 * app-webpack-js:/op.js
 *
 * @creation  2017-06-07
 * @version   1.0
 * @package   app-webpack-js
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Use strict mode.
 *
 */
"use strict";

/** OP
 *
 */
if( $OP === undefined ){
	var $OP = {};
}

/** Check if admin.
 *
 * <pre>
 * $OP.isAdmin(); --> true / false
 * </pre>
 */
$OP.isAdmin = function(){
	return <?= Env::isAdmin() ? 'true': 'false'; ?>;
}
