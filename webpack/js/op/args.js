/**
 * app-webpack-js:/args.js
 *
 * @creation  2017-07-31
 * @version   1.0
 * @package   app-webpack-js
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
//(function(){
	/** Generate arguments spans.
	 *
	 * @param  array
	 * @return DOM
	 */
	$OP.Args = function(values, is_notice){
		//	...
		var args = document.createElement('span');
			args.classList.add('args');

		//	...
		if( values ){
			for(var i=0; i<values.length; i++ ){
				var arg = document.createElement('span');
					arg.classList.add('arg');
					arg.appendChild( $OP.Arg(values[i], is_notice) );
				args.appendChild( arg );
			}
		}

		//	...
		return args;
	}

	/** Create each argument span.
	 *
	 * @param  mixed
	 * @return DOM
	 */
	$OP.Arg = function(val, is_notice){
		var span = document.createElement('span');
		var type = val === null ? 'null': typeof val;

		//	...
		span.classList.add('arg');
		span.classList.add(type);

		//	...
		if( type === 'string' ){
			//	...
			if( is_notice ){
				val = $OP.Path.Compress(val);
			}

			//	In case of from the Notice.
			if( is_notice ){
			//	span.innerText = val;
				span.innerHTML = __meta(val);
			}else{
				span.innerHTML = __meta(val);
			}

			//	Display: 123 --> "123" (Not number)
		//	if( val.match(/^\s?\d+\s?$/) ){ // <-- What is this? <-- maybe " 123 "
			if( val.match(/^\d+$/) ){
				span.classList.add('quote');
			}

			//	Display: true --> "true" (Not boolean)
			if( val === 'true' || val === 'false' || val === 'null' ){
				span.classList.add('quote');
			}

			//	Display: "" (Empty string)
			if( val.length === 0 ){
				span.classList.add('quote');
			}
		}else{
			//	...
			if( type === 'null' ){
				val = 'null';
			}

			//	...
			if( type === 'boolean' ){
				span.classList.add( val ? 'true':'false' );
				val = val ? 'true':'false';
			}

			//	...
			span.innerText = val;
		}

		//	...
		return span;
	}

	/** Show meta character.
	 *
	 * @param  string
	 * @return string
	 */
	function __meta(s){
		return s.replace(/</g,  '&lt;')
				.replace(/>/g,  '&gt;')
				.replace(/ /g,  '<span class="meta space">&nbsp;</span>')
				.replace(/\t/g, '<span class="meta tab">\\t</span>')
				.replace(/\r/g, '<span class="meta cr">\\r</span>')
				.replace(/\n/g, '<span class="meta lf">\\n</span>');
	};
//})();
