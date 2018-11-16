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
	var dom = document.querySelector('body.body .GDPR .close');
	if(!dom){
		return;
	}

	//	...
	dom.addEventListener('click', function(e){
		var key  = '<?= Hasha1(__DIR__) ?>';
		var url  = 'app:/';
		var data = [];
			data[key] = 1;
		$OP.Ajax.Get(url, data, function(html){
			D(html);
		});
	});
}, 1000);
