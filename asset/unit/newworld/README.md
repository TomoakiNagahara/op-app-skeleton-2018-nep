The NewWorld is a new world!!
===

## Classes

 * Router<br/>
	Calculate of end-point from URL. In a general framework, an end-point is called an controller.
 * Dispatcher<br/>
	Run the end-point.
 * Template<br/>
	Run the Template file.
 * Layout<br/>
	Run the Layout. Layout is the outer frame of the entire site.

## How to use

``` index.php
<?php
//	Use namespace.
use OP\UNIT\NEWWORLD;

//	Get content of end-point. (end-point is executed)
$content = Dispatch::Get();

//	The content is wrapped in the Layout.
echo Layout::Get($content);
```

## Detail of each classes

### Router

 Router class is calculate end-point from URL.
 End-point file name is "index.php".
 Search end-point by request uri.
 Generate smart-url's arguments by request URL.

#### Structure of route table

```
{
  "args" : [],
  "end-point" : "/index.html"
}
```

#### Methods

##### Set

 Set route table method.

##### Get

 Get route table method.

| index     | value |
|-----------|-------|
| args      | Arguments of Smart-URL. |
| end-point | Full path of end-point. |

### Dispatcher

### Template

### Layout
