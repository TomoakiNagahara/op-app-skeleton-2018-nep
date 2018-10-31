<?php
/**
 * unit-referencet:/index.php
 *
 * @creation  2018-10-30
 * @version   1.0
 * @package   unit-reference
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$endpoint  = App::EndPoint();
$reference = basename(dirname($endpoint));

//	...
App::Breadcrumbs(['href'=>'app:/','text'=>'TOP']);

//	...
App::Breadcrumbs(['href'=>'app:/'.$reference,'text'=>'Reference']);

//	...
$args = [$reference];
foreach( App::Args() as $arg ){
	$args[] = $arg;
	$list['text'] = ucfirst($arg);
	$list['href'] = 'app:/'.join('/', $args);
	App::Breadcrumbs($list);
}

//	...
include('menu.phtml');

//	...
if( count($args) < 2 ){
	return;
}

//	...
$action = $args[1]."/action.php";

//	...
if( file_exists($action) ){
	printf('<div id="markdown" class="markdown" data-markdown="%s"></div>', include($action));
}
?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
//	...
document.addEventListener('DOMContentLoaded', function(){
	//	...
	/*
	marked.setOptions({
		gfm:		 true,
		tables:		 true,
		breaks:		 false,
		pedantic:	 false,
		sanitize:	 true,
		smartLists:	 true,
		smartypants: false,
		langPrefix: '',
		highlight:	 function(code, lang) {
			// hogehoge
			return code;
		}
	});
	*/

	//	...
	var dom = document.querySelector('#markdown');
	if(!dom ){
		return;
	};

	//	...
	var text = dom.dataset.markdown;
	var html = marked(text);
D(text, html);
	//	...
	dom.innerHTML = html;
});
</script>
