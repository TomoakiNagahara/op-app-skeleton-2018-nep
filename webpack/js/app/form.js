/**
 * app-skeleton-webpack:/js/app/args.js
 *
 * @creation  2017-07-31
 * @version   1.0
 * @package   app-skeleton-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Wait dom content loaded.
document.addEventListener('DOMContentLoaded', function(){
	//	Get the button tag under the form tag has OP class.
	var buttons = document.querySelectorAll('FORM.OP BUTTON');

	//	Set each buttons.
	for(var button of buttons ){
		if( button.onclick ){
			continue;
		}

		//	Wait button click.
		button.addEventListener("click", function( event ) {
			//	Disable duplicate click.
			event.target.disabled = true;

			//	Disable other input.
			for(var input of event.target.form.querySelectorAll('input, textarea, select') ){
				switch( input.type ){
					case 'select':
					case 'select-one':
					case 'select-multiple':
						for(var option of input.options ){
							if( option.selected === false ){
								option.disabled = true;
							}
						}
						break;

					default:
						D(input.type);
						input.readOnly = true;
				}
			}

			return;

			//	Submit to form.
			event.target.form.submit();

			//	Disable other link click.
			for(var a of document.querySelectorAll('a') ){
				a.addEventListener("click", function( event ) {
					event.preventDefault();
				}, false);
			};
		}, false);
	};
}, false );
