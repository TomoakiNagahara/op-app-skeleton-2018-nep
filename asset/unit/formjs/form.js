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
			return this.tag ? true: false;
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
			if(!this.tag ){
				D(`Has not been found this tag. (${name})`);
				return;
			};

			//	...
			this.onchange = this.tag.onchange;

			//	...
			var onchange = null;

			//	...
			document.addEventListener('change', function(e){
				onchange;
			}, false);
		};

		//	...
		Value(value){
			//	...
			if(!this.tag ){
				return null;
			};

			//	...
			var tag = this.tag.tagName.toLowerCase();

			//	...
			switch( tag ){
				case 'input':
				case 'textarea':
					//	...
					if( value ){
						this.tag.value = value;
					}else{
						value = this.tag.value;
					};
					break;

				case 'select':
					if( value !== undefined ){
						for(var i=0, len=this.tag.options.length; i<len; i++ ){
							D(i, this.tag.options[i].value, value);
							if( this.tag.options[i].value === value ){
								this.tag.selectedIndex = i;
								break;
							}
						};
					}else{
						value = this.tag.options[this.tag.selectedIndex].value;
					};
					break;

				default:
				D(`Has not been support yet this tag. (${tag})`);
			};

			//	...
			return value;
		};
	};
})();
