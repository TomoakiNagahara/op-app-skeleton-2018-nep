/**
 * unit-test:/unit/shadow-dom/test-5.html
 *
 * @creation  2018-09-19
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

	//	...
	$OP.SDOM.Create = function(name){
		return new ShadowDom(name);
	};

	//	...
	$OP.SDOM.Get = function(root, tag, name){
		//	...
		if(!__list[tag] ){
			__list[tag] = {};
		};

		//	...
		if( __list[tag][name] ){
			//	Exist
		}else{
			//	Search
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
		list[name] = func;

		//	...
		return list;

		//	...
//		$OP.SDOM.Action.Set(sdom_name, name, Function.call(null,"return function"+func)());
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
	$OP.SDOM.Action.Exe = function(sdom_name, func_name){
		if(!__action[sdom_name] || !__action[sdom_name][func_name] ){
			console.error(`Has not been set this function. (sdom: ${sdom_name}, func: ${func_name})`);
			return false;
		}

		//	...
		return __action[sdom_name][func_name]();
	};
})();

//...
var ShadowDom = function(name){
	//	...
	this.__name   = name;

	//	...
	var dom = $OP.SDOM.Get(document, 'sdom', name);

	//	...
	this.__html = dom.innerHTML;

	//	...
	dom.innerHTML = '';
};

//...
ShadowDom.prototype.Build = function(){
	//	...
	var dom = document.createElement('div');
		dom.innerHTML = this.__html;

	//	...
//	this.__Json(dom);

	//	...
	this.__Dom(dom);

	//	...
	this.__On(dom);

	//	...
	var name_1 = this.__name;
	var name_2 = this.__insert_name;

	//	...
	var temp = $OP.SDOM.Get(document, this.__name, this.__insert_name);
	if(!temp ){
		return;
	};

	//	...
	temp.innerHTML = dom.innerHTML;
};

//...
ShadowDom.prototype.Insert = function(name){
	//	...
	this.__insert_name = name;

	//	...
	this.Build();
};

//...
ShadowDom.prototype.Update = function(){
	//	...
	this.Build();
};

//...
ShadowDom.prototype.Remove = function(){
	//	...
	this.__insert_point.innerHTML = '';
};

//...
ShadowDom.prototype.__Dom = function(dom){

	//	...
	this.__If( dom.querySelectorAll(':scope > [if]') );

	//	...
	this.__For( dom.querySelectorAll(':scope > [for]') );

	//	...
	for(var i=0; i<dom.childNodes.length; i++){
		//	...
		var node = dom.childNodes[i];

		//	...
		if(!node.tagName ){
			continue;
		};

		//	...
		this.__Dom( node );
	};
};

//...
ShadowDom.prototype.__If = function(list){
	//	...
	for(var i=0; i<list.length; i++){
		var dom = list[i];
		var val = dom.getAttribute('if');
		if(!eval( val ) ){
			dom.parentNode.removeChild(dom);
		};
	};
};

//...
ShadowDom.prototype.__For = function(list){
	//	...
	for(let i=0; i<list.length; i++){
		var dom = list[i];
		var tmp = dom.getAttribute('for');
		if( tmp === "{ this.json }" ){
			tmp = dom.getAttribute('json');
			if( tmp ){
				tmp = tmp.replace(/\\'/g  , '&#39;');
				tmp = tmp.replace(/'/g    , '"');
				tmp = tmp.replace(/&#39;/g, "'");
			};
		};
		var val = JSON.parse(tmp);
		var temp= '';

		//	...
		for(let i in val){
			let v = val[i];

			//	...
			var html = dom.innerHTML;

			//	...
			html = html.replace(/\{\s*i\s*\}/g, i);
			html = html.replace(/\{\s*v\s*\}/g, v);

			//	...
			html = html.replace(/\{\s*index\s*\}/g, i);
			html = html.replace(/\{\s*value\s*\}/g, v);

			//	...
			temp += html;
		};

		//	...
		dom.innerHTML  = '';
		dom.innerHTML += temp;
	};
};

//...
ShadowDom.prototype.__On = function(dom){
	//	...
	for(var attr of ['onclick','onmouseover','onmouseleave']){

		//	...
		var list = dom.querySelectorAll(`[${attr}]`);

		//	...
		for(var i=0; i<list.length; i++){
			var temp = list[i];

			//	...
			var sdom_name = this.__name;
			var func_name = temp.getAttribute(attr);

			//	...
			temp.setAttribute(attr, `return $OP.SDOM.Action.Exe('${sdom_name}', '${func_name}');`);
		};
	};
};