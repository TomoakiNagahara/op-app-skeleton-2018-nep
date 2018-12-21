app-skeleton-2018-nep
===

 The onepiece-framework is insanely great!!
 Windows environment is not considered.
 Please develop at UNIX clone or Windows subsystem.

## Feature

### Intuitive file path

 The URL matches the actual file path.
 This is easy to nest of directories.
 We this mechanism so call "NEW WORLD"!!
 That's so not "OLD WORLD"...

### Admin settings

 1. Localhost.
 1. IP-Address.
 1. EMail sending.

### Good error handling

 1. Forcibly catch all errors.
 1. Errors are output for easy to readable.
 1. If end user are not admin, not display error message and send e-mail.
 1. These functions are realized by Notice::Set().

### Notice::Set()

```
Notice::Set('Error message.');
```

### Very secure

 1. XSS will not occur.
 1. SQL injection will not occur.

### Cookie

 1. All keys and values are encrypted.
 1. Separated for each application.

### Session

 1. Separated for each application.

### Form

 1. Usage is flexible and intuitive.
 1. XSS will not occur even if the transmitted value is directly substitution.
 1. ORM is attached. Also, this is separate from ORM.

### Database

 1. Usage is flexible and intuitive.
 1. SQL injection will not occur even if the transmitted value is directly substitution.
 1. ORM is attached. Also, this is separate from ORM.

### ORM

 1. Usage is flexible and intuitive.
 1. XSS and SQL injection will not occur even if the transmitted value is directly substitution.

### HTML pass through

 HTML pass through is directly output html file.
 No setting is necessary.
 Just save the extension as html.
 Please notice, layout is added.
 This can not be done other frameworks.
 Other frameworks not applied layout, in case of directly output.
 If do directly output html have layout at other frameworks, need a create empty controller.

## Technical information

### Rules

 1. Please see ".gitignore" file.
    Added ".*" and "_*".
    A file whose file name starts with dot or underscore is not committed.
    If you want to commit that files, Add the "-f" option.
    ```
    git add -f _secret.txt
    ```

### asset

 This directory contains the program used by the onepiece-framework itself.

### asset/core

 The onepiece-framework's core program is inside this directory.
 You are not touch necessary this files.

### asset/bootstrap

 The onepiece-framework's boot program is inside this directory.
 You are not touch necessary this files.

### asset/config.php

 Write application-specific settings.

### asset/_config.php

 Write application-specific local settings.

```
<?php
//	Admin settings.
Env::Set(Env::_ADMIN_IP_,   '192.168.0.1');
Env::Set(Env::_ADMIN_MAIL_, 'info@example.com');
```

### asset/layout

 Layout is the design of the entire site.
 For example, header, footer, menu and navigation.
 Each page is output to inside the layout.

 * index.php
 * js
 * css
 * img

### asset/template

 Template file is used by unspecified page.

### asset/unit

 The onepiece-framework is unitizes each function.
 This directory stored that units.

### asset/test

 This directory stored test files.

### asset/reference

 This directory reference to reference files by each units.

### asset/cache

 This directory stored cache files.

## What is that word?

 We will write here that hint of word.

### End-Point

 In most frameworks, That the method of the class.

## About English

 I am not native English speaker.
 That most people are.
 We are not want fluent English.
 We are want easy to readable English.
 This does not have to be strict.
