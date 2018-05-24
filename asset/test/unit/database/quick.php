<?php
/**
 * unit-test:/unit/database/quick.php
 *
 * @creation  2018-05-08
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/* @var $db \OP\UNIT\Database */
include('connect.php');

//	QQL
D($db->quick(" t_test ",['limit'=>1]));
D($db->quick(" t_test.ai = MAX(ai) ",['limit'=>1]));
D($db->quick(" t_test.deleted = null ",['limit'=>1]));
D($db->quick(" ai <- t_test.deleted = null ",['limit'=>1]));
D($db->quick(" ai, id <- t_test.deleted = null ",['limit'=>1]));
D($db->quick(" ai, id <- t_test.deleted = null ",['limit'=>2]));
D($db->Queries());
