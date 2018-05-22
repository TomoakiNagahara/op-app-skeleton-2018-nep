<?php
/**
 * Error.php
 *
 * @creation  2014-02-18 --> 2016-12-07
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Error report settings.
 *
 * To display error log to until startuped of the onepiece-framework.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/** Set error handlers.
 *
 */
set_error_handler('_HandlerError', E_ALL);
set_exception_handler('_HandlerException');
register_shutdown_function('_HandlerShutdown');

/** Catch standard error.
 *
 * @see   http://php.net/manual/ja/function.restore-error-handler.php
 * @param integer $errno
 * @param string  $error
 * @param string  $file
 * @param integer $line
 * @param array   $context
 */
function _HandlerError($errno, $error, $file, $line, $context)
{
	switch($errno){
		case E_ERROR:				 // 1
		case E_WARNING:				 // 2
		case E_PARSE:				 // 4
		case E_NOTICE:				 // 8
		case E_CORE_ERROR:			 // 16
		case E_CORE_WARNING:		 // 32
		case E_COMPILE_ERROR:		 // 64
		case E_COMPILE_WARNING:		 // 128
		case E_USER_ERROR:			 // 256
		case E_USER_WARNING:		 // 512
		case E_USER_NOTICE:			 // 1024
		case E_STRICT:				 // 2048
		case E_RECOVERABLE_ERROR:	 // 4096
		case E_DEPRECATED:			 // 8192
		case E_USER_DEPRECATED:		 // 16384
		default:
			Notice::Set($error, debug_backtrace());
			return true;
	}
}

/** Catch of uncaught error.
 *
 * @param Throwable $e
 */
function _HandlerException($e)
{
	//	...
	$backtrace['file']		 = $e->getFile();
	$backtrace['line']		 = $e->getLine();
	$backtrace['function']	 = null;

	//	...
	$backtraces = $e->getTrace();

	//	...
	switch( $backtraces[0]['function'] ){
		case 'include':
		case 'require':
		case 'include_once':
		case 'require_once':
			if( empty($backtraces[0]['args']) ){
				$backtraces[0]['args'][] = $backtrace['file'];
			}
			break;
	}

	//	...
	array_unshift($backtraces, $backtrace);
	Notice::Set($e->getMessage(), $backtraces);
}

/** Called back on shutdown.
 *
 * @see http://www.php.net/manual/ja/function.pcntl-signal.php
 */
function _HandlerShutdown()
{
	if( $error = error_get_last() ){
		_HandlerError($error['type'], $error['message'], $error['file'], $error['line'], null);
	}
}
