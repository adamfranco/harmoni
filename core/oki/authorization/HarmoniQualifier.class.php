<?php

require_once(OKI."/authorization.interface.php");
require_once(HARMONI.'oki/hierarchy2/HarmoniNode.class.php');
require_once(HARMONI.'oki/authorization/AuthorizationCache.class.php');
require_once(HARMONI.'oki/authorization/DefaultQualifierType.class.php');
require_once(HARMONI.'oki/authorization/HarmoniQualifierIterator.class.php');

/**
 * Qualifier is the context in which an Authorization is valid and consists of an Id, a description and a QualifierType.  Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid_v1.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniQualifier.class.php,v 1.10 2005/01/19 23:23:02 adamfranco Exp $
 */
class HarmoniQualifier extends Qualifier {

	
	/**
	 * The associated hierarchy node object.
	 * @var object _node 
	 * @access private
	 */
	var $_node;
	

	/**
	 * The AuthorizationCache object.
	 * @var object _cache 
	 * @access private
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
	 * Get the Unique Id for this Qualifier.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() {
		$id =& $this->_node->getId();
		return $id;
	}


	/* :: full java declaration :: osid.shared.Id getId()
	/**
	 * Get the name for this Qualifier.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() {
		return $this->_node->getDisplayName();
	}


	/* :: full java declaration :: String getDisplayName()
	/**
	 * Get the description for this Qualifier.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() {
		return $this->_node->getDescription();
	}



	/* :: full java declaration :: String getDescription()
	/**
	 * Return true if this Qualifier has any children; false otherwise
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function isParent() {
		$children =& $this->getChildren();
		return ($children->hasNext());
	}


	/* :: full java declaration :: boolean isParent()
	/**
	 * Get the QualifierType for this Qualifier.
	 * @return object osid.shared.Type
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getQualifierType() {
		return $this->_node->getType();
	}


	/* :: full java declaration :: osid.shared.Type getQualifierType()
	/**
	 * Update the name for this Qualifier.
	 * @param string displayName
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDisplayName($displayName) {
		$this->_node->updateDisplayName($displayName);
	}


	/* :: full java declaration :: void updateDisplayName(String displayName)
	/**
	 * Update the description for this Qualifier.
	 * @param string description
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDescription($description) {
		$this->_node->updateDescription($description);
	}



	/* :: full java declaration :: void updateDescription(String description)
	/**
	 * Adds a parent to this Qualifier supported by the Authorization implementation.
	 * @param parentQualifierId a Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function addParent(& $parentQualifierId) {
		$this->_node->addParent($parentQualifierId);
	}


	/* :: full java declaration :: void addParent(osid.shared.Id parentQualifierId)
	/**
	 * Removes a parent from this Qualifier.  If this is the last parent the delete will fail and an AuthorizationException will be thrown.  For a non-Root Qualifier there must always be a parent.
	 * @param parentQualifierId a Qualifer
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function removeParent(& $parentQualifierId) {
		$this->_node->removeParent($parentQualifierId);
	}


	/* :: full java declaration :: void removeParent(osid.shared.Id parentQualifierId)
	/**
	 * Changes the parent of this Qualifier by adding a new parent and removing the old parent.
	 * @param object oldParentId a Qualifier
	 * @param object newParentId a Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function changeParent(& $oldParentId, & $newParentId) {
		$this->_node->changeParent($oldParentId, $newParentId);
	}



	/* :: full java declaration :: void changeParent(osid.shared.Id oldParentId, osid.shared.Id newParentId)
	/**
	 * Determines if this Qualifier is the child a given parent
	 * @param parentId a Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function isChildOf(& $parentId) {
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



	/* :: full java declaration :: boolean isChildOf(osid.shared.Id parentId)
	/**
	 * Determines if this Qualifier is a descendant of the given Qualifier.
	 * @param ancestorId a Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function isDescendantOf(& $ancestorId) {
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



	/* :: full java declaration :: boolean isDescendantOf(osid.shared.Id ancestorId)
	/**
	 * Gets the children of this Qualifier.
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getChildren() {
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



	/* :: full java declaration :: QualifierIterator getChildren()
	/**
	 * Gets the parents of this Qualifier.
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getParents() {
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