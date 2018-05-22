<?php
/**
 * unit-sql:/Grant.class.php
 *
 * @created   2017-12-19
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2017-12-19
 */
namespace OP\UNIT\SQL;

/** Grant
 *
 * @created   2017-12-19
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Grant
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Grant to Privilege.
	 *
	 * @param array $config
	 * @param array $DB
	 */
	static function Privilege($config, $DB)
	{
		//	...
		foreach( ['host','user'] as $key ){
			if( isset($config[$key]) ){
				${$key} = $DB->GetPDO()->Quote($config[$key]);
			}else{
				\Notice::Set("Has not been set $key.");
				return false;
			}
		}

		//	...
		foreach( ['database','table'] as $key ){
			if( isset($config[$key]) ){
				${$key} = $DB->Quote($config[$key]);
			}else{
				\Notice::Set("Has not been set $key.");
				return false;
			}
		}

		//	...
		switch( $type = gettype( ifset($config['privileges']) ) ){
			case 'string':
				$privileges = explode(',', $config['privileges']);
				break;

			case 'array':
				$privileges = $config['privileges'];
				break;

			default:
				\Notice::Set("Has not been set this privilege type. ($type)");
			return false;
		}

		//	...
		foreach( $privileges as $privilege ){
			$privilege = trim($privilege);
			$privilege = strtoupper($privilege);
			if( preg_match('/[^A-Z]/', $privilege, $m) ){
				\Notice::Set("Illegal privilege. ({$m[1]})");
				return false;
			}
			$join[] = $privilege;
		}
		$privileges = join(', ', $join);

		//	...
		if( strlen($user) > 16 ){
			\Notice::Set("User name is too long. (Maximum 16 character: $user)");
			return false;
		}

		//	...
		return "GRANT {$privileges} ON {$database}.{$table} TO {$user}@{$host}";
	}
}
