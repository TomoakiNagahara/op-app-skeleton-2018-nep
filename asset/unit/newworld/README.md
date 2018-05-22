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
