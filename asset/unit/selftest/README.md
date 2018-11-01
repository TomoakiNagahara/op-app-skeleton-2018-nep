Unit of Selftest
===

## How to use.

Only this.

```
//  Generate instance.
$selftest = Unit::Instantiate('Selftest');

//  Automatically do self test.
$selftest->Auto('table-config.json');
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
$configer->Database([
  'user'     => 'testcase-user',
  'database' => 'testcase',
  'table'    => '*',
  'privilege'=> 'insert, select, update, delete',
  'column'   => '*',
]);



```
