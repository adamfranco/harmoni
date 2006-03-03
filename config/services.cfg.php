<?php

/**
 * Services Configuration
 *
 * In this file, include whatever class files you need and register the
 * necessary services.
 *
 * @package harmoni.services
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: services.cfg.php,v 1.54 2006/03/03 17:45:52 adamfranco Exp $
 */

/* :: what services should we load? you can disable some to save on startup time :: */

/**
 * functionality affected: StorageHandler
 */
if (!defined("LOAD_STORAGE")) 				define("LOAD_STORAGE", true);

/**
 * functionality affected: Debug output
 */
if (!defined("LOAD_DEBUG")) 				define("LOAD_DEBUG", true);

/**
 * functionality affected: Themes/Layouts through the GUIManager
 */
if(!defined("LOAD_GUI"))			define("LOAD_GUI",false);

/**
 * functionality affected: HarmoniDataManager, sub-services: DataSetTypeManager, DataTypeManager, DataSetManager
 */
if (!defined("LOAD_DATAMANAGER")) 			define("LOAD_DATAMANAGER", true);

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
 * functionality affected: OKI Agent calls.
 */
if (!defined("LOAD_AGENT")) 				define("LOAD_AGENT", true);

/**
 * functionality affected: OKI AuthN calls.
 */
if (!defined("LOAD_AUTHN")) 				define("LOAD_AUTHN", true);

/**
 * functionality affected: OKI AuthN calls.
 */
if (!defined("LOAD_AGENT_MANAGEMENT")) 				define("LOAD_AGENT_MANAGEMENT", true);

/**
 * functionality affected: OKI AuthZ calls.
 */
if (!defined("LOAD_AUTHZ")) 				define("LOAD_AUTHZ", true);

/**
 * functionality affected: Hiearchy, Digital Repository.
 */
if (!defined("LOAD_HIERARCHY")) 			define("LOAD_HIERARCHY", true);

/**
 * functionality affected: OKI Id calls.
 */
if (!defined("LOAD_ID")) 				define("LOAD_ID", true);

/**
 * functionality affected: OKI Logging calls.
 */
if (!defined("LOAD_LOGGING")) 				define("LOAD_LOGGING", true);

/**
 * functionality affected: Digital Repository.
 */
if (!defined("LOAD_REPOSITORY")) 			define("LOAD_REPOSITORY", true);




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
 * the constructor. Implement the methods in OsidManager, assignConfiguration()
 * and assignOsidContext() for assigning configuration.
 *
 * You can also create aliases by which to access services:
 *
 *	Services::createServiceAlias(<user-defined name>, <first alias name>);
 *  Services::createServiceAlias(<user-defined name>, <second alias name>);
 *	...
 *  Services::createServiceAlias(<user-defined name>, <N'th alias name>);
 * 
 * All services methods can be used with the aliases instead of the original name.
 *
 * Using this feature, your scripts can use the service like this:
 *
 *   Services::startManagerAsService(<user-defined name>, <OsidContext>, <configuration>);
 *   $var =& Service::getService(<user-defined name>);
 *	 ...
 *   $var->someMethod($someParameter,...);
 *   ...
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
 * Load property manager
 */ 
 
require_once(HARMONI."oki2/agent/HarmoniPropertyManager.class.php");
Services::registerService("Property", "HarmoniPropertyManager");
Services::createServiceAlias("Property", "PropertyManager");


/**
 * load ArgumentValidator
 */
require_once(HARMONI."utilities/ArgumentValidator.class.php");

require_once(OKI2."osid/OsidContext.php");
$context =& new OsidContext;
$context->assignContext('harmoni', $harmoni);


/**
 * load error handler
 */
require_once(HARMONI."errorHandler/ErrorHandler.class.php");
require_once(HARMONI."errorHandler/throw.inc.php");
Services::registerService("ErrorHandler","ErrorHandler");

require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
$configuration =& new ConfigurationProperties;
Services::startManagerAsService("ErrorHandler", $context, $configuration);


/**
 * load user error handler
 */
Services::registerService("UserError","ErrorHandler");
require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
$configuration =& new ConfigurationProperties;
Services::startManagerAsService("UserError", $context, $configuration);
/**
 * load DBHandler
 */
require_once(HARMONI."DBHandler/DBHandler.class.php");
Services::registerService("DatabaseManager","DBHandler");
Services::createServiceAlias("DatabaseManager", "DBHandler");

/**
 * load debug handler
 */
if (LOAD_DEBUG) {
	require_once(HARMONI."debugHandler/DebugHandler.class.php");
	Services::registerService("DebugManager","DebugHandler");
	Services::createServiceAlias("DebugManager", "Debug");
	require_once(HARMONI."debugHandler/debug.class.php");
	
	require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
	$configuration =& new ConfigurationProperties;
	Services::startManagerAsService("DebugManager", $context, $configuration);
}

/**
 * load the GuiManager
 */
if(LOAD_GUI) {

	require_once(HARMONI."GUIManager/GUIManager.class.php");
	Services::registerService("GUIManager","GUIManager");
	Services::createServiceAlias("GUIManager", "GUI");

}

/**
 * load the Storage handler.
 */
if (LOAD_STORAGE) {
	require_once(HARMONI."storageHandler/StorageHandler.class.php");
	Services::registerService("StorageManager","StorageHandler");
	Services::createServiceAlias("StorageManager", "Storage");
	require_once(HARMONI_BASE."config/storage.cfg.php");
}

/**
 * include DataManager files
 */
if (LOAD_DATAMANAGER) {
	require_once(HARMONI."dataManager/DataManager.abstract.php");
	// The DataManager class is simply a shell that creates other
	// services that handle specific parts of the DataManager system's
	// functionality.
	Services::registerService("DataManager","DataManager");
}

/**
 * load the LanguageLocalization service
 */
if (LOAD_LANG) {
	require_once(HARMONI."languageLocalizer/LanguageLocalizer.class.php");
	Services::registerService("LanguageManager","LanguageLocalizer");
	Services::createServiceAlias("LanguageManager", "Lang");
}

/**
 * load the Sets service
 */
if (LOAD_SETS) {
	require_once(HARMONI."sets/SetManager.class.php");
	Services::registerService("SetManager","SetManager");
	Services::createServiceAlias("SetManager", "Sets");
}

/**
 * load the Sets service
 */
if (LOAD_MIME) {
	require_once(HARMONI."utilities/MIMETypes.class.php");
	Services::registerService("MIMEManager", "MIMETypes");
	Services::createServiceAlias("MIMEManager", "MIME");
}

/**
 * load the Sets service
 */
if (LOAD_IMAGEPROCESSOR) {
	require_once(HARMONI."ImageProcessor/ImageProcessor.class.php");
	Services::registerService("ImageProcessingManager", "ImageProcessor");
	Services::createServiceAlias("ImageProcessingManager", "ImageProcessor");
}


/**
 * OKI OSID implementations:
 */


/**
 * load the AgentManager
 */
if (LOAD_AGENT) {
	require_once(HARMONI."oki2/agent/HarmoniAgentManager.class.php");
	Services::registerService("AgentManager","HarmoniAgentManager");
	Services::createServiceAlias("AgentManager", "Agent");
}
	
/**
 * load the AuthNManager
 */
if (LOAD_AUTHN) {
	require_once(HARMONI."oki2/authentication/HarmoniAuthenticationManager.class.php");
	Services::registerService("AuthenticationManager","HarmoniAuthenticationManager");
	Services::createServiceAlias("AuthenticationManager", "AuthN");
}

/**
 * load the AuthNManager
 */
if (LOAD_AGENT_MANAGEMENT) {
	require_once(HARMONI."oki2/agentmanagement/AuthNMethods/AuthNMethodManager.class.php");
	Services::registerService("AuthNMethodManager","AuthNMethodManager");
	Services::createServiceAlias("AuthNMethodManager", "AuthNMethods");
	require_once(HARMONI."oki2/agentmanagement/AgentTokenMapping/AgentTokenMappingManager.class.php");
	Services::registerService("AgentTokenMappingManager","AgentTokenMappingManager");
	Services::createServiceAlias("AgentTokenMappingManager", "AgentTokenMapping");
}

/**
 * load the AuthZManager
 */
if (LOAD_AUTHZ) {
	require_once(HARMONI."oki2/authorization/HarmoniAuthorizationManager.class.php");
	Services::registerService("AuthorizationManager","HarmoniAuthorizationManager");
	Services::createServiceAlias("AuthorizationManager", "AuthZ");
}

/**
 * load the HierarchyManager.
 */
if (LOAD_HIERARCHY) {
	require_once(HARMONI."oki2/hierarchy/HarmoniHierarchyManager.class.php");
	Services::registerService("HierarchyManager","HarmoniHierarchyManager");
	Services::createServiceAlias("HierarchyManager", "Hierarchy");
}

/**
 * load the IdManager
 */
if (LOAD_ID) {
	require_once(HARMONI."oki2/id/HarmoniIdManager.class.php");
	Services::registerService("IdManager","HarmoniIdManager");
	Services::createServiceAlias("IdManager", "Id");
}

/**
 * load the LoggingManager
 */
if (LOAD_LOGGING) {
	require_once(HARMONI."oki2/logging/HarmoniLoggingManager.class.php");
	Services::registerService("LoggingManager","HarmoniLoggingManager");
	Services::createServiceAlias("LoggingManager", "Logging");
}
	
/**
 * load the DigitalRepositoryManager.
 */
if (LOAD_REPOSITORY) {
	require_once(HARMONI."oki2/repository/HarmoniRepositoryManager.class.php");
	Services::registerService("RepositoryManager","HarmoniRepositoryManager");
	Services::createServiceAlias("RepositoryManager", "Repository");
}

?>
