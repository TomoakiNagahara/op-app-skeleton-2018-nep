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
					__list[tag][name] = dom;
					break;
				};
			};
		};

		//	...
		return __list[tag][name];
	};
})();

//...
var ShadowDom = function(name){
	//	...
	this.__name = name;

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

	/*
	//	...
	this.__Json(dom);

	//	...
	this.__Dom(dom);

	//	...
	this.__On(dom);
	*/

	//	...
	var name_1 = this.__name;
	var name_2 = this.__insert_name;

	//	...
	var temp = $OP.SDOM.Get(document, this.__name, this.__insert_name);
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
