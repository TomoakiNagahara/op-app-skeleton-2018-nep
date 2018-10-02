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
	$OP.URL.Query.Parse = function(query){
		//	...
		var queries = {};

		//	...
		query.substr(1).replace(/&amp;/g,'%26').split('&').map(function(v){
			//	...
			var tmp = v.split('=');
			if( tmp.length !== 2 ){
				tmp = ['',''];
			};

			//	...
			var key = tmp[0];
			var val = decodeURIComponent(tmp[1].replace(/\+/g,' '));

			//	For checkbox.
			if( key.match(/%5B%5D$/) ){
				key = key.replace(/%5B%5D$/,'');
				if( queries[key] === undefined ){
					queries[key] = [];
				};
			};

			//	...
			if( 'object' === typeof queries[key] ){
				if( queries[key] instanceof Array ){
					queries[key].push(val);
				}else{
					console.error(key, queries[key]);
				};
			}else{
				queries[key] = val;
			};
		});

		//	...
		return queries;
	};

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
		//	...
		queries[key] = val;

		//	...
		window.history.pushState(null, null, __generate());

		//	...
		if( save ){
			//	Web storage
		};
	};

	//	...
	function __generate(){
		//	...
		var url = '?';

		//	...
		for(var key in queries ){
			var val =  queries[key];

			//	...
			if( key === '' ){ continue };

			//	...
			if( 'object' === typeof val ){
				for(var i in val){
					var v =  val[i];
					if( val instanceof Array ){
						url += `${key}%5B%5D=${v}&`;
					}else{
						url += `${key}%5B${i}%5D=${v}&`;
					};
				};
			}else{
				url += key+"="+val+'&';
			};
		};

		//	...
		return url.length === 1 ? url : url.slice(0, -1);
	};

	//	Initialize of accessed URL Query. (And remove of "?")
	var queries = $OP.URL.Query.Parse( location.search.substr(1) );
})();
