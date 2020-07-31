<?php
/**
 * unit-template:/TEMPLATE.trait.php
 *
 * @created   2019-11-21 Separate from Template class.
 * @version   1.0
 * @package   unit-template
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-11-21
 */
namespace OP;

/** Used class.
 *
 * @created   2019-11-21
 */
use Exception;
use function OP\ConvertPath;
use function OP\CompressPath;

/** Template
 *
 * @created   2017-02-09
 * @updated   2019-02-22 Separate from NewWorld.
 * @updated   2019-11-21 Separate from Template class.
 * @version   1.0
 * @package   unit-template
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait UNIT_TEMPLATE
{
	/** Using trait.
	 *
	 */
	/*
	use OP_DEBUG;
	*/

	/** Template directory is separate each instance.
	 *
	 * @var string
	 */
	private $_dir;

	/** Stack arguments. Separate each instance.
	 *
	 * @var array
	 */
	/*
	private $_args;
	*/

	/** Construct
	 *
	 */
	function __construct()
	{
		//	Init template directory.
		/*
		if( $this->_dir = Env::Get('template')['directory'] ?? false ){
			$this->_dir = rtrim(ConvertPath($this->_dir), '/').'/';
		}else{
			throw new Exception('Template directory has not been set.');
		};
		*/
		$this->_dir = RootPath('asset') . 'template/';

		//	Check if exists.
		if(!file_exists($this->_dir) ){
			throw new Exception("This directory has not been exists. ({$this->_dir})");
		};
	}

	/** Search exists file path.
	 *
	 * @param  string $path
	 * @return string|boolean
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
	function __TEMPLATE_GET(string $path, array $args=[]):string
	{
		//	...
		if(!ob_start()){
			throw new \Exception("ob_start was failed.");
		}

		//	...
		$this->__TEMPLATE($path, $args);

		//	...
		return ob_get_clean();
	}

	/** Output executed template file result.
	 *
	 * @param  string    $path
	 * @param  array     $args
	 * @throws Exception $e
	 */
	function __TEMPLATE(string $path, array $args=[])
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
		/*
		$this->_args[] = &$args;
		*/

		//	Save debug info.
		/*
		self::__DebugSet(__FUNCTION__, CompressPath($path) );
		*/

		//	Execute template file in closure.
		call_user_func(function($current_template_file_path, $current_template_argument) {
			//	...
			if( $current_template_argument ){
				//	Extract variable.
				if(!$count = extract($current_template_argument, null, null)){
					//	Maybe not assoc.
					throw new Exception("Passed arguments is not an assoc array. (count=$count)");
				};
			}

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
		/*
		array_pop($this->_args);
		*/

		//	Recovery last directory.
		chdir($current_dir);
	}
}
