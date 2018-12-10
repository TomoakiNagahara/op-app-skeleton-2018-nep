/**
 * unit-selftest:/result.js
 *
 * @creation  2018-04-30
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
setTimeout(function(){
	//	...
	var area = document.querySelector('#OP_SELFTEST');
	var text = area.innerText;

	//	...
	area.innerText = '';

	//	...
	var json = JSON.parse(text);

	//	...
	var roots = document.createElement('ul');
	var div   = document.createElement('div');
		div.appendChild(roots);

	//	...
	area.appendChild(div);

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
		__fields(list, json[dsn]['fields']);

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
			var lack   = document.createElement('span');
			var item   = document.createElement('li');
				item.classList = color;
				item.appendChild(name);
				item.appendChild(error);
				item.appendChild(lack);
				item.appendChild(modify);
				list.appendChild(item);

			//	...
			name.innerText = user;
			name.classList = 'name';

			//	...
			lack.classList.add('lack');

			//	...
			error.classList.add('error');
			if(!json[user]['exist']    ){ error.classList.add('exist')    }else
			if(!json[user]['password'] ){ error.classList.add('password') }else
			if(!json[user]['database'] ){ error.classList.add('database') }else
			if(!json[user]['table']    ){ error.classList.add('table')    }else
			if(!json[user]['privilege']){ error.classList.add('privilege')};

			//	...
			if(!json[user]['database'] ){
				//	...
				for(var database_name in json[user]['databases'] ){
					//	...
					if( json[user]['databases'][database_name] ){
						continue;
					};
					//	...
					var span = document.createElement('span');
						span.innerText = database_name;
						lack.appendChild(span);
				};
			}else if(!json[user]['table'] ){
				//	...
				for(var database_name in json[user]['tables'] ){
					var tables = json[user]['tables'][database_name];
					//	...
					for(var table_name in tables ){
						//	...
						if( tables[table_name] ){
							//	...
							var span = document.createElement('span');
								span.innerText = `${database_name}.${table}`;
								lack.appendChild(span);
						};
					};
				};
			}else if(!json[user]['privilege'] ){
				//	...
				for(var database_name in json[user]['privileges'] ){
					var tables = json[user]['privileges'][database_name];
					//	...
					for(var table_name in tables ){
						//	...
						var span = document.createElement('span');
							span.innerText = `Database: ${database_name}, Table: ${table_name}, Privilege: ${tables[table_name]}`;
							lack.appendChild(span);
					};
				};
			};

			//	...
			if( json[user]['modify'] ){
				modify.innerText = json[user]['modify'];
				modify.classList.add('modify');
			};
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
	function __fields(root, json){
		//	...
		for(var database in json ){
			for(var table in json[database] ){
				//	...
				var list = document.createElement('ul');

				//	...
				root.querySelector('[data-database="'+database+'"]')
					.querySelector('[data-table="'+table+'"]').appendChild(list);

				//	...
				for(var field in json[database][table] ){
					//	...
					var result = json[database][table][field]['result'];
					var item = document.createElement('li');
						item.innerText = field;
						item.classList.add('field');
						item.dataset.field = field;
					list.appendChild(item);

					//	...
					if( result ){
						item.classList.add('success');

						//	Remove list tag.
					//	list.removeChild(item);
					}else{
						item.classList.add('error');
						item.classList.add('bold');
						item.classList.add('missing');
					}
				}
			}
		}
	};

	//	...
	function __columns(root, json){
		for(var database in json ){
			for(var table in json[database] ){
				for(var field in json[database][table] ){
					//	...
					var list = document.createElement('ol');

					//	...
					for(var column in json[database][table][field] ){
						//	...
						if( json[database][table][field][column].result ){
							continue;
						}

						//	...
						var item = root	.querySelector('[data-database="'+database+'"]')
										.querySelector('[data-table="'+table+'"]')
										.querySelector('[data-field="'+field+'"]');
						item.appendChild(list);

						//	...
						__column(list, column, json[database][table][field][column]);
					}
				}
			}
		}
	};

	//	...
	function __column(list, column, json){

		//	...
		var item    = document.createElement('li');
			item.classList.add('error');
		var name    = document.createElement('name');
			name.innerText = column;

		//	...
		var current = document.createElement('span');
		var arrow   = document.createElement('span');
		var modify  = document.createElement('span');

		current.classList.add('current');
		arrow  .classList.add('arrow');
		modify .classList.add('modify');

		//	...
		item.appendChild(name);
		item.appendChild(current);
		item.appendChild(arrow);
		item.appendChild(modify);
		list.appendChild(item);

		//	...
		current.innerText = json.current;
		modify .innerText = json.modify;

		//	...
		if( json.current === null || json.current.length ){
			current.classList.add('empty');
		}
		if( json.modify  === null || json.modify.length ){
			modify .classList.add('empty');
		}
	};
}, 0);
