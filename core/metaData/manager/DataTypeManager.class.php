<?php

class DataTypeManager 
	extends ServiceInterface {
	
	var $_registeredTypes;
	
	function DataTypeManager() {
		$this->_registeredTypes = array();
		
		include HARMONI."metaData/dataTypes/register.inc.php";
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
		if (!$rule->check($class)) {
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
	
	function start() { }
	
	function stop() { }
}

?>