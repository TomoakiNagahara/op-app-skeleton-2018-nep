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
			if( this.tag = this.parent.tag.querySelector(`[NAME="${name}"]`) ){
				//	OK
			}else if( this.tag = this.parent.tag.querySelector(`[NAME="${name}[]"]`) ){
				//	Checkbox
			}else{
				D(`Has not been found this input name. (${this.parent.name}, ${name})`);
				return;
			};
		};

		//	...
		Value(value, checked){
			//	...
			if(!this.tag ){
				return null;
			};

			//	...
			var tag = this.tag.tagName.toLowerCase();

			//	...
			switch( tag ){
				case 'input':
					//	...
					if( this.tag.type === 'radio' ){
						//	...
						if( value !== undefined ){
							//	Set
							var nodes = this.parent.tag.querySelectorAll(`[name="${this.name}"]`);

							//	...
							for(var i=0; i<nodes.length; i++ ){
								if( nodes[i].value === value ){
									nodes[i].checked = true;
								}
							}
						}else{
							//	Get
							var node = this.parent.tag.querySelector(`[name="${this.name}"]:checked`);
							value = node ? node.value: null;
						}
						break;
					};

					//	...
					if( this.tag.type === 'checkbox' ){
						//	...
						if( value !== undefined ){
							//	Set
							var node = this.parent.tag.querySelector(`[name="${this.name}[]"][value="${value}"]`);
							if( node.value === value ){
								node.checked = checked;
							}
						}else{
							//	Get
							value = [];

							//	...
							var nodes = this.parent.tag.querySelectorAll(`[name="${this.name}[]"]:checked`);

							//	...
							for(var i=0; i<nodes.length; i++ ){
								value[i] = nodes[i].value;
							}
						};
						break;
					};
				//	break;

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

		//	...
		Option(options, add){
			//	...
			if(!add ){
				while( this.tag.options.length ){
					this.tag.removeChild( this.tag.options[0] );
				};
			};

			//	...
			if( typeof options === "string" ){
				options = JSON.parse(options)
			};

			//	...
			if(!options){
				return;
			};

			//	...
			for( var option of options ){
				//	...
				switch( typeof option ){
					case 'string':
						var value = option;
						var label = option;
						break;

					default:
						D(typeof option);
					continue;
				}

				//	...
				var tag = document.createElement('option');
					tag.value     = value;
					tag.innerText = label;

				//	...
				this.tag.appendChild( tag );
			};
		};

		//	...
		Data(name){
			return this.tag.dataset[name] ? this.tag.dataset[name]: null;
		};

		//	...
		Event(label, func){
			var input = this;
			input.tag.addEventListener(label, function(e){
				func(e, input);
			}, false);
		};
	};
})();
