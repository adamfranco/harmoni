<?

require_once HARMONI."dataManager/versionConstraints/VersionConstraint.interface.php";

/**
 * Prunes out ALL inactive values, of everything.
 * @package harmoni.datamanager.versionconstraint
 * @copyright 2004, Middlebury College
 * @version $Id: PruneAllVersionConstraint.class.php,v 1.1 2004/07/27 20:23:44 gabeschine Exp $
 */
class PruneAllVersionConstraint extends VersionConstraint {

	function checkRecordFieldValue(&$value) {		
		foreach ($value->getVersionList() as $verID) {
			$ver =& $value->getVersion($verID);
			
			// these are the conditions under which we will prune the version: (OR)
			// 1) it is inactive
			// 2) the field it is part of has been entirely deleted (deactivated) in the Schema
			// 3) the Record it is part of is inactive
			if (!$ver->isActive() || !$ver->_parent->_parent->_schemaField->isActive()
				|| !$ver->_parent->_parent->_parent->isActive())
				$ver->prune();
		}
	}
	
	function checkTags(&$record) {
		$mgr =& Services::getService("TagManager");
		
		$mgr->pruneTags($record);
	}
	
	function checkRecord(&$record) {
		// FALSE if we are to be deleted
		return ($record->isActive())?true:false;
	}
	
}