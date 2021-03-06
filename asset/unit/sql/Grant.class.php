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
	 * <pre>
	 * Has not been support to privilege to each column yet.
	 * </pre>
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 */
	static function Privilege($config, $DB)
	{
		//	...
		$host = $user = null;
		foreach( ['host','user'] as $key ){
			if( isset($config[$key]) ){
				${$key} = $DB->PDO()->Quote($config[$key]);
			}else{
				\Notice::Set("Has not been set $key.");
				return false;
			}
		}

		//	...
		$database = $table = null;
		foreach( ['database','table'] as $key ){
			if( isset($config[$key]) ){
				${$key} = $config[$key] === '*' ? '*': $DB->Quote($config[$key]);
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
		$join = $m = null;

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

		/*
		 REVOKE ALL PRIVILEGES ON `testcase`.`t_test` FROM 'testcase'@'localhost';
		 GRANT SELECT (`ai`, `id`), UPDATE (`ai`) ON `testcase`.`t_test` TO 'testcase'@'localhost';
		 */
		//		GRANT SELECT,INSERT ON  `database`.*      TO  'user'@'host';
		return "GRANT {$privileges} ON {$database}.{$table} TO {$user}@{$host}";
	}
}
