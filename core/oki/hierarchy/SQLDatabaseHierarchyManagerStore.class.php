<?php

require_once(HARMONI."oki/hierarchy/HierarchyManagerStore.interface.php");
require_once(HARMONI."oki/hierarchy/SQLDatabaseHierarchyStore.class.php");

/**
 * A storage class for HierarchyManager[s]. This class provides saving and loading
 * of the HierarchyManager from persistable storage.
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLDatabaseHierarchyManagerStore.class.php,v 1.6 2005/01/19 22:28:09 adamfranco Exp $
 */


class SQLDatabaseHierarchyManagerStore
	extends HierarchyManagerStore
{

	/**
	 * @var array $_changed The ids of objects that have been modified since they were 
	 *						loaded from persistable storage.
	 */
	var $_hierarchies = array();

	/**
	 * Constructor
	 *
	 * @param integer $dbIndex	The index of the database from which to pull this hierarchy.
	 *
	 * @param string $hierarchyTableName	The table from which to pull this hierarchy.
	 * @param string $hierarchyIdColumn	The id column.
	 * @param string $hierarchyDisplayNameColumn	The displayName column.
	 * @param string $hierarchyDescriptionColumn	The description column.
	 *
	 * @param string $nodeTableName	The table from which to pull this hierarchy.
	 * @param string $nodeHierarchyKeyColumn	The hierarchy key column.
	 * @param string $nodeIdColumn	The id column.
	 * @param string $nodeParentKeyColumn	The parent key column.
	 * @param string $nodeDisplayNameColumn	The displayName column.
	 * @param string $nodeDescriptionColumn	The description column.
	 */
	function SQLDatabaseHierarchyManagerStore ($dbIndex, $hierarchyTableName, $hierarchyIdColumn, $hierarchyDisplayNameColumn, $hierarchyDescriptionColumn, $nodeTableName, $nodeHierarchyKeyColumn, $nodeIdColumn, $nodeParentKeyColumn, $nodeDisplayNameColumn, $nodeDescriptionColumn) {
		// Check the arguments
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule);
		ArgumentValidator::validate($hierarchyTableName, new StringValidatorRule);
		ArgumentValidator::validate($hierarchyIdColumn, new StringValidatorRule);
		ArgumentValidator::validate($hierarchyDisplayNameColumn, new StringValidatorRule);
		ArgumentValidator::validate($hierarchyDescriptionColumn, new StringValidatorRule);
		ArgumentValidator::validate($nodeTableName, new StringValidatorRule);
		ArgumentValidator::validate($nodeHierarchyKeyColumn, new StringValidatorRule);
		ArgumentValidator::validate($nodeIdColumn, new StringValidatorRule);
		ArgumentValidator::validate($nodeParentKeyColumn, new StringValidatorRule);
		ArgumentValidator::validate($nodeDisplayNameColumn, new StringValidatorRule);
		ArgumentValidator::validate($nodeDescriptionColumn, new StringValidatorRule);
		
		$this->_dbIndex = $dbIndex;
		$this->_hierarchyTableName = $hierarchyTableName;
		$this->_hierarchyIdColumn = $hierarchyIdColumn;
		$this->_hierarchyDisplayNameColumn = $hierarchyDisplayNameColumn;
		$this->_hierarchyDescriptionColumn = $hierarchyDescriptionColumn;
		$this->_nodeTableName = $nodeTableName;
		$this->_nodeHierarchyKeyColumn = $nodeHierarchyKeyColumn;
		$this->_nodeIdColumn = $nodeIdColumn;
		$this->_nodeParentKeyColumn = $nodeParentKeyColumn;
		$this->_nodeDisplayNameColumn = $nodeDisplayNameColumn;
		$this->_nodeDescriptionColumn = $nodeDescriptionColumn;
		
		$this->_hierarchies = array();
		
//		$this->load();
	}
	
	/**
	 * Adds a hierachy to this managerStore.
	 * @param object HarmoniHierarchy $hierarchy The Hierarchy to add.
	 */
	function addHierarchy (& $hierarchy) {
		// Check the arguments
		ArgumentValidator::validate($hierarchy, new ExtendsValidatorRule("Hierarchy"));
		
		$hierarchyId =& $hierarchy->getId();
		
		// Throw an error if we already have this hierarchy.
		if(in_array($hierarchyId->getIdString(),$this->_hierarchies))
			throwError(new Error(ALREADY_ADDED, "Hierarchy", 1));
		
		$this->_hierarchies[$hierarchyId->getIdString()] =& $hierarchy;
	}

	/**
	 * Deletes a hierachy from this managerStore.
	 * @param object Id $hierarchyId The Id of the Hierarchy to delete.
	 */
	function deleteHierarchy (& $hierarchyId) {
		// Check the arguments
		ArgumentValidator::validate($hierarchyId, new ExtendsValidatorRule("Id"));
		
		$hierarchyIdString = $hierarchyId->getIdString();
		$hierarchy =& $this->_hierarchies[$hierarchyIdString];
		
		// Make sure that the hierarchy is loaded and doesn't have any nodes
		$hierarchy->load();
		$nodeIterator =& $hierarchy->getAllNodes();
		if ($nodeIterator->hasNext())
			throwError(new Error(HIERARCHY_NOT_EMPTY, "Hierarchy", 1));
		
		$dbc =& Services::requireService("DBHandler");
		$query =& new DeleteQuery;
		$query->setTable($this->_hierarchyTableName);
		$query->setWhere($this->_hierarchyIdColumn."=".$hierarchyIdString);
		
//		print MySQL_SQLGenerator::generateSQLQuery($query);
		
		$result =& $dbc->query($query, $this->_dbIndex);
		
		unset($this->_hierarchies[$hierarchyIdString]);
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
		$store =& new SQLDatabaseHierarchyStore($this->_dbIndex, $this->_hierarchyTableName, 
						$this->_hierarchyIdColumn, $this->_hierarchyDisplayNameColumn,
						$this->_hierarchyDescriptionColumn, $this->_nodeTableName, $this->_nodeHierarchyKeyColumn,
						$this->_nodeIdColumn, $this->_nodeParentKeyColumn, $this->_nodeDisplayNameColumn, 
						$this->_nodeDescriptionColumn);
		return $store;
	}
	
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		$dbc =& Services::requireService("DBHandler");
		$sharedManager =& Services::requireService("Shared");
		
		// Pull the info for the hierarchies.
		$query =& new SelectQuery;
		$query->addColumn($this->_hierarchyIdColumn,"id");
		$query->addColumn($this->_hierarchyDisplayNameColumn,"displayName");
		$query->addColumn($this->_hierarchyDescriptionColumn,"description");
		$query->addTable($this->_hierarchyTableName);
		
		$result =& $dbc->query($query, $this->_dbIndex);
		
		while ($result->hasMoreRows()) {
			$id = intval($result->field("id"));
			$displayName = $result->field("displayName");
			$description = $result->field("description");
			
			if (!in_array($id, $this->_hierarchies)) {
				$hierarchyStore =& $this->createHierarchyStore();
				$hierarchyId =& $sharedManager->getId($id);
				$nodeTypes = array();
				$hierarchy =& new HarmoniHierarchy($hierarchyId, $displayName, $description, $nodeTypes, $hierarchyStore, TRUE);
				$this->_hierarchies[$id] =& $hierarchy;
			}
			
			$result->advanceRow();
		}
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		foreach ($this->_hierarchies as $key => $val) {
			$this->_hierarchies[$key]->save();
		}
	}

}
?>