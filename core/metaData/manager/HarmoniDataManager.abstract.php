<?php

require_once(HARMONI."metaData/manager/DataSetTypeManager.class.php");
require_once(HARMONI."metaData/manager/DataTypeManager.class.php");
require_once(HARMONI."metaData/manager/IDManager.class.php");
require_once(HARMONI."metaData/manager/DataType.interface.php");
require_once(HARMONI."metaData/manager/DataSetManager.class.php");

/**
 * The HarmoniDataManager class is used purely to setup the services required to use the
 * other DataManager classes such as the {@link DataSetTypeManager} or the {@link DataSetManager}.
 * @package harmoni.datamanager
 * @version $Id: HarmoniDataManager.abstract.php,v 1.5 2004/01/01 19:03:42 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 * @abstract
 **/

class HarmoniDataManager {
	
	function setup( $dbID ) {
		
		// let's setup all our services
		
		// first, make sure they're all stopped and unregistered.
		$services = array("DataTypeManager","DataSetTypeManager","DataSetManager","IDManager");
		foreach ($services as $service) {
			if (Services::serviceAvailable($service)) {
				if (Services::serviceRunning($service))
					Services::stopService($service);
			}
		}
		
		// ok, now on to registering everything
		$idManager =& new IDManager( $dbID );
		$dataSetTypeManager =& new DataSetTypeManager($idManager, $dbID);
		$dataTypeManager =& new DataTypeManager();
		$dataSetManager =& new DataSetManager( $idManager, $dbID, $dataSetTypeManager );

		Services::registerObjectAsService("IDManager",$idManager);
		Services::registerObjectAsService("DataSetTypeManager",$dataSetTypeManager);
		Services::registerObjectAsService("DataTypeManager",$dataTypeManager);
		Services::registerObjectAsService("DataSetManager",$dataSetManager);

		debug::output("Activated Harmoni Data Manager.",DEBUG_SYS1,"HarmoniDataManager");
	}
	
}

?>