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

	/** Drop database
	 *
	 * @created	 2019-01-09
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function Drop(array $config, \IF_DATABASE $DB)
	{
		$config['verb'] = 'DROP';
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
		$database = $config['database'] ?? $config['name']     ??  null;

		//	...
		if( $database ){
			$database = $DB->Quote($database);
		}else{
			throw new \Exception("Database name has empty.");
		}

		//	...
		switch( $verb ){
			case 'CREATE':
			case 'ALTER':
				//	...
				$encoding = $config['encoding'] ?? 'utf8';
				$charset  = $config['charset']  ?? 'utf8mb4';
				$collate  = $config['collate']  ?? null;

				//	...
				$charset  = $DB->Quote($charset);
				$encoding = $DB->Quote($encoding);
				if( $collate ){
					$collate = $DB->Quote($collate);
				};

				break;

			case 'DROP':
				break;

			default:
				throw new \Exception("Has not been support this value. ($verb)");
		};

		//	...
		if( $verb === 'DROP' ){
			$option = null;
		}else{
			switch( $prod = $DB->Config()['prod'] ){
				case 'mysql':
					//	...
					if(!$collate ){
						$collate = substr($charset, 1, -1) . "_general_ci";
						$collate = $DB->Quote($collate);
					};

					//	...
					if( $verb !== 'DROP' ){
						$option = "DEFAULT CHARACTER SET {$charset} COLLATE {$collate}";
					};
					break;

				case 'pgsql':
					//	...
					if( $owner = $config['owner'] ?? null ){
						$owner = $DB->Quote($owner);
					};

					//	...
					if( $locale  = $config['locale'] ?? null ){
						$collate = $DB->Quote($locale .'.'. $encoding);
					//	$type    = $DB->Quote($locale .'.'. $encoding);
					};

					//	...
					if( $verb !== 'DROP' ){
						$option = "ENCODING {$encoding}";
					//	$option = "ENCODING {$encoding} OWNER={$owner} LC_COLLATE = {$collate} LC_CTYPE = $type";
					};
					break;

				default:
					throw new \Exception("Has not been support this product. ($prod)");
			};
		};

		//	...
		return "{$verb} DATABASE {$database} {$option}";

		/** PostgreSQL
		 *
		 * @see https://www.postgresql.jp/document/9.4/html/sql-createdatabase.html
		 *
		 * CREATE DATABASE name
		 * [ [ WITH ] [ OWNER [=] user_name ]
		 * 		[ TEMPLATE [=] template ]
		 * 		[ ENCODING [=] encoding ]
		 * 		[ LC_COLLATE [=] lc_collate ]
		 * 		[ LC_CTYPE [=] lc_ctype ]
		 * 		[ TABLESPACE [=] tablespace_name ]
		 * 		[ CONNECTION LIMIT [=] connlimit ] ]
		 */
	}
}
