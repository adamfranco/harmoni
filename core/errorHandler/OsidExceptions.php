<?php
/**
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */ 

/**
 * Thrown on an unknown Id
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class UnknownIdException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('UNKNOWN ID: '.$message, $code);
	}
	
}

/**
 * Thrown when a method is unimplemented.
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class UnimplementedException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		
		$trace = debug_backtrace();
		$entry = $trace[1];
		
		$function = isset($entry['function'])?$entry['function']:'';
		$class = isset($entry['class'])?$entry['class']:'';
		$type = isset($entry['type'])?$entry['type']:'';
		
		$fullMessage = $class.$type.$function."() ";
		if (strlen($message))
			$fullMessage .= " -- ".$message;
		
		parent::__construct('UNIMPLEMENTED: '.$fullMessage, $code);
	}
	
}

/**
 * Thrown when a method is unimplemented.
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class OperationFailedException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('OPERATION_FAILED: '.$message, $code);
	}
	
}

/**
 * Thrown when a there is a configuration error.
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class ConfigurationErrorException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('CONFIGURATION_ERROR: '.$message, $code);
	}
	
}

/**
 * Thrown when permission is denied
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class PermissionDeniedException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('PERMISSION_DENIED: '.$message, $code);
	}
	
}

/**
 * Thrown when an argument is null.
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class NullArgumentException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('NULL_ARGUMENT: '.$message, $code);
	}
	
}

/**
 * Thrown when the type is unknown
 * 
 * @since 10/4/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class UnknownTypeException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('UNKNOWN_TYPE: '.$message, $code);
	}
	
}

/**
 * Thrown when there are no more iterator elements
 * 
 * @since 8/4/08
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OsidExceptions.php,v 1.1 2007/10/05 14:01:50 adamfranco Exp $
 */
class NoMoreIteratorElementsException
	extends HarmoniException
{
		
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message = '', $code = 0) {
		parent::__construct('NO_MORE_ITERATOR_ELEMENTS: '.$message, $code);
	}
	
}


?>