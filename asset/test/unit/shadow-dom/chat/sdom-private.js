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
	ShadowDom.prototype.__Insert = function(){
		//	Get SDOM.
		var sdom = __get_sdom(this.__sdom_name);

		//	Register private function.
		for(let func_name in sdom.script){
			let func = sdom.script[func_name];
			$OP.SDOM.Action.Set(this.__sdom_name, func_name, func);
		};

		//	Insert style tag.
		for(var tag_name of ['style'/* ,'script' */]){
			//	...
			var list = document.querySelectorAll(`${tag_name}[name=${this.__sdom_name}]`);

			//	...
			if( list.length !== 0 ){
				return;
			};

			//	...
			var dom = document.createElement(tag_name);
				dom.innerHTML = sdom[tag_name];
				dom.setAttribute('name', this.__sdom_name);

			//	...
			document.querySelector('body').appendChild(dom);
		};

		//	...
		var rdom = __get_dom(document, this.__sdom_name, this.__attr_name);

		//	...
		$OP.SDOM.Action.Exe(this.__sdom_name, 'onInsert', rdom);
	};

	//	...
	ShadowDom.prototype.__Update = function(){
		//	Shadow DOM.
		var sdom = __get_sdom(this.__sdom_name);

		//	Real DOM.
		var rdom = __get_dom(document, this.__sdom_name, this.__attr_name);

		//	Initialize html.
		rdom.innerHTML = sdom.html;

		//	Processing.
		__for_if_root(rdom);
	};

	//	...
	ShadowDom.prototype.__Delete = function(){
		//	...
		var sdom = __get_sdom(this.__sdom_name);

		//	...
		__del_style(sdom);
		__del_script(sdom);
	};

	//	Load model functions.
	//	<?php
	include('sdom-model.js')
	//	?>
})();
