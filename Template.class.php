<?php
/**
 * unit-template:/Template.class.php
 *
 * @created   2017-05-09
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
use OP\IF_UNIT;
use OP\UNIT_TEMPLATE;

/** Template
 *
 * @created   2017-02-09
 * @updated   2019-11-21 Separate to UNIT_TEMPLATE.
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
	use OP_CORE, OP_UNIT, UNIT_TEMPLATE;
}
