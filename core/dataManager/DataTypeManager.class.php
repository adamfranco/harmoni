<?php

require_once(HARMONI."utilities/recast.function.php");
require_once(HARMONI."dataManager/StorablePrimitive.interface.php");
require_once(HARMONI."dataManager/primitives/inc.php");
require_once(HARMONI."dataManager/storablePrimitives/inc.php");

/**
 * Responsible for keeping track of the available data type primitives (such as string, integer, etc) and 
 * creation of the appropriate classes when those data types are required. Is also responsible for mapping {@link Primitive}s with
 * their respective {@link StorablePrimitive}s so that we can store them in the database.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DataTypeManager.class.php,v 1.12 2005/07/14 14:07:00 gabeschine Exp $
 *
 * @author Gabe Schine
 */
class DataTypeManager {
	
	var $_registeredTypes;
	var $_primitiveClassMapping;
	
	function DataTypeManager() {
		$this->_registeredTypes = array();
		$this->_primitiveClassMapping = array();
		
		include HARMONI."dataManager/registerPrimitives.inc.php";
	}
	
	/**
	 * Returns an array of strings that represent all of the available {@link Primitive}s.
	 * @return array
	 * @access public
	 */
	function getRegisteredTypes() {
		return array_keys($this->_registeredTypes);
	}
	
	/**
	 * Adds a specific data type (identified by a string such as "integer") to our registry. Each data type has two classes associated with it: a {@link Primitive} and a {@link StorablePrimitive}. The former is used when setting/getting values, the latter used when talking with the database.
	 * @param string $typeName The name (such as "integer" or "boolean") of this new data type.
	 * @param string $primitiveClass The name of the {@link Primitive} class.
	 * @param string $storablePrimitiveClass The name of the {@link StorablePrimitive} class.
	 * @access public
	 * @return void
	 */
	function addDataType($typeName, $primitiveClass, $storablePrimitiveClass)
	{
		$this->_registeredTypes[$typeName] = array("primitive"=>$primitiveClass,"storable"=>$storablePrimitiveClass);
		if (!in_array(strtolower($storablePrimitiveClass), $this->_primitiveClassMapping)) $this->_primitiveClassMapping[] = strtolower($storablePrimitiveClass);	
	}
	
	/**
	 * Check if we have a datatype registered under $name.
	 * @param string $name
	 * @return bool
	 * @access public
	 */
	function typeRegistered( $name ) {
		return (isset($this->_registeredTypes[$name]))?true:false;
	}
	
	/**
	 * Creates a new {@link Primitive} object that is associated with the type registered under $name.
	 * @param string $name
	 * @return ref object
	 * @access public
	 */
	function &newPrimitive( $name ) {
		if (!$this->typeRegistered($name)) {
			throwError( new Error("Could not create new DataType object for '$name' because it doesn't seem to be registered.",
			"DataTypeManager",true));
		}
		
		$class = $this->_registeredTypes[$name]["primitive"];
		
		$object =& new $class;
		return $object;
	}
	
	/**
	 * Returns the class that is associated with the given $name.
	 * @param string $type The type-string of the primitive (such as "integer").
	 * @access public
	 * @return string
	 */
	function storablePrimitiveClassForType($type)
	{
		$type = strtolower($type);
		if (!$this->typeRegistered($type)) {
			throwError( new Error("Could not create new DataType object for '$type' because it doesn't seem to be registered.",
			"DataTypeManager",true));
		}
		
		$class = $this->_registeredTypes[$type]["storable"];
		
		return $class;
	}
	
	/**
	 * Recasts a {@link SObject} to its associated {@link StorablePrimitive} class and returns the new object.
	 * @param ref object $primitive
	 * @param string $type The type of data contained in the primitive (ie, "integer" or "string")
	 * @access public
	 * @return ref object
	 */
	function &recastAsStorablePrimitive(&$primitive, $type)
	{
		$type = strtolower($type);
		$class = strtolower(get_class($primitive));
		if (!isset($this->_registeredTypes[$type]) || strtolower($this->_registeredTypes[$type]["primitive"]) != $class) {
			// this means that either we can't do anything with this primitive (we dont' know it) or
			// it's already a storable.
			return $primitive;
		}
		
		$newClass = $this->_registeredTypes[$type]["storable"];
		$newObj =& recast($primitive, $newClass);
		// now call the constructor in case any setup has to be done.
		if (method_exists($newObj, $newClass)) $newObj->$newClass();
		return $newObj;
	}
	
	/**
	 * Returns an array of the {@link StorablePrimitive}s that we have registered.
	 * @access public
	 * @return ref object
	 */
	function getRegisteredStorablePrimitives()
	{
		return $this->_primitiveClassMapping;
	}
	
	/**
	 * Takes an object and a DataType name and checks if the object is of the correct class to be
	 * an object of DataType $type.
	 * @param ref object The {@link Primitive} object to check.
	 * @param string $type The type (name) of the registered DataType to check against.
	 * @return bool
	 * @access public
	 */
	function isObjectOfDataType(&$object, $type) {
		$type = strtolower($type);
		if (!$this->typeRegistered($type)) {
			throwError ( new Error("AAAH! Trying to check the data type of an object... but '$type' isn't defined!","DataTypeManager",true));
			return false;
		}
		
		$rule =& ExtendsValidatorRule::getRule($this->_registeredTypes[strtolower($type)]["primitive"]);
		return $rule->check($object);
	}
}

?>