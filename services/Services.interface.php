<?php

/**
 * The ServicesInterface defines the functionality required by any Services class or derivative.
 * The ServicesInterface defines the functionality required by any Services class or derivative.
 * @version $Id: Services.interface.php,v 1.2 2003/06/25 20:42:02 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.services
 **/

class ServicesInterface {
	/*     STATIC METHODS     */
	
	/**
	 * Registers a new service.
	 *
	 * Registers a new service named $name. Upon starting, a new class of type $class will be instantiated.
	 * @param string $name The reference name of the service.
	 * @param string $class The class name to be instantiated.
	 * @access public
	 * @static
	 * @return boolean True on success. False if service is registered and running or an error occurs.
	 **/
	function registerService( $name, $class ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Returns the services object.
	 * Returns the services object.
	 * @access public
	 * @static
	 * @return object Services The Services object.
	 **/
	function & getServices() {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Returns the service object associated with reference name $name.
	 * Returns the service object associated with reference name $name.
	 * @param string $name The reference name of the service.
	 * @access public
	 * @static
	 * @return object Object The service object.
	 **/
	function & getService( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Attempts to start the service referenced by $name.
	 * Attempts to start the service referenced by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 **/
	function startService( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Attempts to stop the service reference by $name.
	 * Attempts to stop the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 **/
	function stopService( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * Attempts to restart the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 **/
	function restartService( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Checks if the service referenced by $name is available for use.
	 * Checks if the service referenced by $name is available for use.
	 * @access public
	 * @param string $name The service name.
	 * @static
	 * @return boolean True if the service is available, false otherwise.
	 **/
	function serviceAvailable( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @param string $name The service name.
	 * @static
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function serviceRunning( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	
	/* 			MEMBER METHODS			*/
	
	/**
	 * Registers a new service.
	 *
	 * Registers a new service named $name. Upon starting, a new class of type $class will be instantiated.
	 * @param string $name The reference name of the service.
	 * @param string $class The class name to be instantiated.
	 * @access public
	 * @return boolean True on success. False if service is registered and running or an error occurs.
	 **/
	function register( $name, $class ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
		
	/**
	 * Returns the service object associated with reference name $name.
	 * Returns the service object associated with reference name $name.
	 * @param string $name The reference name of the service.
	 * @access public
	 * @return object Object The service object.
	 **/
	function & get( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Attempts to start the service referenced by $name.
	 * Attempts to start the service referenced by $name.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True on success.
	 **/
	function start( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Attempts to stop the service reference by $name.
	 * Attempts to stop the service reference by $name.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True on success.
	 **/
	function stop( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * Attempts to restart the service reference by $name.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True on success.
	 **/
	function restart( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Checks if the service referenced by $name is available for use.
	 * Checks if the service referenced by $name is available for use.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is available, false otherwise.
	 **/
	function available( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	function running( $name ) {die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}
}
	
?>