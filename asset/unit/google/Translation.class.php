<?php
/**
 * Translation.class.php
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Translation
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Translation
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Google cloud platform's api key.
	 *
	 * @var string
	 */
	const _API_KEY_ = 'google-cloud-translation';

	/** Where error messages are stored.
	 *
	 * @var array
	 */
	static private $_errors = [];

	/** Stored of error messages.
	 *
	 * @param string $error
	 */
	static function _Error($error)
	{
		self::$_errors[] = $error;
	}

	/** Google cloud platform's api key.
	 *
	 * @param  string|null $apikey
	 * @return string
	 */
	static function ApiKey($apikey=null)
	{
		if( $apikey ){
			Env::Set(self::_API_KEY_, $apikey);
		}
		return Env::Get( self::_API_KEY_ );
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
	 * //  Set onepiece-frameworks unit directory.
	 * Unit::SetDirectory('app:/app/unit');
	 *
	 * //  Load unit of google.
	 * Unit::Load('google');
	 *
	 * //  Setup google cloud platform's api key.
	 * Translation::ApiKey('your-api-key');
	 *
	 * //  Setup configuration.
	 * $config = [];
	 * $config['model']  = 'nmt'; // NMT=Neural Machine Translation, PBMT=Phrase-Based Machine Translation
	 * $config['target'] = 'en';  // Language name will translate.
	 * $config['array']  = true;  // true is return array, false is return assoc.
	 *
	 * //  Get supported language list.
	 * $result = Translation::Language($config);
	 * d($result);
	 * </pre>
	 *
	 * @param  array $config
	 * @return array
	 */
	static function Language($config=[])
	{
		//	...
		if(!$apikey = self::ApiKey() ){
			self::_Error("Has not been set google cloud platform's api key.");
			return false;
		}

		//	...
		$domain = 'translation.googleapis.com';
		$path   = '/language/translate/v2/languages';
		$url    = "https://{$domain}{$path}";

		//	...
		$model   = ifset($config['model'] , 'nmt');
		$target  = ifset($config['target'], 'en' );
		$isarray = ifset($config['array'] , true ); // Return result format.

		//	...
		$post = array();
		$post['key']	 = $apikey;
		$post['model']	 = $model;
		$post['target']	 = $target;

		//	...
		$text = Curl::Get($url, $post);
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
	 * //  Set onepiece-frameworks unit directory.
	 * Unit::SetDirectory('app:/app/unit');
	 *
	 * //  Load unit of google.
	 * Unit::Load('google');
	 *
	 * //  Setup google cloud platform's api key.
	 * Translation::ApiKey('your-api-key');
	 *
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
	static function Translate($config)
	{
		//	...
		if(!$apikey = self::ApiKey() ){
			self::_Error("Has not been set google cloud platform's api key.");
			return false;
		}

		//	...
		$domain = 'translation.googleapis.com';
		$path   = '/language/translate/v2';
		$url    = "https://{$domain}{$path}";

		//	...
		$model   = ifset($config['model'],  'nmt');
		$format  = ifset($config['format'], 'html');
		$source  = ifset($config['source']);
		$target  = ifset($config['target']);
		$string  = ifset($config['string']);
		$strings = ifset($config['strings']);

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
			$strings = Html::Decode($strings);
			foreach( $strings as $string ){
				$data .= '&q=' . Curl::Escape($string);
			}
		}

		//	...
		$text = Curl::Get($url.'?'.$data);
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
