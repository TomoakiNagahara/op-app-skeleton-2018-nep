/**
 * layout-chameleon:/js/init-hue.js
 *
 * @creation  2018-10-26
 * @version   1.0
 * @package   layout-chameleon
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(() => {
//	let hue = Math.round( Math.floor(Math.random() * 360) );
	let hou = (new Date()).getHours();
	let min = (new Date()).getMinutes();

	//	...
	if( hou > 12 ){
		hou = hou - 12;
	};

	//	...
		hou = hou * 30;
		min = min / 2;
	let hue = hou + min;

	//	...
	document.documentElement.style.setProperty('--root-hue', hue);
})();
