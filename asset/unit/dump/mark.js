/**
 * unit-dump:/mark.js
 *
 * @creation  2017-07-28
 * @version   1.0
 * @package   unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	$OP.Mark = function(div){
		//	...
		if( div.getAttribute('op-mark-complete') ){
			//	...
			console.log('op-mark-complete');

			//	...
			var scripts = document.head.querySelectorAll('script');
			for(var script of document.head.querySelectorAll('script')){
				var source = script.getAttribute('src');
				var queries= $OP.URL.Query.Parse( ((source + '?').split('?'))[1] );

				//	...
				console.log(script.getAttribute('src'));
			};

			return;
		};

		//	...
		if( div.innerText.length < 1 ){
			return;
		}

		//	...
		var text = div.innerText;
		var json = JSON.parse(text);

		//	...
		var spans = {};
			spans.file = document.createElement('span');
			spans.line = document.createElement('span');
			spans.args = document.createElement('span');

			spans.file.innerText = json.file;
			spans.line.innerText = json.line;
			spans.args.appendChild( $OP.Args(json.args) );

			spans.file.classList.add('file');
			spans.line.classList.add('line');
			spans.args.classList.add('args');

		//	...
		div.innerText = '';
		div.appendChild(spans.file);
		div.appendChild(spans.line);
		div.appendChild(spans.args);

		//	...
		div.setAttribute('op-mark-complete', true);
	}

	//	...
	document.addEventListener('DOMContentLoaded', function(){
		//	...
		var divs = document.querySelectorAll('div.OP_MARK');

		//	...
		for(var i=0; i<divs.length; i++){
			$OP.Mark(divs[i]);
		}
	});
})();
