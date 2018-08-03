/**
 * unit-formjs:/form.js
 *
 * @created   2018-08-03
 * @version   1.0
 * @package   unit-form
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	$OP.Form = function(name){
		var $_form = new Form(name);
		return $_form;
	};

	//	...
	class Core {
		//	...
		constructor(name){
			//	...
			this.name = name;
		};

		//	...
		Tag(){
			if(!this.tag ){

			}
			return this.tag;
		};

		//	...
		Test(){
			return true;
		};
	};

	//	...
	class Form extends Core {
		//	...
		_constructor(name){
			//	...
			this.tag = document.querySelector(`FORM[NAME="${name}"]`);
		};

		//	...
		Input(name){
			var $_input = new Input(name);
			return $_input;
		};
	};

	//	...
	class Input extends Core {
		//	...
		Value(){

		};
	};
})();
