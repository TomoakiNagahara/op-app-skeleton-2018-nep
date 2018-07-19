Unit of pager for onepiece-framework
===

## How to use

```
//	Generate database unit.
$db = Unit::Instance('Database');
$db->Connect( Env::Get('database') );

//	Generate pager unit.
$pager  = Unit::Instance('Pager');
$select = $pager->Config(['database'=>$database, 'table'=>$table], $db);

//	Display pager.
$pager->Display();

//	Select pagenation target record.
$record = $db->Select($select)
```
