<?php
/**
 * OP_UNIT.trait.php
 *
 * @creation  2019-02-13
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * OP_UNIT
 *
 * @creation  2019-02-13
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_UNIT
{
	/** For developers.
	 *
	 *
	 * @see \IF_UNIT::Help()
	 * @param	 string		 $topic
	 */
	function Help(string $topic=''):void
	{
		$unit = __CLASS__;
		D($unit);
		echo '<pre><code>';
		echo file_get_contents( $this->Path("unit:/{$unit}/README.md") );
		echo '</code></pre>';
	}

	/** For developers.
	 *
	 * @see \IF_UNIT::Debug()
	 * @param	 string		 $topic
	 */
	function Debug(string $topic=''):void
	{
		//	...
		if( $topic ){
			D( $this->_debug[$topic] );
		}else{
			D( $this->_debug );
		};
	}
}
