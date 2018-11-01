Unit of Selftest
===

## How to use.

Only this.

```
//  Generate instance.
$selftest = Unit::Instantiate('Selftest');

//  Automatically do self test.
$selftest->Auto('database-config.json');
```

## How to generate configuration file.

```
//  Instantiate self-test configuration generator.
$configer = Unit::Instantiate('SelftestConfiger');

//  DSN configuration.
$configer->DSN([
  'host'     => 'localhost',
  'product'  => 'mysql',
  'port'     => '3306',
]);

//  User configuration.
$configer->User([
  'user'     => 'testcase-user',
  'password' => 'my-password',
  'charset'  => 'utf8',
]);

//  Database configuration.
$configer->Database([
  'name'     => 'testcase',
  'charset'  => 'utf8',
]);

//  Privilege configuration.
$configer->Privilege([
  'user'     => 'testcase-user',
  'database' => 'testcase',
  'table'    => '*',
  'privilege'=> 'insert, select, update, delete',
  'column'   => '*',
]);

//  Add auto incrment id column configuration.
$Configer->Column([
  'name'    =>  'id',
  'type'    => 'int',
  'length'  =>    11,
  'null'    => false,
  'default' =>  null,
  'comment' => 'Auto increment id.',
]);

//  Add auto incrment id configuration.
$Configer->Index([
  'name'    => 'ai',
  'type'    => 'ai',
  'column'  => 'ai',
  'comment' => 'auto incrment',
]);

//  Add type of set column configuration.
$Configer->Column([
  'name'    => 'flags',
  'type'    => 'set',
  'length'  => 'a, b, c',
  'null'    =>  true,
  'default' =>  null,
  'comment' => 'Ideal for form of checkbox values. (Multiple choice)',
]);

//  Add type of enum column configuration.
$Configer->Column([
  'name'    => 'choice',
  'type'    => 'enum',
  'length'  => 'a, b, c',
  /*
  'null'    =>  true, // Can be omitted.
  'default' =>  null, // Can be omitted.
  */
  'comment' => 'Ideal for form of select or radio mono value. (Single choice)',
]);

//  Add search index configuration.
$Configer->Index([
  'name'    => 'search index',
  'type'    => 'index',
  'column'  => 'flags, choice',
  'comment' => 'Indexed by two columns.',
]);

```
