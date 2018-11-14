<?php
/**
 * unit-pager:/index.php
 *
 * @creation  2018-06-12
 * @version   1.0
 * @package   unit-pager
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-02-01
 */
namespace OP\UNIT;

/** Pager
 *
 * @creation  2018-06-12
 * @version   1.0
 * @package   unit-pager
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class pager
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Configurations.
	 *
	 * @var array
	 */
	private $_config;

	/** Generate configuration.
	 *
	 * @param	 array		 $config;
	 * @param	\IF_DATABASE $db
	 */
	function Config($config=[], $db)
	{
		//	...
		if( empty($config['database']) or empty($config['table']) ){
			throw new \Exception("Has not been set database or table.");
		}

		//	Count conditions.
		$this->_config['database'] = $config['database'] ?? null;
		$this->_config['table'] = $config['table'] ?? null;
		$this->_config['where'] = $config['where'] ?? null;
		$this->_config['order'] = $config['order'] ?? null;

		//	If empty where case is generate where condition.
		if(!$this->_config['where'] ){
			if( $pkey = $db->PKey($this->_config['database'], $this->_config['table']) ?? null ){
				$this->_config['where'][$pkey]['evalu'] = '!=';
				$this->_config['where'][$pkey]['value'] = null;
			}else{
				throw new \Exception("This table has not been set primary key. ({$this->_config['database']}.{$this->_config['table']})");
			}
		}

		//	Count total record number.
		$this->_config['count'] = $db->Count($this->_config, 'count');

		//	Get method variable name.
		$this->_config['label'] = $config['label'] ?? 'page';

		//	Get current page.
		$this->_config['page']  = (int)($config['page']  ?? $_GET[$this->_config['label']] ?? 1);

		//	Paging conditions.
		$this->_config['limit']  = $config['limit'] ?? 10; // Page per record.
		$this->_config['offset'] = $config['offset'] ?? (((int)$this->_config['page']) -1) * $this->_config['limit'];

		//	...
		if( $this->_config['limit'] > 100 ){
			$this->_config['limit'] = 100;
		}

		//	...
		if( $this->_config['offset'] < 0 ){
			$this->_config['offset'] = 0;
		}

		//	Return SQL config. (Remove pagination config)
		return array_diff_key( $this->_config, ['label'=>null, 'page'=>null] );
	}

	/** Do display.
	 *
	 * @param	 array		 $config;
	 * @param	\IF_DATABASE $db
	 */
	function Display()
	{
		//	...
		$max = (int)ceil($this->_config['count'] / $this->_config['limit']);

		//	...
		$current_page = ($this->_config['page'] > $max) ? $max: $this->_config['page'];

		//	...
		printf('<nav class="OP pager">'.PHP_EOL);
		printf('<span class="page top"><a href="?%s"></a></span>'.PHP_EOL, http_build_query( array_merge($_GET, ['page'=>1]) ));
		for($i=1;$i<=$max;$i++){
			if( $i === $current_page ){
				printf('<span class="page"><span class="current">%s</span></span>'.PHP_EOL, $i);
			}else{
				printf('<span class="page"><a href="?%s">%s</a></span>'.PHP_EOL, http_build_query( array_merge($_GET, ['page'=>$i])), $i);
			}
		}
		printf('<span class="page last"><a href="?%s"></a></span>'.PHP_EOL, http_build_query( array_merge($_GET, ['page'=>$max]) ));
		printf('</nav>'.PHP_EOL);
	}
}
