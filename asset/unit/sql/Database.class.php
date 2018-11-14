<?php
/**
 * unit-sql:/Database.class.php
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\SQL;

/** Database
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Database
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Create database
	 *
	 * @created	 2017-12-13
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function Create(array $config, \IF_DATABASE $DB)
	{
		$config['verb'] = 'CREATE';
		return self::Generate($config, $DB);
	}

	/** Change database
	 *
	 * @created	 2018-11-14
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function Change(array $config, \IF_DATABASE $DB)
	{
		$config['verb'] = 'ALTER';
		return self::Generate($config, $DB);
	}

	/** Generate database SQL
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @throws	\Exception
	 * @return	 string		 $sql
	 */
	static function Generate(array $config, \IF_DATABASE $DB)
	{
		//	...
		$verb     = $config['verb']     ?? null;
		$database = $config['database'] ?? null;
		$charset  = $config['charset']  ?? 'utf8mb4';
		$collate  = $config['collate']  ?? 'utf8mb4_general_ci';

		//	...
		if( $verb === 'CREATE' or $verb === 'ALTER' ){
			//	OK
		}else{
			throw new \Exception("Has not been support this value. ($verb)");
		}

		//	...
		if( empty($database) ){
			throw new \Exception("Database name has empty.");
		}

		//	...
		$database = $DB->Quote($database);
		$charset  = $DB->Quote($charset);
		$collate  = $DB->Quote($collate);

		//	...
		return "{$verb} DATABASE {$database} DEFAULT CHARACTER SET {$charset} COLLATE {$collate}";
	}
}
