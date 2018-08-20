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
	var __form__  = {};
	var __input__ = {};

	//	...
	$OP.Form = function(name){
		//	...
		if( __form__[name] === undefined ){
			__form__[name] = new Form(name);
		};

		//	...
		return __form__[name];
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
			return this.Tag() ? true: false;
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
		Tag(){
			return this.tag;
		};

		//	...
		Input(name){
			//	...
			if( __input__[this.name] === undefined ){
				__input__[this.name] = {};
			};

			//	...
			if( __input__[this.name][name] === undefined ){
				__input__[this.name][name] = new Input(name, this);;
			}

			//	...
			return __input__[this.name][name];
		};
	};

	//	...
	class Input extends Core {
		//	...
		constructor(name, parent){
			//	...
			super(name);

			//	...
			this.name = name;

			//	...
			this.parent = parent;

			//	...
			this.tag = null;

			//	...
			var value = $OP.URL.Query.Get(name);

			//	...
			if( value !== null ){

				//	...
				if( typeof value !== 'string' ){
					//	...
					var temp = {};

					//	...
					for(var val of value){
						temp[val] = true;
					}

					//	...
					value = temp;
				};

				//	...
				this.Value(value);
			};
		};

		//	...
		Tag(value){
			//	...
			if( value === undefined && this.tag ){
				return [this.tag];
			};

			//	...
			var tags = null;

			//	...
			if( this.parent.tag === null ){
				//	NG
				D('this.parent.tag === null');
			}else if( (tags = this.parent.tag.querySelectorAll(`[NAME="${this.name}"]`)).length ){
				//	OK
			}else if( (tags = this.parent.tag.querySelectorAll(`[NAME="${this.name}[]"]`)).length ){
				//	Checkbox
			}else{
				D(`Has not been found this input name. (${this.parent.name}, ${this.name})`);
				return;
			};

			//	...
			if( tags.length === 1 ){
				this.tag = tags[0];
			}else if( value !== undefined ){
				for(var tag of tags){
					//	...
					if( tag.value === value ){
						this.tag = tag;
						return [this.tag];
					};
				};
			};

			//	...
			return tags;
		};

		//	...
		Form(){
			return this.parent;
		};

		//	...
		Input(name){
			return this.parent.Input(name);
		};

		//	...
		Name(){
			return this.name;
		};

		//	...
		Value(value, add){
			//	...
			var tags = this.Tag();

			//	...
			if( tags.length ){
				var tag = tags[0];
			}else{
				return null;
			};

			//	...
			var tagname = tag.tagName.toLowerCase();

			//	...
			switch( tagname ){
				case 'input':
					//	...
					if( tag.type === 'radio' ){
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
					if( tag.type === 'checkbox' ){
						//	...
						if( value !== undefined ){
							//	Set
							for(var tag of tags){
								//	...
								if( add ){
									//	...
									if( value[tag.value] === undefined ){
										continue;
									}
								};
								//	...
								tag.checked = value[tag.value];
							};
						}else{
							//	Get
							value = [];

							//	Reset stored tag. (Re:get)
							this.tag = null;
							var tags = this.Tag();

							//	...
							for(var tag of tags){
								//	Get
								value[tag.value] = tag.checked;

								/*
								//	...
								if( tag.checked ){
									value.push(tag.value);
								}
								*/
							};
						};

						break;
					};
				//	break;

				case 'textarea':
					//	...
					if( value !== undefined ){
						if( add ){
							tag.value += value;
						}else{
							tag.value = value;
						}
					}else{
						value = tag.value;
					};
					break;

				case 'select':
					if( value !== undefined ){
						for(var i=0, len=tag.options.length; i<len; i++ ){
							if( tag.options[i].value === value ){
								tag.selectedIndex = i;
								break;
							}
						};
					}else{
						value = tag.options[tag.selectedIndex].value;
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
			var tags = this.Tag();
			var tag  = null;
			if( tags.length ){
				tag = tags[0];
			}else{
				D(`Tag is empty. (${this.name})`);
				return;
			};

			//	...
			if(!add ){
				//	...
				while( tag.options.length ){
					tag.removeChild( tag.options[0] );
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
			var is_array = Array.isArray(options);
			for(var option in options ){
				//	...
				var label = options[option];
				var value = is_array ? label: option;

				//	...
				var opt = document.createElement('option');
					opt.value     = value;
					opt.innerText = label;

				//	...
				tag.appendChild( opt );
			};
		};

		//	...
		Data(name){
			//	...
			var tag = this.Tag()[0];

			//	...
			return tag.dataset[name] ? tag.dataset[name]: null;
		};

		//	...
		Event(label, func){
			//	...
			var input = this;

			//	...
			for(var tag of this.Tag()){
				//	...
				tag.addEventListener(label, function(e){
					//	...
					input.Tag( e.target.value );

					//	...
					func(e, input);

					/*
					//	...
					if( label === 'change' ){
						if( selectedIndex === 0 ){
							// throw event
						}
					}
					*/
				}, false);
			};
		};
	};
})();
