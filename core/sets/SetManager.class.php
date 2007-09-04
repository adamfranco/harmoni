<?php

require_once(dirname(__FILE__)."/PersistentOrderedSet.class.php");

/**
 * The SetManager maintains a configuration and retreives Sets with that 
 * configuration.
 *
 * @package  harmoni.sets
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SetManager.class.php,v 1.13 2007/09/04 20:25:49 adamfranco Exp $
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
	var $_persistentSets;
	
	/**
	 * The constructor
	 * 
	 * @param integer $dbIndex The database index to use
	 * @access public
	 * @since 6/28/04
	 */
	function SetManager () {
		$this->_persistentSets = array ();
		if (!isset($_SESSION['__temporarySets']) 
			|| !is_array($_SESSION['__temporarySets']))
		{
			$_SESSION['__temporarySets'] = array();
		}
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
		
		$dbIndex =$configuration->getProperty('database_index');
		
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
	 * Get a Set object of the specified Id. The Set does not have to have been
	 * created previously and any changes to the set will be persisted 
	 * automatically.
	 * 
	 * @param object Id $id The Id of the set to get.
	 * @return object SetInterface
	 * @access public
	 * @since 6/28/04
	 */
	function getPersistentSet ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		if (!isset($this->_persistentSets[$id->getIdString()])) {
			$this->_persistentSets[$id->getIdString()] = new PersistentOrderedSet(
															$id, $this->_dbIndex);
		}
		
		return $this->_persistentSets[$id->getIdString()];
	}
	
	/**
	 * Remove all of the items from the set, thereby deleting it.
	 * 
	 * @param object Id $id The Id of the Set to delete.
	 * @return void
	 * @access public
	 * @since 6/28/04
	 */
	function deletePersistentSet ( $id ) {
		$set =$this->getPersistentSet($id);
		$set->removeAllItems();
	}
	
	/**
	 * Get a Set object of the specified Id. The Set does not have to have been
	 * created previously and any changes to the set will be persisted 
	 * automatically for the remainder of the SESSION.
	 * 
	 * @param object Id $id The Id of the set to get.
	 * @return object SetInterface
	 * @access public
	 * @since 6/28/04
	 */
	function getTemporarySet ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		if (!isset($_SESSION['__temporarySets'][$id->getIdString()])) {
			$_SESSION['__temporarySets'][$id->getIdString()] = new OrderedSet($id);
		}
		
		return $_SESSION['__temporarySets'][$id->getIdString()];
	}
	
	/**
	 * Remove all of the items from the set, thereby deleting it.
	 * 
	 * @param object Id $id The Id of the Set to delete.
	 * @return void
	 * @access public
	 * @since 6/28/04
	 */
	function deleteTemporarySet ( $id ) {
		$set =$this->getTemporarySet($id);
		$set->removeAllItems();
	}
	
	/**
	 * Persist a Set and return the new persistent version of it. If A persistent
	 * Set of the same Id already exists, the new one will replace it.
	 * 
	 * @param object OrderedSet $set
	 * @return object PersistentOrderedSet
	 * @access public
	 * @since 8/5/05
	 */
	function persist ( $set ) {
		$persistentSet =$this->getPersistentSet($set->getId());
		
		if ($persistentSet->isNotEqualTo($set)) {
			$persistentSet->removeAllItems();
			
			$set->reset();
			while($set->hasNext()) {
				$persistentSet->addItem($set->next());
			}
		}
		return $persistentSet;
	}
}

?>