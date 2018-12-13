<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * app-skeleton-2018-nep:/asset/config.php
 *
 * @creation  2018-03-27
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Time
Time::Timezone('Asia/Tokyo');

//	Layout settigs.
OP\UNIT\NEWWORLD\Layout::Directory(__DIR__.'/layout');
OP\UNIT\NEWWORLD\Layout::Execute(true);
OP\UNIT\NEWWORLD\Layout::Name('white');

//	Template settings.
OP\UNIT\NEWWORLD\Template::Directory(__DIR__.'/template');

//	Application settings.
App::Title('app-skeleton-2018-nep');
