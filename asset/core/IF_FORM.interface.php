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
	/** Set configuration.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @return	 array		 $config
	 */
	public function Config(array $config);

	/** Start form. Output open FORM tag.
	 *
	 * @addition 2018-04-20
	 */
	public function Start();

	/** Finish form. Output close FORM tag.
	 *
	 * @addition 2018-04-20
	 */
	public function Finish();

	/** Display input label.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Label($name);

	/** Display input tag.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Input($name);

	/** Display each radio tag by value.
	 *
	 * @addition 2019-02-01
	 * @param	 string		 $name
	 */
	public function Radio($name, $value);

	/** Display each checkbox tag by value.
	 *
	 * @addition 2019-02-01
	 * @param	 string		 $name
	 */
	public function Checkbox($name, $value);

	/** Display submitted value.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Value($name);

	/** Display error message.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 * @param	 string		 $tag
	 */
	public function Error($name);

	/** Overwrite input attributes.
	 *
	 * @addition 2018-06-29
	 * @param	 array		 $input
	 */
	public function SetInput(array $input);

	/** Overwrite input options.
	 *
	 * @addition 2018-06-29
	 * @param	 array		 $option
	 */
	public function SetOption(array $option);

	/** Get submitted value.
	 *
	 * @addition 2018-06-29
	 * @param	 string			 $name
	 * @param	 string|array	 $value
	 */
	public function GetValue($name);
}
