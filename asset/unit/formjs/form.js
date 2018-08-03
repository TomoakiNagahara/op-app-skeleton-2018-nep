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
		Test(){
			return true;
		};
	};

	//	...
	class Form extends Core {
		//	...
		constructor(name){
			//	...
			super(name);

			//	...
			this.tag = document.querySelector(`FORM[NAME="${name}"]`);
		};

		//	...
		Input(name){
			var $_input = new Input(name, this);
			return $_input;
		};
	};

	//	...
	class Input extends Core {
		//	...
		constructor(name, parent){
			//	...
			super(name);

			//	...
			this.parent = parent;

			//	...
			this.tag = this.parent.tag.querySelector(`[NAME="${name}"]`);

			//	...
			this.onchange = this.tag.onchange;

			//	...
			var onchange = null;

			//	...
			document.addEventListener('change', function(e){
				onchange
			}, false);
		};

		//	...
		Value(value){
			//	...
			var tag = this.tag.tagName;

			//	...
			switch( tag ){
				case 'INPUT':
					//	...
					if( value ){
						this.tag.value = value;
					}else{
						value = this.tag.value;
					};
					break;
				default:
				D(`Has not been support yet this tag. (this.tag.tagName)`);
			};

			//	...
			return value;
		};
	};
})();
