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
	this.__json = {};
};

//	...
ShadowDom.prototype.Name = function(){
	return this.__sdom_name;
};

//	...
ShadowDom.prototype.Json = function(index, value){
	//	...
	if( value !== undefined ){
		this.__json[index] = value;
	};

	//	...
	return this.__json[index] ? this.__json[index]: null;
};

//	...
ShadowDom.prototype.Insert = function(update){
	//	...
	if( this.__Insert() ){
		//	...
		if( update !== false ){
			this.__Update();
		};
	}
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
