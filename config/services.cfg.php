<?php

/**
* Services Configuration
*
* In this file, include whatever class files you need and register the
* necessary services.
*
* @package harmoni.services
* @version $Id: services.cfg.php,v 1.38 2005/02/04 23:08:06 adamfranco Exp $
* @copyright 2003
**/

/* :: what services should we load? you can disable some to save on startup time :: */

/**
 * functionality affected: Authentication, LoginHandler
 */
if (!defined("LOAD_AUTHENTICATION")) 		define("LOAD_AUTHENTICATION", true);

/**
 * functionality affected: StorageHandler
 */
if (!defined("LOAD_STORAGE")) 				define("LOAD_STORAGE", true);

/**
 * functionality affected: AgentInformationHandler
 * requires: authentication
 */
if (!defined("LOAD_AGENTINFORMATION")) 		define("LOAD_AGENTINFORMATION", true);

/**
 * functionality affected: Debug output
 */
if (!defined("LOAD_DEBUG")) 				define("LOAD_DEBUG", true);

/**
 * functionality affected: Layout/Themes
 */
if (!defined("LOAD_THEMES")) 				define("LOAD_THEMES", true);

/**
 * functionality affected: HarmoniDataManager, sub-services: DataSetTypeManager, DataTypeManager, DataSetManager
 */
if (!defined("LOAD_DATAMANAGER")) 			define("LOAD_DATAMANAGER", true);

/**
 * functionality affected: almost everything but basic services: Harmoni architecture, LoginHandler, ActionHandler
 */
if (!defined("LOAD_ARCHITECTURE")) 			define("LOAD_ARCHITECTURE", true);

/**
 * functionality affected: Database connectivity, and anything that depends on it.
 */
if (!defined("LOAD_DBC")) 					define("LOAD_DBC", true);

/**
 * functionality affected: Sets
 */
if (!defined("LOAD_SETS")) 			define("LOAD_SETS", true);

/**
 * functionality affected: MIME Type sniffing, ImageProcessing
 */
if (!defined("LOAD_MIME")) 			define("LOAD_MIME", true);

/**
 * functionality affected: ImageProcessing
 */
if (!defined("LOAD_IMAGEPROCESSOR")) 		define("LOAD_IMAGEPROCESSOR", true);

/**
 * functionality affected: Language Localization
 */
if (!defined("LOAD_LANG")) 			define("LOAD_LANG", true);



/**
 * OKI OSID implementations:
 */
if (!defined("OKI_VERSION")) 			define("OKI_VERSION", NULL);

/**
 * Version 1 implementations
 */
if (OKI_VERSION === 1 || OKI_VERSION === NULL) {
	/**
	 * functionality affected: Hiearchy, Digital Repository.
	 */
	if (!defined("LOAD_HIERARCHY")) 			define("LOAD_HIERARCHY", true);
	
	/**
	 * functionality affected: Hiearchy, Digital Repository, DataManager, ID generation.
	 */
	if (!defined("LOAD_SHARED")) 				define("LOAD_SHARED", true);
	
	/**
	 * functionality affected: OKI AuthN calls.
	 */
	if (!defined("LOAD_AUTHN")) 				define("LOAD_AUTHN", true);
	
	/**
	 * functionality affected: OKI AuthZ calls.
	 */
	if (!defined("LOAD_AUTHZ")) 				define("LOAD_AUTHZ", true);
	
	/**
	 * functionality affected: Digital Repository.
	 */
	if (!defined("LOAD_DR")) 			define("LOAD_DR", true);
} 

/**
 * Version 2 implementations
 */
else if (OKI_VERSION === 2) {
	
	/**
	 * functionality affected: OKI Agent calls.
	 */
	if (!defined("LOAD_AGENT")) 				define("LOAD_AGENT", true);

	/**
	 * functionality affected: OKI AuthN calls.
	 */
	if (!defined("LOAD_AUTHN")) 				define("LOAD_AUTHN", true);
	
	/**
	 * functionality affected: OKI AuthZ calls.
	 */
	if (!defined("LOAD_AUTHZ")) 				define("LOAD_AUTHZ", true);
	
	/**
	 * functionality affected: Hiearchy, Digital Repository.
	 */
	if (!defined("LOAD_HIERARCHY")) 			define("LOAD_HIERARCHY", true);
	
	/**
	 * functionality affected: OKI Agent calls.
	 */
	if (!defined("LOAD_ID")) 				define("LOAD_ID", true);
	
	/**
	 * functionality affected: Digital Repository.
	 */
	if (!defined("LOAD_REPOSITORY")) 			define("LOAD_REPOSITORY", true);
}

else if (OKI_VERSION) {
	die ("Unknown OKI version, '".OKI_VERSION."'");
}




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
 */





/**
 * DON'T EDIT BELOW THIS LINE!
 *
 * HARMONI REQUIRED SERVICES
 *
 * These Services are *required* for proper Harmoni functionality.
 * If you choose to replace them, make SURE your classes implement the proper
 * interface so that compatibility can be assured.
 */

/**
 * load ArgumentValidator
 */
require_once(HARMONI."utilities/ArgumentValidator.class.php");

/**
 * load error handler
 */
require_once(HARMONI."errorHandler/ErrorHandler.class.php");
Services::registerService("ErrorHandler","ErrorHandler");
require_once(HARMONI."errorHandler/throw.inc.php");

/**
 * load user error handler
 */
Services::registerService("UserError","ErrorHandler");

/**
 * load DBHandler
 */
require_once(HARMONI."DBHandler/DBHandler.class.php");
Services::registerService("DBHandler","DBHandler");

/**
 * load authentication handler
 */
if (LOAD_AUTHENTICATION) {
	require_once(HARMONI."authenticationHandler/AuthenticationHandler.class.php");
	Services::registerService("Authentication","AuthenticationHandler");
	require_once(HARMONI_BASE."config/authentication.cfg.php");
}

/**
 * load debug handler
 */
if (LOAD_DEBUG) {
	require_once(HARMONI."debugHandler/DebugHandler.class.php");
	Services::registerService("Debug","DebugHandler");
	require_once(HARMONI."debugHandler/debug.class.php");
}

/**
 * load layout and theme handlers
 */
if (LOAD_THEMES) {
	require_once(HARMONI."layoutHandler/LayoutHandler.class.php");
	require_once(HARMONI."themeHandler/ThemeHandler.class.php");
	Services::registerService("Themes", "ThemeHandler");
}

/**
 * load the agent information handler
 */
if (LOAD_AGENTINFORMATION && LOAD_AUTHENTICATION) {
	require_once(HARMONI."authenticationHandler/AgentInformationHandler.class.php");
	Services::registerService("AgentInformation","AgentInformationHandler");
}

/**
 * load the Storage handler.
 */
if (LOAD_STORAGE) {
	require_once(HARMONI."storageHandler/StorageHandler.class.php");
	Services::registerService("Storage","StorageHandler");
	require_once(HARMONI_BASE."config/storage.cfg.php");
}

/**
 * include MetaDataManager files
 */
if (LOAD_DATAMANAGER) {
	require_once(HARMONI."dataManager/DataManager.abstract.php");
}

/**
 * load the LanguageLocalization service
 */
if (LOAD_LANG) {
	require_once(HARMONI."languageLocalizer/LanguageLocalizer.class.php");
	Services::registerService("Lang","LanguageLocalizer");
}

/**
 * load the Sets service
 */
if (LOAD_SETS) {
	require_once(HARMONI."sets/SetManager.class.php");
	Services::registerService("Sets","SetManager");
}

/**
 * load the Sets service
 */
if (LOAD_MIME) {
	require_once(HARMONI."utilities/MIMETypes.class.php");
	Services::registerService("MIME", "MIMETypes");
}

/**
 * load the Sets service
 */
if (LOAD_IMAGEPROCESSOR) {
	require_once(HARMONI."ImageProcessor/ImageProcessor.class.php");
	Services::registerService("ImageProcessor", "ImageProcessor");
}


/**
 * OKI OSID implementations:
 */

/**
 * Version 1 implementations
 */
if (OKI_VERSION === 1 || OKI_VERSION === NULL) {
	
	/**
	 * load the AuthNManager
	 */
	if (LOAD_AUTHN) {
		require_once(HARMONI."oki/authentication/HarmoniAuthenticationManager.class.php");
		Services::registerService("AuthN","HarmoniAuthenticationManager");
	}
	
	/**
	 * load the AuthZManager
	 */
	if (LOAD_AUTHZ) {
		require_once(HARMONI."oki/authorization/HarmoniAuthorizationManager.class.php");
		Services::registerService("AuthZ","HarmoniAuthorizationManager");
	}
	
	/**
	 * load the DigitalRepositoryManager.
	 */
	if (LOAD_DR) {
		require_once(HARMONI."oki/dr/HarmoniDigitalRepositoryManager.class.php");
		Services::registerService("DR","HarmoniDigitalRepositoryManager");
	}
	
	/**
	 * load the HierarchyManager.
	 */
	if (LOAD_HIERARCHY) {
		require_once(HARMONI."oki/hierarchy2/HarmoniHierarchyManager.class.php");
		Services::registerService("Hierarchy","HarmoniHierarchyManager");
	}
	
	/**
	 * load the SharedManager
	 */
	if (LOAD_SHARED) {
		require_once(HARMONI."oki/shared/HarmoniSharedManager.class.php");
		Services::registerService("Shared","HarmoniSharedManager");
	}
} 

/**
 * Version 2 implementations
 */
else if (OKI_VERSION === 2) {
	
	/**
	 * load the AgentManager
	 */
	if (LOAD_AGENT) {
		require_once(HARMONI."oki2/agent/HarmoniAgentManager.class.php");
		Services::registerService("Agent","HarmoniAgentManager");
	}
		
	/**
	 * load the AuthNManager
	 */
	if (LOAD_AUTHN) {
		require_once(HARMONI."oki2/authentication/HarmoniAuthenticationManager.class.php");
		Services::registerService("AuthN","HarmoniAuthenticationManager");
	}
	
	/**
	 * load the AuthZManager
	 */
	if (LOAD_AUTHZ) {
		require_once(HARMONI."oki2/authorization/HarmoniAuthorizationManager.class.php");
		Services::registerService("AuthZ","HarmoniAuthorizationManager");
	}
	
	/**
	 * load the HierarchyManager.
	 */
	if (LOAD_HIERARCHY) {
		require_once(HARMONI."oki2/hierarchy/HarmoniHierarchyManager.class.php");
		Services::registerService("Hierarchy","HarmoniHierarchyManager");
	}
	
	/**
	 * load the IdManager
	 */
	if (LOAD_ID) {
		require_once(HARMONI."oki2/id/HarmoniIdManager.class.php");
		Services::registerService("Id","HarmoniIdManager");
	}
		
	/**
	 * load the DigitalRepositoryManager.
	 */
	if (LOAD_REPOSITORY) {
		require_once(HARMONI."oki2/repository/HarmoniRepositoryManager.class.php");
		Services::registerService("Repository","HarmoniRepositoryManager");
	}
}

?>
