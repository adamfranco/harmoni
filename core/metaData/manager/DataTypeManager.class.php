<?php

/**
 * Responsible for keeping track of the available data types (such as string, integer, etc) and 
 * creation of the appropriate classes when those data types are required.
 * @package harmoni.datamanager
 * @version $Id: DataTypeManager.class.php,v 1.5 2004/01/01 19:03:42 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataTypeManager 
	extends ServiceInterface {
	
	var $_registeredTypes;
	
	function DataTypeManager() {
		$this->_registeredTypes = array();
		
		include HARMONI."metaData/dataTypes/register.inc.php";
	}
	
	function getRegisteredTypes() {
		return array_keys($this->_registeredTypes);
	}
	
	function getRegisteredTypeClasses() {
		return array_values($this->_registeredTypes);
	}
	
	function registerType( $name, $class ) {
		ArgumentValidator::validate($name, new StringValidatorRule());
		ArgumentValidator::validate($class, new StringValidatorRule());
		
		
		if (!class_exists($class)) {
			throwError ( new Error("Could not register new DataType '$name' to class '$class' because it seems that
			the class does not exist. Be sure to include the necessary class definitions before calling registerType().",
			"DataTypeManager",true));
		}
		
		// now check if it extends the DataTypeInterface
		$rule =& new ExtendsValidatorRule("DataTypeInterface");
		$obj =& new $class;
		if (!$rule->check($obj)) {
			throwError ( new Error("Could not register new DataType '$name' to class '$class' because the class does
			not extends the DataTypeInterface.","DataTypeManager",true));
		}
		unset($obj, $rule);
		
		$this->_registeredTypes[$name] = $class;
	}
	
	function typeRegistered( $name ) {
		return (isset($this->_registeredTypes[$name]))?true:false;
	}
	
	function &newDataObject( $name ) {
		if (!$this->typeRegistered($name)) {
			throwError( new Error("Could not create new DataType object for '$name' because it doesn't seem to be registered.",
			"DataTypeManager",true));
		}
		
		$class = $this->_registeredTypes[$name];
		
		$object =& new $class;
		return $object;
	}
	
	function isObjectOfDataType(&$object, $type) {
		if (!$this->typeRegistered($type)) {
			throwError ( new Error("AAAH! Trying to check the data type of an object... but '$type' isn't defined!","DataTypeManager",true));
			return false;
		}
		
		$rule =& new ExtendsValidatorRule($this->_registeredTypes[$type]);
		return $rule->check($object);
	}
	
	function start() { }
	
	function stop() { }
}

?>