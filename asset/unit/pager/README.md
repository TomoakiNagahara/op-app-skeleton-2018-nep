Unit of pager for onepiece-framework
===

## How to use

```
/* @var $pager \OP\UNIT\Pager */
$db = Unit::Instance('Database');
$db->Connect( Env::Get('database') );

//  Generate pager unit.
$pager  = Unit::Instance('Pager');
$select = $pager->Config([
  'database'=> $database,
  'table'   => $table,
  /*
  'where'   => ['deleted'=>null],
  'order'   => 'timestamp desc, id asc',
  'limit'   => 10,
  'offset'  =>  0,
  'wings'   =>  2,
  'url-query-key-name'  => 'page',
  'current-page-number' => 1,
  */
], $db);

//  Display pager.
$pager->Display();

//  Select pagenation target record.
$record = $db->Select($select);
```
