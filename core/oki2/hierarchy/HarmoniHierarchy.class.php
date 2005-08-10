<?

require_once(OKI2."/osid/hierarchy/Hierarchy.php");
require_once(HARMONI.'/oki2/hierarchy/HarmoniNode.class.php');
require_once(HARMONI.'/oki2/hierarchy/HierarchyCache.class.php');
require_once(HARMONI.'/oki2/hierarchy/HarmoniNodeIterator.class.php');
require_once(HARMONI.'/oki2/hierarchy/HarmoniTraversalInfo.class.php');
require_once(HARMONI.'/oki2/hierarchy/HarmoniTraversalInfoIterator.class.php');
require_once(HARMONI.'/oki2/hierarchy/DefaultNodeType.class.php');

/**
 * Hierarchy is a structure composed of nodes arranged in root, parent, and
 * child form.	The Hierarchy can be traversed in several ways to determine
 * the arrangement of nodes. A Hierarchy can allow multiple parents.  A
 * Hierarchy can allow recursion.  The implementation is responsible for
 * ensuring that the integrity of the Hierarchy is always maintained.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniHierarchy.class.php,v 1.15 2005/08/10 21:20:10 adamfranco Exp $
 */

class HarmoniHierarchy 
	extends Hierarchy {

	/**
	 * The Id of this hierarchy.
	 * @var object _id 
	 * @access private
	 */
	var $_id;
	
	
	/**
	 * The display name of this hierarchy.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	
	/**
	 * The description of this hierarchy.
	 * @var string _description 
	 * @access private
	 */
	var $_description;
	
	
	/**
	 * Constructor.
	 *
	 * @param object ID	  $id	The Id of this Hierarchy.
	 * @param string $displayName The displayName of the Hierarchy.
	 * @param string $description The description of the Hierarchy.
	 * @param boolean allowsMultipleParents This is true if the hierarchy will allow
	 * multiple parents.
	 * @param ref object cache This is the HierarchyCache object. Must be the same
	 * one that all other nodes in the Hierarchy are using.
	 * @access public
	 */
	function HarmoniHierarchy(& $id, $displayName, $description, & $cache) {
		// ** parameter validation
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($cache, ExtendsValidatorRule::getRule("HierarchyCache"), true);
		// ** end of parameter validation
	
		$this->_id =& $id;
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_cache =& $cache;
	}

	
	/**
	 * Get the unique Id for this Hierarchy.
	 *	
	 * @return object Id
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getId () { 
		return $this->_id;
	}

	/**
	 * Get the display name for this Hierarchy.
	 *	
	 * @return string
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDisplayName () { 
		return $this->_displayName;
	}
	
	/**
	 * Update the display name for this Hierarchy.
	 * 
	 * @param string $displayName
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_displayName == $displayName)
			return; // nothing to update
		
		// update the object
		$this->_displayName = $displayName;

		// update the database
		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_cache->_hyDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."hierarchy");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}hierarchy.hierarchy_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}hierarchy.hierarchy_display_name"));
		$query->setValues(array("'".addslashes($displayName)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(HierarchyException::OPERATION_FAILED(),"Hierarchy",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(HierarchyException::OPERATION_FAILED() ,"Hierarchy",true));
	}

	/**
	 * Get the description for this Hierarchy.
	 *	
	 * @return string
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDescription () { 
		return $this->_description;
	}

	/**
	 * Update the description for this Hierarchy.
	 * 
	 * @param string $description
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		// ** parameter validation
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
			return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_cache->_hyDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."hierarchy");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}hierarchy.hierarchy_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}hierarchy.hierarchy_description"));
		$query->setValues(array("'".addslashes($description)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(HierarchyException::OPERATION_FAILED(),"Hierarchy",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(HierarchyException::OPERATION_FAILED(),"Hierarchy",true));
	}
	
	/**
	 * Create a root Node. The Node is created with the specified unique Id,
	 * and, unlike Nodes created with createNode, initially has no parents or
	 * children.
	 * 
	 * @param object Id $nodeId
	 * @param object Type $nodeType
	 * @param string $displayName
	 * @param string $description
	 *	
	 * @return object Node
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}{@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#SINGLE_PARENT_HIERARCHY
	 *		   SINGLE_PARENT_HIERARCHY}
	 * 
	 * @access public
	 */
	function &createRootNode ( &$nodeId, &$nodeType, $displayName, $description ) { 
		// ** parameter validation
		ArgumentValidator::validate($nodeId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($nodeType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		// ** end of parameter validation

		return $this->_cache->createRootNode($nodeId, $nodeType, $displayName, $description);
	}

	/**
	 * Create a Node. The Node is created with the specified unique Id and
	 * initially has only the specified parent.
	 * 
	 * @param object Id $nodeId
	 * @param object Id $parentId
	 * @param object Type $type
	 * @param string $displayName
	 * @param string $description
	 *	
	 * @return object Node
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNKNOWN_PARENT_NODE
	 *		   UNKNOWN_PARENT_NODE}, {@link
	 *		   org.osid.hierarchy.HierarchyException#ATTEMPTED_RECURSION
	 *		   ATTEMPTED_RECURSION}
	 * 
	 * @access public
	 */
	function &createNode ( &$nodeId, &$parentId, &$type, $displayName, $description ) { 
		// ** parameter validation
		ArgumentValidator::validate($nodeId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($parentId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		// ** end of parameter validation

		return $this->_cache->createNode($nodeId, $parentId, $type, $displayName, $description);
	}

	/**
	 * Delete a Node by Id.	 Only leaf Nodes can be deleted.
	 * 
	 * @param object Id $nodeId
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
	 *		   NODE_TYPE_NOT_FOUND}, {@link
	 *		   org.osid.hierarchy.HierarchyException#INCONSISTENT_STATE
	 *		   INCONSISTENT_STATE}
	 * 
	 * @access public
	 */
	function deleteNode ( &$nodeId ) { 
		// ** parameter validation
		ArgumentValidator::validate($nodeId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		$this->_cache->deleteNode($nodeId->getIdString());
	}

	/**
	 * Add a NodeType to this Hierarchy.
	 * 
	 * @param object Type $type
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#ALREADY_ADDED
	 *		   ALREADY_ADDED}
	 * 
	 * @access public
	 */
	function addNodeType ( &$type ) { 
		throwError(new Error(HierarchyException::UNIMPLEMENTED(), "Hierarchy", true));
	}

	/**
	 * Remove a NodeType from this Hierarchy.  Note that no Nodes can have this
	 * NodeType.
	 * 
	 * @param object Type $type
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_IN_USE
	 *		   NODE_TYPE_IN_USE}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
	 *		   NODE_TYPE_NOT_FOUND}
	 * 
	 * @access public
	 */
	function removeNodeType ( &$type ) { 
		throwError(new Error(HierarchyException::UNIMPLEMENTED(), "Hierarchy", true));
	}

	/**
	 * Get all the Nodes in this Hierarchy.
	 *	
	 * @return object NodeIterator
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getAllNodes () { 
		// if all the nodes haven't been cached then do it
		$nodes =& $this->_cache->getAllNodes();

		// create the iterator and return them
		return new HarmoniNodeIterator($nodes);
	}

	/**
	 * Get the root Nodes in this Hierarchy.
	 *	
	 * @return object NodeIterator
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getRootNodes () { 
		// if all the nodes haven't been cached then do it
		$nodes =& $this->_cache->getRootNodes();

		// create the iterator and return them
		return new HarmoniNodeIterator($nodes);
	}

	/**
	 * Get a Node by unique Id.
	 * 
	 * @param object Id $nodeId
	 *	
	 * @return object Node
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
	 *		   NODE_TYPE_NOT_FOUND}
	 * 
	 * @access public
	 */
	function &getNode ( &$nodeId ) { 
		// ** parameter validation
		ArgumentValidator::validate($nodeId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		$idValue = $nodeId->getIdString();
		$node =& $this->_cache->getNode($idValue);
		
		return $node;
	}

	/**
	 * Get all NodeTypes used in this Hierarchy.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getNodeTypes () { 
		$dbHandler =& Services::getService("DatabaseManager");
		$query =& new SelectQuery();
		
		$db = $this->_cache->_hyDB.".";
		// set the tables
		$query->addTable($db."node");
		$joinc = $db."node.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		$hierarchyIdValue = $this->_id->getIdString();
		$query->addWhere($db."node.fk_hierarchy = '{$hierarchyIdValue}'");

		// set the columns to select
		$query->setDistinct(true);
		$query->addColumn("type_id", "id", $db."type");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "description", $db."type");
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);

		$types = array();
		while ($queryResult->hasMoreRows()) {
			// fetch current row
			$arr = $queryResult->getCurrentRow();
			
			// create type object
			$type =& new HarmoniType($arr['domain'],$arr['authority'],$arr['keyword'],$arr['description']);
			
			// add it to array
			$types[] =& $type;

			$queryResult->advanceRow();
		}
		$queryResult->free();
		
		$result =& new HarmoniTypeIterator($types);
		return $result;
	}
	
	/**
	 * Get the Nodes of the specified Type in this Hierarchy. 
	 *
	 * WARNING: NOT IN OSID - This method is not in the OSIDs as of version 2.0.
	 *
	 * @param object Type $nodeType
	 * @return object NodeIterator	Iterators return a set, one at a time.	The
	 *		   Iterator's hasNext method returns true if there are additional
	 *		   objects available; false otherwise.	The Iterator's next method
	 *		   returns the next object.	 The order of the objects returned by
	 *		   the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getNodesByType( & $nodeType ) {
		// if all the nodes haven't been cached then do it
		$where = "type_domain = '".addslashes($nodeType->getDomain())."'";
		$where .= " AND type_authority = '".addslashes($nodeType->getAuthority())."'";
		$where .= " AND type_keyword = '".addslashes($nodeType->getKeyword())."'";
		$nodes =& $this->_cache->getNodesFromDB($where);

		// create the iterator and return them
		return new HarmoniNodeIterator($nodes);
	}

	/**
	 * Returns true if multiple parents are allowed; false otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function allowsMultipleParents () { 
		return $this->_cache->_allowsMultipleParents;
	}

	/**
	 * Returns true if recursion allowed; false otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function allowsRecursion () { 
		return false;
	}

	/**
	 * Traverse a Hierarchy returning information about each Node encountered.
	 * 
	 * @param object Id $startId
	 * @param int $mode
	 * @param int $direction
	 * @param int $levels
	 *	
	 * @return object TraversalInfoIterator
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
	 *		   NODE_TYPE_NOT_FOUND}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNKNOWN_TRAVERSAL_MODE
	 *		   UNKNOWN_TRAVERSAL_MODE}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNKNOWN_TRAVERSAL_DIRECTION
	 *		   UNKNOWN_TRAVERSAL_DIRECTION}
	 * 
	 * @access public
	 */
	function &traverse ( &$startId, $mode, $direction, $levels ) { 
		// Check the arguments
		ArgumentValidator::validate($startId, ExtendsValidatorRule::getRule("Id"));
		ArgumentValidator::validate($mode, IntegerValidatorRule::getRule());
		ArgumentValidator::validate($direction, IntegerValidatorRule::getRule());
		ArgumentValidator::validate($levels, IntegerValidatorRule::getRule());

		if ($mode != Hierarchy::TRAVERSE_MODE_DEPTH_FIRST()) {
			// Only depth-first traversal is supported in the current implementation.
			throwError(new Error(HierarchyException::UNKNOWN_TRAVERSAL_DIRECTION(), "Hierarchy", true));
		}

		$down = ($direction == Hierarchy::TRAVERSE_DIRECTION_DOWN());
		$result =& $this->_cache->traverse($startId, $down, $levels);

		return $result;
	}
	
	
	/**
	 * Clears the cache.
	 *
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 **/
	function clearCache() {
		$this->_cache->clearCache();
	}
		
}

?>