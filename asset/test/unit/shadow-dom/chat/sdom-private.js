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
		//	...
		var sdom = __get_sdom(this.__sdom_name);

		//	...
		for(var tag_name of ['style','script']){
			//	...
			var list = document.querySelectorAll(`${tag_name}[name=${this.__sdom_name}]`);

			//	...
			if( list.length !== 0 ){
				return;
			};

			//	...
			var dom = document.createElement(tag_name);

			//	...
			document.querySelector('body').appendChild(dom);

			//	...
			dom.innerHTML = sdom[tag_name];
		};
	};

	//	...
	ShadowDom.prototype.__Remove = function(){
		//	...
		var sdom = __get_sdom(this.__sdom_name);

		//	...
		__del_style(sdom);
		__del_script(sdom);
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

	//	Load model functions.
	<?php include('sdom-model.js') ?>
})();
