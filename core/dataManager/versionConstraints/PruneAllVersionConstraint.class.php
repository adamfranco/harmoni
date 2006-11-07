<?

require_once HARMONI."dataManager/versionConstraints/VersionConstraint.interface.php";

/**
 * Prunes out ALL inactive values, of everything.
 *
 * @package harmoni.datamanager.versionconstraint
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PruneAllVersionConstraint.class.php,v 1.3.4.1 2006/11/07 21:19:19 adamfranco Exp $
 */
class PruneAllVersionConstraint extends VersionConstraint {

	function checkRecordFieldValue(&$value) {		
		foreach ($value->getVersionIDs() as $verID) {
			$ver =& $value->getVersion($verID);
			
			// these are the conditions under which we will prune the version: (OR)
			// 1) it is inactive
			// 2) the field it is part of has been entirely deleted (deactivated) in the Schema
			// 3) the Record it is part of is inactive
			if (!$ver->isActive() || !$ver->_parent->_parent->_schemaField->isActive()
				|| !$ver->_parent->_parent->_parent->isActive())
				$ver->prune();
//			if (!$ver->isActive()) print "version";
//			if (!$ver->_parent->_parent->_schemaField->isActive()) print "schemaField";
//			if (!$ver->_parent->_parent->_parent->isActive()) print "record";
		}
	}
	
	function checkTags(&$record) {
		$mgr =& Services::getService("RecordTagManager");
		
		$mgr->pruneTags($record);
	}
	
	function checkRecord(&$record) {
		// FALSE if we are to be deleted
		return ($record->isActive())?true:false;
	}
	
}