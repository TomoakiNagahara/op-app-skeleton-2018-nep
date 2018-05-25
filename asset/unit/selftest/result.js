/**
 * unit-selftest:/result.js
 *
 * @creation  2018-04-30
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
(function(){
	//	...
	var text = document.querySelector('#selftest-result').innerText;
	document.querySelector('#selftest-result').innerText = '';

	//	...
	var json = JSON.parse(text);

	//	...
	var roots = document.createElement('ul');
	var div   = document.createElement('div');
		div.appendChild(roots);

	//	...
	document.querySelector('#selftest-result').appendChild(div);

	//	...
	for(var dsn in json ){
		//	...
		var root = document.createElement('li');
			root.innerText = dsn;

		//	...
		roots.appendChild(root);

		//	...
		var list = document.createElement('ul');
		var item = document.createElement('li');
			item.innerText = 'Users';
			list.appendChild(item);
			root.appendChild(list);
		__user(list, json[dsn]['users']);

		//	...
		var list = document.createElement('ul');
		var item = document.createElement('li');
			item.innerText = 'Databases';
			list.appendChild(item);
			root.appendChild(list);
		__database(list, json[dsn]['databases']);

		//	...
		__tables(list, json[dsn]['tables']);

		//	...
		__columns(list, json[dsn]['columns']);
	}

	//	...
	function __user( root, json){
		//	...
		var list = document.createElement('ol');
			list.classList.add('user');
			root.appendChild(list);

		//	...
		for(var user in json ){
			//	...
			var result = json[user]['result'];
			var color  = result ? 'success':'error';

			//	...
			var name   = document.createElement('span');
			var error  = document.createElement('span');
			var modify = document.createElement('span');
			var item   = document.createElement('li');
				item.classList = color;
				item.appendChild(name);
				item.appendChild(error);
				item.appendChild(modify);
				list.appendChild(item);

			//	...
			name.innerText = user;
			name.classList = 'name';

			//	...
			error.classList.add('error');
			if(!json[user]['exist']    ){ error.classList.add('exist')    }else
			if(!json[user]['password'] ){ error.classList.add('password') }else
			if(!json[user]['privilege']){ error.classList.add('privilege')}

			//	...
			if( json[user]['modify'] ){
				modify.innerText = json[user]['modify'];
				modify.classList.add('modify');
			}
		}
	}

	//	...
	function __database(root, json){
		//	...
		var ol = document.createElement('ol');
		root.appendChild(ol);

		//	...
		for(var database in json ){
			var result = json[database]['result'];
			var color  = result ? 'success':'error';
			var li = document.createElement('li');
				li.classList = color;
				li.innerText = database;
				li.dataset.database = database;
				ol.appendChild(li);

			//	...
			if( json[database]['result'] ){
				continue;
			}

			//	...
			for(var key in json[database] ){
				if(!json[database][key] ){
					D(key, false);
				}
			}
		}
	}

	//	...
	function __tables(root, json){
		//	...
		for(var database in json ){
			//	...
			var ol = document.createElement('ol');

			//	...
			root.querySelector('[data-database="'+database+'"]').appendChild(ol);

			//	...
			for(var table in json[database]){
				var result = json[database][table]['result'];
				var color  = result ? 'success':'error';
				var li = document.createElement('li');
					li.classList = color;
					li.innerText = table;
					li.dataset.table = table;
					ol.appendChild(li);

				//	...
				if( result ){
					continue;
				}
			}
		}
	}

	//	...
	function __columns(root, json){
		//	...
		for(var database in json ){
			for(var table in json[database] ){
				//	...
				var list = document.createElement('ul');

				//	...
				root.querySelector('[data-database="'+database+'"]')
					.querySelector('[data-table="'+table+'"]').appendChild(list);

				//	...
				for(var column in json[database][table] ){
					//	...
					var result = json[database][table][column]['result'];
					var color  = result ? 'success' : 'error';
					var item = document.createElement('li');
						item.innerText = column;
						item.classList.add(color);
						if( !result ){
							item.classList.add('bold');
						}
					list.appendChild(item);

					//	...
					var result = __details(list, json[database][table][column]);

					//	...
					if( result ){
						item.classList.add('success');
					}else{
						item.classList.add('error');
						item.classList.add('bold');
					}

					//	...
					list.removeChild(item);
				}
			}
		}
	};

	//	...
	function __details(root, json){
		//	...
		var list = document.createElement('ul');
		root.appendChild(list);

		//	...
		for(var name in json){
			if( name === 'result' ){
				continue;
			}

			//	...
			if( json[detail]['result'] ){
				continue;
			}

			//	...
			result = false;

			//	...
			var span = document.createElement('span');
				span.innerText = detail;
				span.classList.add('bold');

			var item = document.createElement('li');
				item.classList.add('error');

			//	...
			item.appendChild(span);
			list.appendChild(item);

			//	...
			__detail(item, json[detail]['detail']);
		}

		//	...
		return result;
	};

	//	...
	function __detail(item, json){
		//	...
		var current = document.createElement('span');
		var arrow   = document.createElement('span');
		var modify  = document.createElement('span');

		//	...
		current.innerText = json.current;
		modify .innerText = json.modify;

		//	...
		item   .classList.add('name');
		current.classList.add('current');
		arrow  .classList.add('arrow');
		modify .classList.add('modify');

		//	...
		if( json.current.length === 0 ){
			current.classList.add('empty');
		}
		if( json.modify .length === 0 ){
			modify .classList.add('empty');
		}

		//	...
		item.appendChild(current);
		item.appendChild(arrow);
		item.appendChild(modify);
	};
})();
