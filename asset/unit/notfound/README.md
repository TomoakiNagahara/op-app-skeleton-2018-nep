Unit of NotFound
===

 Save of 404 error URL.

# Usage

 Added 404.php.

```
<?php
if( Unit::Load('NotFound') ){
    OP\UNIT\NotFound::Auto();
};
```

 Added admin.php

```
<?php
if( Unit::Load('NotFound') ){
    OP\UNIT\NotFound::Admin();
};
```
