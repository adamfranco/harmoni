<?

require_once HARMONI."dataManager/versionConstraints/VersionConstraint.interface.php";

/**
 * Removes versions based on the number for a certain value stored in the database. The maximum number
 * allowed is passed to the constructor, and any extra values will be deleted based on age.
 * @package harmoni.datamanager.versionconstraint
 * @copyright 2004, Middlebury College
 * @version $Id: NumberVersionConstraint.class.php,v 1.2 2004/08/04 02:18:57 gabeschine Exp $
 */
class NumberVersionConstraint extends VersionConstraint {
	
	var $_num;
	
	function NumberVersionConstraint( $num ) {
		$this->_num = $num;
	}
	
	function checkRecordFieldValue(&$value) {
		$numVers = $value->numVersions();
		
		if ($numVers <= $this->_num) return; // it's all good. nothing to do
		
		$timestamps = array();
		$versions = array();
		
		foreach ($value->getVersionIDs() as $verID) {
			$ver =& $value->getVersion($verID);
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
	
	function checkTags(&$record) {
		// do nothing
		return;
	}
	
	function checkRecord(&$record) {
		// do nothing
		return true;
	}
	
}