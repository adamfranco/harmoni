<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_Db.php,v 1.1.2.7 2008/04/08 15:48:16 adamfranco Exp $
 */ 

require_once 'Zend/Db.php';

require_once(dirname(__FILE__).'/Adapter/Pdo/Mysql.php');
require_once(dirname(__FILE__).'/Adapter/Pdo/Pgsql.php');

require_once(dirname(__FILE__).'/Statement/Pdo.php');

require_once(dirname(__FILE__).'/Select.php');
require_once(dirname(__FILE__).'/Update.php');
require_once(dirname(__FILE__).'/Delete.php');
require_once(dirname(__FILE__).'/Insert.php');

require_once(dirname(__FILE__).'/Result/Harmoni_Db_SelectResult.class.php');

/**
 * Class for connecting to SQL databases and performing common operations.
 * 
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_Db.php,v 1.1.2.7 2008/04/08 15:48:16 adamfranco Exp $
 */
class Harmoni_Db
	extends Zend_Db
{
		
	/**
	 * @var array $dbRegistry; A registry of created databases. 
	 * @access private
	 * @since 4/3/08
	 * @static
	 */
	private static $dbRegistry = array();
	
	/**
	 * Add a database to the registry
	 * 
	 * @param string $name
	 * @param object Zend_Db_Adapter_Abstract $database
	 * @return void
	 * @access public
	 * @since 4/3/08
	 * @static
	 */
	public static function registerDatabase ($name, Zend_Db_Adapter_Abstract $database) {
		if (!is_array(self::$dbRegistry)) 
			throw new OperationFailedException("Database registry is not valid");
		if (!strlen($name))
			throw new InvalidArgumentException("\$name, '$name', must be a string.");
		if (isset(self::$dbRegistry[$name])) 
			throw new OperationFailedException("Database already registered with name, '$name'.");
		
		self::$dbRegistry[$name] = $database;
	}
	
	/**
	 * Access a registered database
	 * 
	 * @param string $name
	 * @return object Zend_Db_Adapter_Abstract
	 * @access public
	 * @since 4/3/08
	 * @static
	 */
	public static function getDatabase ($name) {
		if (!isset(self::$dbRegistry[$name])) 
			throw new UnknownIdException("Database not registered with name, '$name'.");
		
		return self::$dbRegistry[$name];
	}
}

?>