/**
 * unit-gdpr:/gdpr.js
 *
 * @creation  2018-11-16
 * @version   1.0
 * @package   unit-gdpr
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
setTimeout(function(){
	//	...
	var dom = document.querySelector('#GDPR .close');
	if(!dom){
		return;
	}

	//	...
	dom.addEventListener('click', function(e){
		var key  = '<?= Hasha1(__DIR__) ?>';
		var url  = 'app:/';
		var data = [];
			data.GDPR = 1;
			data[key] = 1;
		$OP.Ajax.Get(url, data, function(html){
			//	...
			var gdpr = document.getElementById("GDPR");
			if( gdpr.parentNode ){
				gdpr.parentNode.removeChild(gdpr);
			};
		});
	});
}, 1000);
