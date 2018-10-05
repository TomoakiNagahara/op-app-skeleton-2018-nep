/**
 * unit-test:/unit/shadow-dom/test-6-obj.js
 *
 * @creation  2018-10-05
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
var ShadowDom = function(name){
	//	...
	this.__name   = name;

	//	...
	var dom = $OP.SDOM.Get('sdom', name);

	//	...
	this.__On(dom);

	//	...
	this.__html = dom.innerHTML;

	//	...
	dom.innerHTML = '';
};

//	...
ShadowDom.prototype.Build = function(){
	//	...
	var dom = document.createElement('div');
		dom.innerHTML = this.__html;

	//	...
	this.__Child(dom);

	//	...
	this.__Json(dom);

	//	...
	this.__Dom(dom);

	//	...
	var name_1 = this.__name;
	var name_2 = this.__insert_name;

	//	...
	var temp = $OP.SDOM.Get(this.__name, this.__insert_name);
	if(!temp ){
		return;
	};

	//	...
	temp.innerHTML = dom.innerHTML;
};

//	...
ShadowDom.prototype.Insert = function(root_dom, name){
	//	...
	this.__root = root_dom;

	//	...
	this.__insert_name = name;

	//	...
	if( root_dom.Child ){
		root_dom.Child(this, name);
	};

	//	...
	this.Build();
};

//	...
ShadowDom.prototype.Update = function(){
	//	...
	this.Build();
};

//	...
ShadowDom.prototype.Remove = function(){
	//	...
	this.__insert_point.innerHTML = '';
};

//...
ShadowDom.prototype.Child = function(sdom, name){
	//	...
	if(!this.__child ){
		this.__child = {};
	};

	//	...
	this.__child[name] = sdom;
};

//	...
ShadowDom.prototype.__Child = function(dom){
	for(var name in this.__child ){
		var sdom  = this.__child[name];

		//	...
		sdom_name = sdom.__name;
		attr_name = name;

		//	...
		var list = dom.querySelectorAll(sdom_name);
		for(var i=0; i<list.length; i++){
			//	Check attribute name.
			if( list[i].getAttribute('name') !== attr_name ){
				continue;
			}

			//	Insert child Shadow-DOM.
			list[i].innerHTML = sdom.__html;
		};
	};
};

//...
ShadowDom.prototype.__Json = function(dom){
	//	...
	var json = this.__json;

	//	...
	dom.innerHTML = dom.innerHTML.replace(/(\{\s*(json[\w\.]*)\s*\})/g, function(match, offset, string){
		//	...
		var list = string.split('.');
		var key  = null;
		var val  = null;
		var type = null;

		//	...
		if( list.length === 1 ){
			val = json;
		}else{
			//	json.foo.bar --> foo.bar
			var root = list.shift();

			//	...
			while( key = list.shift() ){
				//	...
				if( val ){
					val = val[key];
				}else{
					val = json[key];
				}

				//	...
				type = typeof val;

				//	...
				switch( type ){
					case 'undefined':
						D(key, type);
						return 'undefined';

					case 'boolean':
						return val ? 'true': 'false';

					case 'number':
					case 'string':
						return val;

					case 'object':
						break;

					default:
						console.log(json, type, key, val);
				};
			};
		};

		//	...
		return JSON.stringify(val).replace(/'/, "\\'").replace(/"/g, "'");
	});
};

//	...
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

//	...
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

//	...
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

//	...
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
			temp.setAttribute(attr, `return $OP.SDOM.Action.Exe('${sdom_name}', '${func_name}', this);`);
		};
	};
};
