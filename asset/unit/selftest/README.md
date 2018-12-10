Unit of Selftest
===

## How to use.

Only this.

```
//  Generate instance.
$selftest = Unit::Instantiate('Selftest');

//  Automatically do self test by configuration file.
$selftest->Auto('database-config.json');
```

## How to generate configuration file.

```
//  Instantiate self-test configuration generator.
$configer = \OP\UNIT\Selftest::Configer();

//  DSN configuration.
$configer->DSN([
  'host'     => 'localhost',
  'product'  => 'mysql',
  'port'     => '3306',
]);

//  User configuration.
$configer->User([
  'name'     => 'testcase-user',
  'password' => 'my-password',
  'charset'  => 'utf8',
]);

//  Database configuration.
$configer->Database([
  'name'     => 'testcase',
  'charset'  => 'utf8',
  'collate'  => 'utf8mb4_general_ci',
]);

//  Privilege configuration.
$configer->Privilege([
  'user'     => 'testcase-user',
  'database' => 'testcase',
  'table'    => '*',
  'privilege'=> 'insert, select, update, delete',
  'column'   => '*',
]);

//  Add table configuration.
$configer->Set('table', [
  'name'    => 't_table',
  /* Can be omitted. To be inherited from database.
  'charset' => 'utf8',
  'collate' => 'utf8mb4_general_ci',
  */
  'comment' => 'This is test table.',
]);

//  Add auto incrment id column configuration.
$configer->Set('column', [
  'name'    =>  'id',
  'type'    => 'int',
  'length'  =>    11,
  'null'    => false,
  'default' =>  null,
  'comment' => 'Auto increment id.',
]);

//  Add auto incrment id configuration.
$configer->Set('index', [
  'name'    => 'ai',
  'type'    => 'ai',
  'column'  => 'ai',
  'comment' => 'auto incrment',
]);

//  Add type of set column configuration.
$configer->Set('column', [
  'name'    => 'flags',
  'type'    => 'set',
  'length'  => 'a, b, c',
  'null'    =>  true,
  'default' =>  null,
  'collate' => 'ascii_general_ci', // Change collate.
  'comment' => 'Ideal for form of checkbox values. (Multiple choice)',
]);

//  Add type of enum column configuration.
$configer->Set('column', [
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
$configer->Set('index', [
  'name'    => 'search index',
  'type'    => 'index',
  'column'  => 'flags, choice',
  'comment' => 'Indexed by two columns.',
]);

//  Get selftest configuration.
$config = $configer->Get();
```
