/**
 * app-skeleton-webpack:/js/op/url.js
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if( typeof $OP.URL === "undefined" ){
	$OP.URL = {};
}

//	...
(function(){
	//	...
	var queries = {};

	//	...
	location.search.substr(1).split('&').map(function(v){
		var tmp = v.split('=');
		var key = tmp[0];
		var val = decodeURIComponent(tmp[1].replace(/\+/,' '));

		//	For checkbox.
		if( key.match(/%5B%5D$/) ){
			key = key.replace(/%5B%5D$/,'');
			if( queries[key] === undefined ){
				queries[key] = [];
			}

			//	...
			queries[key].push(val);
		}else{
			queries[key] = val;
		};
	});

	//	...
	$OP.URL.Protocol = function(){
		return location.Protocol;
	};

	//	...
	$OP.URL.Domain = function(){
		return location.host;
	};

	//	...
	$OP.URL.Query = {};

	//	...
	$OP.URL.Query.Get = function(key, def){
		//	...
		var result = null;

		//	...
		if( queries[key] !== undefined ){
			result = queries[key];
		}else if( def === undefined ){
			//	Web storage
		}else{
			result = def;
		}

		//	...
		return result;
	};

	//	...
	$OP.URL.Query.Set = function(key, val, save){
		queries[key] = val;
		window.history.pushState(null, null, __generate());

		//	...
		if( save ){
			//	Web storage
		};
	};

	//	...
	function __generate(){
		var url = '?';
		for(var key in queries ){
			var val =  queries[key];
			url += key+"="+val+'&';
		};
		return url.slice(0, -1);
	};
})();
