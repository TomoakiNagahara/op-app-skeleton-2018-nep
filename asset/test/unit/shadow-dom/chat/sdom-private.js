/**
 * unit-test:/unit/shadow-dom/chat/sdom-private.js
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
	ShadowDom.prototype.__Mount = function(){
		__add_style();
		__add_script();
	};

	//	...
	ShadowDom.prototype.__Remove = function(){
		__del_style();
		__del_script();
	};

	//	...
	ShadowDom.prototype.__Build = function(){
		//	...
		var sdom = __get_sdom(this.__sdom_name);

		//	...
		var dom = __get_dom(document, this.__sdom_name, this.__attr_name);

		//	...
		dom.innerHTML = sdom.html;
	};

	//	...
	var __sdom = {};

	//	...
	function __get_dom(root, sdom_name, attr_name){
		//	...
		var list = root.querySelectorAll(`${sdom_name}[name=${attr_name}]`);

		//	...
		var dom = document.createElement('div');

		//	...
		switch( list.length ){
			case 0:
				console.error(`Not Found tag. (${sdom_name}, ${attr_name})`);
				break;

			case 1:
				dom = list[0];
				break;

			default:
				console.error(`Found was multiple tags. (${sdom_name}, ${attr_name})`);
			break;
		};

		//	...
		return dom;
	};

	//	...
	function __get_sdom(sdom_name){
		//	...
		if(!__sdom[sdom_name] ){
			//	...
			for(var sdom of document.getElementsByTagName('sdom') ){
				//	...
				if( sdom_name === sdom.getAttribute('name') ){
					var temp = {};
						temp.html   = sdom.innerHTML;
						temp.style  = '';
						temp.script = '';
					__sdom[sdom_name] = temp;
				};
			};
		};

		//	...
		return __sdom[sdom_name];
	};

	//	...
	function __add_style(){};
	function __add_script(){};
	function __del_style(){};
	function __del_script(){};
})();
