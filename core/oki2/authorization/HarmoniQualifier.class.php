<?php

require_once(OKI2."/osid/authorization/Qualifier.php");
require_once(HARMONI.'oki2/hierarchy/HarmoniNode.class.php');
require_once(HARMONI.'oki2/authorization/AuthorizationCache.class.php');
require_once(HARMONI.'oki2/authorization/DefaultQualifierType.class.php');
require_once(HARMONI.'oki2/authorization/HarmoniQualifierIterator.class.php');

/**
 * Qualifier is the context in which an Authorization is valid and consists of
 * an Id, a description and a QualifierType.  Ids in Authorization are
 * externally defined and their uniqueness is enforced by the implementation.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid.authorization
 */
class HarmoniQualifier 
	extends Qualifier 
{
	
	/**
	 * The associated hierarchy node object.
	 * @attribute private object _node
	 */
	var $_node;
	

	/**
	 * The AuthorizationCache object.
	 * @attribute private object _cache
	 */
	var $_cache;
	
	
	/**
	 * The constructor.
	 * @param ref object node The associated hierarchy node object.
	 * @param ref object cache The AuthorizationCache object.
	 * @access public
	 */
	function HarmoniQualifier(& $node, & $cache) {
		// ** parameter validation
		ArgumentValidator::validate($node, new ExtendsValidatorRule("Node"), true);
		ArgumentValidator::validate($cache, new ExtendsValidatorRule("AuthorizationCache"), true);
		// ** end of parameter validation
		
		$this->_node =& $node;
		$this->_cache =& $cache;
	}
	
	
	/**
	 * Get the unique Id for this Qualifier.
	 *	
	 * @return object Id
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function &getId () { 
		$id =& $this->_node->getId();
		return $id;
	}

	/**
	 * Get the permanent reference name for this Qualifier.
	 *	
	 * @return string
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function getReferenceName () { 
		return $this->_node->getDisplayName();
	}

	/**
	 * Get the description for this Qualifier.
	 *	
	 * @return string
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function getDescription () { 
		return $this->_node->getDescription();
	}

	/**
	 * Return true if this Qualifier has any children; false otherwise
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function isParent () { 
		$children =& $this->getChildren();
		return ($children->hasNext());
	}

	/**
	 * Get the QualifierType for this Qualifier.
	 *	
	 * @return object Type
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function &getQualifierType () { 
		return $this->_node->getType();
	}

	/**
	 * Update the reference name for this Qualifier.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param string $referenceName
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @public
	 */
	function updateReferenceName ( $referenceName ) { 
		$this->_node->updateDisplayName($displayName);
	}

	/**
	 * Update the description for this Qualifier.
	 * 
	 * @param string $description
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @public
	 */
	function updateDescription ( $description ) { 
		$this->_node->updateDescription($description);
	}

	/**
	 * Adds a parent to this Qualifier supported by the Authorization
	 * implementation.
	 * 
	 * @param object Id $parentQualifierId
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @public
	 */
	function addParent ( &$parentQualifierId ) { 
		$this->_node->addParent($parentQualifierId);
	}

	/**
	 * Removes a parent from this Qualifier.  If this is the last parent the
	 * delete will fail and an AuthorizationException will be thrown.  For a
	 * non-Root Qualifier there must always be a parent.
	 * 
	 * @param object Id $parentQualifierId
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @public
	 */
	function removeParent ( &$parentQualifierId ) { 
		$this->_node->removeParent($parentQualifierId);
	}

	/**
	 * Changes the parent of this Qualifier by adding a new parent and removing
	 * the old parent.
	 * 
	 * @param object Id $oldParentId
	 * @param object Id $newParentId
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @public
	 */
	function changeParent ( &$oldParentId, &$newParentId ) { 
		$this->_node->changeParent($oldParentId, $newParentId);
	}

	/**
	 * Determines if this Qualifier is the child a given parent
	 * 
	 * @param object Id $parentId
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @public
	 */
	function isChildOf ( &$parentId ) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($parentId, $extendsRule, true);
		// ** end of parameter validation

		// get the parents of this node
		$parents =& $this->getParents();
		// search for the given parent
		while ($parents->hasNext()) {
			$parent =& $parents->next();
			$parentId1 =& $parent->getId();
			
			if ($parentId->isEqual($parentId1)) 
				return true;
		}
		
		return false;
	}

	/**
	 * Determines if this Qualifier is a descendant of the given qualifierId.
	 * 
	 * @param object Id $ancestorId
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @public
	 */
	function isDescendantOf ( &$ancestorId ) { 
		// Alright, I realize this could be written much more efficiently (for
		// example by using Hierarchy->traverse()) but it is too much pain to do so.
		// The code below uses the methods in this class and is clearer, albeit slower.
		// Are we going to use this method a lot anyway?
		
		// base case
		if ($ancestorId->isEqual($this->getId()))
			return true;
		
		// recurse up
		$parents =& $this->getParents();
		while ($parents->hasNext()) {
			$parent =& $parents->next();
			if ($parent->isDescendantOf($ancestorId))
				return true;
		}
		
		return false;
	}

	/**
	 * Gets the children of this Qualifier.
	 *	
	 * @return object QualifierIterator
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function &getChildren () { 
		// obtain the parent nodes
		$children =& $this->_node->getChildren();
		
		$result = array();
		// for each node, cache if not cached, create a new Qualifier, 
		// and add to result array
		while ($children->hasNext()) {
			$child =& $children->next();
			$childId =& $child->getId();
			$idValue =& $childId->getIdString();
			
			if (!isset($this->_cache->_qualifiers[$idValue])) {
				$qualifier =& new HarmoniQualifier($child, $this->_cache);
				$this->_cache->_qualifiers[$idValue] =& $qualifier;
			}
			
			$result[] =& $this->_cache->_qualifiers[$idValue];
		}
		
		return new HarmoniQualifierIterator($result);
	}

	/**
	 * Gets the parents of this Qualifier.
	 *	
	 * @return object QualifierIterator
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function &getParents () { 
		// obtain the parent nodes
		$parents =& $this->_node->getParents();
		
		$result = array();
		// for each node, cache if not cached, create a new Qualifier, 
		// and add to result array
		while ($parents->hasNext()) {
			$parent =& $parents->next();
			$parentId =& $parent->getId();
			$idValue =& $parentId->getIdString();
			
			if (!isset($this->_cache->_qualifiers[$idValue])) {
				$qualifier =& new HarmoniQualifier($parent, $this->_cache);
				$this->_cache->_qualifiers[$idValue] =& $qualifier;
			}
			
			$result[] =& $this->_cache->_qualifiers[$idValue];
		}
		
		return new HarmoniQualifierIterator($result);
	}
	
}

?>