<?php

require_once(dirname(__FILE__)."/OrderedSet.class.php");

/**
 * The SetManager maintains a configuration and retreives Sets with that 
 * configuration.
 *
 * @package  harmoni.sets
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SetManager.class.php,v 1.9 2005/03/29 19:44:30 adamfranco Exp $
 */
class SetManager {
	
	/**
	 * @var integer $_dbIndex; The index of the database connection to use. 
	 * @access private
	 */
	var $_dbIndex;
	
	/**
	 * @var array $_sets; An array of created Set objects 
	 * @access private
	 */
	var $_sets;
	
	/**
	 * The constructor
	 * 
	 * @param integer $dbIndex The database index to use
	 * @access public
	 * @since 6/28/04
	 */
	function SetManager () {
		$this->_sets = array ();
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
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		$dbIndex =& $configuration->getProperty('database_index');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
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
	 * Get a Set object of the specified Id. The Set does not have to have been
	 * created previously and any changes to the set will be persisted 
	 * automatically.
	 * 
	 * @param object Id $id The Id of the set to get.
	 * @return object SetInterface
	 * @access public
	 * @since 6/28/04
	 */
	function &getSet ( & $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
		if (!isset($this->_sets[$id->getIdString()])) {
			$this->_sets[$id->getIdString()] =& new OrderedSet($id, $this->_dbIndex);
		}
		
		return $this->_sets[$id->getIdString()];
	}
	
	/**
	 * Remove all of the items from the set, thereby deleting it.
	 * 
	 * @param object Id $id The Id of the Set to delete.
	 * @return void
	 * @access public
	 * @since 6/28/04
	 */
	function deleteSet ( & $id ) {
		$set =& $this->getSet($id);
		$set->removeAllItems();
	}
	
	/**
	 * Start the service
	 * 
	 * @return void
	 * @access public
	 * @since 6/28/04
	 */
	function start () {
		
	}
	
	/**
	 * Stop the service
	 * 
	 * @return void
	 * @access public
	 * @since 6/28/04
	 */
	function stop () {
		
	}
	
	
	
}

?>