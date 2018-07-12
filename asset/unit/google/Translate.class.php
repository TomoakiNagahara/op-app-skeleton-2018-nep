<?php
/**
 * Translate.class.php
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-10
 */
namespace OP\UNIT\GOOGLE;

/** Translate
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Translate
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Where error messages are stored.
	 *
	 * @var array
	 */
	static private $_errors = [];

	/** Stored of error messages.
	 *
	 * @param string $error
	 */
	static private function _Error($error)
	{
		self::$_errors[] = $error;
	}

	/** Google cloud platform's api key.
	 *
	 * @return string
	 */
	static private function _ApiKey()
	{
		$key = 'google-cloud-translation-api-key';
		if(!$val = \Env::Get($key) ){
			throw new \Exception('Has not been set '.$key.'. Please set to Env::Set("'.$key.'", $id)');
		}
		return $val;
	}

	/** Return error message.
	 *
	 * @return array
	 */
	static function Errors()
	{
		return self::$_errors;
	}

	/** Get supported language code list.
	 *
	 * <pre>
	 * //  Setup configuration.
	 * $config = [];
	 * $config['model']  = 'nmt'; // NMT=Neural Machine Translation, PBMT=Phrase-Based Machine Translation
	 * $config['target'] = 'en';  // Language name will translate.
	 * $config['array']  = true;  // true is return array, false is return assoc.
	 *
	 * //  Get supported language list.
	 * $result = Translation::Language($config);
	 * D($result);
	 * </pre>
	 *
	 * @param  array $config
	 * @return array
	 */
	static function Language($config=[])
	{
		//	...
		if(!$apikey = self::_ApiKey() ){
			return false;
		}

		//	...
		$domain = 'translation.googleapis.com';
		$path   = '/language/translate/v2/languages';
		$url    = "https://{$domain}{$path}";

		//	...
		$model   = $config['model']  ?? 'nmt';
		$target  = $config['target'] ?? 'en' ;
		$isarray = $config['array']  ?? true ; // Return result format.

		//	...
		$post = array();
		$post['key']	 = $apikey;
		$post['model']	 = $model;
		$post['target']	 = $target;

		//	...
		$text = \OP\UNIT\Curl::Get($url, $post);
		$json = json_decode($text, true);

		//	...
		$result = [];

		//	...
		if( isset($json['data']['languages']) ){
			foreach( $json['data']['languages'] as $language ){
				//	...
				$code = $language['language'];
				$name = $language['name'];

				//	...
				if( $isarray ){
					//	Return result value is array.
					$result[] = ['code'=>$code, 'name'=>$name];
				}else{
					//	Return result value is assoc. (object)
					$result[$code] = $name;
				}
			}
		}

		//	...
		if( isset($json['error']['errors']) ){
			foreach( $json['error']['errors'] as $error ){
				self::$_errors[] = $error['message'];
			}

		}

		//	...
		return $result;
	}

	/** Translate
	 *
	 * <pre>
	 * //  Setup configuration.
	 * $config = [];
	 * $config['model']    = 'nmt';  // NMT=Neural Machine Translation, PBMT=Phrase-Based Machine Translation
	 * $config['format']   = 'html'; // Source string format.
	 * $config['source']   = 'en';   // Source language name. (from original)
	 * $config['target']   = 'ja';   // Target language name. (to translate)
	 * $config['string']   = 'This is test.'; // Single string.
	 * $config['strings']  = null;   // Multi string.
	 *
	 * //  Get supported language list.
	 * $result = Translation::Translate($config);
	 * d($result);
	 * </pre>
	 *
	 * @param  array $config
	 * @return array
	 */
	static function Translation($config)
	{
		//	...
		if(!$apikey = self::_ApiKey() ){
			self::_Error("Has not been set google cloud platform's api key.");
			return false;
		}

		//	...
		$domain = 'translation.googleapis.com';
		$path   = '/language/translate/v2';
		$url    = "https://{$domain}{$path}";

		//	...
		$model   = $config['model']   ?? 'nmt';
		$format  = $config['format']  ?? 'html';
		$source  = $config['source']  ??  null;
		$target  = $config['target']  ??  null;
		$string  = $config['string']  ??  null;
		$strings = $config['strings'] ??  null;

		//	...
		if(!$source){
			self::_Error("Has not been set source language code.");
		}

		//	...
		if(!$target){
			self::_Error("Has not been set target language code.");
		}

		//	...
		if( $target === $source ){
			self::_Error("Source language code and target language code are the same.");
		}

		//	...
		if( empty($string) and empty($strings) ){
			self::_Error("Has not been set translate string.");
		}

		//	...
		if( self::$_errors ){
			return false;
		}

		//	...
		$post = array();
		$post['key']	 = $apikey;
		$post['model']	 = $model;
		$post['format']	 = $format;
		$post['source']	 = $source;
		$post['target']	 = $target;

		//	...
		$data = http_build_query($post, null, '&');

		//	...
		if( $string ){
			$strings[] = $string;
		}

		//	...
		if( $strings ){
			foreach( $strings as $string ){
				$string = html_entity_decode($string, ENT_QUOTES, 'utf-8');
				$data .= '&q=' . \OP\UNIT\Curl::Escape($string);
			}
		}

		//	...
		$text = \OP\UNIT\Curl::Get($url.'?'.$data);
		$json = json_decode($text, true);

		//	...
		$result = [];

		//	...
		if( isset($json['data']['translations']) ){
			foreach( $json['data']['translations'] as $translation ){
				$result[] = $translation['translatedText'];
			}
		}

		//	...
		if( isset($json['error']['errors']) ){
			foreach( $json['error']['errors'] as $error ){
				self::$_errors[] = $error['message'];
			}
		}

		//	...
		return $result;
	}
}
