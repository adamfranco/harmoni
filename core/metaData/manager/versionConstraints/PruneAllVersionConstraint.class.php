<?

require_once HARMONI."metaData/manager/versionConstraints/VersionConstraint.interface.php";

/**
 * Prunes out ALL inactive values, of everything.
 * @package harmoni.datamanager.versionconstraint
 * @copyright 2004, Middlebury College
 * @version $Id: PruneAllVersionConstraint.class.php,v 1.1 2004/01/14 21:14:34 gabeschine Exp $
 */
class PruneAllVersionConstraint extends VersionConstraint {

	function checkValueVersions(&$valueVers) {		
		foreach (array_keys($valueVers) as $verID) {
			$ver =& $valueVers->getVersion($verID);
			
			// these are the conditions under which we will prune the version: (OR)
			// 1) it are inactive
			// 2) the field it are part of has been entirely deleted (inactivated) in the DataSetTypeDefinition
			// 3) the dataset is is part of is inactive
			if (!$ver->isActive() || !$ver->_parent->_parent->_fieldDefinition->isActive()
				|| !$ver->_parent->_parent->_parent->isActive())
				$ver->_prune = true;
		}
	}
	
	function checkDataSetTags(&$dataSet) {
		$mgr =& Services::getService("DataSetTagManager");
		
		$mgr->pruneTags($dataSet);
	}
	
	function checkDataSet(&$dataSet) {
		// FALSE if we are to be deleted
		return ($dataSet->isActive())?true:false;
	}
	
}