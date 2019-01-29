<?php
/**
 * unit-html:/Html.class.php
 *
 * @creation  2018-01-24
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-01-24
 */
namespace OP\UNIT;

/** i18n
 *
 * @creation  2018-01-24
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Html
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Generate HTML.
	 *
	 * <pre>
	 * Html('message', 'span #id .class');
	 * </pre>
	 *
	 * @param	 string		 $string
	 * @param	 string		 $config
	 * @param	 boolean	 $escape tag and quote
	 */
	static function Generate(string $string, string $attr=null, bool $escape=true)
	{
		//	Escape tag and quote.
		if( $escape ){
			$string = Escape($string);
		}

		//	...
		if( $attr ){
			$attr = self::Attribute($attr);
		}

		//	...
		$tag = $id = $class = null;
		foreach( ['tag','id','class'] as $key ){
			${$key} = $attr[$key] ?? null;
		}

		//	...
		if( empty($tag) ){
			$tag = 'div';
		}

		//	...
		$attr = $id    ? " id='$id'"      :'';
		$attr.= $class ? " class='$class'":'';

		//	...
		if( $tag === 'a' ){
			$attr = ' href="' . $string . '"';
		}

		//	...
		return sprintf('<%s%s>%s</%s>'.PHP_EOL, $tag, $attr, $string, $tag);
	}

	/** Parse html tag attribute from string to array.
	 *
	 * @param  string $attr
	 * @return array  $result
	 */
	static function Attribute(string $attr)
	{
		//	...
		$key    = 'tag';
		$result = null;

		//	...
		for($i=0, $len=strlen($attr); $i<$len; $i++){
			//	...
			switch( $attr[$i] ){
				case '.':
					$key = 'class';
					if(!empty($result[$key]) ){
						$result[$key] .= ' ';
					}
					continue 2;

				case '#':
					$key = 'id';
					continue 2;

				case ' ':
					continue 2;

				default:
			}

			//	...
			if( empty($result[$key]) ){
				$result[$key] = '';
			}

			//	...
			$result[$key] .= $attr[$i];
		}

		//	...
		return $result;
	}

	/** Return secure json string at wrapped div tag.
	 *
	 * @param	 array		 $json
	 * @param	 string		 $attr
	 */
	static function Json($json, $attr=null)
	{
		//	Decode
		$json = Decode($json);

		//	Convert to json.
		$json = json_encode($json);

		//	Encode XSS. (Not escape quote)
		$json = htmlentities($json, ENT_NOQUOTES, 'utf-8');

		//	...
		return self::Generate($json, 'div.'.$attr, false);
	}
}
