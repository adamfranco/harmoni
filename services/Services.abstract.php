<?php

require_once(HARMONI."services/Services.interface.php");

/**
 * The ServicesAbstract class defines the public static methods used by users.
 * @version $Id: Services.abstract.php,v 1.8 2003/08/07 22:09:04 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @static
 * @abstract
 * @package harmoni.services
 **/

class ServicesAbstract
	extends ServicesInterface {
	
	/**
	 * Registers a new service named $name. Upon starting, a new class of type $class will be instantiated.
	 * @param string $name The reference name of the service.
	 * @param string $class The class name to be instantiated.
	 * @access public
	 * @static
	 * @return boolean True on success. False if service is registered and running or an error occurs.
	 **/
	function registerService( $name, $class ) {
		return $GLOBALS[SERVICES_OBJECT]->register( $name, $class );
	}
	
	/**
	 * Register's an object as a service. 
	 * @param string $name The name of the new service.
	 * @param ref object $object The object.
	 * @access public
	 * @return void
	 **/
	function registerObjectAsService($name, &$object) {
		$GLOBALS[SERVICES_OBJECT]->registerObject($name,$object);
	}
	
	/**
	 * Returns the services object.
	 * @access public
	 * @static
	 * @return object Services The Services object.
	 **/
	function & getServices() {
		return $GLOBALS[SERVICES_OBJECT];
	}
	
	/**
	 * Returns the service object associated with reference name $name.
	 * @param string $name The reference name of the service.
	 * @access public
	 * @static
	 * @return object Object The service object.
	 **/
	function & getService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->get( $name );
	}
	
	/**
	 * Attempts to start the service referenced by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 **/
	function startService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->start( $name );
	}
	
	/**
	 * Cycles through all registered services and attempts to start them.
	 * @static
	 * @access public
	 * @return void
	 **/
	function startAllServices() {
		$GLOBALS[SERVICES_OBJECT]->startAll();
	}
	
	
	/**
	 * Attempts to stop the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 **/
	function stopService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->stop( $name );
	}
	
	/**
	 * Attempts to stop all running services.
	 * @access public
	 * @return void
	 **/
	function stopAllServices() {
		return $GLOBALS[SERVICES_OBJECT]->stopAll();
	}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 **/
	function restartService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->restart( $name );
	}
	
	/**
	 * Checks if the service referenced by $name is available for use.
	 * @access public
	 * @static
	 * @param string $name The service name.
	 * @return boolean True if the service is available, false otherwise.
	 **/
	function serviceAvailable( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->available( $name );
	}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @static
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function serviceRunning( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->running( $name );
	}
	
	/**
	 * The Require Service function checks for required service availability.
	 * 
	 * The function first checks for service availabilty, and then attempts to
	 * start the service if it's available. If either action fails, it stops
	 * script execution. If $start=false then the function will only check for 
	 * availability.
	 * @param string $name The name of the service.
	 * @param boolean $start If we should attempt to start the service or not.
	 * @access public
	 * @static
	 * @return ref object The started service object. (if start=true)
	 **/
	function &requireService( $service, $start=true ) {
		$error = false;
		if (!Services::serviceAvailable($service)) {
			$error = true;
		} else if ($start && !Services::serviceRunning($service) && !Services::startService($service)) {
			$error = true;
		}
		
		if ($error) {
			$debug = debug_backtrace();
			$str = "<B>FATAL ERROR</b><BR><BR>";
			$str .= "A required Service <b>\"$service\"</b> ";
			$str .= ($start)? "could not be started":"is not available";
			$str .= ".<br><br>\n";
			$str .= "<b>Debug backtrace:</b>\n";
			$str .= "<pre>\n";
			$str .= print_r($debug, true);
			$str .= "\n</pre>\n";
			die($str);
		}
		if ($start) return Services::getService($service);
	}
}