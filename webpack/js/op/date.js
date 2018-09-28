/**
 * app-skeleton-webpack:/js/op/date.js
 *
 * @creation  2018-09-27
 * @version   1.0
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
(function(){
	//	...
	if(!$OP.Date ){
		$OP.Date = {};
	};

	/** Get date object.
	 *
	 * @param  string datetime
	 * @return object date
	 */
	$OP.Date.Get = function(datetime){
		return new Date( datetime.replace(/-/g,'/') );
	};

	/** Get date string from data object.
	 *
	 * @param  object date|null
	 * @return string datetime
	 */
	$OP.Date.Date = function(date){
		//	...
		if(!date ){
			date = new Date();
		};

		//	...
		var year  = date.getFullYear();
		var month = date.getMonth() +1;
		var day   = date.getDate();

		//	...
		if( month < 10 ){
			month = '0'+month;
		};

		//	...
		if( day < 10 ){
			day = '0'+day;
		};

		//	...
		return year+'-'+month+'-'+day;
	};

	/** Get date time string from object.
	 *
	 * @param  object date|null
	 * @return string datetime
	 */
	$OP.Date.Datetime = function(date){
		//	...
		if(!date ){
			date = new Date();
		};

		//	...
		var days = $OP.Date.Date(date);
		var hour = date.getHours();
		var min  = date.getMinutes();
		var sec  = date.getSeconds();

		//	...
		if( hour < 10 ){
			hour = '0'+hour;
		}
		if( min < 10 ){
			min = '0'+min;
		}
		if( sec < 10 ){
			sec = '0'+sec;
		}

		//	...
		return days+' '+hour+':'+min+':'+sec;
	};
})();
