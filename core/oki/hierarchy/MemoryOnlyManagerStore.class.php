<?php

require_once(HARMONI.'/oki/hierarchy/HierarchyManagerStore.interface.php');

/******************************************************************************
 * A storage class for HierarchyManager[s]. This class provides saving and loading
 * of the HierarchyManager from persistable storage.
 * @author Adam Franco
 * @version $$
 ******************************************************************************/


class MemoryOnlyManagerStore
	extends HierarchyManagerStore
{
	
	/**
	 * @var array $_hierarchies The hierarchies known to this manager.
	 */
	var $_hierarchies = array();

	/**
	 * Adds a hierachy to this managerStore.
	 * @param object HarmoniHierarchy $hierarchy The Hierarchy to add.
	 */
	function addHierarchy (& $hierarchy) {
		$this->hierarchies[] =& $hierarchy;
	}
	
	/**
	 * Returns an array of hierachies known to this managerStore.
	 * @return array The array of hierarchies.
	 */
	function getHierarchyArray () {
		return $this->_hierarchies;
	}

	/**
	 * Creates a new hierarchy store that will work in this manager's location.
	 * @return object HierarchyStore A HierarchyStore that will work in this manager's 
	 *				location.
	 */
	function createHierarchyStore () {
		$hierarchyStore =& new MemoryOnlyHierarchyStore;
		return $hierarchyStore;
	}

	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		// Do nothing as this store isn't saved
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		// Do nothing as this store isn't saved
	}

}
?>