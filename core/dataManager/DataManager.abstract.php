<?php

//require_once(HARMONI."dataManager/manager/DataSetTypeManager.class.php");
//require_once(HARMONI."dataManager/manager/DataTypeManager.class.php");
//require_once(HARMONI."dataManager/manager/DataType.interface.php");
//require_once(HARMONI."dataManager/manager/DataSetManager.class.php");
//require_once(HARMONI."dataManager/manager/DataSetTagManager.class.php");
//require_once(HARMONI."dataManager/manager/DataSetGroup.class.php");

//require_once(HARMONI."dataManager/manager/search/include.php");

//require_once(HARMONI."dataManager/manager/versionConstraints/include.php");

/**
 * The HarmoniDataManager class is used purely to setup the services required to use the
 * other DataManager classes such as the {@link DataSetTypeManager} or the {@link DataSetManager}.
 * @package harmoni.datamanager
 * @version $Id: DataManager.abstract.php,v 1.1 2004/07/26 04:21:16 gabeschine Exp $
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
		
		// first, make sure they're all stopped and unregistered.
//		$services = array("DataTypeManager","SchemaManager","RecordManager","TagManager");
//		foreach ($services as $service) {
//			if (Services::serviceAvailable($service)) {
//				if (Services::serviceRunning($service))
//					Services::stopService($service);
//			}
//		}
		
		define("DATAMANAGER_DBID",$dbID);

		// ok, now on to registering everything
		$schemaManager =& new SchemaManager($preloadTypes);
//		$dataTypeManager =& new DataTypeManager();
//		$dataSetManager =& new DataSetManager($dbID, $dataSetTypeManager );
//		$dataSetTagManager =& new DataSetTagManager($dbID);

		Services::registerObjectAsService("SchemaManager",$schemaManager);
//		Services::registerObjectAsService("DataTypeManager",$dataTypeManager);
//		Services::registerObjectAsService("DataSetManager",$dataSetManager);
//		Services::registerObjectAsService("DataSetTagManager",$dataSetTagManager);

		debug::output("Activated Harmoni Data Manager.",DEBUG_SYS1,"DataManager");
	}
	
}

?>