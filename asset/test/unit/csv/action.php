<?php
/**
 * unit-test:/unit/csv/action.php
 *
 * @creation  2018-07-17
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
$path = 'sample.csv';
$file = new SplFileObject($path);
$file->setFlags(SplFileObject::READ_CSV);
foreach ($file as $line) {
	$record[] = $line;
}
D($record);

$csv = new CSV();
foreach( $csv->Read2($path, 0) as $line ){
	D($line);
}

class CSV
{
	function Read($path, $assoc=false)
	{
		$head = null;
		$file = new SplFileObject($path);
		$file->setFlags(SplFileObject::READ_CSV);
		foreach ($file as $line) {
			if( $assoc ){
				$head  = $line;
				$assoc = false;
				continue;
			}

			//	...
			if( $head ){
				for($i=0, $c=count($line); $i<$c; $i++){
					$result[$head[$i]] = $line[$i];
				}
			}else{
				$result = $line;
			}

			//	...
			yield $result;
		}
	}

	function Read2($path, $assoc=false)
	{
		//	...
		if(!$fp = fopen($path, 'r') ){
			return;
		}

		//	...
		stream_filter_prepend($fp, 'convert.iconv.cp932/utf-8', STREAM_FILTER_READ);

		//	...
		while( $line = fgetcsv($fp) ){
			//	...
			if( $assoc ){
				$head  = $line;
				$assoc = false;
				continue;
			}

			//	...
			if( $head ){
				for($i=0, $c=count($line); $i<$c; $i++){
					$result[$head[$i]] = $line[$i];
				}
			}else{
				$result = $line;
			}

			//	...
			yield $result;
		}
	}
}
