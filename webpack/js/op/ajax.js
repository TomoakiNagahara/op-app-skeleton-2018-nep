/**
 * app-skeleton-webpack:/js/op/ajax.js
 *
 * @creation  2018-09-18
 * @version   1.0
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!$OP.Ajax ){
	$OP.Ajax = {};
};

//	...
(function(){
	$OP.Ajax.Get = function(url, data, __success, __failure){
		//	...
		if( data ){
			url += '?' + _convert_url_query(data);
		};
		return _ajax('get', url, null, __success, __failure);
	};

	//	...
	$OP.Ajax.Post = function(url, data, __success, __failure){
		return _ajax('post', url, data, __success, __failure);
	};

	//	...
	$OP.Ajax.Json = function(url, data, __success, __failure){
		return _ajax('json', url, data, __success, __failure);
	};

	//	...
	$OP.Ajax.Xml = function(url, data, __success, __failure){
		return _ajax('xml', url, data, __success, __failure);
	};

	//	...
	function _ajax(method, url, data, __success, __failure){
		//	...
		if(!url ){
			console.error("URL is empty.");
			return;
		}

		//	...
		url = $OP.Path.Convert(url);
		if( url === false ){
			return false;
		};

		//	...
		var xhr = new XMLHttpRequest();
		if(!xhr){
			console.error("XMLHttpRequest was failed.");
			return;
		}

		//	...
		xhr.onreadystatechange = function(){
			/**
			 * 0 = uninitialized
			 * 1 = loading
			 * 2 = loaded
			 * 3 = interactive
			 * 4 = complete
			 */
			var state  = this.readyState;

			/**
			 * 200	OK
			 * 401	Unauthorized
			 * 403	Forbidden
			 * 404	Not Found
			 * 500	Internal Server Error
			 */
			var status = this.status;

			//	...
			if( state === 4 ){
				if( status === 200 ){
					var type = xhr.getResponseHeader('content-type');
					var text = this.responseText;

					//	...
					if( type.substr(0, 9) === 'text/json' ){
						//	...
						var json = text = JSON.parse(text);

						//	...
						if( (json.errors && json.errors.length) ||
							(json.notice && json.notice.length) ){
							console.error('Error', url);
							console.log(json);
						};

						//	...
						if( json.errors ){
							for(var i=0; i<json.errors.length; i++){
								console.info(json.errors[i]);
							}
						}

						//	...
						if( json.notice ){
							for(var i=0; i<json.notice.length; i++){
								console.info(json.notice[i]);
							}
						}
					}

					//	...
					if( __success ){
						__success(text);
					}
				}else{
					//	...
					if( __failure ){
						__failure(status);
					}
				}
			}
		};

		//	method, url, async, user-name, password
		xhr.open(method, url, true, null, null);

		//	...
		var body = null;

		//	...
		switch( method ){
			case 'get':
				break;

			case 'post':
				body = _convert_url_query(data);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				break;

			case 'json':
				xhr.setRequestHeader('Content-Type','application/json');
				body = JSON.stringify(data);
				break;

			case 'xml':
				break;
		};

		//	...
		xhr.send(body);
//		xhr.abort();

		//	...
		return xhr;
	};

	/** Generate URL Query.
	 *
	 */
	function _convert_url_query(data){
		var join = [];
		for(var key in data){
			var val =  data[key];
				key =  encodeURIComponent(key);
			switch( typeof val ){
				case 'string':
					val = encodeURIComponent(val);
					break;

				case 'object':
					for(var tmp in val){
						tmp = encodeURIComponent(tmp);

						//	...
						join.push(key+'['+tmp+']' +'='+ encodeURIComponent(val[tmp]));
					}
					continue;

				default:
			}

			//	...
			join.push(key +'='+ val);
		}
		return join.join('&').replace( /%20/g, '+' );
	}
})();
