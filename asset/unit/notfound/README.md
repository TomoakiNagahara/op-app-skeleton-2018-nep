Unit of NotFound
===

 Save of 404 error URL.

# Usage

 Add to 404.php.

```
<?php
if( Unit::Load('NotFound') ){
    OP\UNIT\NotFound::Auto();
};
```

 Add to admin.php

```
<?php
if( Unit::Load('NotFound') ){
    OP\UNIT\NotFound::Admin();
};
```
