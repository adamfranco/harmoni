<?php

/**
* Services Configuration
*
* In this file, include whatever class files you need and register the
* necessary services.
*
* @package harmoni.services
* @version $Id: services.cfg.php,v 1.25 2004/06/08 15:29:58 dobomode Exp $
* @copyright 2003
**/

/* :: what services should we load? you can disable some to save on startup time :: */

// functionality affected: Authentication, LoginHandler
if (!defined("LOAD_AUTHENTICATION")) 		define("LOAD_AUTHENTICATION", true);

// functionality affected: StorageHandler
if (!defined("LOAD_STORAGE")) 				define("LOAD_STORAGE", true);

// functionality affected: AgentInformationHandler
// requires: authentication
if (!defined("LOAD_AGENTINFORMATION")) 		define("LOAD_AGENTINFORMATION", true);

// functionality affected: Debug output
if (!defined("LOAD_DEBUG")) 				define("LOAD_DEBUG", true);

// functionality affected: Layout/Themes
if (!defined("LOAD_THEMES")) 				define("LOAD_THEMES", true);

// functionality affected: HarmoniDataManager, sub-services: DataSetTypeManager, DataTypeManager,
// 		DataSetManager
if (!defined("LOAD_DATAMANAGER")) 			define("LOAD_DATAMANAGER", true);

// functionality affected: almost everything but basic services: Harmoni architecture, LoginHandler,
//      ActionHandler
if (!defined("LOAD_ARCHITECTURE")) 			define("LOAD_ARCHITECTURE", true);

// functionality affected: Database connectivity, and anything that depends on it.
if (!defined("LOAD_DBC")) 					define("LOAD_DBC", true);

// functionality affected: Hiearchy, Digital Repository.
if (!defined("LOAD_HIERARCHY")) 			define("LOAD_HIERARCHY", true);

// functionality affected: Hiearchy, Digital Repository.
if (!defined("LOAD_HIERARCHY2")) 			define("LOAD_HIERARCHY2", true);

// functionality affected: Hiearchy, Digital Repository, DataManager, ID generation.
if (!defined("LOAD_SHARED")) 				define("LOAD_SHARED", true);

// functionality affected: OKI AuthN calls.
if (!defined("LOAD_AUTHN")) 				define("LOAD_AUTHN", true);

// functionality affected: Digital Repository.
if (!defined("LOAD_DR")) 			define("LOAD_DR", true);

// functionality affected: Language Localization
if (!defined("LOAD_LANG")) 			define("LOAD_LANG", true);

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

// load layout and theme handlers
if (LOAD_THEMES) {
	require_once(HARMONI."layoutHandler/LayoutHandler.class.php");
//	Services::registerService("Layout","LayoutHandler");
	require_once(HARMONI."themeHandler/ThemeHandler.class.php");
//	Services::registerService("Theme","ThemeHandler");
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

// load the HierarchyManager.
// THIS IT THE OLD HIERARCHY IMPLEMENTATION
//if (LOAD_HIERARCHY) {
//	require_once(HARMONI."oki/hierarchy/HarmoniHierarchyManager.class.php");
//	Services::registerService("Hierarchy","HarmoniHierarchyManager");
//}

// load the HierarchyManager.
if (LOAD_HIERARCHY) {
	require_once(HARMONI."oki/hierarchy2/HarmoniHierarchyManager.class.php");
	Services::registerService("Hierarchy","HarmoniHierarchyManager");
}

// load the SharedManager
if (LOAD_SHARED) {
	require_once(HARMONI."oki/shared/HarmoniSharedManager.class.php");
	Services::registerService("Shared","HarmoniSharedManager");
}

// load the AuthNManager
if (LOAD_AUTHN) {
	require_once(HARMONI."oki/authentication/HarmoniAuthenticationManager.class.php");
	Services::registerService("AuthN","HarmoniAuthenticationManager");
}

// load the DigitalRepositoryManager.
if (LOAD_DR) {
	require_once(HARMONI."oki/dr/HarmoniDigitalRepositoryManager.class.php");
	Services::registerService("DR","HarmoniDigitalRepositoryManager");
}

// include MetaDataManager files
if (LOAD_DATAMANAGER) {
	require_once(HARMONI."metaData/manager/HarmoniDataManager.abstract.php");
}

// load the LanguageLocalization service
if (LOAD_LANG) {
	require_once(HARMONI."languageLocalizer/LanguageLocalizer.class.php");
	Services::registerService("Lang","LanguageLocalizer");
}

/**
* Load wrapper classes and functions for some of the above services.
**/

// Debug
require_once(HARMONI."debugHandler/debug.class.php");

// ErrorHandler
require_once(HARMONI."errorHandler/throw.inc.php");

?>
