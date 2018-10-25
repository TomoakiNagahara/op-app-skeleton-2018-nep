The onepiece-framework's API-Unit
===

## How to use

```
<?php
//  Load of API-Unit
if(!Unit::Load('api') ){
    return;
}

//  Set them bulk.
Api::Result(['key1'=>true]);

//  Set individually.
Api::Set('key2', true);

//  Output JSON string to stdout. (Default is JSON)
Api::Finish();
```

## Other options.

 You can pass option values in a URL query.

| key    | content |
|:------:|:--------|
| sleep  | Change the number of seconds to wait.<br/> If localhost, will automatically wait one second. |
| html   | MIME becomes HTML. |
