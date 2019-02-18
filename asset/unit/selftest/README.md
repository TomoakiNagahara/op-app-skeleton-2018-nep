Unit of Selftest
===

## How to use.

Only this.

```
//  Generate instance.
$selftest = Unit::Instantiate('Selftest');

//  Automatically do self test by configuration file.
$selftest->Auto('config.selftest.php');
```

## How to generate configuration file.

```
<?php
//  Instantiate self-test configuration generator.
/* @var $configer \OP\UNIT\SELFTEST\Configer */
$configer = Unit::Instantiate('Selftest')->Configer();

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

//  Privilege configuration.
$configer->Privilege([
  'user'     => 'testcase-user',
  'database' => 'testcase',
  'table'    => '*',
  'privilege'=> 'insert, select, update, delete',
  'column'   => '*',
]);

//  Database configuration.
$configer->Database([
  'name'     => 'testcase',
  'charset'  => 'utf8',
  'collate'  => 'utf8mb4_general_ci',
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
  'name'    =>  'ai',
  /* Automatically
  'type'    => 'int',
  'length'  =>    10,
  'null'    => false,
  'default' =>  null,
  'unsigned'=>  true,
  */
  'comment' => 'Auto increment id.',
  'ai'      =>  true,
]);

//  Add type of set column configuration.
$configer->Set('column', [
  'name'    =>   'id',
  'type'    => 'char',
  'length'  =>     10,
  'null'    =>   true,
  'default' =>   null,
  'collate' => 'ascii_general_ci', // Change collate.
  'comment' => 'Unique ID.',
  'unique'  =>   true,
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

//  Add type of timestamp configuration.
$configer->Set('column', [
  'name'    => 'timestamp',
  'type'    => 'timestamp',
  'comment' => 'On update current timestamp.',
]);

//  Add auto incrment id configuration.
$configer->Set('index', [
  'name'    => 'ai',
  'type'    => 'ai',
  'column'  => 'ai',
  'comment' => 'auto incrment',
]);

//  Add search index configuration.
$configer->Set('index', [
  'name'    => 'search index',
  'type'    => 'index',
  'column'  => 'flags, choice',
  'comment' => 'Indexed by two columns.',
]);

//  Return selftest configuration.
return $configer->Get();
```
