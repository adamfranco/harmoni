<?

require_once HARMONI."metaData/manager/versionConstraints/VersionConstraint.interface.php";

class DateVersionConstraint extends VersionConstraint {
	
	var $_cutoffDate;
	
	function DateVersionContraint( $relativeDateString ) {
		$now = time();
		$relative = strtotime($relativeDateString, $now);
		
		if ($relativeDateString >= $now) {
			throwError( new Error("DateVersionConstraint: the specified relative date must be in the PAST.", "DateVersionConstraint", true));
		}
		
		$this->_cutoffDate = $relative;
	}
	
	function checkValueVersions(&$valueVers) {
		foreach ($valueVers->getVersionList() as $verID) {
			$ver =& $valueVers->getVersion($verID);
			if ($ver->isActive()) continue;
			$date =& $ver->getDate();
			$timestamp = $date->toTimestamp();
			
			if ($timestamp < $this->_cutoffDate) {
				$ver->prune();
			}
		}
	}
	
	function checkDataSetTags(&$dataSet) {
		$mgr =& Services::getService("DataSetTagManager");
		
		$tags =& $mgr->fetchTagDescriptors($dataSet);
		
		if ($tags && is_array($tags)) {
			foreach (array_keys($tags) as $id) {
				$date =& $tags[$id]->getDate();
				$timestamp = $date->toTimestamp();
				
				if ($timestamp < $this->_cutoffDate) {
					$mgr->pruneTag($tags[$id]);
				}
			}
		}
	}
	
	function checkDataSet(&$dataSet) {
		// do nothing
		return true;
	}
	
}