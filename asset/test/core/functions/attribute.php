<?php
/**
 * unit-test:/core/functions/attribute.php
 *
 * @creation  2018-06-05
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$attr = 'div';
D( $attr, Attribute($attr) );

//	...
$attr = 'div#id';
D( $attr, Attribute($attr) );

//	...
$attr = 'div #id';
D( $attr, Attribute($attr) );

//	...
$attr = 'div.class';
D( $attr, Attribute($attr) );

//	...
$attr = 'div.class_1.class-2';
D( $attr, Attribute($attr) );

//	...
$attr = 'div .class';
D( $attr, Attribute($attr) );

//	...
$attr = 'div .class_1.class-2';
D( $attr, Attribute($attr) );

//	...
$attr = 'div.class_1 .class-2';
D( $attr, Attribute($attr) );

//	...
$attr = 'div .class_1 .class-2';
D( $attr, Attribute($attr) );

//	...
$attr = 'div #id .class_1 .class-2';
D( $attr, Attribute($attr) );
