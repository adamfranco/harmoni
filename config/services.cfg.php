<?php

/**
* Services Configuration
*
* In this file, include whatever class files you need and register the
* necessary services.
*
* @package harmoni.services
* @version $Id: services.cfg.php,v 1.12 2003/11/26 02:35:00 gabeschine Exp $
* @copyright 2003
**/

/* :: what services should we load? you can disable some to save on startup time :: */

// functionality affected: Authentication, LoginHandler
define("LOAD_AUTHENTICATION", true);

// functionality affected: StorageHandler
define("LOAD_STORAGE", true);

// functionality affected: AgentInformationHandler
// requires: authentication
define("LOAD_AGENTINFORMATION", true);

// functionality affected: Debug output
define("LOAD_DEBUG", true);

// functionality affected: HarmoniDataManager, sub-services: DataSetTypeManager, DataTypeManager,
// 		DataSetManager
define("LOAD_DATAMANAGER", true);

// functionality affected: almost everything but basic services: Harmoni architecture, LoginHandler,
//      ActionHandler
define("LOAD_ARCHITECTURE", true);

// functionality affected: Database connectivity, and anything that depends on it.
define("LOAD_DBC", true);

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
* DON'T EDIT BELOW THIS LINE!
*
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

// load user error handler
Services::registerService("UserError","ErrorHandler");

// load DBHandler
require_once(HARMONI."DBHandler/DBHandler.class.php");
Services::registerService("DBHandler","DBHandler");

// load authentication handler
if (LOAD_AUTHENTICATION) {
	require_once(HARMONI."authenticationHandler/AuthenticationHandler.class.php");
	Services::registerService("Authentication","AuthenticationHandler");
	require_once(HARMONI_BASE."config/authentication.cfg.php");
}

// load debug handler
if (LOAD_DEBUG) {
	require_once(HARMONI."debugHandler/DebugHandler.class.php");
	Services::registerService("Debug","DebugHandler");
}

// load the agent information handler
if (LOAD_AGENTINFORMATION && LOAD_AUTHENTICATION) {
	require_once(HARMONI."authenticationHandler/AgentInformationHandler.class.php");
	Services::registerService("AgentInformation","AgentInformationHandler");
}

// load the Storage handler.
if (LOAD_STORAGE) {
	require_once(HARMONI."storageHandler/StorageHandler.class.php");
	Services::registerService("Storage","StorageHandler");
	require_once(HARMONI_BASE."config/storage.cfg.php");
}

// include MetaDataManager files
if (LOAD_DATAMANAGER) {
//	require_once(HARMONI."metaData/manager/HarmoniDataManager.abstract.php");
}

/**
* Load wrapper classes and functions for some of the above services.
**/

// Debug
require_once(HARMONI."debugHandler/debug.class.php");

// ErrorHandler
require_once(HARMONI."errorHandler/throw.inc.php");

?>
