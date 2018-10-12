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
	var __list = {};

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

			//	...
			__style(name, __list[tag][name]['style']);
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
	function __style(name, source){
		//	...
		if(!source ){
			return;
		};

		//	...
		var style = document.createElement('style');
			style.setAttribute('name', name);

		//	...
		style.innerHTML = source.replace(/[\t\s]*(.+)\{/g, function(match, p1, offset, string){
			return "\n" + name + ' ' + p1 + '{';
		});

		//	...
		document.getElementsByTagName('body')[0].appendChild(style);
	};

	//	...
	function __script(sdom_name, source){
		//	...
		if(!source ){
			return;
		};

		//	...
		var list    = {};
		var scripts = {};

		//	...
		var r = new RegExp(/function ([-_a-z0-9]+) ?\(\)\ ?{/i);
		do{
			//	...
			var i = source.search(r);
			if( i === -1 ){
				break;
			};

			//	...
			source = source.substr(i);

			//	...
			var match  = source.match(r);
			var length = match[0].length -1;
			var name   = match[1];

			//	...
			source = source.substr(length);

			//	...
			var br = 0;
			for(var i=0; i<source.length; i++){
				//	...
				switch( source[i] ){
					case '{':
						br++;
						break;
					case '}':
						br--;
						break;
				};

				//	...
				if( br === 0 ){
					//	...
					var script = source.substr(0, i+1);

					//	...
					source = source.substr( script.length );

					//	...
					scripts[name] = script + ';';
					break;
				}
			};
		}while( source.length );

		//	...
		for(var name in scripts ){
			var func = scripts[name];

			//	...
			$OP.SDOM.Action.Set(sdom_name, name, func);

			//	...
			list[name] = func;
		};

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
