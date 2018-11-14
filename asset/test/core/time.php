<?php
/**
 * unit-test:/core/time.php
 *
 * @creation  2018-05-01
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	ICE AGE
Time::Set('2020-01-01 09:00:00');

//	...
$temp = [];
$temp['Time::Timezone()']	 = Time::Timezone();
$temp['date(\'P\')']		 = date('P');
$temp['Time::Get()']		 = Time::Get();
$temp['Time::Get(true)']	 = Time::Get(true);
$temp['REQUEST_TIME']		 = $_SERVER['REQUEST_TIME'];
$temp['gmdate()']			 = gmdate('Y-m-d H:i:s');
$temp['Time::Date()']		 = Time::Date();
$temp['Time::Datetime()']	 = Time::Datetime();
$temp['Time::GMT()']		 = Time::GMT();

//	...
HTML('Did freeze of time goto 2020-01-01.');
D($temp);
