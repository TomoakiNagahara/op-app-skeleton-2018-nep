<?php
/**
 * unit-markdown:/Markdown.class.php
 *
 * @creation  2019-02-13
 * @version   1.0
 * @package   unit-markdown
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-13
 */
namespace OP\UNIT;

/** Markdown
 *
 * @creation  2019-02-13
 * @version   1.0
 * @package   unit-markdown
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Markdown implements \IF_UNIT
{
	/** trait.
	 *
	 */
	use \OP_CORE, \OP_UNIT;

	/** To stacked opened tag.
	 *
	 * @var array
	 */
	private $_tags;

	/** That will be executed automatically.
	 *
	 */
	function Auto($path)
	{
		//	...
		$path = $this->Path($path);

		//	...
		if(!file_exists($path) ){
			\Notice::Set("Has not been exists this file. ($path)");
			return;
		};

		//	...
		$this->_tags[] = 'section';

		//	...
		$file = fopen($path, 'r');

		//	...
		while( $line = fgets($file) ){
			$this->_Line($line);
		};

		//	...
		fclose($file);
	}

	private function _Line($line)
	{
		$this->_Tag($line);
	}

	/** Calc tag.
	 *
	 */
	private function _Tag($line)
	{
		//	To stacked opened tag.
		static $_tag;

		//	If empty line.
		if( strlen(trim($line)) === 0 ){
			//	If empty open tag.
			if( empty($_tag) ){
				$new = $tag = 'P';
			}else{
				$tag = array_shift($_tag);
			};
		};

		//	...
		if( $new ){
			$_tag[] = $new;
		};

		//	...
		return $tag;
	}
}
