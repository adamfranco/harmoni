<?

require_once HARMONI."metaData/manager/versionConstraints/VersionConstraint.interface.php";

/**
 * Removes versions based on the number for a certain value stored in the database. The maximum number
 * allowed is passed to the constructor, and any extra values will be deleted based on age.
 * @package harmoni.datamanager.versionconstraint
 * @copyright 2004, Middlebury College
 * @version $Id: NumberVersionConstraint.class.php,v 1.2 2004/01/14 21:09:26 gabeschine Exp $
 */
class NumberVersionConstraint extends VersionConstraint {
	
	var $_num;
	
	function NumberVersionConstraint( $num ) {
		$this->_num = $num;
	}
	
	function checkValueVersions(&$valueVers) {
		$numVers = $valueVers->numVersions();
		
		if ($numVers <= $this->_num) return; // it's all good. nothing to do
		
		$timestamps = array();
		$versions = array();
		
		foreach ($valueVers->getVersionList() as $verID) {
			$ver =& $valueVers->getVersion($verID);
			$date =& $ver->getDate();
			$timestamp = $date->toTimestamp();
			
			$timestamps[] = $timestamp;
			$versions[$timestamp] =& $ver;
		}
		
		// sort the versions from oldest to newest
		asort($timestamps);
		
		for ($i=0; $i<count($timestamps); $i++) {
			$tstamp = $timestamps[$i];
			
			if ($versions[$tstamp]->isActive()) continue;
			
			$versions[$tstamp]->prune();
			$numVers--;
			
			if ($numVers <= $this->_num) return;
		}
	}
	
	function checkDataSetTags(&$dataSet) {
		// do nothing
		return;
	}
	
	function checkDataSet(&$dataSet) {
		// do nothing
		return true;
	}
	
}