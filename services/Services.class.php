<?php

require_once(HARMONI."services/Services.abstract.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * The Services class handles starting, stopping, registering, etc of any available services.
 * The Services class handles starting, stopping, registering, etc of any available services.
 * @version $Id: Services.class.php,v 1.5 2003/06/26 18:11:46 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.services
 **/

class Services extends ServicesAbstract {
	/**
	 * A private array of services: array("key1"=>ServiceObject1, ...)
	 *
	 * @var array $_services The array of services.
	 **/
	var $_services;
	
	/**
	 * A private array of registerd services: array("key1"=>classname, ...)
	 *
	 * @var array $_registeredServices The array of registered services.
	 **/
	var $_registeredServices;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function Services() {
		$this->_services = array();
	}
	
	/**
	 * Registers a new service.
	 *
	 * Registers a new service named $name. Upon starting, a new class of type $class will be instantiated.
	 * @param string $name The reference name of the service.
	 * @param string $class The class name to be instantiated.
	 * @access public
	 * @return boolean True on success. False if service is registered and running or an error occurs.
	 **/
	function register( $name, $class ) {
		// if its registered and started, throw fatal error return false.
		if ($this->running($name)) {
			die("Services::registerService('$name') or Services::register('$name') - can not register service '$name' because it is already registered AND running.");
			return false;
		}
		$rule =& new ExtendsValidatorRule("ServiceInterface");
		$tryObj =& new $class;
		if (!$rule->check($tryObj)) {
			die("Services::registerService('$name') or Services::register('$name') - can not register service '$name' because the class '$class' does not implement the Service Interface. Please change your PHP class definitions to include the Service Interface.");
			return false;
		}
		unset($rule,$tryObj);
		// otherwise add to the the registered services array
		$this->_registeredServices[$name] = $class;
		return true;
	}
	
	/**
	 * Returns the service object associated with reference name $name.
	 * Returns the service object associated with reference name $name.
	 * @param string $name The reference name of the service.
	 * @access public
	 * @return object Object|false The service object.
	 **/
	function & get( $name ) {
		if (!$this->running($name)) {
			die("Services::getService('$name') or Services::get('$name') - can not get service '$name' because it is not yet started.");
			return false;
		}
		return $this->_services[$name];
	}
	
	/**
	 * Attempts to start the service referenced by $name.
	 * Attempts to start the service referenced by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function start( $name ) {
		// make sure that the service is not currently running.
		if ($this->running($name))
			return true;
		
		$classname = $this->_registeredServices[$name];
		
		// check if $classname has been defined as a class
		if (!class_exists($classname)) {
			die("Services::startService('$name') or Services::start('$name') - can not start service - class $classname is not defined - make sure you include the appropriate file(s)");
			return false;
		}
		
		$this->_services[$name] =& new $classname;
		
		// make sure the service was instantiated properly
		if (!is_object($this->_services[$name]) || get_class($this->_services[$name]) != strtolower($classname)) {
			die("Services::startService('$name') or Services::start('$name') - could not start service - the object of class $classname was not instantiated correctly");
			return false;
		}
		return true;
	}
	 
	/**
	 * Attempts to stop the service reference by $name.
	 * Attempts to stop the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function stop( $name ) {
		unset($this->_services[$name]);
		return true;
	}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * Attempts to restart the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function restart( $name ) {
		if (!$this->stop($name))
			return false;
		if (!$this->start($name))
			return false;
		return true;
	}
	
	/**
	 * Checks if the service referenced by $name is available for use.
	 * Checks if the service referenced by $name is available for use.
	 * @param string $name The service name.* 
	 * @access public
	 * @return boolean True if the service is available, false otherwise.
	 **/
	function available( $name ) {
		return (isset($this->_registeredServices[$name]))?true:false;
	}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function running ( $name ) {
		if (is_object($this->_services[$name]) && get_class($this->_services[$name]) == strtolower($this->_registeredServices[$name]))
			return true;
		return false;
	}
	
	/**
	 * Stops all the services -- used internally by PHP.
	 * @access public
	 * @return void
	 **/
	function __sleep() {
		foreach ($this->_services as $service) $this->stop($service);
	}
	
}
	
?>