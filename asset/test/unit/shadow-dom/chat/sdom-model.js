
/**
 * unit-test:/unit/shadow-dom/chat/sdom-model.js
 *
 * @creation  2018-10-18
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
var __sdom = {};

//	...
function __get_rdom(root, sdom_name, attr_name){
	//	...
	var list = root.querySelectorAll(`[sdom-name="${sdom_name}"][idnt-name="${attr_name}"]`);

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
	//	If exists.
	if(!__sdom[sdom_name] ){
		//	Search target sdom.
		for(var sdom of document.getElementsByTagName('sdom') ){
			//	<sdom name="sdom-name">...</sdom>
			if( sdom_name === sdom.getAttribute('name') ){
				//	__sdom[sdom_name] = {"html":"...","style":"...","script":"..."}
				__sdom[sdom_name] = __parse_sdom(sdom.innerHTML);

				//	Parse of script to each functions.
				__sdom[sdom_name]['script'] = __parse_script(__sdom[sdom_name]['script']);
			};
		};
	};

	//	...
	return __sdom[sdom_name];
};

//	...
function __parse_sdom(source){
	//	...
	var result = {};
		result.html   = '';
		result.style  = '';
		result.script = '';

	//	...
	for(var tag_name of ['style','script']){
		var r1 = new RegExp(`<${tag_name}>`);
		var r2 = new RegExp(`</${tag_name}>`);
		var st = source.search(r1) + tag_name.length +2;
		var en = source.search(r2);
		var aa = source.slice(st, en);

		//	...
		result[tag_name] = aa;

		//	...
		st -= tag_name.length + 2;
		en += tag_name.length + 3;
		source = source.slice(0, st)
		       + source.slice(en);
	};

	//	...
	result.html = source;

	//	...
	return result;
};

//	...
function __parse_script(source){
	//	...
	var result = {};

	//	...
	let r = new RegExp(/\s*function\s*([-_a-z0-9]+)\(\)\s*\{/i);

	//	...
	do{
		//	...
		var i = source.search(r);
		if( i === -1 ){
			break;
		};

		//	...
		source = source.substr(i);

		//	...
		var match  = source.match(r);
		var length = match[0].length -1;
		var name   = match[1];

		//	...
		source = source.substr(length);

		//	...
		var br = 0;
		for(var i=0; i<source.length; i++){
			//	...
			switch( source[i] ){
				case '{':
					br++;
					break;
				case '}':
					br--;
					break;
			};

			//	...
			if( br === 0 ){
				//	...
				var script = source.substr(0, i+1);

				//	...
				source = source.substr( script.length );

				//	...
				result[name] = script;

				//	...
				break;
			}
		};
	}while( source.length );

	//	...
	return result;
};

//	...
function __for_root(sdom, rdom){
	//	...
	for(var dom of rdom.querySelectorAll('[for]')){ // :scope > [for]
		__for(sdom, dom);
	};
};

//	...
function __for(sdom, rdom){
	//	...
	let html = rdom.innerHTML;

	//	...
	rdom.innerHTML = '';

	//	...
	var json = rdom.getAttribute('for');
	if(!json.length ){
		return;
	};

	//	...
	var m = json.match(/^ *(this\.json)\.(\w+) *$/);
	if( m[2] ){
		json = sdom.Json(m[2]);
	}else{
		json = JSON.parse(json);
	}

	//	...
	for(let i in json){
		let v =  json[i];
		//	...
		let temp = html;

		//	...
		if( 'object' !== typeof v ){
			temp = temp.replace(/{\s*value\s*}/, v);
		}else{
			for(let key in v){
				let val =  v[key];

				//	...
				var rx = new RegExp(String.raw`{\s*${key}\s*}`, 'g');
				temp = temp.replace(rx, `${val}`);
			};
		};

		//	...
		rdom.innerHTML += temp;
	};
};

//...
function __if_root(sdom, rdom){
	for(var dom of rdom.querySelectorAll('[if]')){
		//	...
		__if(sdom, dom);
	};
};

//...
function __if(sdom, rdom){
	//	...
	var func = function(){
		//	...
		var parsed = __if_parser(rdom.getAttribute('if'));

		//	...
		var ce = parsed.eval;
		var le = __if_value(parsed.left);
		var ri = __if_value(parsed.right);

		//	...
		var io = eval(`${le} ${ce} ${ri}`);

		//	...
		switch( parsed.value ){
			case 'disabled':
				rdom[parsed.value] = io;
			break;
		}

		//	..
		return parsed;
	};

	//	...
	var parsed = func();

	//	...
	[parsed.left, parsed.right].map(function(str){
		var inputs = __if_inputs(str);
		if(!inputs ){ return };
		for(var i=0; i<inputs.length; i++){
			inputs[i].addEventListener('input', function(e){
				func();
			});
		};
	});
};

//	...
function __if_parser(str){
	//	...
	var parsed = {};

	//	...
	if( str.indexOf('?') !== -1 ){
		var tmp = str.split('?');
		var str = tmp[0].trim();
		var att = tmp[1].trim();
	}else{
		var str = str.trim();
		var att = 'remove';
	};

	//	...
	var m = str.match(/^(.+) ([!<>=]+) (.+)$/);
	if(!m ){
		return str;
	};

	//	...
	parsed.left  = m[1].trim();
	parsed.eval  = m[2].trim();
	parsed.right = m[3].trim();
	parsed.value = att;

	//	...
	return parsed;
};

//	...
function __if_inputs(str){
	//	...
	if(!str.match(/^form\./) ){
		return false;
	};

	//	...
	var temp = str.split('.');
	var form_name  = temp[1];
	var input_name = temp[2];
	var form   = document.querySelector(`form[name=${form_name}]`);
	var inputs = form.querySelectorAll(`[name=${input_name}]`);

	//	...
	return inputs;
};

//	...
function __if_value(str){
	//	...
	if(!str.match(/^form\./) ){
		return str;
	};

	//	...
	var temp = str.split('.');
	var form_name  = temp[1];
	var input_name = temp[2];
	var attr_name  = temp[3];
	var prop_name  = temp[4];

	//	...
	if( attr_name === undefined){
		console.error(`Has not been set attribute. (${attr_name})`);
		return false;
	};

	//	...
	if( attr_name !== 'value' ){
		console.error(`Has not been supported this attribute yet. (${attr_name})`);
		return false;
	};

	//	...
	var value = __get_input_value(form_name, input_name);

	//	...
	if( value === null ){
		return false;
	};

	//	...
	if( prop_name === undefined ){
		return value;
	};

	//	...
	if( value[prop_name] === undefined ){
		return false;
	};

	//	...
	return value[prop_name];
};

//	...
function __get_input_value(form_name, input_name){
	//	...
	var form   = document.querySelector(`form[name=${form_name}]`);
	var inputs = form.querySelectorAll(`input[name=${input_name}]`);

	//	...
	var type = __get_input_type(inputs);

	//	...
	return __get_input_type_value(inputs, type);
};

//	...
function __get_input_type(inputs){
	//	...
	var type = null;

	//	...
	if( inputs.length === 1 ){
		type = inputs[0].getAttribute('type');
		return type ? type: inputs[0].tagName;
	};

	//	...
	for(var i=0; i<inputs.length; i++){
		if( type !== 'hidden' ){
			type = input[i].getAttribute('type');
		};
	}

	//	...
	return type;
};

//	...
function __get_input_type_value(inputs, type){
	//	...
	if( type === 'text' || type === 'textarea' ){
		return inputs[0].value;
	};

	//	...
	console.error(type);
};
