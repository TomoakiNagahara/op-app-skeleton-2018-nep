/**
 * app-webpack-js:/notice.js
 *
 * @creation  2017-07-28
 * @version   1.0
 * @package   app-webpack-js
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	$OP.Notice = function(div, i){
		//	...
		if(!div.innerText){
			return;
		}

		//	...
		var json  = JSON.parse(div.innerText);
		var tags = {};
			tags.count   = document.createElement('span');
			tags.message = document.createElement('div');
			tags.created = document.createElement('span');

			tags.count  .innerText = json.count;
			tags.created.innerText = json.created;

			//	...
			var me1 = document.createElement('p');
			var me2 = document.createElement('p');

			//	...
			json.message += "\n";
			var pos = json.message.indexOf("\n");
			me1.innerHTML = json.message.substr(0, pos);
			me2.innerHTML = json.message.substr(pos+1, json.message.length -pos -2);

			//	...
			tags.message.classList.add('message');
			tags.message.appendChild(me1);
			tags.message.appendChild(me2);

		//	...
		var temp = document.createElement('div');
			temp.appendChild( tags.message );
			temp.appendChild( __backtrace( json.backtrace ) )

		//	...
		div.innerText = '';
		div.appendChild(temp);

		//	...
		setTimeout(function(){
			__notice(me1.innerText, me2.innerText);
		}, 1000 * i);
	}

	function __notice(message, subtext){
		//	...
		console.error(message, subtext);

		//	...
		var area = document.querySelector('#OP_NOTICE_AREA');
		if(!area ){
			//	...
			area = document.createElement('div');
			area.id = 'OP_NOTICE_AREA';

			//	...
			var body = document.querySelector('body');
				body.insertBefore(area, body.children[0]);
		}

		//	...
		var div  = document.createElement('div');
		var span = document.createElement('span');
			span.innerText = message;

		//	...
		div .appendChild(span);
		area.appendChild(div);

		//	...
		setTimeout(function(){
			div.classList.add('hide');
			setTimeout(function(){
				area.removeChild(div);
			}, 1000 * 1);
		}, 1000 * 3);
	}

	//	...
	function __backtrace(json){
		var table = document.createElement('table');
		for(var i=0; i<json.length; i++){
			table.appendChild( __line(json[i]) );
		}
		return table;
	}

	//	...
	function __line(json){
		var tds = {};
			//	...
			tds.file = document.createElement('td');
			tds.line = document.createElement('td');
			tds.func = document.createElement('td');

			//	...
			tds.file.classList.add('file');
			tds.line.classList.add('line');
			tds.func.classList.add('function');

			//	file
			var span = document.createElement('span');
			span.innerText = $OP.Path.Compress(json.file);
			span.classList.add('file');
			tds.file.appendChild(span);

			//	line
			var span = document.createElement('span');
			span.innerText = json.line === undefined ? '': json.line;
			span.classList.add('line');
			tds.line.appendChild(span);

			//	function
			var span = document.createElement('span');
			span.innerText = json.line;
			span.classList.add('function');
			tds.func.appendChild(span);
			if( json.type ){
				span.innerHTML = json.class + json.type + json['function'];
			}else if( json['function'] ){
				span.innerText = json['function'];
			}else{
				span.innerText = '';
			}

			//	arguments
			if( span.innerText ){
				tds.func.appendChild( $OP.Args(json.args, true) );
			}

		var tr = document.createElement('tr');
			tr.appendChild( tds.file );
			tr.appendChild( tds.line );
			tr.appendChild( tds.func );
		return tr;
	}

	//	...
	document.addEventListener('DOMContentLoaded', function(){
		var divs = document.querySelectorAll('div.OP_NOTICE');
		for(var i=0; i<divs.length; i++){
			$OP.Notice(divs[i], i);
		}
	});
})();
