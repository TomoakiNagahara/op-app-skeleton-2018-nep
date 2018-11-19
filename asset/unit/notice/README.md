Unit of Notice
===

## What is this unit?

 This unit is notifies to administrator of the Notice registered by OP\CORE\Notice::Set().

## How to use

 You do not need to learn how to use.
 The Notice are displayed automatically, If you is an administrator.
 If you are not an administrator, In that case a e-mail will be sent.
 Set the administrator's IP address and e-mail address as follows.

```
<?php
//  Set the administrator's IP address.
Env::Set(Env::_ADMIN_IP_,   '192.168.0.1');

//  Set the administrator's e-mail address.
Env::Set(Env::_ADMIN_MAIL_, 'admin@example.com');
?>
```

## Technical information

### Notice.class.php

### notice.js

### notice.css

### mail
