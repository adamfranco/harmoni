<?php

require_once(OKI2."/osid/hierarchy/Node.php");
require_once(dirname(__FILE__)."/HierarchyCache.class.php");
require_once(dirname(__FILE__)."/NodeIterator.class.php");
// require_once(dirname(__FILE__)."/tree/Tree.class.php");
require_once(dirname(__FILE__)."/DefaultNodeType.class.php");

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
 * @version $Id: Node.class.php,v 1.1 2008/04/24 20:51:43 adamfranco Exp $
 */

class AuthZ2_Node 
	implements Node 
{

	/**
	 * The Id of this node.
	 * @var object _id 
	 * @access private
	 */
	var $_id;
	
	
	/**
	 * The type of this node.
	 * @var object _type 
	 * @access private
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
	 * @var object _cache 
	 * @access private
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
	function __construct(Id $id, Type $type, $displayName, $description, AuthZ2_HierarchyCache $cache) {
		// ** parameter validation
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		// set the private variables
		$this->_id =$id;
		$this->_type =$type;
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_cache =$cache;
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
	function getId () {
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
	function getType () { 
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
	function getParents () { 
		$idValue = $this->_id->getIdString();
	
		// get the children (cache them if necessary)
		$children =$this->_cache->getParents($this);
		$result = new AuthZ2_NodeIterator($children);

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
	function getChildren () { 
		$idValue = $this->_id->getIdString();
	
		// get the children (cache them if necessary)
		$children =$this->_cache->getChildren($this);
		$result = new AuthZ2_NodeIterator($children);

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
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
			return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new UpdateQuery();
		$query->setTable("az2_node");
		$query->addWhereEqual("id", $this->getId()->getIdString());
		$query->addValue("description", $description);
		
		$queryResult =$dbHandler->query($query, $this->_cache->_dbIndex);
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
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_displayName == $displayName)
			return; // nothing to update
		
		// update the object
		$this->_displayName = $displayName;

		// update the database
		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new UpdateQuery();
		$query->setTable("az2_node");
		$query->addWhereEqual("id", $this->getId()->getIdString());
		$query->addValue("display_name", $displayName);
		
		$queryResult =$dbHandler->query($query, $this->_cache->_dbIndex);
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
		return $this->_cache->isLeaf($this);
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
		
		$parents =$this->getParents();
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
	function addParent ( Id $nodeId ) {
		$authZ = $this->_cache->getAuthorizationManager();
		$isAuthorizedCache = $authZ->getIsAuthorizedCache();
		$isAuthorizedCache->dirtyNode($this->_id);
		
		// Store the current ancestor Ids for AuthZ updating
		$oldAncestorIds = $this->getAncestorIds();
		
		$this->_cache->addParent($nodeId->getIdString(), $this->_id->getIdString());
		
		// Instruct the Authorization system to add any implicit AZs given
		// the addintion of our ancestors.
		$addedAncestors = $this->idsAdded($oldAncestorIds, $this->getAncestorIds());
		$authZ->getAuthorizationCache()->createHierarchyImplictAZs($this, $addedAncestors);
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
	function removeParent ( Id $parentId ) { 
		
		$authZ = $this->_cache->getAuthorizationManager();
		$isAuthorizedCache = $authZ->getIsAuthorizedCache();
		$isAuthorizedCache->dirtyNode($this->_id);
		
		// Store the current ancestor Ids for AuthZ updating
		$oldAncestorIds = $this->getAncestorIds();
		
		$this->_cache->removeParent($parentId->getIdString(), $this->_id->getIdString());
		
		// Instruct the Authorization system to remove any implicit AZs given
		// the removal of our ancestors.
		$removedAncestors = $this->idsRemoved($oldAncestorIds, $this->getAncestorIds());
		$authZ->getAuthorizationCache()->deleteHierarchyImplictAZs($this, $removedAncestors);
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
	function changeParent ( Id $oldParentId, Id $newParentId ) { 		
		if ($oldParentId->isEqual($newParentId))
			return;
		
		$authZ = $this->_cache->getAuthorizationManager();
		$isAuthorizedCache = $authZ->getIsAuthorizedCache();		$isAuthorizedCache->dirtyNode($this->_id);
		
		// Store the current ancestor Ids for AuthZ updating
		$oldAncestorIds = $this->getAncestorIds();
		
		$this->_cache->removeParent($oldParentId->getIdString(), $this->_id->getIdString());
		$this->_cache->addParent($newParentId->getIdString(), $this->_id->getIdString());
		
		// Instruct the Authorization system to remove any implicit AZs given
		// the removal of our ancestors.
		$removedAncestors = $this->idsRemoved($oldAncestorIds, $this->getAncestorIds());
		$authZ->getAuthorizationCache()->deleteHierarchyImplictAZs($this, $removedAncestors);
		
		// Instruct the Authorization system to add any implicit AZs given
		// the addintion of our ancestors.
		$addedAncestors = $this->idsAdded($oldAncestorIds, $this->getAncestorIds());
		$authZ->getAuthorizationCache()->createHierarchyImplictAZs($this, $addedAncestors);
	}
	
	/**
	 * Answer an array of id objects for the parents and further ancestors of this node.
	 * 
	 * @return array
	 * @access public
	 * @since 4/21/08
	 */
	public function getAncestorIds () {
		$ids = array();
		$hierarchy = $this->getHierarchy();
		$info = $hierarchy->traverse(
					$this->getId(), 
					Hierarchy::TRAVERSE_MODE_DEPTH_FIRST,
					Hierarchy::TRAVERSE_DIRECTION_UP,
					Hierarchy::TRAVERSE_LEVELS_ALL);
		while ($info->hasNext()) {
			$id = $info->next()->getNodeId();
			if (!$id->isEqual($this->getId()))
				$ids[] = $id;
		}
		
		return $ids;
	}
	
	/**
	 * Given an original array of ids and a new array of ids, return an array of
	 * ids that no longer exist in  the new array.
	 * 
	 * @param array $oldIds
	 * @param array $newIds
	 * @return array
	 * @access protected
	 * @since 4/21/08
	 */
	protected function idsRemoved (array $oldIds, array $newIds) {
		$removed = array();
		foreach ($oldIds as $oldId) {
			$found = false;
			foreach ($newIds as $newId) {
				if ($oldId->isEqual($newId)) {
					$found = true;
					break;
				}
			}
			if (!$found)
				$removed[] = $oldId;
		}
		
		return $removed;
	}
	
	/**
	 * Given an original array of ids and a new array of ids, return an array of
	 * ids that no longer exist in  the new array.
	 * 
	 * @param array $oldIds
	 * @param array $newIds
	 * @return array
	 * @access protected
	 * @since 4/21/08
	 */
	protected function idsAdded (array $oldIds, array $newIds) {
		return $this->idsRemoved($newIds, $oldIds);
	}
	
	/**
	 * Answer the hierarchy id that this node belongs to.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return object Id
	 * @access public
	 * @since 4/21/08
	 */
	public function getHierarchyId () {
		return $this->_cache->getHierarchyId();
	}
	
	/**
	 * Answer the hierarchy that this node belongs to.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return object Hierarchy
	 * @access public
	 * @since 4/21/08
	 */
	public function getHierarchy () {
		return $this->_cache->getHierarchy();
	}
}

?>