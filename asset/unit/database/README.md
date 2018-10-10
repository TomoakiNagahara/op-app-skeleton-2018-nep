The onepiece-framework Database Unit.
===

```
<?php
//  Load of database unit.
if(!Unit::Load('database') ){
    throw new Exception('Load of the Database unit was failed.');
}

/* @var $db \OP\UNIT\Database */
if(!$db = Unit::Instance('Database') ){
    throw new Exception('Instance of the Database unit was failed.');
}

//  Configuration.
$config = [
    'prod'     => 'mysql',
    'host'     => 'localhost',
    'port'     => '3306',
    'user'     => 'testcase',
    'password' => 'password',
    'database' => 'testcase',
];

//  Connect to database by configuration.
if(!$io = $db->Connect($config) ){
    throw new Exception('Connect to database was failed.');
}

//  Get records by SQL.
$records = $db->Query('SELECT * FROM table_name');
```
