<?php

require_once(HARMONI."debugHandler/DebugItem.class.php");
//require_once(HARMONI."debugHandler/DebugHandler.interface.php");

/**
 * @const integer DEBUG_API1 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API1",6);

/**
 * @const integer DEBUG_API2 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API2",7);

/**
 * @const integer DEBUG_API3 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API3",8);

/**
 * @const integer DEBUG_API4 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API4",9);

/**
 * @const integer DEBUG_API5 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API5",10);

/**
 * @const integer DEBUG_USER1 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER1",1);

/**
 * @const integer DEBUG_USER2 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER2",2);

/**
 * @const integer DEBUG_USER3 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER3",3);

/**
 * @const integer DEBUG_USER4 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER4",4);

/**
 * @const integer DEBUG_USER5 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER5",5);

/**
 * @const integer DEBUG_SYS1 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS1",11);

/**
 * @const integer DEBUG_SYS2 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS2",12);

/**
 * @const integer DEBUG_SYS3 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS3",13);

/**
 * @const integer DEBUG_SYS4 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS4",14);

/**
 * @const integer DEBUG_SYS5 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS5",15);

/**
 * The DebugHandler keeps track of multiple DebugItems.
 *
 * @package harmoni.utilities.debugging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DebugHandler.class.php,v 1.10 2007/09/04 20:25:33 adamfranco Exp $
 **/

class DebugHandler {
	/**
	 * @var array $_queue The array of DebugItems.
	 * @access private
	 **/
	var $_queue;
	
	/**
	 * @access private
	 * @var integer $_outputLevel The internal output level.
	 **/
	var $_outputLevel;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function DebugHandler() {
		$this->_queue = array();
		$this->_outputLevel = 0;
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( $configuration ) { 
		$this->_configuration =$configuration;
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( $context ) { 
		$this->_osidContext =$context;
	} 
	
	/**
	 * Adds debug text to the handler.
	 *
	 * @param mixed $debug Either a string with debug text or a DebugItem object.
	 * @param optional int $level The detail level of the debug text.
	 * @param optional string $category The text category.
	 * @access public
	 * @return void
	 **/
	function add( $debug, $level=5, $category="general") {
		if (is_object($debug))
			$this->_add($debug, debug_backtrace());
		else if (is_string($debug)) {
			$this->_add( new DebugItem($debug, $level, $category), debug_backtrace());
		}
		else
			return "Exception";
	}
	
	/**
	 * Adds a DebugItem to the queue.
	 *
	 * @param object DebugItem $debugItem The DebugItem to add to the queue.
	 * @param optional array $debugBacktrace A DebugBacktrace array.
	 * @access private
	 * @return void
	 **/
	function _add( $debugItem, $debugBacktrace ) {
		$debugItem->setBacktrace($debugBacktrace);

		$this->_queue[] =  $debugItem;
	}
	
	/**
	 * Returns the number of DebugItems registered.
	 * 
	 * @access public
	 * @return int The DebugItem count.
	 **/
	function getDebugItemCount() {
		return count($this->_queue);
	}
	
	/**
	 * Returns an array of DebugItems, optionally limited to category $category.
	 * 
	 * @param optional string $category The category.
	 * @access public
	 * @return array The array of DebugItems.
	 **/
	function getDebugItems( $category="" ) {
		$array = array();
		for ($i = 0; $i < $this->getDebugItemCount(); $i++) {
			if ($category == "" || $this->_queue[$i]->getCategory() == $category)
				$array[] = $this->_queue[$i];
		}
		return $array;
	}

	/**
	 * Sets the internal output level to $level. This can be overridden at output time.
	 * @param integer $level
	 * @access public
	 * @return void
	 **/
	function setOutputLevel($level) {
		$this->_outputLevel = $level;
	}
	
	/**
	 * Returns the internal output level.
	 * @access public
	 * @return integer
	 **/
	function getOutputLevel() {
		return $this->_outputLevel;
	}
}

?>