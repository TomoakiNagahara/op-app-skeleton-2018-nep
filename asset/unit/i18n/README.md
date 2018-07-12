Unit of i18n for onepiece-framework
===

## How to use

```
//  Instantiate of i18n object.
if(!$i18n = Unit::Instantiate('i18n') ){
    return;
}

//  Settings
$i18n->To('ja-jp');
$i18n->From('en-us');
$i18n->Service('google');

//  Translation
echo $i18n->Translate('This is test.');
```
