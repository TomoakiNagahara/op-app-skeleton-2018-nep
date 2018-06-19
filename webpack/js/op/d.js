/**
 * app-skeleton-webpack:/js/op/d.js
 *
 * @creation  2017-06-07
 * @version   1.0
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$OP.D = function(){
	//	...
	var log = '';
	var stack = [];

	//	...
	for(var i=0; i<arguments.length; i++){
		//	...
		var val  = arguments[i];
		var type = typeof(val);

		//	...
		switch( type ){
			case 'string':
				log += '"'+val+'"';
				break;

			case 'object':
				if( val === null ){
					log += val;
					break;
				}else{
					log += val.length !== undefined ? 'array': 'object';
				}

				//	...
				stack.push(val);
				break;

			default:
				log += val;
		}

		//	...
		if( i+1 !== arguments.length ){
			log += ', ';
		}
	}

	//	...
	if( log.length ){
		console.log(log);
	}

	//	...
	for(var i=0; i<stack.length; i++){
		console.log(stack[i]);
	}
};

//	...
var d = $OP.D;
var D = $OP.D;
