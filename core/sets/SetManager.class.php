<?php

require_once(dirname(__FILE__)."/OrderedSet.class.php");

/**
 * The SetManager maintains a configuration and retreives Sets with that 
 * configuration.
 * 
 * @package harmoni.sets
 * @version $Id: SetManager.class.php,v 1.3 2004/07/12 18:56:46 adamfranco Exp $
 * @date $Date: 2004/07/12 18:56:46 $
 * @copyright 2004 Middlebury College
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
	 * @date 6/28/04
	 */
	function SetManager ($dbIndex) {
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule, true);
		
		$this->_dbIndex = $dbIndex;
		$this->_sets = array ();
	}
	
	/**
	 * Get a Set object of the specified Id. The Set does not have to have been
	 * created previously and any changes to the set will be persisted 
	 * automatically.
	 * 
	 * @param object Id $id The Id of the set to get.
	 * @return object SetInterface
	 * @access public
	 * @date 6/28/04
	 */
	function & getSet ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
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
	 * @date 6/28/04
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
	 * @date 6/28/04
	 */
	function start () {
		
	}
	
	/**
	 * Stop the service
	 * 
	 * @return void
	 * @access public
	 * @date 6/28/04
	 */
	function stop () {
		
	}
	
	
	
}

?>

