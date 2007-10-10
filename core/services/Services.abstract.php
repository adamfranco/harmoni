<?php

require_once(HARMONI."services/Services.interface.php");

/**
 * The ServicesAbstract class defines the public static methods used by users.
 *
 * @static
 * @abstract
 *
 * @package harmoni.services
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Services.abstract.php,v 1.17 2007/10/10 22:58:40 adamfranco Exp $
 */
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
	static function registerService( $name, $class ) {
		return $GLOBALS[SERVICES_OBJECT]->register( $name, $class );
	}
	
	/**
	 * Register's an object as a service. 
	 * @param string $name The name of the new service.
	 * @param ref object $object The object.
	 * @access public
	 * @return void
	 **/
	static function registerObjectAsService($name, $object) {
		$GLOBALS[SERVICES_OBJECT]->registerObject($name,$object);
	}
	
	/**
	 * Create an alias from one service name to another.
	 * 
	 * @param string $name1
	 * @param string $name2
	 * @return void
	 * @access public
	 * @since 3/24/05
	 @static
	 */
	static function createServiceAlias ($name1, $name2) {
		$GLOBALS[SERVICES_OBJECT]->createAlias($name1, $name2);
	}
	
	/**
	 * Returns the services object.
	 * @access public
	 * @static
	 * @return object Services The Services object.
	 **/
	static function getServices() {
		return $GLOBALS[SERVICES_OBJECT];
	}
	
	/**
	 * Returns the service object associated with reference name $name.
	 * @param string $name The reference name of the service.
	 * @access public
	 * @static
	 * @return object Object The service object.
	 **/
	static function getService( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->get( $name );
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
	static function startService( $name, $args=null ) {
		$backtrace = debug_backtrace();
		print "\n<br/><strong>Warning: Method call, Services::startService(), is deprecated. Please use Services::startManagerAsService() and/or Services::getService() instead. ";
		print $backtrace[0]['file']." (Line ".$backtrace[0]['line'].")";
		
		$argList='';
		if (func_num_args() > 1) {
			for ($i=1; $i<func_num_args(); $i++) {
				$var = "arg$i";
				$$var = func_get_arg($i);
				$argList .= ', $arg'.$i;
			}
		}
		$str = '$result = $GLOBALS[SERVICES_OBJECT]->start( $name'.$argList.' );';
//		print "$name: ".$str."<pre>".print_r($arg1, TRUE)."</pre>";
//		$str = 'return $GLOBALS[SERVICES_OBJECT]->start( $name'.$argList.' );';
		eval($str);
//		var_dump($result);
		return $result;
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
	 * @static
	 */
	static function startManagerAsService ( $name, $context, $configuration ) {
		return $GLOBALS[SERVICES_OBJECT]->startManager($name, $context, $configuration);
	}
	
	/**
	 * Cycles through all registered services and attempts to start them.
	 * @static
	 * @access public
	 * @return void
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
	 **/
	static function startAllServices() {
		$backtrace = debug_backtrace();
		print "\n<br/><strong>Warning: Method call, Services::startAllServices(), is deprecated. Please use Services::startManagerAsService() and/or Services::getService() instead. ";
		print $backtrace[0]['file']." (Line ".$backtrace[0]['line'].")";
		print "</strong><br/>\n";
		$GLOBALS[SERVICES_OBJECT]->startAll();
	}
	
	
	/**
	 * Attempts to stop the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
	 **/
	static function stopService( $name ) {
		$backtrace = debug_backtrace();
		print "\n<br/><strong>Warning: Method call, Services::stopService(), is deprecated. Please use Services::startManagerAsService() and/or Services::getService() instead. ";
		print $backtrace[0]['file']." (Line ".$backtrace[0]['line'].")";
		return $GLOBALS[SERVICES_OBJECT]->stop( $name );
	}
	
	/**
	 * Attempts to stop all running services.
	 * @access public
	 * @return void
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
	 * @static
	 **/
	static function stopAllServices() {
		$backtrace = debug_backtrace();
		print "\n<br/><strong>Warning: Method call, Services::stopAllServices(), is deprecated. Please use Services::startManagerAsService() and/or Services::getService() instead. ";
		print $backtrace[0]['file']." (Line ".$backtrace[0]['line'].")";
		return $GLOBALS[SERVICES_OBJECT]->stopAll();
	}
	
	/**
	 * Attempts to restart the service reference by $name.
	 * @param string $name The service name.
	 * @access public
	 * @static
	 * @return boolean True on success.
	 * @deprecated 2005/04/04 Use {@link startManagerAsService()} and {@link getService()} instead.
	 **/
	static function restartService( $name ) {
		$backtrace = debug_backtrace();
		print "\n<br/><strong>Warning: Method call, Services::restartService(), is deprecated. Please use Services::startManagerAsService() and/or Services::getService() instead. ";
		print $backtrace[0]['file']." (Line ".$backtrace[0]['line'].")";
		print "</strong><br/>\n";
		return $GLOBALS[SERVICES_OBJECT]->restart( $name );
	}
	
	/**
	 * Checks if the service referenced by $name is available for use.
	 * @access public
	 * @static
	 * @param string $name The service name.
	 * @return boolean True if the service is available, false otherwise.
	 **/
	static function serviceAvailable( $name ) {
		return $GLOBALS[SERVICES_OBJECT]->available( $name );
	}
	
	/**
	 * Checks if the service referenced by $name has been started.
	 * @access public
	 * @static
	 * @param string $name The service name.
	 * @return boolean True if the service is running, false otherwise.
	 **/
	static function serviceRunning( $name ) {
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
	 * @deprecated 2004/07/28 Use {@link startManagerAsService()} and {@link getService()} instead.
	 **/
	static function requireService( $service, $start=true ) {
		$backtrace = debug_backtrace();
		print "\n<br/><strong>Warning: Method call, Services::requireService(), is deprecated. Please use Services::startManagerAsService() and/or Services::getService() instead. ";
		print $backtrace[0]['file']." (Line ".$backtrace[0]['line'].")";
		print "</strong><br/>\n";
		
		$error = false;
		if (!Services::serviceAvailable($service)) {
			$error = true;
		} else if ($start && !Services::serviceRunning($service) && !Services::startService($service)) {
			$error = true;
		}
		if ($error) {
			// if we have the error Handler, throw a pretty error with that,
			// otherwise, use the die() function.
			if ($GLOBALS[SERVICES_OBJECT]->available( 'ErrorHandler' )) {
				throwError(new Error("A required Service <b>\"$service\"</b> ".(($start)? "could not be started":"is not available"), "Services", 1));
			} else {
				$debug = debug_backtrace();
				$str = "<B>FATAL ERROR</b><br /><br />";
				$str .= "A required Service <b>\"$service\"</b> ";
				$str .= ($start)? "could not be started":"is not available";
				$str .= ".<br /><br />\n";
				$str .= "<b>Debug backtrace:</b>\n";
				$str .= "<pre>\n";
				$str .= print_r($debug, true);
				$str .= "\n</pre>\n";
				die($str);
			}
		}
		if ($start) return Services::getService($service);
	}
}