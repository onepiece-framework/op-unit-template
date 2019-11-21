<?php
/**
 * unit-template:/index.php
 *
 * @creation  2017-05-09
 * @updation  2019-02-22 Separate from NewWorld.
 * @version   1.0
 * @package   unit-template
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-13
 */
namespace OP\UNIT;

/** Used class.
 *
 */
use OP\OP_CORE;
use OP\OP_UNIT;
use OP\OP_DEBUG;
use OP\IF_UNIT;
use OP\Env;
use OP\Notice;
use Exception;
use function OP\ConvertPath;
use function OP\CompressPath;

/** Template
 *
 * @creation  2017-02-09
 * @version   1.0
 * @package   unit-newworld
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Template implements IF_UNIT
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_UNIT, OP_DEBUG;

	/** Template directory is separate each instance.
	 *
	 * @var string
	 */
	private $_dir;

	/** Stack arguments. Separate each instance.
	 *
	 * @var array
	 */
	private $_args;

	/** Construct
	 *
	 */
	function __construct()
	{
		//	Init template directory.
		if( $this->_dir = Env::Get('template')['directory'] ?? false ){
			$this->_dir = rtrim(ConvertPath($this->_dir), '/').'/';
		}else{
			throw new Exception('Template directory has not been set.');
		};

		//	Check if exists.
		if(!file_exists($this->_dir) ){
			throw new Exception("This directory has not been exists. ({$this->_dir})");
		};
	}

	/** Search exists file path.
	 *
	 * @param  string $path
	 * @return string
	 */
	private function _Path($path)
	{
		//	...
		if( file_exists($path) ){
			return realpath($path);
		};

		//	...
		if( strpos($path, ':/') and file_exists( $temp = ConvertPath($path) ) ){
			return $temp;
		};

		//	...
		if( $this->_dir and file_exists( $temp = $this->_dir.$path ) ){
			return $temp;
		};

		//	...
		Notice::Set("This file has not been exists. ($path)");

		//	...
		return false;
	}

	/** Return template string.
	 *
	 * @param  string $path
	 * @param  array  $args
	 * @return string
	 */
	function Get(string $path, array $args=[])
	{
		//	...
		if(!ob_start()){
			Notice::Set("ob_start was failed.");
			return;
		}

		//	...
		$this->Out($path, $args);

		//	...
		return ob_get_clean();
	}

	/** Output executed template file result.
	 *
	 * @param  string    $path
	 * @param  array     $args
	 * @throws Exception $e
	 */
	function Out(string $path, array $args=[])
	{
		//	Calc execute file path.
		if(!$path = $this->_Path($path) ){
			return;
		};

		//	Save current directory.
		$current_dir = getcwd();

		//	Change to execute file in directory.
		chdir( dirname($path) );

		//	Stack args.
		$this->_args[] = &$args;

		//	Save debug info.
		self::__DebugSet(__FUNCTION__, CompressPath($path) );

		//	Execute template file in closure.
		call_user_func(function($current_template_file_path, $current_template_argument) {
			//	Extract variable.
			if(!$count = extract($current_template_argument, null, null)){
				//	Maybe not assoc.
				throw new Exception("Passed arguments is not an assoc array. (count=$count)");
			};

			//	...
			try{
				include( basename($current_template_file_path) );
			/**
			 * Exception --> Fatal errors un-catchable.
			 * Throwable --> Fatal errors catchable.
			}catch( \Exception $e ){
			*/
			}catch( \Throwable $e ){
				Notice::Set($e);
			};

		}, $path, $args);

		//	Remove last in args.
		array_pop($this->_args);

		//	Recovery last directory.
		chdir($current_dir);
	}
}
