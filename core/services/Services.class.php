<?php

require_once(HARMONI."services/Services.abstract.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * The Services class handles starting, stopping, registering, etc of any available services.
 * @version $Id: Services.class.php,v 1.21 2005/04/12 18:22:57 adamfranco Exp $
 *
 * @package harmoni.services
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Services.class.php,v 1.21 2005/04/12 18:22:57 adamfranco Exp $
 */
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
		$this->_aliases = array();
	}
	
	/**
	* @return array
	* Returns a backtrace string to prepend onto error messages.	
 	*/
	function _getBacktrace() {
		$bt = debug_backtrace();
		$str = "<pre>".print_r($bt,true) . "</pre><br /><br />";
//		$str = $bt[2]['file'].":".$bt[2]['line']."<br /><br />";
		return $str;
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
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::registerService('$name') - can not 
					register service '$name' because it is already registered AND 
					running.", "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::registerService('$name') - can not 
					register service '$name' because it is already registered AND running.");
			}
			return false;
		}
		if (!class_exists($class)) {
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::registerService('$name') - can not 
				register service '$name' because the class '$class' does not exist!"
				, "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::registerService('$name') - can not 
				register service '$name' because the class '$class' does not exist!");
			}
			return false;
		}

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
		$class = get_class($object);

		$this->_registeredServices[$name] = $class;
		$this->_services[$name] =& $object;
		return true;
	}
	
	/**
	 * Create an alias from one service name to another.
	 * 
	 * @param string $registeredName
	 * @param string $aliasName
	 * @return void
	 * @access public
	 * @since 3/24/05
	 */
	function createAlias ($registeredName, $aliasName) {
		if (!$this->_registeredServices[$registeredName]) {
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::createAlias('$registeredName', '$aliasName') - failed because an '$registeredName' wasn't registered yet."
				, "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::createAlias('$registeredName', '$aliasName') - failed because an '$registeredName' wasn't registered yet.");
			}
		}
		
		if ($this->_aliases[$aliasName] || $this->_registeredServices[$aliasName]) {
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::createAlias('$registeredName', '$aliasName') - failed because an '$aliasName' is already in use."
				, "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::createAlias('$registeredName', '$aliasName') - failed because an '$aliasName' is already in use.");
			}
		}
		
		$this->_aliases[$aliasName] = $registeredName;
	}
	
	/**
	 * Attempts to stop all running services.
	 * @access public
	 * @return void
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
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
	function &get( $name ) {
		$name = $this->_getServiceName($name);
		if (!$this->running($name)) {
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::getService('$name') - can not get service
					'$name' because it is not yet started.", "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::getService('$name') - can not get
					service '$name' because it is not yet started.");
			}
			return false;
		}
		return $this->_services[$name];
	}
	
	/**
	 * Attempts to start the service referenced by $name.
	 * @param string $name The service name.
	 * @param optional mixed $args,... Optional arguments to pass to the constructor of the service class.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
	 **/
	function start( $name, $args=null ) {
		$name = $this->_getServiceName($name);
		// make sure that the service is not currently running.
		if ($this->running($name))
			return true;
		
		$classname = $this->_registeredServices[$name];
//		print "<pre>".print_r($this->_registeredServices, TRUE)."</pre><br />$classname<br />";
		
		$argList=array();
		if (func_num_args() > 1) {
			for ($i=1; $i<func_num_args(); $i++) {
				$var = "arg$i";
				$$var = func_get_arg($i);
				$argList[] = '$arg'.$i;
			}
		}
		
		$str = '$this->_services[$name] =& new '.$classname.'('.implode(', ', $argList).');';
//		print "<br />$str";

		if (!$classname)
			throwError(new Error("Services::startService('$name') - could not 
				start service - A classname was not registered for this service
				correctly", "Services", 1));
				
		eval($str);
		
//		$this->_services[$name] =& new $classname;
		
		// make sure the service was instantiated properly
		if (!is_object($this->_services[$name]) 
			|| strtolower(get_class($this->_services[$name])) != strtolower($classname)) 
		{
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::startService('$name') - could not 
				start service - the object of class $classname was not instantiated 
				correctly", "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::startService('$name') - could not 
				start service - the object of class $classname was not instantiated 
				correctly");
			}
			return false;
		}
		
		return true;
	}
	
	/**
	 * Attempts to start the manager referenced by $name. The manager must
	 * extend OsidManager And assign its context and configuration.
	 * 
	 * @param string $name
	 * @param object OsidContext $context
	 * @param object Properties $configuration
	 * @return boolean true on success
	 * @access public
	 * @since 3/24/05
	 */
	function startManager ( $name, &$context, &$configuration ) {
		$name = $this->_getServiceName($name);
		// make sure that the service is not currently running.
		if ($this->running($name))
			return true;
		
		$classname = $this->_registeredServices[$name];
		
		if (!$classname)
			throwError(new Error("Services::startService('$name') - could not 
				start service - A classname was not registered for this service
				correctly", "Services", 1));
						
		$this->_services[$name] =& new $classname;
		$this->_services[$name]->assignOsidContext($context);
		$this->_services[$name]->assignConfiguration($configuration);
		
		
		// make sure the service was instantiated properly
		if (!is_object($this->_services[$name]) 
			|| strtolower(get_class($this->_services[$name])) != strtolower($classname)) 
		{
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($this->_registeredServices['ErrorHandler']) {
				throwError(new Error("Services::startService('$name') - could not 
				start service - the object of class $classname was not instantiated 
				correctly", "Services", 1));
			} else {
				die($this->_getBacktrace()."Services::startService('$name') - could not 
				start service - the object of class $classname was not instantiated 
				correctly");
			}
			return false;
		}
		
		return true;
	}
	 
	/**
	 * Cycles through all registered services and attempts to start them.
	 * @access public
	 * @return void
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
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
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
	 **/
	function stop( $name ) {
		$name = $this->_getServiceName($name);
		unset($this->_services[$name]);
		return true;
	}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
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
		$name = $this->_getServiceName($name);
		return (isset($this->_registeredServices[$name]))?true:false;
	}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function running ( $name ) {
		$name = $this->_getServiceName($name);
		if (isset($this->_services[$name]) && is_object($this->_services[$name]) 
			&& strtolower(get_class($this->_services[$name])) == strtolower($this->_registeredServices[$name]))
		{
			return true;
		}
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
	
	/**
	 * Get service name. Gets the name of a service or its alias.
	 * 
	 * @param string $name
	 * @return string
	 * @access public
	 * @since 3/24/05
	 */
	function _getServiceName ($name) {
		if ($this->_aliases[$name])
			return $this->_aliases[$name];
		else
			return $name;
	}
}
	
?>