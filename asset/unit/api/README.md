The onepiece-framework's API-Unit
===

## How to use

```
<?php
//  Load of API-Unit.
if(!Unit::Load('api') ){
    return;
}

//  Set them bulk.
Api::Result(['key1'=>true]);

//  Set individually result.
Api::Set('key2', true);

//  The result is output to stdout by JSON. (Default is JSON)
Api::Finish();
```

## How to use

 Do outputs server side variables to the client side console.

```php
Api::Dump($label, $value);
```

```javascript
for(var dump of json['dump']){
    console.log(dump[0]);
    console.dir(dump[1]);
};
```

## Other options.

 You can pass option values in a URL query.
 Example: `http://localhost/api/?html=1&sleep=0`

| key    | example | content |
|:------:|:--------|:--------|
| sleep  | sleep=0 | *Deliberately delay* - This is localhost only. Will automatically wait one second.<br/> Change the number of seconds to wait second. |
| html   | html=1  | *For developer* - Output JSON in HTML format. |
