Unit of NotFound
===

 Save of 404 error URL.

# Setup

 Set configuration to Env.

```config.php
<?php
$this->Env()->Set('notfound', [
    'dsn' => 'mysql://notfound:password@localhost:3306?database=onepiece&charset=utf8',
]);
```

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
