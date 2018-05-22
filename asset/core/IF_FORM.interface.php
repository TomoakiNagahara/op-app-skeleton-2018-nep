<?php
/**
 * IF_FORM.interface.php
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_FORM
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_FORM
{
	/** Get saved values.
	 *
	 */
	public function Get();

	/** Set save values.
	 *
	 * @param	 array		 $args
	 */
	public function Set(array $args);

	/** Set configuration
	 *
	 * @param	 array		 $config
	 */
	public function Config(array $config);

	/** Display form tag.
	 *
	 */
	public function Start();

	/** Display close form tag.
	 *
	 */
	public function Finish();

	/** Display input label.
	 *
	 * @param	 string		 $name
	 */
	public function Label($name);

	/** Display input tag.
	 *
	 * @param	 string		 $name
	 */
	public function Input($name);

	/** Display posted value.
	 *
	 * @param	 string		 $name
	 */
	public function Value($name);

	/** Display error message.
	 *
	 * <pre>
	 * <?php $form->Error('nickname','p.nickname') ?>
	 * </pre>
	 *
	 * @param	 string		 $name
	 * @param	 string		 $tag
	 */
	public function Error($name, $tag=null);
}
