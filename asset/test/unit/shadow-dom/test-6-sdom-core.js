/**
 * unit-test:/unit/shadow-dom/test-6-sdom-core.js
 *
 * @creation  2018-10-05
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	__list = {};

	//	...
	$OP.SDOM = {};

	/** Create ShadowDom object.
	 *
	 * @param	 string		 SDOM tag name attribute.
	 * @return	 object		 ShadowDom
	 */
	$OP.SDOM.Create = function(name){
		return new ShadowDom(name);
	};

	//	...
	$OP.SDOM.Get = function(tag, name){
		//	...
		if(!__list[tag] ){
			__list[tag] = {};
		};

		//	...
		if( __list[tag][name] ){
			//	Already found.
		}else{
			//	Do search.
			var list = document.getElementsByTagName(tag);

			//	...
			for(var i=0; i<list.length; i++){
				var dom = list[i];

				//	...
				if( name === dom.getAttribute('name') ){
					//	...
					if( __list[tag][name] ){
						console.error(`This shadow dom was already exist.(${tag}, ${name})`);
						return false;
					};

					//	...
					__list[tag][name] = __parser(dom);

					//	...
					break;
				};
			};
		};

		//	...
		if(!__list[tag][name] ){
			console.error(`Has not been found this dom. (${tag}, ${name})`);
			return false;
		};

		//	...
		__list[tag][name]['function'] = __script(name, __list[tag][name]['script']);

		//	...
		return __list[tag][name]['dom'];
	};

	//	...
	function __parser(dom, list){
		//	...
		list = {};

		//	...
		for(var tag of ['script','style']){
			var st = dom.innerHTML.indexOf(`<${tag}>`);
			var en = dom.innerHTML.indexOf(`</${tag}>`);
			if( st !== -1 && en !== -1 ){
				//	...
				var ad = 2 + tag.length;

				//	...
				list[tag] = dom.innerHTML.slice(st+ad,en);

				//	...
				dom.innerHTML = dom.innerHTML.substr(0, st);
			};
		};

		//	...
		list['dom'] = dom;

		//	...
		return list;
	};

	//	...
	function __script(sdom_name, script){
		//	...
		if(!script ){
			return;
		};

		//	...
		var list = {};

		//	...
		var st   = script.indexOf('function');
		var en   = script.indexOf('(');
		var name = script.slice(st+9, en);
		var func = script.substr(en);

		//	...
		$OP.SDOM.Action.Set(sdom_name, name, func);

		//	...
		list[name] = func;

		//	...
		return list;
	};

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

		//	...
		eval(`function kage ${func}`);

		//	...
		return kage.call(dom);
	};
})();
