UNIT DB
===

# How to use

```
<?php
//	Instantiate.
$DB = Unit::Factory('DB');

//	Database Configuration.
$config = [
  'driver'   => 'mysql',
  'port'     => '3306',
  'host'     => 'localhost',
  'user'     => 'usernaem',
  'password' => 'password',
  'database' => 'test',
  'charset'  => 'utf8'
];

//	Execute Database Connection.
$DB->Connect($config);

//	Execute SQL.
$record = $DB->Query('SELECT * FROM t_table WHERE id = 1 LIMIT 1');

//	Execute Quick SQL.
$record = $DB->Quick('id <- t_table.id = 1', ['limit'=>'1']);

//	For Debug.
D( $DB->GetQueries() );
```
