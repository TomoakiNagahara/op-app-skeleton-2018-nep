/**
 * unit-test:/unit/shadow-dom/chat/sdom-public.js
 *
 * @creation  2018-10-16
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
var ShadowDom = function(sdom_name, attr_name){
	//	...
	this.__sdom_name = sdom_name;
	this.__attr_name = attr_name;
};

//	...
ShadowDom.prototype.Insert = function(){
	//	...
	this.__Insert();

	//	...
	this.__Update();
};


//...
ShadowDom.prototype.Update = function(){
	//	...
	this.__Update();
};

//...
ShadowDom.prototype.Delete = function(){
	//	...
	this.__Delete();
};
