<?php

/**
 * Agents are an abstraction for a principal or group.  The Agent may be granted authorization to perform specific functions.  Agents are created through implementations of osid.shared.SharedManager and have an immutable name, Type, and Unique Id. <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
 * @package osid.shared
 */
class HarmoniAgent // :: API interface
//	extends java.io.Serializable
{

	/**
	 * The display name.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	
	/**
	 * The Id of this Agent.
	 * @attribute private object _Id
	 */
	var $_id;
	
	
	/**
	 * The type of this Agent.
	 * @attribute private object _type
	 */
	var $_type;
	
	
	/**
	 * The constructor.
	 * @param string displayName The display name.
	 * @param object id The id.
	 * @@param object type The type.
	 * @access public
	 */
	function HarmoniAgent($displayName, & $id, & $type) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"), true);
		// ** end of parameter validation
		
		$this->_displayName = $displayName;
		$this->_id =& $id;
		$this->_type =& $type;
	}	
	

	/**
	 * Get the name of this Agent.
	 * @return String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function getDisplayName() {
		return $this->_displayName;
	}

	/**
	 * Get the id of this Agent.
	 * @return id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & getId() {
		return $this->_id;
	}

	/**
	 * Get the type of this Agent.
	 * @return Type
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & getType() {
		return $this->_type;
	}

	/**
	 * Get all the Properties associated with this Agent.
	 * @return PropertiesIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & getProperties() { /* :: interface :: */ }
	// :: full java declaration :: PropertiesIterator getProperties()

	/**
	 * Get the Properties of this Type associated with this Agent.
	 * @return Properties
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.shared
	 */
	function & getPropertiesByType(& $propertiesType) { /* :: interface :: */ }
	// :: full java declaration :: Properties getPropertiesByType(Type propertiesType)

	/**
	 * Get the Properties Types supported by the implementation.
	 * @return TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & getPropertiesTypes() { /* :: interface :: */ }
	// :: full java declaration :: TypeIterator getPropertiesTypes()
}


?>