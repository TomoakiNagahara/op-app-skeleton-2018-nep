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
if(!$OP.SDOM ){
	$OP.SDOM = {};
};

//	...
(function(){
	//	...
	var __sdom = {};

	//	...
	$OP.SDOM.Get = function(sdom_name, attr_name){
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

//	...
(function(){
	//	...
	__action = {};

	//	...
	$OP.SDOM.Action = {};

	//	...
	$OP.SDOM.Action.Set = function(sdom_name, func_name, func){
		//	...
		if(!__action[sdom_name] ){
			__action[sdom_name] = {};
		};

		//	...
		if( __action[sdom_name][func_name] ){
			console.error(`This function was already exists. (${sdom_name}, ${func_name})`);
			return;
		};

		//	...
		__action[sdom_name][func_name] = func;
	};

	//	...
	$OP.SDOM.Action.Exe = function(sdom_name, func_name, dom){
		//	...
		if(!__action[sdom_name] || !__action[sdom_name][func_name] ){
			console.error(`Has not been set this function. (sdom: ${sdom_name}, func: ${func_name})`);
			return false;
		}

		//	...
		var func = __action[sdom_name][func_name];

		//	Init return value.
		var result = false;

		//	Closed scope.
		(function(){
			//	Create function in closed scope.
			eval(`function kage () ${func}`);

			//	Function execute.
			result = kage.call(dom);
		})();

		//	Return false is to suppress form submit.
		return result ? result: false;
	};
})();
