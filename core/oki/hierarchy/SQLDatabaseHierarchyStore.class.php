<?php

require_once(HARMONI.'/oki/hierarchy/HierarchyStore.interface.php');
require_once(HARMONI.'/oki/shared/HarmoniSharedManager.class.php');
Services::registerService("Shared","HarmoniSharedManager");

/******************************************************************************
 * A storage wrapper for the Tree class
 *
 * 
 ******************************************************************************/


class SQLDatabaseHierarchyStore
	extends HierarchyStore
{

	/**
	 * @var integer $_dbIndex The index of the database from which to fetch the hierarchy
	 * 						and data.
	 */
	var $_dbIndex = 0;

	/**
	 * @var string $_hierarchyTableName The name of the db table from which to access this hierarchy.
	 */
	var $_hierarchyTableName = "hierarchy";

	/**
	 * @var string $_hierarchyIdColumn The name of the id column in the table.
	 */
	var $_hierarchyIdColumn = "id";

	/**
	 * @var string $_hierarchyDisplayNameColumn The name of the displayName column in the table.
	 */
	var $_hierarchyDisplayNameColumn = "display_name";
	
	/**
	 * @var string $_hierarchyDescriptionColumn The name of the description column in the table.
	 */
	var $_hierarchyDescriptionColumn = "description";

	/**
	 * @var string $_nodeTableName The name of the db table from which to access this hierarchy.
	 */
	var $_nodeTableName = "hierarchy_node";

	/**
	 * @var string $_nodeHierarchyKeyColumn The name of the hierarchy key column in the table.
	 */
	var $_nodeHierarchyKeyColumn = "fk_hierarchy";	

	/**
	 * @var string $_nodeIdColumn The name of the id column in the table.
	 */
	var $_nodeIdColumn = "id";

	/**
	 * @var string $_nodeParentKeyColumn The name of the parent key column in the table.
	 */
	var $_nodeParentKeyColumn = "lk_parent";

	/**
	 * @var string $_nodeDisplayNameColumn The name of the displayName column in the table.
	 */
	var $_nodeDisplayNameColumn = "display_name";
	
	/**
	 * @var string $_nodeDescriptionColumn The name of the description column in the table.
	 */
	var $_nodeDescriptionColumn = "description";

	/**
	 * @var integer $_maxDepth The maximum depth of this hierarchy.
	 */
	var $_maxDepth = 10;
	
	/**
	 * @var object Id $_id The id for this hierarchy.
	 */
	var $_id;
	
	/**
	 * @var string $_description The description for this hierarchy.
	 */
	var $_description;
	
	/**
	 * @var string $_displayName The description for this hierarchy.
	 */
	var $_displayName;
	
	/**
	 * @var object Tree $_tree A tree object.
	 */
	var $_tree = NULL;
	
	/**
	 * @var array $_added The ids of objects that have been added since they were 
	 *						loaded from persistable storage.
	 */
	var $_added = array();
	
	/**
	 * @var array $_changed The ids of objects that have been modified since they were 
	 *						loaded from persistable storage.
	 */
	var $_changed = array();

	/**
	 * @var array $_deleted The ids of objects that have been delete since they were 
	 *						loaded from persistable storage.
	 */
	var $_deleted = array();

	/**
	 * @var boolean $_isChanged True if the displayName, description, or type has been
	 * 						modified since the dr was loaded from persistable storage.
	 */
	var $_isChanged = FALSE;

	/**
	 * @var array $_nodeTypes Node types in this hierarchy.
	 */
	var $_nodeTypes = array();
	
	/**
	 * Constructor
	 *
	 * @param string $hierarchyId
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
	function SQLDatabaseHierarchyStore ($hierarchyId, $dbIndex, $hierarchyTableName, $hierarchyIdColumn, $hierarchyDisplayNameColumn, $hierarchyDescriptionColumn, $nodeTableName, $nodeHierarchyKeyColumn, $nodeIdColumn, $nodeParentKeyColumn, $nodeDisplayNameColumn, $nodeDescriptionColumn) {
		// Check the arguments
		ArgumentValidator::validate($hierarchyId, new NumericValidatorRule);
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
		
		$this->_id = $hierarchyId;
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
		
		$this->_tree =& new Tree;
		
		// Load without a nodeId will load the entire hirearchy. Instead of doing this, we will fetch data
		// as it is needed.
//		$this->load();
	}
	
	/**
	 * Initializes this Store. Loads any saved data for the hierarchy.
	 *
	 * @param object Id	$hierarchyId		The Id of the hierarchy that should be initialized.
	 * @param string 	$hierarchyDisplayName	The displayName, will be loaded from storage
	 *											if NULL.
	 * @param string	$hierarchyDescription	The description, will be loaded from storage
	 *											if NULL.
	 */
	function initialize() {
		$dbc =& Services::requireService("DBHandler");
		$sharedManager =& Services::requireService("Shared");
		
		// Pull the info for this hierarchy
		$query =& new SelectQuery;
		$query->addColumn($this->_hierarchyDisplayNameColumn,"displayName");
		$query->addColumn($this->_hierarchyDescriptionColumn,"description");
		$query->addTable($this->_hierarchyTableName);
		$query->addWhere($this->_hierarchyIdColumn."=".$this->_id);
		
		$result =& $dbc->query($query, $this->_dbIndex);
		
		if ($result->getNumberOfRows() > 1) { // we have problems.
			throwError(new Error("Loss of data integrity, multiple hierarchies of id, ".$this->_id.", found!", "Hierarchy", 1));
			
		} else if ($result->getNumberOfRows() == 1) { // The hierarchy exists
			$this->_exists = TRUE;
			$this->_displayName = $result->field("displayName");
			$this->_description = $result->field("description");
		} else {	// the hierarchy doesn't exist yet
			$this->_exists = FALSE;
		}
	}
	
	/**
	 * Loads this object from persistable storage.
	 * Existing nodes will not be overwritten.
	 *
	 * @param string $nodeId	The id of the node that needs to be updated. If 0 or NULL,
	 * 							then load() will load the entire hierarchy as needed.
	 * @access protected
	 */
	function load ($nodeId=0) {
		
		if ($nodeId !== NULL) {
			// Check the arguments
			ArgumentValidator::validate($nodeId, new NumericValidatorRule);
		}
		
		$dbc =& Services::requireService("DBHandler");
		$sharedManager =& Services::requireService("Shared");
		
		// This may be able to be droped if the hierarchy has been initialized, but it makes for a nice check
		// of data integrity.
		// Pull the info for this hierarchy
		$query =& new SelectQuery;
		$query->addColumn($this->_hierarchyDisplayNameColumn,"displayName");
		$query->addColumn($this->_hierarchyDescriptionColumn,"description");
		$query->addTable($this->_hierarchyTableName);
		$query->addWhere($this->_hierarchyIdColumn."=".$this->_id);
		
		$result =& $dbc->query($query, $this->_dbIndex);
		
		if ($result->getNumberOfRows() > 1) { // we have problems.
			throwError(new Error("Loss of data integrity, multiple hierarchies of id, ".$this->_id.", found!", "Hierarchy", 1));
			
		} else if ($result->getNumberOfRows() == 1) { // The hierarchy exists
			$this->_exists = TRUE;
			$this->_displayName = $result->field("displayName");
			$this->_description = $result->field("description");
		
			
			// build the query. To get trees, this could be broken into
			// two queries; one that fetched the parents, and one that fetched
			// the children rooted at this node with joins.

			// pull the parents of $nodeId if $nodeId is not a root node.
			if ($nodeId) {
				$query =& new SelectQuery;
				
				$query->addColumn($this->_nodeTableName."0.".$this->_nodeIdColumn,"id0");
				$query->addColumn($this->_nodeTableName."0.".$this->_nodeParentKeyColumn,"parent_id0");
				$query->addColumn($this->_nodeTableName."0.".$this->_nodeDisplayNameColumn,"displayName0");
				$query->addColumn($this->_nodeTableName."0.".$this->_nodeDescriptionColumn,"description0");
				
				$query->addTable($this->_nodeTableName, NO_JOIN, "", $this->_nodeTableName."0");
			
				$query->addWhere($this->_nodeTableName."0.".$this->_nodeHierarchyKeyColumn."=".$this->_id);
				$query->addWhere($this->_nodeTableName."0.".$this->_nodeIdColumn."=".$nodeId, _AND);

//				$query->addOrderBy($this->_nodeTableName."0.".$this->_nodeParentKeyColumn, ASCENDING);
//				$query->addOrderBy($this->_nodeTableName."0.".$this->_nodeIdColumn, ASCENDING);
				
				for ($i = 1; $i <= $this->_maxDepth; $i++) {
					$query->addTable($this->_nodeTableName, LEFT_JOIN, $this->_nodeTableName.($i-1).".".$this->_nodeParentKeyColumn."=".$this->_nodeTableName.($i).".".$this->_nodeIdColumn, $this->_nodeTableName.($i));
					$query->addColumn($this->_nodeTableName.$i.".".$this->_nodeIdColumn,"id".$i);
					$query->addColumn($this->_nodeTableName.$i.".".$this->_nodeParentKeyColumn,"parent_id".$i);
					$query->addColumn($this->_nodeTableName.$i.".".$this->_nodeDisplayNameColumn,"displayName".$i);
					$query->addColumn($this->_nodeTableName.$i.".".$this->_nodeDescriptionColumn,"description".$i);
				}
				
				$result =& $dbc->query($query, $this->_dbIndex);
				
//				print MySQL_SQLGenerator::generateSQLQuery($query);
				
				for ($i = $this->_maxDepth; $i > 0; $i--) {
					if ($result->field("id".$i)) { // this is a node and not a null join
						$id = $result->field("id".$i);
						$parent_id = $result->field("parent_id".$i);
						$displayName = $result->field("displayName".$i);
						$description = $result->field("description".$i);
				
						// If this node is not in the hierarchy, add it.
						if (!$this->_tree->nodeExists($id)) {
							// create the Id for the HarmoniNode object
							$nodeIdObj =& $sharedManager->getId($id);
				
							// create the HarmoniNode object
							$harmoniNode =& new HarmoniNode($nodeIdObj, $this, NULL, $displayName, $description);
							
							// the parentKey should be 0 if this is a root node, so addNode should work
							// always.
							// Add the node to the tree with HarmoniNode object as data
							$this->_tree->addNode($harmoniNode, $parent_id, $id);
//							print "Adding parent $id\n";
				//			$this->_tree->setData($harmoniNode, $id);
						}
					}
				}
			}

			// pull the sub-tree rooted at $nodeId
			$query =& new SelectQuery;
			
			$query->addColumn($this->_nodeTableName."0.".$this->_nodeIdColumn,"id");
			$query->addColumn($this->_nodeTableName."0.".$this->_nodeParentKeyColumn,"parent_id");
			$query->addColumn($this->_nodeTableName."0.".$this->_nodeDisplayNameColumn,"displayName");
			$query->addColumn($this->_nodeTableName."0.".$this->_nodeDescriptionColumn,"description");
			
			$query->addTable($this->_nodeTableName, NO_JOIN, "", $this->_nodeTableName."0");
			
			$query->addWhere($this->_nodeTableName."0.".$this->_nodeHierarchyKeyColumn."=".$this->_id);
			$query->addOrderBy($this->_nodeTableName."0.".$this->_nodeParentKeyColumn, ASCENDING);
			$query->addOrderBy($this->_nodeTableName."0.".$this->_nodeIdColumn, ASCENDING);
			
			$additionalWhere = array();
			for ($i = 0; $i <= $this->_maxDepth; $i++) {
				$query->addTable($this->_nodeTableName, LEFT_JOIN, $this->_nodeTableName.$i.".".$this->_nodeParentKeyColumn."=".$this->_nodeTableName.($i+1).".".$this->_nodeIdColumn, $this->_nodeTableName.($i+1));
				$additionalWhere[] = $this->_nodeTableName.$i.".".$this->_nodeIdColumn."=".$nodeId;
//				$additionalWhere[] = $this->_nodeTableName.$i.".".$this->_nodeParentKeyColumn."=".$nodeId;
			}
			if ($nodeId)
				$query->addWhere("(".implode(" OR ", $additionalWhere).")", _AND);
			
			$result =& $dbc->query($query, $this->_dbIndex);
	
	//		print_r($result);
	//		print MySQL_SQLGenerator::generateSQLQuery($query);
			
			// Build the tree from the results
			while ($result->hasMoreRows()) {
				$id = $result->field("id");
				$parent_id = $result->field("parent_id");
				$displayName = $result->field("displayName");
				$description = $result->field("description");
				
				// If this node is not in the hierarchy, add it.
				if (!$this->_tree->nodeExists($id)) {
					// create the Id for the HarmoniNode object
					$nodeIdObj =& $sharedManager->getId($id);
		
					// create the HarmoniNode object
					$harmoniNode =& new HarmoniNode($nodeIdObj, $this, NULL, $displayName, $description);
					
					// the parentKey should be 0 if this is a root node, so addNode should work
					// always.
					// Add the node to the tree with HarmoniNode object as data
					$this->_tree->addNode($harmoniNode, $parent_id, $id);
//					print "Adding $id\n";
		//			$this->_tree->setData($harmoniNode, $id);
				}
				
				$result->advanceRow();
			}
		
			// Since we've just loaded everything from the hierarchy, clear out the changed flags
/* 			$this->_added = array(); */
/* 			$this->_changed = array(); */
/* 			$this->_deleted = array(); */
/* 			$this->_isChanged = FALSE; */
			
		} else {	// the hierarchy doesn't exist yet
			$this->_exists = FALSE;
		}
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @param string $nodeId	The id of the node that has been modified and needs to 
	 * 							be updated. If 0 or NULL, the save will save the entire 
	 *							hierarchy as needed.
	 * @access protected
	 */
	function save ($nodeId=NULL) {
		if ($nodeId !== NULL) {
			// Check the arguments
			ArgumentValidator::validate($nodeId, new NumericValidatorRule);
		}
		
		$queryQueue =& new Queue;
		
		// Save any changes to the hierarchy properties
		if ($this->_isChanged) {
			$query =& new InsertQuery;
			$columns = array(
							$this->_hierarchyIdColumn,
							$this->_hierarchyDisplayNameColumn,
							$this->_hierarchyDescriptionColumn
						);
		}
		
		// Insert any new nodes
		if (count($this->_added)) {
			$query =& new InsertQuery;
			$columns = array(
				$this->_nodeIdColumn,
				$this->_nodeHierarchyKeyColumn,
				$this->_nodeParentKeyColumn,
				$this->_nodeDisplayNameColumn,
				$this->_nodeDescriptionColumn
			);
			$query->setColumns($columns);
			$query->setTable($this->_nodeTableName);
			
			// Add a row of values for each new node
			foreach ($this->_added as $key => $id) {
				$nodeObj =& $this->_tree->getData($id);
				$parentId = $this->_tree->getParentId($id);
				$displayName = $nodeObj->getDisplayName();
				$description = $nodeObj->getDescription();
				
				$values = array(
					$id,
					$this->_id,
					$parentId,
					"'".$displayName."'",
					"'".$description."'"					
				);
				$query->addRowOfValues($values);
			}
			
			$queryQueue->add($query);
		}
		
		// Save any changes to any nodes
		if (count($this->_changed)) {
			foreach ($this->_changed as $key => $id) {
				if (!in_array($id, $this->_added) && !in_array($id, $this->_deleted)) {
					$query =& new UpdateQuery;
					$query->setTable($this->_nodeTableName);
					$columns = array(
						$this->_nodeHierarchyKeyColumn,
						$this->_nodeParentKeyColumn,
						$this->_nodeDisplayNameColumn,
						$this->_nodeDescriptionColumn
					);
					$query->setColumns($columns);
					$values = array(
						$this->_id,
						$parentId,
						"'".$displayName."'",
						"'".$description."'"					
					);
					$query->setValues($values);
					$query->setWhere($this->_nodeIdColumn."=".$id);
				}
				
				$queryQueue->add($query);
			}
		}
		
		// Remove any deleted nodes
		if (count($this->_deleted)) {
			foreach ($this->_deleted as $key => $id) {
				$query =& new DeleteQuery;
				$query->setTable($this->_nodeTableName);
				$query->setWhere($this->_nodeIdColumn."=".$id);
				
				$queryQueue->add($query);
			}
		}
		
		// Run all of the queries
		$queryQueue->rewind();
		while ($queryQueue->hasNext()) {
			print MySQL_SQLGenerator::generateSQLQuery($queryQueue->next());
		}
		$queryQueue->rewind();
		
		// Since we've just saved everything in the hierarchy, clear out the changed flags
		$this->_added = array();
		$this->_changed = array();
		$this->_deleted = array();
		$this->_isChanged = FALSE;
	}

    /**
     * Get the unique Id for this Hierarchy.
     *
     * @return osid.shared.Id A unique Id that is usually set by a create
     *         method's implementation
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getId() {
		return $this->_id;
	}

    /**
     * Get the display name for this Hierarchy.
     *
     * @return String the display name
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDisplayName() {
		return $this->_displayName;
	}

    /**
     * Get the description for this Hierarchy.
     *
     * @return String the description
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDescription() {
		return $this->_description;
	}

    /**
     * Update the description for this Hierarchy.
     *
     * @param String description  Description cannot be null but may be empty.
     *
     * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   description is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDescription($description) {
		// Check the arguments
		ArgumentValidator::validate($description, new StringValidatorRule);
				
		// update and save
		$this->_description = $description;
		$this->_isChanged = TRUE;
	}

/******************************************************************************
 * below here are the methods of the Tree class
 ******************************************************************************/


	/**
    * Adds a node to the tree.
	* 
	* @param mixed   $data	The data that pertains to this node. This cannot contain
	*						objects. Use setData for objects.
	* @param integer $parentID Optional parent node ID
    */
	function addNode(&$data, $parentID=0, $id=0) {
		$this->_tree->addNode($data, $parentID, $id);
		if (!in_array($id,$this->_changed))
			$this->_added[] = $id;
	}

	/**
    * Removes the node with given id. All child
	* nodes are also removed.
	* 
	* @param integer $id Node ID
    */
	function removeNode($id) {
		if (!in_array($id,$this->_deleted))
			$this->_deleted[] = $id;
				
		$toDelete = $this->_tree->getFlatList($id);
		foreach ($toDelete as $deleteId) {
			if (!in_array($deleteId,$this->_deleted))
				$this->_deleted[] = $deleteId;
		}
		
		$this->_tree->removeNode($deleteId);
	}
	
	/**
    * Returns total number of nodes in the tree
	*
	* @return integer Number of nodes in the tree
    */
	function totalNodes() {
		return $this->_tree->totalNodes();
	}
	
	/**
    * Gets the data associated with the given
	* node ID.
	* 
	* @param  integer $id Node ID
	* @return mixed       The data
    */
	function & getData($id)	{
		return $this->_tree->getData($id);
	}
	
	/**
    * Sets the data associated with the given
	* node ID.
	* 
	* @param integer $id Node ID
    */
	function setData($id, & $data) {
		$this->_tree->setData($id, $data);
		if (!in_array($id,$this->_changed))
			$this->_changed[] = $id;
	}
	
	/**
    * Returns parent id of the node with
	* given id.
	* 
	* @param  integer $id Node ID
	* @return integer     The parent ID
    */
	function getParentID($id) {
		return $this->_tree->getParentID($id);
	}
	
	/**
    * Returns the depth in the tree of the node with
	* the supplied id. This is a zero based indicator,
	* so root nodes will have a depth of 0 (zero).
	*
	* @param  integer $id Node ID
	* @return integer     The depth of the node
    */
	function depth($id) {
		return $this->_tree->depth($id);
	}
	
	/**
    * Returns true/false as to whether the node with given ID is a child
	* of the given parent node ID.
	*
	* @param  integer $id       Node ID
	* @param  integer $parentID Parent node ID
	* @return bool              Whether the ID is a child of the parent ID
    */
	function isChildOf($id, $parentID) {
		return $this->_tree->isChildOf($id, $parentID);
	}
	
	/**
    * Returns true or false as to whether the node
	* with given ID has children or not. Give 0 as
	* the id to determine if there are any root nodes.
	* 
	* @param  integer $id Node ID
	* @return bool        Whether the node has children
    */
	function hasChildren($id) {
		return $this->_tree->hasChildren($id);
	}
	
	/**
    * Returns the number of children the given node ID
	* has.
	* 
	* @param  integer $id Node ID
	* @return integer     Number of child nodes
    */
	function numChildren($id) {
		return $this->_tree->numChildren($id);
	}
	
	/**
    * Returns an array of the child node IDs pertaining
	* to the given id. Returns an empty array if there
	* are no children.
	* 
	* @param  integer $id Node ID
	* @return array       The child node IDs
    */
	function getChildren($id) {
		return $this->_tree->getChildren($id);
	}
	
	/**
    * Moves all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function moveChildrenTo($parentID, $newParentID) {
		$childIds = $this->_tree->getChildren($parentID);
		foreach ($childIds as $key => $id) {
			if (!in_array($id, $this->_changed))
				$this->_changed[] = $id;
		}
		
		$this->_tree->moveChildrenTo($parentID, $newParentID);
	}
	
	/**
    * Copies all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function copyChildrenTo($parentID, $newParentID) {
		$existingChildIds = $this->_tree->getChildren($newParentID);
	
		$this->_tree->copyChildrenTo($parentID, $newParentID);
		
		$childIds = $this->_tree->getChildren($newParentID);
		foreach ($childIds as $key => $id) {
			if (!in_array($id, $this->_added) && !in_array($id, $existingChildIds))
				$this->_added[] = $id;
		}
	}
	
	/**
    * Returns the ID of the previous sibling to the node
	* with the given ID, or null if there is no previous
	* sibling.
	* 
	* @param  integer $id Node ID
	* @return integer     The previous sibling ID
    */
	function prevSibling($id) {
		return $this->_tree->prevSibling($id);
	}
	
	/**
    * Returns the ID of the next sibling to the node
	* with the given ID, or null if there is no next
	* sibling.
	* 
	* @param  integer $id Node ID
	* @return integer     The next sibling ID
    */
	function nextSibling($id) {
		return $this->_tree->nextSibling($id);
	}
	
	/**
    * Moves a node to a new parent. The node being
	* moved keeps it child nodes (they move with it
	* effectively).
	*
	* @param integer $id       Node ID
	* @param integer $parentID New parent ID
    */
	function moveTo($id, $parentID) {
		$this->_tree->moveTo($id, $parentID);
		if (!in_array($id, $this->_changed))
			$this->_changed[] = $id;
	}
	
	/**
    * Copies this node to a new parent. This copies the node
	* to the new parent node and all its child nodes (ie
	* a deep copy). Technically, new nodes are created with copies
	* of the data, since this is for all intents and purposes
	* the only thing that needs copying.
	*
	* @param integer $id       Node ID
	* @param integer $parentID New parent ID
    */
	function copyTo($id, $parentID) {
		$existingChildIds = $this->_tree->getChildren($parentID);

		$this->_tree->copyTo($id, $parentID);

		$childIds = $this->_tree->getChildren($parentID);
		foreach ($childIds as $key => $id) {
			if (!in_array($id, $this->_added) && !in_array($id, $existingChildIds))
				$this->_added[] = $id;
		}		
	}
	
	/**
    * Returns the id of the first node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer           The node ID
    */
	function firstNode($parentID = 0) {
		return $this->_tree->firstNode($parentID);
	}
	
	/**
    * Returns the id of the last node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer The node ID
    */
	function lastNode($parentID = 0) {
		return $this->_tree->lastNode($parentID);
	}
	
	/**
    * Returns the number of nodes in the tree, optionally
	* starting at (but not including) the supplied node ID.
	*
	* @param  integer $id The node ID to start at
	* @return integer     Number of nodes
    */
	function getNodeCount($id = 0) {
		return $this->_tree->getNodeCount($id);
	}
    
    /**
    * Returns a flat list of the nodes, optionally beginning at the given
	* node ID.
    *
    * @return array Flat list of the node IDs from top to bottom, left to right.
    */
    function getFlatList($id = 0) {
		return $this->_tree-> getFlatList($id);
	}

    /**
    * Traverses the tree applying a function to each and every node.
    * The function name given (though this can be anything you can supply to 
    * call_user_func(), not just a name) should take two arguments. The first
	* is this tree object, and the second is the ID of the current node. This
	* way you can get the data for the nodes in your function by doing
	* $tree->getData($id). The traversal goes from top to bottom, left to right
    * (ie same order as what you get from getFlatList()).
    *
    * @param callback $function The callback function to use
    */
    function traverse($function) {
		$this->_tree->traverse($function);
    }

	/**
    * Searches the node collection for a node with a tag matching
	* what you supply. This is a simply "tag == your data" comparison, (=== if strict option is applied)
	* and more advanced comparisons can be made using the traverse() method.
	* This function returns null if nothing is found, and the first node ID found if a match is made.
	*
	* @param  mixed $data   Data to try to find and match
	* @param  mixed $strict Whether to use === or simply == to compare
	* @return mixed         Null if no match or the first node ID if a match is made
    */
	function &search(& $data, $strict = false) {
		return $this->_tree->search($data, $strict);
	}

	/**
    * Returns whether or not a node of the supplied id exists in the tree.
	*
	* @author Adam Franco <adam@adamfranco.com>
	* @since 2003-10-01
	*
	* @param  integer $id The node ID to look for
	* @return boolean     True if the node exists in the tree.
    */	
	function nodeExists($id) {
		return $this->_tree->nodeExists($id);
	}
	
	/**
    * Returns a list (array) of nodes after traversal.
	*
	* @author Adam Franco <adam@adamfranco.com>
	* @since 2003-10-02
	*
	* @param	string	$id 	The starting node's id
	* @param	integer	$levels	The number of levels to traverse. 
	*							NULL for infinate, 1 for the currentNode only, 2 for the current
	*							node and its children.
	* @return	array			An array of the resulting ids
	*/
	function depthFirstEnumeration($currentId, $levels = NULL) {
		return $this->_tree->depthFirstEnumeration($currentId, $levels);
	}

}
?>