<?php

require_once(HARMONI.'/oki/hierarchy/HierarchyStore.interface.php');
require_once(HARMONI.'/oki/hierarchy/Tree.php');
require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchy.class.php');
require_once(HARMONI.'/oki/shared/HarmoniSharedManager.class.php');

/**
 * A storage wrapper for the Tree class
 *
 * @package harmoni.osid.hierarchy
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: SQLDatabaseHierarchyStore.class.php,v 1.15 2004/04/27 19:48:38 adamfranco Exp $
 */


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
	var $_maxDepth = 14;
	
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
	 * @var boolean $_exists True if the hierarchy exists in persistable storage.
	 */
	var $_exists = FALSE;

	/**
	 * @var array $_nodeTypes Node types in this hierarchy.
	 *		This is an associative array of Type objects with the database id of 
	 *		the node type as the key.
	 */
	var $_nodeTypes = array();
	
	/**
	 * @var array $_newNodeTypes Node types to be saved in the hierarchy.
	 *		These should be an indexed array of Type objects. When they are saved they 
	 *		will be given ids and put into the _nodeTypes array.
	 */
	var $_newNodeTypes = array();
	
	/**
	 * @var array $_deletedNodeTypes Node types to be removed from the hierarchy.
	 *		These should be an associative array with the database ids of the node 
	 *		types to delete as the keys.
	 */
	var $_deletedNodeTypes = array();
	
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
	function SQLDatabaseHierarchyStore ($dbIndex, 
			$hierarchyTableName = "hierarchy", $hierarchyIdColumn = "id", 
			$hierarchyDisplayNameColumn = "display_name", $hierarchyDescriptionColumn = "description", 
			$nodeTableName = "hierarchy_node", $nodeHierarchyKeyColumn = "fk_hierarchy", 
			$nodeIdColumn = "id", $nodeParentKeyColumn = "fk_parent", 
			$nodeDisplayNameColumn = "display_name", $nodeDescriptionColumn = "description",
			$nodeTypeKeyColumn = "fk_nodetype",
			$typeTableName = "hierarchy_nodetype", $typeHierarchyKeyColumn = "fk_hierarchy",
			$typeIdColumn = "id", $typeDomainColumn = "domain", $typeAuthorityColumn = "authority",
			$typeKeywordColumn = "keyword", $typeDescriptionColumn = "description") {
			
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
		$this->_nodeTypeKeyColumn = $nodeTypeKeyColumn;
		
		$this->_typeTableName = $typeTableName;
		$this->_typeHierarchyKeyColumn = $typeHierarchyKeyColumn;
		$this->_typeIdColumn = $typeIdColumn;
		$this->_typeDomainColumn = $typeDomainColumn;
		$this->_typeAuthorityColumn = $typeAuthorityColumn;
		$this->_typeKeywordColumn = $typeKeywordColumn;
		$this->_typeDescriptionColumn = $typeDescriptionColumn;
		
		$this->_tree =& new Tree;
		
		// Load without a nodeId will load the entire hirearchy. Instead of doing this, we will fetch data
		// as it is needed.
//		$this->load();
	}

	/**
	 * Initializes this Store. Loads any saved data for the hierarchy.
	 * @deprecated Use set exists instead
	 */
	function initialize() {
		throwError(new Error("Manager should handle the existance state. Use setExists() to set the current existance", "Hierarchy", 1));
	}
	
    /**
     * Set the existence state
     *
     * @param boolean $exists True if the hierarchy exists in persistable storage.
	 */
	function setExists($exists) {
		// Check the arguments
		ArgumentValidator::validate($exists, new BooleanValidatorRule);
		
		$this->_exists = $exists;
	}

	/**
	 * Loads this object from persistable storage.
	 * Existing nodes will not be overwritten.
	 *
	 * @param string $nodeId	The id of the node that needs to be updated. If 0 or NULL,
	 * 							then load() will load the entire hierarchy as needed.
	 * @param boolean $childrenOnly Set to true if it is wished only to load the children
	 *					of the specified node and not the grandchildren, etc.
	 * 
	 * @access protected
	 */
	function load ($nodeId=0, $childrenOnly=FALSE) {
		// Check the arguments
		ArgumentValidator::validate($childrenOnly, new BooleanValidatorRule);
		if ($nodeId !== NULL)
			ArgumentValidator::validate($nodeId, new NumericValidatorRule);
		
		$dbc =& Services::requireService("DBHandler");
		$sharedManager =& Services::requireService("Shared");
		
		// This may be able to be droped if the hierarchy has been initialized, but it makes for a nice check
		// of data integrity.
		// Pull the info for this hierarchy if it doesn't already exist.
		if (!$this->_exists) {
			$query =& new SelectQuery;
			$query->addColumn($this->_hierarchyDisplayNameColumn,"displayName");
			$query->addColumn($this->_hierarchyDescriptionColumn,"description");
			$query->addTable($this->_hierarchyTableName);
			$query->addWhere($this->_hierarchyIdColumn."=".$this->_id->getIdString());
			
			$result =& $dbc->query($query, $this->_dbIndex);
			$existingHierarchiesWithThisId = $result->getNumberOfRows();
			
			if ($existingHierarchiesWithThisId > 1) { // we have problems.
				throwError(new Error("Loss of data integrity, multiple hierarchies of id, ".$this->_id->getIdString().", found!", "Hierarchy", 1));
				
			} else if ($existingHierarchiesWithThisId == 1) { // The hierarchy exists
				$this->_exists = TRUE;
				$this->_displayName = stripslashes($result->field("displayName"));
				$this->_description = stripslashes($result->field("description"));
			} else {
				$this->_exists = FALSE;
			}
		}
		
		// If this hierarchy exists in the database, lets load it.
		if ($this->_exists) {
		
			// get all the types for this hierarchy
			$query =& new SelectQuery;
			$query->addColumn($this->_typeIdColumn,"id");
			$query->addColumn($this->_typeDomainColumn,"domain");
			$query->addColumn($this->_typeAuthorityColumn,"authority");
			$query->addColumn($this->_typeKeywordColumn,"keyword");
			$query->addColumn($this->_typeDescriptionColumn,"description");
			$query->addTable($this->_typeTableName);
			$query->addWhere($this->_typeHierarchyKeyColumn."=".$this->_id->getIdString());
			
			$result =& $dbc->query($query, $this->_dbIndex);
			
			$this->_nodeTypes = array();
			while ($result->hasMoreRows()) {
				$id = intval($result->field("id"));
				$domain = stripslashes($result->field("domain"));
				$authority = stripslashes($result->field("authority"));
				$keyword = stripslashes($result->field("keyword"));
				$description = stripslashes($result->field("description"));
				
				$this->_nodeTypes[$id] =& new HarmoniType($domain, $authority, $keyword, $description);
				
				$result->advanceRow();
			}
					
			// pull the sub-tree rooted at $nodeId
			// Actually, we are just going to pull the whole hierarchy for now.
			// Later, maybe we should just pull the tree with the same root node as
			// $nodeId
					
			$query =& new SelectQuery;
			
			$query->addColumn($this->_nodeTableName.".".$this->_nodeIdColumn,"id");
			$query->addColumn($this->_nodeTableName.".".$this->_nodeParentKeyColumn,"parent_id");
			$query->addColumn($this->_nodeTableName.".".$this->_nodeDisplayNameColumn,"displayName");
			$query->addColumn($this->_nodeTableName.".".$this->_nodeDescriptionColumn,"description");
			$query->addColumn($this->_nodeTableName.".".$this->_nodeTypeKeyColumn,"type_id");
			
			$query->addTable($this->_nodeTableName, NO_JOIN, "", $this->_nodeTableName);
			
			$query->addWhere($this->_nodeTableName.".".$this->_nodeHierarchyKeyColumn."=".$this->_id->getIdString());
			$query->addOrderBy($this->_nodeTableName.".".$this->_nodeParentKeyColumn, ASCENDING);
			$query->addOrderBy($this->_nodeTableName.".".$this->_nodeIdColumn, ASCENDING);
			
			$result =& $dbc->query($query, $this->_dbIndex);
	
	//		print_r($result);
	//		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
			
			// Build the tree from the results
			while ($result->hasMoreRows()) {
				$id = intval($result->field("id"));
				$parent_id = intval($result->field("parent_id"));
				$displayName = stripslashes($result->field("displayName"));
				$description = stripslashes($result->field("description"));
				$type_id = intval($result->field("type_id"));
				
				// If this node is not in the hierarchy, add it.
				if (!$this->_tree->nodeExists($id)) {
					// create the Id for the HarmoniNode object
					$nodeIdObj =& $sharedManager->getId($id);
					
					// create a type object for the Node
					if ($type_id) {
						$type =& $this->_nodeTypes[$type_id];
					} else {
						$type =& new GenericNodeType;
					}
					
					// create the HarmoniNode object
					$harmoniNode =& new HarmoniNode($nodeIdObj, $this, $type, $displayName, $description);
					
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
		// connect to the database
		$dbc =& Services::requireService("DBHandler");
	
		if ($nodeId !== NULL) {
			// Check the arguments
			ArgumentValidator::validate($nodeId, new NumericValidatorRule);
		}
		
//		printpre($this);
		
		$queryQueue =& new Queue;
		
		// Save any changes to the hierarchy properties
		if (!$this->_exists) {
			$query =& new InsertQuery;
			$columns = array(
							$this->_hierarchyIdColumn,
							$this->_hierarchyDisplayNameColumn,
							$this->_hierarchyDescriptionColumn
						);
			$query->setColumns($columns);
			$values = array(
							$this->_id->getIdString(),
							"'".addslashes($this->_displayName)."'",
							"'".addslashes($this->_description)."'"
						);
			$query->setTable($this->_hierarchyTableName);
			$query->addRowOfValues($values);
			
			$queryQueue->add($query);
			
		} else if ($this->_isChanged && $this->_exists) {
			$query =& new UpdateQuery;
			$columns = array(
							$this->_hierarchyIdColumn,
							$this->_hierarchyDisplayNameColumn,
							$this->_hierarchyDescriptionColumn
						);
			$query->setColumns($columns);
			$values = array(
							$this->_id->getIdString(),
							"'".addslashes($this->_displayName)."'",
							"'".addslashes($this->_description)."'"
						);
			$query->setValues($values);
			$query->setTable($this->_hierarchyTableName);
			$query->setWhere($this->_hierarchyIdColumn."=".$this->_id->getIdString());
			$queryQueue->add($query);
		}
		
		// Insert any new types. After inserting them, add them to the _nodeTypes 
		// array with their new ids. 
		if (count($this->_newNodeTypes)) {
			foreach($this->_newNodeTypes as $key => $type) {
				// Insert this node type.
				$query =& new InsertQuery;
				$query->setTable($this->_typeTableName);
				$columns = array(
								$this->_typeHierarchyKeyColumn,
								$this->_typeAuthorityColumn,
								$this->_typeDomainColumn,
								$this->_typeKeywordColumn,
								$this->_typeDescriptionColumn
							);
				$query->setColumns($columns);
				$values = array(
							$this->_id->getIdString(),
							"'".addslashes($type->getAuthority())."'",
							"'".addslashes($type->getDomain())."'",
							"'".addslashes($type->getKeyword())."'",
							"'".addslashes($type->getDescription())."'"
						);
				$query->addRowOfValues($values);
				$result =& $dbc->query($query, $this->_dbIndex);
				$id = $result->getLastAutoIncrementValue();
				
				// Move this node type to the _nodeTypes array with its new id.
				// The _newNodeTypes array will be cleared at the end.
				$this->_nodeTypes[$id] =& $this->_newNodeTypes[$key];
			}
			
			// Clear out the _newNodeTypes array();
			$this->_newNodeTypes = array();
		}
		
		// Remove any deleted node types.
		// Checking as to whether these are in use or not should have been
		// handled by the remove node functions. If a node is referencing this
		// type, then it should be in line for deletion below.
		if (count($this->_deletedNodeTypes)) {
			// Create the delete Query
			$query =& new DeleteQuery;
			$query->setTable($this->_typeTableName);
			// Add the key for each type to delete.
			foreach($this->_deletedNodeTypes as $key => $type) {
				$query->addWhere($this->_typeIdColumn."=".$key, _OR);
			}
			// Run the Query
			$result =& $dbc->query($query, $this->_dbIndex);
			
			// Clear out the _deletedNodeTypes array();
			$this->_deletedNodeTypes = array();
		}
		
		// Insert any new nodes
		if (count($this->_added)) {
			$query =& new InsertQuery;
			$columns = array(
				$this->_nodeIdColumn,
				$this->_nodeHierarchyKeyColumn,
				$this->_nodeParentKeyColumn,
				$this->_nodeDisplayNameColumn,
				$this->_nodeDescriptionColumn,
				$this->_nodeTypeKeyColumn
			);
			$query->setColumns($columns);
			$query->setTable($this->_nodeTableName);
			
			// Add a row of values for each new node
			foreach ($this->_added as $key => $id) {
				// ---- Database access ----
				// if added - will be inserted
				// if changed - will be updated
				// if deleted - will be deleted
				// if added and changed - will be inserted
				// if changed and deleted - will be deleted
				// if added and deleted - no database calls
				// if added and changed and deleted - no database calls
				
				if (!in_array($id, $this->_deleted)) {
					$nodeObj =& $this->_tree->getData($id);
					$parentId = $this->_tree->getParentId($id);
					$displayName = $nodeObj->getDisplayName();
					$description = $nodeObj->getDescription();
					
					// Get the key of the type for this node.
					// It should be in the _nodeTypes array and should be
					// inserted by this point.
					$nodeType =& $nodeObj->getType();
					$nodeTypeKey = FALSE;
					foreach ($this->_nodeTypes as $key => $type) {
						if ($nodeType->isEqual($type))
							$nodeTypeKey = $key;
					}
					// make sure that we got a valid key.
					if (!$nodeTypeKey)
						throwError(new Error("Invalid NodeType key for node '$displayName'.", "Hierarchy", 1));
					
					$values = array(
						$id,
						$this->_id->getIdString(),
						$parentId,
						"'".addslashes($displayName)."'",
						"'".addslashes($description)."'",
						$nodeTypeKey
					);
					$query->addRowOfValues($values);
				}
			}
			
			$queryQueue->add($query);
		}
		
		// Save any changes to any nodes
		if (count($this->_changed)) {
			foreach ($this->_changed as $key => $id) {
				// ---- Database access ----
				// if added - will be inserted
				// if changed - will be updated
				// if deleted - will be deleted
				// if added and changed - will be inserted
				// if changed and deleted - will be deleted
				// if added and deleted - no database calls
				// if added and changed and deleted - no database calls
				
				$nodeObj =& $this->_tree->getData($id);
				$parentId = $this->_tree->getParentId($id);
				$displayName = $nodeObj->getDisplayName();
				$description = $nodeObj->getDescription();
				
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
						$this->_id->getIdString(),
						$parentId,
						"'".addslashes($displayName)."'",
						"'".addslashes($description)."'"					
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
				// ---- Database access ----
				// if added - will be inserted
				// if changed - will be updated
				// if deleted - will be deleted
				// if added and changed - will be inserted
				// if changed and deleted - will be deleted
				// if added and deleted - no database calls
				// if added and changed and deleted - no database calls
				if (!in_array($id, $this->_added)) {
					$query =& new DeleteQuery;
					$query->setTable($this->_nodeTableName);
					$query->setWhere($this->_nodeIdColumn."=".$id);
				
					$queryQueue->add($query);
				}
			}
		}
		
/* 		$queryQueue->rewind(); */
/* 		while ($queryQueue->hasNext()) { */
/* 			print MySQL_SQLGenerator::generateSQLQuery($queryQueue->next()); */
/* 		} */
		
		// Run all of the queries
		$queryQueue->rewind();
		$result =& $dbc->queryQueue($queryQueue, $this->_dbIndex);
		
		// Since we've just saved everything in the hierarchy, clear out the changed flags
		$this->_added = array();
		$this->_changed = array();
		$this->_deleted = array();
		$this->_isChanged = FALSE;
	}

    /**
     * Get the unique Id for this Hierarchy.
     *
     * @return object osid.shared.Id A unique Id that is usually set by a create
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
     * Set the unique Id for this Hierarchy.
     *
     * @param object osid.shared.Id A unique Id that is usually set by a create
     *         method's implementation
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function setId(& $id) {
		// Check the arguments
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		
		$this->_id =& $id;
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
     * Update the displayName for this Hierarchy.
     *
     * @param String displayName  displayName cannot be null but may be empty.
     *
     * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   displayName is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updatedisplayName($displayName) {
		// Check the arguments
		ArgumentValidator::validate($displayName, new StringValidatorRule);
				
		// update and save
		$this->_displayName = $displayName;
		$this->_isChanged = TRUE;
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
	
	/**
	 * Returns all of the Node Types in this hierarchy.
	 * 
	 * @return array An array of all of the NodeTypes known.
	 */
	function getNodeTypes () {
		$types =& array_merge($this->_nodeTypes, $this->_newNodeTypes);
		return $types;
	}
	
	/**
	 * Adds a node type.
	 * Checking that this node type does not already exist should already be done.
	 * 
	 * @param object Type $nodeType The nodeType to add.
	 */
	function addNodeType (& $nodeType) {
		$this->_newNodeTypes[] =& $nodeType;
	}
	
	/**
	 * Removes a node type.
	 * Checking that this node type is not in use should already have been done.
	 * 
	 * @param object Type $nodeType The nodeType to remove.
	 */
	function removeNodeType(& $nodeType) {
		$newNodeTypes = array();
		$found = FALSE;
		foreach ($this->_nodeTypes as $key => $val) {
			// if it is the type we are removing, add it to the _deletedNodeTypes array,
			// otherwise add it to the new array.			
			if ($nodeType->isEqual($this->_nodeTypes[$key])) {
				$this->_deletedNodeTypes[$key] =& $this->_nodeTypes[$key];
				$found = TRUE;
			} else
				$newNodeTypes[$key] =& $this->_nodeTypes[$key];
		}
		
		// Make sure we found the type to delete.
		if (!$found)
			throwError(new Error(NODE_TYPE_NOT_FOUND, "Hierarchy", 1));
		
		$this->_nodeTypes =& $newNodeTypes;
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
			
		// if we deleted this node and are adding it back in, remove it from the deleted array
		if (in_array($id,$this->_deleted)) {
			$newDeleted = array();
			foreach ($this->_deleted as $deletedId) {
				if ($deletedId != $id)
					$newDeleted[] = $deletedId;
			}
			$this->_deleted =& $newDeleted;
		}
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
		
		$this->_tree->removeNode($id);
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		if (!$this->nodeExists($id))
//			$this->load($id);

		return $this->_tree->getData($id);
	}
	
	/**
    * Sets the data associated with the given
	* node ID.
	* 
	* @param integer $id Node ID
    */
	function setData($id, & $data) {
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		if (!$this->nodeExists($id))
//			$this->load($id);
			
		$this->_tree->setData($id, $data);
		if (!in_array($id,$this->_changed))
			$this->_changed[] = $id;
	}
	
	/**
    * Specifies if the node $id has been changed.
	* 
	* @param integer $id Node ID
    */
	function flagChanged($id) {
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		if (!in_array($id, $this->_changed) && !in_array($id, $this->_added) && !in_array($id, $this->_deleted))
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		if (!$this->nodeExists($id))
//			$this->load($id);
			
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		if (!$this->nodeExists($id))
//			$this->load($id);
			
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		if (!$this->nodeExists($id))
//			$this->load($id);
			
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		if (!$this->nodeExists($id))
//			$this->load($id);
			
		$hasChildren = $this->_tree->hasChildren($id);
		
		// If this doesn't have children, they may have just not been loaded.
		if (!$hasChildren) {
			// There is a chance that not all of the children have been loaded.
			// For instance, two of four children could have been loaded, each of which
			// is added as this node's child. Without load() being called with this node's id,
			// some children might be missing. This could cause significant slowdown if used
			// too much though.
			// For now we will leave it up to the application to call load() on what it needs
//			$this->load($id);
		}
		
		$hasChildren = $this->_tree->hasChildren($id);
		
		return $hasChildren;
	}
	
	/**
    * Returns the number of children the given node ID
	* has.
	* 
	* @param  integer $id Node ID
	* @return integer     Number of child nodes
    */
	function numChildren($id) {
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		$this->load($id);
		
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		$this->load($id);
		
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
		// Check the arguments
		ArgumentValidator::validate($parentID, new NumericValidatorRule);
		ArgumentValidator::validate($newParentID, new NumericValidatorRule);

		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		$this->load($parentID);
		
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
		throwError(new Error("This should be handled on the program level to preserve Id integrity", "Hierarchy", 1));
		
		// Check the arguments
		ArgumentValidator::validate($parentID, new NumericValidatorRule);
		ArgumentValidator::validate($newParentID, new NumericValidatorRule);

		// There is a chance that not all of the children have been loaded.
		// For instance, two of four children could have been loaded, each of which
		// is added as this node's child. Without load() being called with this node's id,
		// some children might be missing. This could cause significant slowdown if used
		// too much though.
		// For now we will leave it up to the application to call load() on what it needs
//		$this->load($parentID);
		
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);

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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		ArgumentValidator::validate($parentID, new NumericValidatorRule);

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
		throwError(new Error("This should be handled on the program level to preserve Id integrity", "Hierarchy", 1));
	
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		ArgumentValidator::validate($parentID, new NumericValidatorRule);
		
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
		// Check the arguments
		ArgumentValidator::validate($parentID, new NumericValidatorRule);
		
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
		// Check the arguments
		ArgumentValidator::validate($parentID, new NumericValidatorRule);
		
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
		return $this->_tree->getNodeCount($id);
	}
    
    /**
    * Returns a flat list of the nodes, optionally beginning at the given
	* node ID.
    *
    * @return array Flat list of the node IDs from top to bottom, left to right.
    */
    function getFlatList($id = 0) {
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
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
    * @param string $function The callback function to use
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
		// Check the arguments
		ArgumentValidator::validate($id, new NumericValidatorRule);
		
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
		// Check the arguments
		ArgumentValidator::validate($currentId, new NumericValidatorRule);
		if ($levels != NULL)
			ArgumentValidator::validate($levels, new NumericValidatorRule);
		
		return $this->_tree->depthFirstEnumeration($currentId, $levels);
	}

}
?>