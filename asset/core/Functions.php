<?php
/**
 * Functions.php
 *
 * @creation  2016-11-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Return meta root path array.
 *
 * @param  string $meta
 * @param  string $path
 * @return array
 */
function _GetRootsPath($meta=null, $path=null)
{
	//	...
	static $root;

	//	...
	if(!$root or ($meta and $path) ){
		//	...
		global $_OP;

		//	...
		if( $meta and $path ){
			//	...
			$temp = strtoupper($meta) . '_ROOT';

			//	...
			$_OP[$temp] = $path;
		}

		//	...
		$root = [];

		//	...
		foreach( $_OP as $key => $val ){
			list($key1, $key2) = explode('_', $key);
			if( $key2 === 'ROOT' ){
				$root[ strtolower($key1) . ':/' ] = rtrim($val, '/').'/';
			}
		}
	}

	//	...
	return $root;
}

/** Compress to meta path from local file path.
 *
 * <pre>
 * print CompressPath(__FILE__); // -> App:/index.php
 * </pre>
 *
 * @param  string $file_path
 * @return string
 */
function CompressPath($path)
{
	foreach( _GetRootsPath() as $key => $var ){
		if( strpos($path, $var) === 0 ){
			$path = substr($path, strlen($var));
			return $key . ltrim($path,'/');
		}
	}
	return $path;
}

/** Convert to local file path from meta path.
 *
 * <pre>
 * print ConvertPath('app:/index.php'); // -> /www/localhost/index.php
 * </pre>
 *
 * @param  string $meta_path
 * @return string
 */
function ConvertPath($path)
{
	foreach( _GetRootsPath() as $key => $var ){
		if( strpos($path, $key) === 0 ){
			$path = substr($path, strlen($key));
			return $var.$path;
		}
	}
	return $path;
}

/** Convert to Document root URL from meta path.
 *
 * This function is for abstract whatever path the application on placed.
 *
 * Example:
 * Document root    --> /var/www/html
 * Application root --> /var/www/html/onepiece-app/
 *
 * ConvertURL('doc:/index.html'); --> /index.html
 * ConvertURL('app:/index.php');  --> /onepiece-app/index.php
 *
 * @param  string $meta_url
 * @return string $document_root_url
 */
function ConvertURL($url)
{
	//	...
	global $_OP;

	//	...
	$result = $url;

	//	Full path.
	$rewrite_base = rtrim($_OP[DOC_ROOT], '/');

	//	...
	if( strpos($url, 'app:/') === 0 ){

		/** Convert to application root path from meta path.
		 *
		 * app:/foo/bar --> /op/7/app-skeleton-2018/foo/bar/
		 *
		 * @var string $result
		 */
		$result = substr($_OP[APP_ROOT], strlen($rewrite_base)).substr($url, 5);

	}else if( strpos($url, $_OP[DOC_ROOT]) === 0 ){

		/** Convert to document root url path from full path.
		 *
		 * /var/www/html/index.html --> /index.html
		 *
		 * @var string $result
		 */
		$result = substr($url, strlen($rewrite_base));

	}else{
		//	What is this?
		$key = ':/';

		//	???
		$len = strpos($url, $key) + strlen($key);

		//	Why?
		foreach( _GetRootsPath() as $key => $dir ){
			//	match
			if( strpos($url, $key) === 0 ){
				//	Convert
				$result = ConvertURL( CompressPath($dir . substr($url, $len)) );
			}
		}
	}

	/** Add slash to URL tail.
	 *
	 * Apache will automatic transfer, in case of directory.
	 */

	//	Separate url query.
	if( $pos = strpos($result, '?') ){
		$url = substr($result, 0, $pos);
		$que = substr($result, $pos);
	}else{
		$url = $result;
		$que = '';
	}

	// Right slash position.
	$pos = strrpos($url, '/') +1;

	//	If URL is closed by slash.
	if( strlen($url) === ($pos) ){
		//	OK
	}else{
		//	Get file name.
		$file = substr($url, $pos);

		//	File name has extension.
		if( strpos($file, '.') ){
			//	/foo/bar/index.html
		}else{
			//	/foo/bar --> /foo/bar/
			$url .= '/';
		}
	}

	//	...
	return $url . $que;
}

/** Dump value for developers only.
 *
 * @param boolean|integer|string|array|object $value
 */
function D()
{
	//	If not admin will skip.
	if(!Env::isAdmin()){
		return;
	}

	//	...
	if(!Unit::Load('dump') ){
		return;
	}

	//	Dump.
	OP\UNIT\Dump::Mark(func_get_args());
}

/** Decode
 *
 * @param  mixed  $value
 * @param  string $charset
 * @return string $var
 */
function Decode($value, $charset=null)
{
	//	...
	if(!$charset ){
		$charset = Env::Charset();
	}

	//	...
	switch( /* $type = */ gettype($value) ){
		//	...
		case 'string':
			$value = DecodeString($value, $charset);
			break;

		//	...
		case 'array':
			$result = [];
			foreach( $value as $key => $val ){
				$key = is_string($key) ? DecodeString($key, $charset): $key;
				$val = Decode($val, $charset);
				$result[$key] = $val;
			}
			$value = $result;
			break;

		//	...
		default:
			//	Does infinite loop.
		//	Notice::Set("Has not been support this type. ($type)");
	}

	//	...
	return $value;
}

function DecodeString($string, $charset)
{
	return html_entity_decode($string, ENT_QUOTES, $charset);
}

/** Encode mixed value.
 *
 * @param  mixed  $var
 * @param  string $charset
 * @return mixed  $var
 */
function Encode($var, $charset=null)
{
	return Escape($var, $charset);
}

/** Escape mixid value.
 *
 * @param  mixed  $var
 * @param  string $charset
 * @return mixed  $var
 */
function Escape($var, $charset=null)
{
	//	...
	if(!$charset ){
		$charset = Env::Charset();
	}

	//	...
	switch( /* $type = */ gettype($var) ){
		case 'string':
			return _EscapeString($var, $charset);

		case 'array':
			$var = _EscapeArray($var, $charset);
			break;

		case 'object':
			/*
			D("Objects are not yet supported.");
			*/
			$var = get_class($var);
			break;

		default:
		//	Notice::Set("Has not been support this type. ($type)");
	}

	//	...
	return $var;
}

/** Escape array.
 *
 * @param  array $arr
 * @return array
 */
function _EscapeArray($arr, $charset='utf-8')
{
	//	...
	$new = [];

	//	...
	foreach( $arr as $key => $var ){
		//	Escape index key in case of string.
		if( is_string($key) ){
			$key = _EscapeString($key, $charset);
		}

		//	Escape value.
		$new[$key] = Escape($var, $charset);
	}

	//	...
	return $new;
}

/** Escape string.
 *
 * @param  string $var
 * @return string
 */
function _EscapeString($var, $charset='utf-8')
{
	$var = str_replace("\0", "", $var);
	return htmlentities($var, ENT_QUOTES, $charset, false);
}

/** To hash
 *
 * This function is convert to fixed length unique string from long or short strings.
 *
 * @param	 null|integer|float|string|array|object $var
 * @param	 integer	 $length
 * @param	 string|null $salt
 * @return	 string		 $hash
 */
function Hasha1($var, $length=8, $salt=null){
	//	...
	if( is_string($var) ){
		//	...
	}else if( is_array($var) or is_object($var) ){
		$var = json_encode($var);
	}

	//	...
	if( $salt === null ){
		$salt = _OP_SALT_;
	};

	//	...
	return substr(sha1($var . $salt), 0, $length);
}

/** ifset
 *
 * @see    http://qiita.com/devneko/items/ee83854eb422c352abc8
 * @param  mixed $check
 * @param  mixed $alternate
 * @return mixed
 */
function ifset(&$check, $alternate=null)
{
	return isset($check) ? $check : $alternate;
}

/** Parse html tag attribute from string to array.
 *
 * @param  string $attr
 * @return array  $result
 */
function Attribute(string $attr)
{
	//	...
	$key = 'tag';
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

/** Output secure JSON.
 *
 * @param	 array	 $json
 * @param	 string	 $attr
 */
function Json($json, $attr)
{
	//	Decode
	$json = Decode($json);

	//	Convert to json.
	$json = json_encode($json);

	//	Encode XSS. (Not escape quote)
	$json = htmlentities($json, ENT_NOQUOTES, 'utf-8');

	//	...
	Html($json, 'div.'.$attr, false);
}

/** Display HTML.
 *
 * <pre>
 * Html('message', 'span #id .class');
 * </pre>
 *
 * @param	 string		 $string
 * @param	 string		 $config
 * @param	 boolean	 $escape tag and quote
 */
function Html($string, $attr=null, $escape=true)
{
	//	Escape tag and quote.
	if( $escape ){
		$string = Escape($string);
	}

	//	...
	if( $attr ){
		$attr = Attribute($attr);
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
		printf('<%s%s>%s</%s>'.PHP_EOL, $tag, $attr, $string, $tag);
	}else{
		printf('<%s%s>%s</%s>'.PHP_EOL, $tag, $attr, $string, $tag);
	}
}
