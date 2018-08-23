/**
 * unit-dom:/dom.js
 *
 * @created   2018-08-23
 * @version   1.0
 * @package   unit-dom
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	$OP.Dom = function(condition){
		//	...
		var dom = {};

		//	...
		dom.__condition = condition;

		//	...
		dom.elements = document.querySelectorAll(condition);

		//	...
		dom.Hide = function(){
			for(var element of this.elements){
				element.style.display = 'none';
			};
		};

		//	...
		dom.Show = function(){
			for(var element of this.elements){
				element.style.display = null;
			};
		};

		//	...
		dom.Text = function(text){
			for(var element of this.elements){
				element.innerText = text;
			};
		};

		//	...
		dom.Html = function(html){
			//	...
			html = html.replace(/<(\/?)script>/g, '&lt;$1script&gt;');

			//	...
			for(var element of this.elements){
				element.innerHTML = html;
			};
		};

		//	...
		return dom;
	};
})();
