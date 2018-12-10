Unit of i18n for onepiece-framework
===

## How to use

### Add settings to config.php.

```
//	OP\UNIT\i18n
Env::Set('i18n',
  [
    'service'    => 'google',
    'api-key'    => 'xxxxxx',
    'locale-to'  => 'ja-jp',
    'locale-from'=> 'en-us',
    'database'   => [
      'prod'     => 'mysql',
      'host'     => 'localhost',
      'port'     => '3306',
      'user'     => 'i18n',
      'password' => 'password',
      'charset'  => 'utf8',
      'database' => 'onepiece',
    ]
  ]
);
```

### Do translation.

```
//  Instantiate of i18n object.
if(!$i18n = Unit::Instantiate('i18n') ){
    return;
}

//  Do translation.
echo $i18n->Translate('This is test.');
```

## Technical information









