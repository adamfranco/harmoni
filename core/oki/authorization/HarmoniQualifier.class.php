<?php

/**
 * Qualifier is the context in which an Authorization is valid and consists of an Id, a description and a QualifierType.  Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package osid.authorization
 */
class HarmoniQualifier /* :: API interface */
{

	/**
	 * The UNIQUE id of this qualifier.
	 * @attribute private object _id
	 */
	var $_id;
	

	/**
	 * The display name of this qualifier.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	
	/**
	 * The description of this qualifier
	 * @attribute private string _description
	 */
	var $_description;
	
	
	/**
	 * The type of this qualifier.
	 * @attribute private object _qualifierType
	 */
	var $_qualifierType;
	
	

	/**
	 * Get the Unique Id for this Qualifier.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getId() {
		return $this->_id;
	}



	/* :: full java declaration :: osid.shared.Id getId()
	/**
	 * Get the name for this Qualifier.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDisplayName() {
		return $this->_displayName;
	}



	/* :: full java declaration :: String getDisplayName()
	/**
	 * Get the description for this Qualifier.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDescription() {
		return $this->_description;
	}



	/* :: full java declaration :: String getDescription()
	/**
	 * Return true if this Qualifier has any children; false otherwise
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function isParent() { /* :: interface :: */ }



	/* :: full java declaration :: boolean isParent()
	/**
	 * Get the QualifierType for this Qualifier.
	 * @return object osid.shared.Type
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getQualifierType() {
		return $this->_qualifierType;
	}



	/* :: full java declaration :: osid.shared.Type getQualifierType()
	/**
	 * Update the name for this Qualifier.
	 * @param string displayName
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDisplayName($displayName) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		// ** end of parameter validation
		
		$this->_displayName = $displayName;
	}



	/* :: full java declaration :: void updateDisplayName(String displayName)
	/**
	 * Update the description for this Qualifier.
	 * @param string description
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDescription($description) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		$this->_description = $description;
	}



	/* :: full java declaration :: void updateDescription(String description)
	/**
	 * Adds a parent to this Qualifier supported by the Authorization implementation.
	 * @param parentQualifierId a Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function addParent(& $parentQualifierId) { /* :: interface :: */ }



	/* :: full java declaration :: void addParent(osid.shared.Id parentQualifierId)
	/**
	 * Removes a parent from this Qualifier.  If this is the last parent the delete will fail and an AuthorizationException will be thrown.  For a non-Root Qualifier there must always be a parent.
	 * @param parentQualifierId a Qualifer
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function removeParent(& $parentQualifierId) { /* :: interface :: */ }



	/* :: full java declaration :: void removeParent(osid.shared.Id parentQualifierId)
	/**
	 * Changes the parent of this Qualifier by adding a new parent and removing the old parent.
	 * @param object oldParentId a Qualifier
	 * @param object newParentId a Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function changeParent(& $oldParentId, & $newParentId) { /* :: interface :: */ }



	/* :: full java declaration :: void changeParent(osid.shared.Id oldParentId, osid.shared.Id newParentId)
	/**
	 * Determines if this Qualifier is the child a given parent
	 * @param parentId a Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function isChildOf(& $parentId) { /* :: interface :: */ }



	/* :: full java declaration :: boolean isChildOf(osid.shared.Id parentId)
	/**
	 * Determines if this Qualifier is a descendant of the given Qualifier.
	 * @param ancestorId a Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function isDescendantOf(& $ancestorId) { /* :: interface :: */ }



	/* :: full java declaration :: boolean isDescendantOf(osid.shared.Id ancestorId)
	/**
	 * Gets the children of this Qualifier.
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getChildren() { /* :: interface :: */ }



	/* :: full java declaration :: QualifierIterator getChildren()
	/**
	 * Gets the parents of this Qualifier.
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getParents() { /* :: interface :: */ }
}

?>