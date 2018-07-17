Unit of ORM for onepiece-framework
===

## How to use

```
<?php
//  Instantiate.
$orm = Unit::Instance('ORM');

//  Generate database config.
config = [
  'product'  => 'mysql',
  'host'     => 'localhost',
  'port'     => '3306',
  'user'     => 'test',
  'password' => '',
  'charset'  => 'utf8',
  'database' => 'test',
];

//  Connect database.
$orm->Connect($config);

//  Get auto increment id.
$ai = $_GET['ai'] ?? null;

//  Generate Quick Query Language.
if( $ai === null ){
	//  Generate empty record.
	$qql = 't_table';
}else{
	//  Generate found record.
	$qql = "t_table.ai = $ai";
}

//  Generate "Record" object.
$record = $orm->Create($qql);

//  Record be found?
if( $record->isFound() === false ){
  printf('ai=%s record has not found.', $ai);
}

//  Generate "Form" object.
$form = $record->Form();

//  Display form of html.
$form->Start();
$form->Label('input_name');
$form->Input('input_name');
$form->Error('input_name');
printf('<button> Submit </button>');
$form->Finish();

//  Do validation.
$record->Validate();

//  Check validation result.
if( $record->isValid() ){
  //  Save to database.
  $orm->Save($record);
}
```
