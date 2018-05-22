Unit of Dump for onepiece-framework
===

 Dump the variable. And display to just admin only.
 Worth using this, just to use onepiece-framework.

# How to use

```
<?php

//	Set admin IP-Address. (Localhost is always admin.)
Env::Set( Env::_ADMIN_IP_, '192.168.0.2' );

//	Do Dump.
D($_REQUEST);

?>
```
