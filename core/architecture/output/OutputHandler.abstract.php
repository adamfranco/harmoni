<?php
/**
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OutputHandler.abstract.php,v 1.1 2005/04/05 18:53:18 adamfranco Exp $
 */ 

/**
 * The OutputHander abstract class defines methods for the interaction between
 * the Harmoni framework object and output handling classes.
 *
 * 
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OutputHandler.abstract.php,v 1.1 2005/04/05 18:53:18 adamfranco Exp $
 */
class OutputHandler {
	
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
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
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
	function &getOsidContext () { 
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
	function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
	} 
		
	/**
	 * Attach this class to the HarmoniObject as the current OutputHandler.
	 * This method and Harmoni::attachOutputHandler() make up a Double-Dispatch
	 * design pattern.
	 * 
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function attachToHarmoni () {
		$osidContext =& $this->getOsidContext();
		$harmoni =& $osidContext->getContext('harmoni');
		
		$harmoni->attachOutputHandler($this);
	}
	
	/**
	 * Output the content that was returned from an action. This content should
	 * have been created such that it is a type that this OutputHandler can deal
	 * with.
	 * 
	 * @param mixed $content
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function output ( &$content ) {
		throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in abstract class <b> ".__CLASS__."</b> has not been overloaded in a child class.","OutputHandler",true));
	}
	
	/**
	 * Set the 'head' html element.
	 * 
	 * @param string $newHead
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function setHead ( $newHead ) {
		$this->_head = $newHead;
	}
	
	/**
	 * Get the 'head' html element.
	 * 
	 * @return string
	 * @access public
	 * @since 4/4/05
	 */
	function getHead () {
		return $this->_head;
	}
}

?>