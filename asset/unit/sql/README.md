onepiece-frameworks SQL unit
===

This is just SQL generate. Not throw query.

```
/* @var $db \OP\UNIT\Database */
if(!$db = Unit::Instance('Database') ){
    throw new Exception('Instance of the Database unit was failed.');
}

/* @var $sql \OP\UNIT\SQL */
if(!$sql = Unit::Instance('SQL') ){
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

//  Select
$config = [
  'table' = 'table_name',
  'limit' = 1,
  'where' = [
    'id' = 1,
  ],
];

D( $sql->Select($config, $db) );

//  Insert
$config = [
  'table' = 'table_name',
  'set'  = [
    'nickname' = 'Hoge',
    'comment'  = 'Hello',
  ],
];

D( $sql->Insert($config, $db) );

//  Update
$config = [
  'table' = 'table_name',
  'limit' = 1,
  'where' = [
    'id' = 1,
  ],
  'set'  = [
    'nickname' = 'Who?',
    'comment'  = 'xxxx',
  ],
];

D( $sql->Update($config, $db) );

//  Delete
$config = [
  'table' = 'table_name',
  'limit' = 1,
  'where' = [
    'id' = 1,
  ],
];

D( $sql->Delete($config, $db) );
```
