<?php

require_once(HARMONI."dataManager/schema/SchemaManager.class.php");
require_once(HARMONI."dataManager/DataTypeManager.class.php");
require_once(HARMONI."dataManager/record/RecordManager.class.php");
require_once(HARMONI."dataManager/record/TagManager.class.php");
require_once(HARMONI."dataManager/record/RecordSet.class.php");

//require_once(HARMONI."dataManager/manager/search/include.php");

//require_once(HARMONI."dataManager/manager/versionConstraints/include.php");

/**
 * The HarmoniDataManager class is used purely to setup the services required to use the
 * other DataManager classes such as the {@link DataSetTypeManager} or the {@link DataSetManager}.
 * @package harmoni.datamanager
 * @version $Id: DataManager.abstract.php,v 1.3 2004/07/27 20:44:22 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 * @abstract
 **/

class DataManager {
	
	/**
	 * Sets up the services required for the DataManager, including: DataSetTypeManager,
	 * DataTypeManager, DataSetManager, DataSetTagManager
	 * @return void
	 * @access public
	 * @param int $dbID The DB index from the {@link DBHandler} that we should use to look for our data.
	 * corresponding to DataSetTypes that should be pre-loaded in one DB query.
	 * @abstract
	 */
	function setup( $dbID ) {
		
		// check config options
		if (ini_get("magic_quotes_gpc")) {
			throwError(
				new Error(
					"The DataManager requires that the php.ini config option <B>magic_quotes_gpc</B> be OFF.",
					"DataManager",
					true));
		}

		if (ini_get("magic_quotes_runtime")) {
			throwError(
				new Error(
					"The DataManager requires that the php.ini config option <B>magic_quotes_runtime</B> be OFF.",
					"DataManager",
					true));
		}
		
		// let's setup all our services
		
		define("DATAMANAGER_DBID",$dbID);

		// ok, now on to registering everything
		$schemaManager =& new SchemaManager($preloadTypes);
		$dataTypeManager =& new DataTypeManager();
		$recordManager =& new RecordManager();
		$tagManager =& new TagManager();

		Services::registerObjectAsService("SchemaManager",$schemaManager);
		Services::registerObjectAsService("DataTypeManager",$dataTypeManager);
		Services::registerObjectAsService("RecordManager",$recordManager);
		Services::registerObjectAsService("TagManager",$tagManager);

		debug::output("Activated Harmoni Data Manager.",DEBUG_SYS1,"DataManager");
	}
	
}

?>