<?php

/**
 * Services Configuration
 * 
 * In this file, include whatever class files you need and register the
 * necessary services.
 *
 * @package harmoni.services
 * @version $Id: services.cfg.php,v 1.7 2003/07/03 18:03:20 gabeschine Exp $
 * @copyright 2003 
 **/

/**
 * USER DEFINED SERVICES 
 *
 * In this section, you can register your own services for your use in your
 * scripts. The syntax for registering a service is:
 * 
 *   Services::registerService(<user-defined name>,<class name>);
 * 
 * where <class name> stands for the class that will be instantiated when the
 * service starts -- service classes can not have any parameters required by
 * the constructor.
 * 
 * Using this feature, your scripts can use the service like this:
 * 
 *   Services::startService(<user-defined name>);
 *   $var =& Service::getService(<user-defined name>);
 *   $var->someMethod($someParameter,...);
 * 
 * Please look at the PHPDoc included with Harmoni for more details on Services.
 **/

// Example:
// require_once("/path/to/your/include/file.class.php");
// Services::registerService("SomeName","SomeClassName");








/**
 * HARMONI REQUIRED SERVICES
 *  
 * These Services are *required* for proper Harmoni functionality.
 * If you choose to replace them, make SURE your classes implement the proper
 * interface so that compatibility can be assured.
 **/

// load ArgumentValidator
require_once(HARMONI."utilities/ArgumentValidator.class.php");

// load error handler
require_once(HARMONI."errorHandler/ErrorHandler.class.php");
Services::registerService("ErrorHandler","ErrorHandler");

// load DBHandler
require_once(HARMONI."DBHandler/DBHandler.class.php");
Services::registerService("DBHandler","DBHandler");

// load authentication handler
require_once(HARMONI."config/authentication.cfg.php");

// load debug handler
require_once(HARMONI."debugHandler/DebugHandler.class.php");
Services::registerService("Debug","DebugHandler");

// load the agent information handler
require_once(HARMONI."authenticationHandler/AgentInformationHandler.class.php");
Services::registerService("AgentInformation","AgentInformationHandler");

// storage handler
require_once(HARMONI."storageHandler/StorageHandler.class.php");
Services::registerService("Storage","StorageHandler");
/**
 * Load wrapper classes and functions for some of the above services. 
 **/

// Debug
require_once(HARMONI."debugHandler/debug.class.php");

// ErrorHandler
require_once(HARMONI."errorHandler/throw.inc.php");

?>