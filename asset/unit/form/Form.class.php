<?php
/**
 * unit-form:/Form.class.php
 *
 * @created   2017-01-25
 * @version   1.0
 * @package   unit-form
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-01-22
 */
namespace OP\UNIT;

/** Form
 *
 * @created   2017-01-25
 * @version   1.0
 * @package   unit-form
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Form
{
	/** Trait
	 *
	 */
	use \OP_CORE, \OP_SESSION;

	/** Form configuration.
	 *
	 * @var array
	 */
	private $_form = [];

	/** Error of validation.
	 *
	 * @var array
	 */
	private $_errors;

	/** Session
	 *
	 */
	private $_session = [];

	/** Start method was called flag.
	 *
	 * @var boolean
	 */
	private $_is_start;

	/** Initialize form config.
	 *
	 * @param	 string|array	 $form
	 * @throws	 Exception		 $e
	 * @return	 boolean		 $io
	 */
	private function _InitForm($form)
	{
		//	...
		if( is_string($form) ){
			//	...
			if(!file_exists($form) ){
				\Notice::Set("Does not found this file. ($form)");
				return;
			}

			//	Load by file path.
			try {
				$form = include($form);
			} catch ( \Throwable $e ){
				\Notice::Set($e);
				return;
			}
		}

		//	...
		if( $this->_form ){
			\Notice::Set("Already initialized. {$this->_form['name']}");
			return;
		}

		//	...
		if(!$form_name = $form['name'] ?? false ){
			\Notice::Set('Form name is empty. EX: $form["name"] = "form-name";');
			return;
		}

		//	...
		if( empty($form['method']) ){
			$form['method'] = 'post';
		}

		//	...
		$this->_form = Escape($form);

		//	...
		$this->_session = $this->Session($form_name);

		//	...
		return true;
	}

	/** Initialize input config.
	 *
	 */
	private function _InitInput()
	{
		//	...
		if( empty($this->_form['input']) ){
			$this->_form['input'] = [];
		}

		//	...
		$form_name = $this->_form['name'];

		//	Result of token authentication.
		$token = $this->Token();

		//	...
		$request = $this->_Request();

		//	...
		$cookie = \Cookie::Get($form_name, []);

		//	...
		foreach( $this->_form['input'] as $name => &$input ){
			//	...
			$type = strtolower($this->_form['input'][$name]['type']);

			//	The value of the button will be sent only when clicked.
			if( 'button' === $type ){
				continue;
			}

			//	...
			if( $type === 'select' or $type === 'radio' or $type === 'checkbox' ){
				$this->_InitOption($input);
			}

			//	...
			if( isset($request[$name]) ){
				$value = $request[$name];
			}else if( isset($cookie[$name]) ){
				$value = $cookie[$name];
			}else{
				$value = $input['value'] ?? null;
			}

			//	The value will overwrite.
			if( $value !== null ){
				//	That will not be saved in the session.
				$input['value'] = $value;

				//	Save to session?
				$is_session = ifset($input['session'], true);

				//	Check token result.
				if( $token and $is_session ){
					//	Overwrite to session from submitted value.
					if( $input['session'] ?? true ){
						$this->_session[$name] = $value;
					}

					//	Save to cookie?
					if( ifset($input['cookie']) ){
						$cookie[$name] = $value;
					}
				}

				//	Discard the saved session. (For developer feature)
				if( $is_session === false ){
					unset($this->_session[$name]);
				}
			}else{
				//	That was not submitted this time. (If is transmitted at different time)
				if( isset($this->_session[$name]) ){
					//	Overwrite to form config from session.
					$input['value'] = $this->_session[$name];
				}
			}
		}

		//	...
		if( count($cookie) ){
			\Cookie::Set($form_name, $cookie);
		}
	}

	/** Init input option.
	 *
	 * @param	 array	&$input
	 */
	private function _InitOption(&$input)
	{
		//	In case of empty.
		if( empty($input['values']) ){
			$input['values'] = $input['options'] ?? $input['option'] ?? [];
		}

		//	In case of string.
		if( is_string($input['values']) ){
			$input['values'] = explode(',', $input['values']);
		}

		//	...
		foreach( $input['values'] as $index => &$values ){
			//	...
			$check = false;
			$value = null;

			//	...
			if( is_string($values) ){
				$label = $value = $values;
			}else{
				$value = $values['value'];
				$label = $values['label'];
			}

			//	...
			$values = [];
			$values['label'] = $label;
			$values['value'] = $value;
			$values['check'] = $check;
		}
	}

	/** Get request values.
	 *
	 * @return	 array	 $request;
	 */
	private function _Request($name=false)
	{
		static $_request = null;

		//	...
		if( $_request === null ){
			switch( strtolower($this->_form['method']) ){
				case 'get':
					$_request = $_GET  ?? [];
					break;

				case 'post':
					$_request = $_POST ?? [];
					break;
			}

			//	...
			$_request = Escape($_request);
		}

		//	...
		return $name ? ($_request[$name] ?? null) : $_request;
	}

	/** Construct
	 *
	 */
	function __construct()
	{

	}

	/** Destruct
	 *
	 */
	function __destruct()
	{
		if( $name = $this->_form['name'] ?? null ){
			$this->Session($name, $this->_session);
		}
	}

	/** Get/Set form configuration.
	 *
	 * @param  string $form
	 * @return array  $form
	 */
	function Config($form=null)
	{
		//	...
		if( $form ){
			//	...
			if(!$this->_InitForm($form) ){
				return;
			}

			//	...
			$this->_InitInput();

			//	...
			if( \Env::isAdmin() ){
				if(!FORM\Test::Config($this->_form) ){
					D( FORM\Test::Error() );
				}
			}
		}

		//	...
		return $this->_form;
	}

	/** Return the result of token authentication.
	 *
	 * <pre>
	 * RETURN VALUE:
	 *   null:    Token has not been set yet.
	 *   boolean: Token match result.
	 * </pre>
	 *
	 * @return boolean
	 */
	function Token()
	{
		//	Static variables are also shared between different instances.
		static $io;

		//	...
		$form_name = $this->_form['name'];

		//	...
		if(!isset($io[$form_name]) ){
			//	Initialize.
			$io[$form_name] = null;

			//	Last time token.
			$token = $this->_session['token'] ?? false;

			//	Regenerate session id.
			session_regenerate_id();

			//	Regenerate new token.
		//	$this->_session['token'] = Hasha1(microtime());
			$this->_session['token'] = random_int(1000, 9999);

			//	Confirmation of request token.
			if( $token ){
				$io[$form_name] = ($token === (int)self::_Request('token'));
			}
		}

		//	...
		if( \Env::isAdmin() ){
			if( $io[$form_name] === null ){
				$this->Debug("Token has not been set yet.");
			}else if( $io[$form_name] === false ){
				$this->Debug("Token is unmatch.");
			}else{
				$this->Debug("Token is match.");
			}
		}

		//	...
		return $io[$form_name];
	}

	/** Get input value.
	 *
	 * @param  string $name
	 * @return string $value
	 */
	function Get($name)
	{
		return $this->_form['input'][$name]['value'];
	}

	/** Set input value.
	 *
	 * @param  string  $name
	 * @param  string  $value
	 * @param  boolean $session Overwrite to saved session value.
	 */
	function Set($name, $value, $session=true)
	{
		//	...
		$this->_form['input'][$name]['value'] = $value;

		//	...
		if( $session and !empty($this->_form['input'][$name]['session']) ){
			$this->_session[$name] = $value;
		}
	}

	/** Print form tag. (open)
	 *
	 * @param array $config
	 */
	function Start($config=[])
	{
		//	...
		$this->_is_start = true;

		//	...
		if(!$this->_form ){
			throw new Exception("Has not been set configuration.");
		}

		//	...
		$attr = [];

		//	...
		if( empty($config['class']) ){
			$config['class'] = 'OP ';
		}else{
			$config['class'] = 'OP ' . $config['class'] . ' ';
		}

		//	...
		foreach(['action','method','name','id','class','style'] as $key){
			//	...
			$val = $config[$key] ?? $this->_form[$key] ?? null;

			//	...
			$attr[] = sprintf('%s="%s"', $key, $val);
		}

		//	...
		printf('<form %s>', join(' ', $attr));
		printf('<input type="hidden" name="form_name" value="%s" />', $this->_form['name']    );
		printf('<input type="hidden" name="token"     value="%s" />', $this->_session['token']);
	}

	/** Print form tag. (close)
	 */
	function Finish()
	{
		//	...
		if( $this->_is_start === null ){
			D("Start method was not called.");
		}

		//	...
		print "</form>";
	}

	/** Get input label.
	 *
	 * @param  string $name
	 * @return string $label
	 */
	function GetLabel($name)
	{
		//	...
		if( empty( $this->_form['input'][$name] ) ){
			\Notice::Set("Does not exists this name. ($name)");
			return;
		}

		//	...
		return $this->_form['input'][$name]['label'] ?? $name;
	}

	/** Generate input tag.
	 *
	 * @param	 string			 $name
	 * @param	 string|array	 $name
	 * @return	 string
	 */
	function GetInput($name, $value=null)
	{
		static $request;

		//	...
		if(!$request){
			$request = self::_Request();
		}

		//	...
		try {
			//	...
			if( empty($this->_form['input'][$name]) ){
				throw new \Exception("This name has not been into config. ($name)");
			}

			//	...
			$input = $this->_form['input'][$name];

			//	...
			$input['name'] = $name;

			//	...
			if( $value ){
				if( is_array($value) ){
					$input['values'] = $value;
				}else{
					$input['value']  = $value;
				}
			}

			//	...
			switch( $type = ucfirst(ifset($input['type'])) ){
				case 'Checkbox':
				case 'Radio':
				case 'Select':
				case 'Button':
					$path = "\OP\UNIT\FORM\\$type";
					return $path::Build($input);

				case 'Submit':
					return \OP\UNIT\FORM\Button::Build($input);

				default:
					return \OP\UNIT\FORM\Input::Build($input);
			}
		} catch ( \Throwable $e ) {
			\Notice::Set($e);
		}
	}

	/** Get/Set value of input.
	 *
	 * @param string $name
	 * @param string $value Set or Overwrite value.
	 */
	function GetValue($name, $value=null)
	{
		//	Override input value.
		if( $value !== null ){
			$this->_session[$name] = Escape($value);
		}

		//	...
		$value = ifset($this->_session[$name]);

		//	...
		if( $value === null ){
			$value = self::_Request($name);
		}

		//	...
		if( gettype($value) === 'array' ){
			//	...
			if( $this->_form['input'][$name]['type'] === 'checkbox' ){
				//	Remove top index. top index is empty value.
				array_shift($value);
			}
		}

		//	...
		return $value;
	}

	/** Get error.
	 *
	 * @param string $name
	 */
	function GetError($name)
	{
		return $this->_errors[$name] ?? [];
	}

	/** Print input label.
	 *
	 * @param string $name
	 */
	function Label($name)
	{
		echo $this->GetLabel($name);
	}

	/** Print generated input tag.
	 *
	 * @param	 string			 $name
	 * @param	 string|array	 $value
	 */
	function Input($name, $value=null)
	{
		//	...
		if( $this->_is_start === null ){
			$this->_is_start  =  false;
			D("Start method was not called.");
		}

		//	...
		echo $this->GetInput($name, $value);
	}

	/** Display error message.
	 *
	 * @param string $name
	 */
	function Error($name, $format='<span class="error">$label is $rule error.</span>')
	{
		//	...
		$config = $this->Config();

		//	...
		$format = $config['error'] ?? $format;

		//	...
		foreach( $this->GetError($name) as $rule => $var ){
			//	...
			if( $var === false ){
				continue;
			}

			//	...
			$input = $config['input'][$name];
			$label = $input['label'] ?? $name;

			//	...
			print str_replace(
				['$label','$Name','$name','$Rule','$rule','$value'],
				[$label, ucfirst($name), $name, ucfirst($rule), $rule, $var],
				isset($input['error']) ? Decode($input['error']) : $format
			);
		}
	}

	/** Display value at input name.
	 *
	 * @param  string $name
	 */
	function Value($name)
	{
		//	...
		$input = $this->_form['input'][$name];

		//	...
		$value = $this->GetValue($name);

		//	...
		if( $input['type'] === 'select' and ifset($input['multiple']) ){
			$input['type'] = 'multiple';
		}

		//	...
		switch( $type = $input['type'] ){
			case 'radio':
			case 'select':
				foreach( $input['values'] as $values ){
					//	...
					if(!isset($values['value']) ){ continue; }

					//	...
					if( $value === (string)$values['value'] ){
						$value = $values['label'];
						break;
					}
				}
				break;

			case 'checkbox':
			case 'multiple':
				$labels = [];
				foreach( $input['values'] as $values ){
					if( is_array($value) and in_array($values['value'], $value, false) ){
						$labels[] = $values['label'];
					}
				}
				$value = $labels;
				break;

			case 'textarea':
				$value = nl2br($value);
				break;

			default:
		}

		//	...
		if( is_string($value) ){
			echo $value;
		}else{
			D($value);
		}
	}

	/** Get saved values.
	 *
	 * @return array
	 */
	function Values()
	{
		//	Get saved session value.
		$saved_session_value = $this->_session;

		//	Get submitted request.
		$request = $this->_Request();

		//	Remove token value.
		unset($saved_session_value['token']);

		//	Generate result each input name.
		foreach( $this->Config()['input'] as $name => $input ){
			//	If not save to session.
			if( empty($input['session']) ){
				//	Result current submit value.
				$result[$name] = $request[$name] ?? null;
			}else{
				//	Calc value.
				$value = $saved_session_value[$name] ?? $input['value'] ?? null;

				//	Set to result.
				$result[$name] = $value;
			}
		}

		//	...
		return $result ?? [];
	}

	/** Validate
	 *
	 * <pre>
	 * Return value
	 *   Null is unmatch token. (Not do validation.)
	 *   Boolean is validation result. (true is no problem.)
	 * </pre>
	 *
	 * @return	 null|boolean	 $io
	 */
	function Validate()
	{
		//	...
		static $_result;

		//	...
		if(!$this->Token() ){
			return;
		}

		//	...
		if(!\Unit::Load('validate') ){
			return;
		}

		//	Check if validate.
		if( $this->_errors ){
			//	Already validation.
		}else{
			//	...
			$config = $this->Config();
			$values = $this->Values();

			//	Each inputs.
			foreach( $config['input'] as $name => $input ){
				//	Get validation rule.
				$rule = $input['rule'] ?? [];

				//	Do validation.
				$_result[$name] = \OP\UNIT\Validate::Evaluation($rule, $values[$name] ?? null, $this->_errors[$name], $values);
			}
		}

		//	Overall result
		return (array_search(false, $_result, true) === false) ? true: false;
	}

	/** Clear saved session value.
	 * 	Sessions are separated by form name.
	 */
	function Clear()
	{
		//	...
		if(!$this->_form ){
			\Notice::Set("Has not been set form configuration.");
			return;
		}

		//	...
		$token = $this->_session['token'];
		$this->_session = [];
		$this->_session['token'] = $token;
		$this->Session($this->_form['name'], $this->_session);

		//	...
		\Cookie::Set($this->_form['name'], []);

		//	...
		$this->_Request(null);

		//	...
		foreach( $this->_form['input'] as &$input ){
			unset($input['value']);
		}
	}

	/** Configuration test.
	 *
	 */
	function Test()
	{
		//	...
		if(!\Env::isAdmin() ){
			return false;
		}

		//	...
		if(!$io = FORM\Test::Config($this->_form) ){
			return FORM\Test::Error();
		}

		//	...
		return $io;
	}

	/** For developers debug information.
	 *
	 */
	function Debug($message=null)
	{
		static $_store = null;

		if( $message ){
			$_store[Hasha1($message)] = $message;
		}else{
			D($_store, $this->_errors);
		}
	}
}
