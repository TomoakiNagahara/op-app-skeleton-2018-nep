/**
 * unit-test:/unit/shadow-dom/chat/sdom-core.js
 *
 * @creation  2018-10-16
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	var __sdom = {};

	//	...
	$OP.SDOM = function(sdom_name, attr_name){
		//	...
		if(!__sdom[sdom_name] ){
			__sdom[sdom_name] = {};
		};

		//	...
		__sdom[sdom_name][attr_name] = new ShadowDom(sdom_name, attr_name);

		//	...
		return __sdom[sdom_name][attr_name];
	};
})();
