<?

require_once(OKI2."/osid/hierarchy/Node.php");
require_once(HARMONI."oki2/hierarchy/HierarchyCache.class.php");
require_once(HARMONI."oki2/hierarchy/HarmoniNodeIterator.class.php");
require_once(HARMONI."oki2/hierarchy/tree/Tree.class.php");
require_once(HARMONI."oki2/hierarchy/DefaultNodeType.class.php");

/**
 * Node is a Hierarchy's representation of an external object that is one of a
 * number of similar objects to be organized. Nodes must be connected to a
 * Hierarchy.
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
 * @version $Id: HarmoniNode.class.php,v 1.6 2005/01/19 22:28:22 adamfranco Exp $
 */

class HarmoniNode 
	extends Node 
{

	/**
	 * The Id of this node.
	 * @attribute private object _id
	 */
	var $_id;
	
	
	/**
	 * The type of this node.
	 * @attribute private object _type
	 */
	var $_type;
	
	
	/**
	 * The description for this node.
	 * @var string $_description
	 */
	var $_description;
	

	/**
	 * The display name for this node.
	 * @var string $_displayName
	 */
	var $_displayName;
	

	/**
	 * This is the HierarchyCache object. Must be the same
	 * one that all other nodes in the Hierarchy are using.
	 * @attribute private object _cache
	 */
	var $_cache;

	
	/**
	 * Constructor.
	 *
	 * @param ref object id The Id of this Node.
	 * @param ref object type The Type of the new Node.
	 * @param string displayName The displayName of the Node.
	 * @param string description The description of the Node.
	 * @param ref object cache This is the HierarchyCache object. Must be the same
	 * one that all other nodes in the Hierarchy are using.
	 */
	function HarmoniNode(& $id, & $type, $displayName, $description, & $cache) {
		// ** parameter validation
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($cache, new ExtendsValidatorRule("HierarchyCache"), true);
		// ** end of parameter validation
		
		// set the private variables
		$this->_id =& $id;
		$this->_type =& $type;
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_cache =& $cache;
	}

	/**
	 * Get the unique Id for this Node.
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
	 * Get the display name for this Node.
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
	 * Get the description for this Node.
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
	 * Get the Type for this Node.
	 *	
	 * @return object Type
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
	function &getType () { 
		return $this->_type;
	}

	/**
	 * Get the parents of this Node.  To get other ancestors use the Hierarchy
	 * traverse method.
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
	function &getParents () { 
		$idValue = $this->_id->getIdString();
	
		// get the children (cache them if necessary)
		$children =& $this->_cache->getParents($this);
		$result =& new HarmoniNodeIterator($children);

		return $result;
	}

	/**
	 * Get the children of this Node.  To get other descendants use the
	 * Hierarchy traverse method.
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
	function &getChildren () { 
		$idValue = $this->_id->getIdString();
	
		// get the children (cache them if necessary)
		$children =& $this->_cache->getChildren($this);
		$result =& new HarmoniNodeIterator($children);

		return $result;
	}

	/**
	 * Update the description of this Node.
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
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
			return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_cache->_hyDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."node");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}node.node_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}node.node_description"));
		$query->setValues(array("'".addslashes($description)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(HierarchyException::OPERATION_FAILED(),"Hierarchy",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(HierarchyException::OPERATION_FAILED() ,"Hierarchy",true));
	}

	/**
	 * Update the name of this Node. Node name changes are permitted since the
	 * Hierarchy's integrity is based on the Node's unique Id.
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_displayName == $displayName)
			return; // nothing to update
		
		// update the object
		$this->_displayName = $displayName;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_cache->_hyDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."node");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}node.node_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}node.node_display_name"));
		$query->setValues(array("'".addslashes($displayName)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(HierarchyException::OPERATION_FAILED(),"Hierarchy",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(HierarchyException::OPERATION_FAILED() ,"Hierarchy",true));
	}

	/**
	 * Return true if this Node is a leaf; false otherwise.	 A Node is a leaf
	 * if it has no children.
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
	function isLeaf () { 
		// leaf-check is done through getChildren(). A leaf would not have any children.
		
		$children =& $this->getChildren();
		return (!$children->hasNext());
	}

	/**
	 * Return true if this Node is a root; false otherwise.
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
	function isRoot () { 
		// leaf-check is done through getChildren(). A leaf would not have any children.
		
		$parents =& $this->getParents();
		return (!$parents->hasNext());
	}

	/**
	 * Link a parent to this Node.
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
	 *		   org.osid.hierarchy.HierarchyException#SINGLE_PARENT_HIERARCHY
	 *		   SINGLE_PARENT_HIERARCHY}, {@link
	 *		   org.osid.hierarchy.HierarchyException#ALREADY_ADDED
	 *		   ALREADY_ADDED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#ATTEMPTED_RECURSION
	 *		   ATTEMPTED_RECURSION}
	 * 
	 * @access public
	 */
	function addParent ( &$nodeId ) { 
		// ** parameter validation
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		$this->_cache->addParent($nodeId->getIdString(), $this->_id->getIdString());
	}

	/**
	 * Unlink a parent from this Node.
	 * 
	 * @param object Id $parentId
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
	 *		   org.osid.hierarchy.HierarchyException#SINGLE_PARENT_HIERARCHY
	 *		   SINGLE_PARENT_HIERARCHY}, {@link
	 *		   org.osid.hierarchy.HierarchyException#INCONSISTENT_STATE
	 *		   INCONSISTENT_STATE}
	 * 
	 * @access public
	 */
	function removeParent ( &$parentId ) { 
		// ** parameter validation
		ArgumentValidator::validate($parentId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		$this->_cache->removeParent($parentId->getIdString(), $this->_id->getIdString());
	}

	/**
	 * Changes the parent of this Node by adding a new parent and removing the
	 * old parent.
	 * 
	 * @param object Id $oldParentId
	 * @param object Id $newParentId
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
	 *		   org.osid.hierarchy.HierarchyException#ATTEMPTED_RECURSION
	 *		   ATTEMPTED_RECURSION}
	 * 
	 * @access public
	 */
	function changeParent ( &$oldParentId, &$newParentId ) { 
		// ** parameter validation
		ArgumentValidator::validate($oldParentId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($newParentId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		if ($oldParentId->getIdString() === $newParentId->getIdString())
			return;
		
		$this->_cache->removeParent($oldParentId->getIdString(), $this->_id->getIdString());
		$this->_cache->addParent($newParentId->getIdString(), $this->_id->getIdString());
	}
	

}

?>