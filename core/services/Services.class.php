<?php

require_once(HARMONI."services/Services.abstract.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * The Services class handles starting, stopping, registering, etc of any available services.
 * @version $Id: Services.class.php,v 1.3 2003/08/26 15:47:24 adamfranco Exp $
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
	 * Registers a new service named $name. Upon starting, a new class of type $class will be instantiated.
	 * @param string $name The reference name of the service.
	 * @param string $class The class name to be instantiated.
	 * @access public
	 * @return boolean True on success. False if service is registered and running or an error occurs.
	 **/
	function register( $name, $class ) {
		// if its registered and started, throw fatal error return false.
		if ($this->running($name)) {
			die("Services::registerService('$name') - can not register service '$name' because it is already registered AND running.");
			return false;
		}
		if (!class_exists($class)) {
			die("Services::registerService('$name') - can not register service '$name' because the class '$class' does not exist!");
			return false;
		}

// Since objects in PHP4 can not impliment multiple interfaces -- interfaces don't exist --
// and objects cannot extend multiple classes, a hack to allow services which ARE an
// implimentation of the ServicesInterface (two methods, start() and stop() are all that's
// needed), but need to extend other interfaces as well, are needed.

// -----------Start Good Code ---------------
//		$rule =& new ExtendsValidatorRule("ServiceInterface");
		$tryObj =& new $class;
//		if (!$rule->check($tryObj)) {
// -----------End Good Code ---------------

// -----------Start Hack ---------------
		$canStart = method_exists($tryObj, "start");
		$canStop = method_exists($tryObj, "stop");
		if (!$canStart || !$canStop) {
// -----------End Hack ---------------
			die("Services::registerService('$name') - can not register service '$name' because the class '$class' does not implement the Service Interface. Please change your PHP class definitions to include the Service Interface.");
			return false;
		}
		unset($rule,$tryObj);
		// otherwise add to the the registered services array
		$this->_registeredServices[$name] = $class;
		return true;
	}
	
	/**
	 * Register's an object as a service. 
	 * @param string $name The name of the new service.
	 * @param ref object $object The object.
	 * @access public
	 * @return void
	 **/
	function registerObject($name ,&$object) {

// Since objects in PHP4 can not impliment multiple interfaces -- interfaces don't exist --
// and objects cannot extend multiple classes, a hack to allow services which ARE an
// implimentation of the ServicesInterface (two methods, start() and stop() are all that's
// needed), but need to extend other interfaces as well, are needed.

// -----------Start Good Code ---------------
//		$rule =& new ExtendsValidatorRule("ServiceInterface");
		$class = get_class($object);
//		if (!$rule->check($object)) {
// -----------End Good Code ---------------

// -----------Start Hack ---------------
		$canStart = method_exists($object, "start");
		$canStop = method_exists($object, "stop");
		if (!$canStart || !$canStop) {
// -----------End Hack ---------------		
			die("Services::registerService('$name') - can not register service '$name' because the class '$class' does not implement the Service Interface. Please change your PHP class definitions to include the Service Interface.");
			return false;
		}
		
		$this->_registeredServices[$name] = $class;
		$this->_services[$name] =& $object;
		return true;
	}
	
	/**
	 * Attempts to stop all running services.
	 * @access public
	 * @return void
	 **/
	function stopAll() {
		foreach (array_keys($this->_registeredServices) as $name)
			$this->stop($name);
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
			die("Services::getService('$name') - can not get service '$name' because it is not yet started.");
			return false;
		}
		return $this->_services[$name];
	}
	
	/**
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
		
		$this->_services[$name] =& new $classname;
		
		// make sure the service was instantiated properly
		if (!is_object($this->_services[$name]) || get_class($this->_services[$name]) != strtolower($classname)) {
			die("Services::startService('$name') - could not start service - the object of class $classname was not instantiated correctly");
			return false;
		}
		
		// call the service's start() method
		$this->_services[$name]->start();
		return true;
	}
	 
	/**
	 * Cycles through all registered services and attempts to start them.
	 * @access public
	 * @return void
	 **/
	function startAll() {
		foreach (array_keys($this->_registeredServices) as $service) {
			if (!$this->running($service)) $this->start($service);
		}
	}
	
	/**
	 * Attempts to stop the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function stop( $name ) {
		if ($this->running($name)) $this->_services[$name]->stop();
		unset($this->_services[$name]);
		return true;
	}
	
	/**
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
	 * @param string $name The service name.* 
	 * @access public
	 * @return boolean True if the service is available, false otherwise.
	 **/
	function available( $name ) {
		return (isset($this->_registeredServices[$name]))?true:false;
	}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function running ( $name ) {
		print "<br><h3>$name</h3>1.".isset($this->_services[$name])."<br>2.".($this->_services[$name])."<br>3.".get_class($this->_services[$name])."==".strtolower($this->_registeredServices[$name])."<br>";
		
		if (isset($this->_services[$name]) && ($this->_services[$name]) && get_class($this->_services[$name]) == strtolower($this->_registeredServices[$name])) {
			print "true<br>";
			return true;
		}
		print "false<br>";
		return false;
	}
	
	/**
	 * Stops all the services -- used internally by PHP.
	 * @access private
	 * @return void
	 **/
	function __sleep() {
		foreach ($this->_services as $service) $this->stop($service);
	}
	
}
	
?>