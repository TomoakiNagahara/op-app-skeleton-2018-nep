
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
function __for_if_root(sdom, rdom){
	//	...
	for(var dom of rdom.querySelectorAll('[for]')){ // :scope > [for]
		__for(sdom, dom);
	};

	//	...
	for(var dom of rdom.querySelectorAll('[if]')){ // :scope > [if]
		__if(sdom, dom);
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
function __if(sdom, rdom){
	D( rdom.getAttribute('if') );
};
