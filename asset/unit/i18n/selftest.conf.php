<?php
/**
 * unit-i18n:/selftest.conf.php
 *
 * @creation  2018-12-04
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//  Get i18n config.
$config = \Env::Get('i18n');
$host     = $config['database']['host'];
$port     = $config['database']['port'];
$prod     = $config['database']['prod'];
$user     = $config['database']['user'];
$password = $config['database']['password'];
$database = $config['database']['database'];
$charset  = $config['database']['charset'] ?? 'utf8';
$collate  = $config['database']['collate'] ?? null;
$table    = \OP\UNIT\i18n::_table_;

//  Instantiate self-test configuration generator.
$configer = \OP\UNIT\Selftest::Configer();

//  DSN configuration.
$configer->DSN([
	'host'     => $host,
	'product'  => $prod,
	'port'     => $port,
]);

//  User configuration.
$configer->User([
	'name'     => $user,
	'password' => $password,
	'charset'  => $charset,
]);

//  Database configuration.
$configer->Database([
	'name'     => $database,
	'charset'  => $charset,
	'collate'  => $collate,
]);

//  Privilege configuration.
$configer->Privilege([
	'user'     => $user,
	'database' => $database,
	'table'    => '*',
	'privilege'=> 'insert, select, update, delete',
	'column'   => '*',
]);

//  Add table configuration.
$configer->Set('table', [
	'name'    => $table,
	/*
	'charset' => 'utf8',
	'collate' => 'utf8mb4_general_ci',
	*/
	'comment' => 'Use to i18n.',
]);

//  Add auto incrment id column configuration.
$configer->Column( 'hash'        , 'char',    0, false, null , 'Hashed unique id.', ['length'=>\OP\UNIT\i18n::_hash_length_]);
$configer->Column( 'from_lang'   , 'char',    2, false, null , 'From language code.');
$configer->Column( 'from_country', 'char',    2, false, null , 'From country code.');
$configer->Column( 'to_lang'     , 'char',    2, false, null , 'To language code.');
$configer->Column( 'to_country'  , 'char',    2, false, null , 'to country code.');
$configer->Column( 'original'    , 'text', null, false, null , 'Original string.');
$configer->Column( 'translated'  , 'text', null, false, null , 'Translated string.');

//  Add auto incrment id configuration.
$configer->Set('index', [
	'name'    => 'hash',
	'type'    => 'pkey',
	'column'  => 'hash',
	'comment' => 'Primary key',
]);

//  Return selftest configuration.
return $configer->Get();
