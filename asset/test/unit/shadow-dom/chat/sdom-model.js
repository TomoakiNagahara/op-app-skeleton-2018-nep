
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
function __get_dom(root, sdom_name, attr_name){
	//	...
	var list = root.querySelectorAll(`${sdom_name}[name=${attr_name}]`);

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
	//	...
	if(!__sdom[sdom_name] ){
		//	...
		for(var sdom of document.getElementsByTagName('sdom') ){
			//	...
			if( sdom_name === sdom.getAttribute('name') ){
				//	...
				__sdom[sdom_name] = __parser(sdom.innerHTML);
			};
		};
	};

	//	...
	return __sdom[sdom_name];
};

//	...
function __parser(source){
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
function __for_if_root(rdom){
	//	...
	for(var dom of rdom.querySelectorAll('[for]')){ // scope > [for]
		__for(dom);
	};

	//	...
	for(var dom of rdom.querySelectorAll('[if]')){
		__for(dom);
	};
};

//	...
function __for(rdom){
	//	...
	let json = rdom.getAttribute('for');
	if(!json.length ){
		return;
	};

	//	...
		json = JSON.parse(json);

	//	...
	let html = rdom.innerHTML;

	//	...
	rdom.innerHTML = '';

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
function __if(dom){

};
