<?

require_once HARMONI."dataManager/versionConstraints/VersionConstraint.interface.php";

/**
 * Limits pruning based on a cutoff date, specified in the past. The date is passed to the constructor,
 * and can be a specific date or a relative date, like "-2 weeks" or "-12 hours". Dates in the future
 * will throw an error.
 * @package harmoni.datamanager.versionconstraint
 * @copyright 2004, Middlebury College
 * @version $Id: DateVersionConstraint.class.php,v 1.2 2004/08/04 02:18:57 gabeschine Exp $
 */
class DateVersionConstraint extends VersionConstraint {
	
	var $_cutoffDate;
	
	function DateVersionConstraint( $relativeDateString ) {
		$now = time();
		$relative = strtotime($relativeDateString, $now);
		
		if ($relative === -1) {
			throwError( new Error("DateVersionConstraint: the passed relative date string, '$relativeDateString', does not appear to be valid.","DateVersionConstraint",true));
		}
		
		if ($relativeDateString >= $now) {
			throwError( new Error("DateVersionConstraint: the specified relative date must be in the PAST.", "DateVersionConstraint", true));
		}
		
		$this->_cutoffDate = $relative;
	}
	
	function checkRecordFieldValue(&$value) {
		foreach ($value->getVersionIDs() as $verID) {
			$ver =& $value->getVersion($verID);
			if ($ver->isActive()) continue;
			$date =& $ver->getDate();
			$timestamp = $date->toTimestamp();
			
			if ($timestamp < $this->_cutoffDate) {
				$ver->prune();
			}
		}
	}
	
	function checkTags(&$record) {
		$mgr =& Services::getService("TagManager");
		
		$tags =& $mgr->fetchTagDescriptors($record->getID());
		
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
	
	function checkRecord(&$record) {
		// do nothing
		return true;
	}
	
}