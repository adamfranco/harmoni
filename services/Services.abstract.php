<?php

require_once(HARMONI."services/Services.interface.php");


/**
 * @const SERVICES_OBJECT The name of the services variable.
 **/
//define("SERVICES_OBJECT","__services__");

$__services__ = NULL;				// above defined variable must be set to NULL

/**
 * The ServicesAbstract class defines the public static methods used by users.
 * The ServicesAbstract class defines the public static methods used by users.
 * @version $Id: Services.abstract.php,v 1.3 2003/06/25 20:42:02 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.services
 **/

class ServicesAbstract
	extends ServicesInterface {
	
	/**
	 * Registers a new service.
	 *
	 * Registers a new service named $name. Upon starting, a new class of type $class will be instantiated.
	 * @param string $name The reference name of the service.
	 * @param string $class The class name to be instantiated.
	 * @access public
	 * @return boolean True on success. False if service is registered and running or an error occurs.
	 **/
	function registerService( $name, $class ) {
		return $GLOBALS[SERVICES_OBJECT]->register( $name, $class );
	}
	
	/**
	 * Returns the services object.
	 * Returns the services object.
	 * @access public
	 * @return object Services The Services object.
	 **/
	function & getServices() {
		return $GLOBALS[SERVICES_OBJECT];
	}
	
	/**
	 * Returns the service object associated with reference name $name.
	 * Returns the service object associated with reference name $name.
	 * @param string $name The reference name of the service.
	 * @access public
	 * @return object Object The service object.
	 **/
	function & getService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->get( $name );
	}
	
	/**
	 * Attempts to start the service referenced by $name.
	 * Attempts to start the service referenced by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function startService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->start( $name );
	}
	
	/**
	 * Attempts to stop the service reference by $name.
	 * Attempts to stop the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function stopService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->stop( $name );
	}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * Attempts to restart the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @return boolean True on success.
	 **/
	function restartService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->restart( $name );
	}
	
	/**
	 * Checks if the service referenced by $name is available for use.
	 * Checks if the service referenced by $name is available for use.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is available, false otherwise.
	 **/
	function serviceAvailable( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->available( $name );
	}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function serviceRunning( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->running( $name );
	}
}