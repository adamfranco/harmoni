<?

/**
 * A VersionConstraint specifies, upon {@link FullDataSet::prune()}, what values to actually prune, and which to
 * keep, what {@link DataSetTag}s to keep, and if the whole DataSets should be deleted or not.
 * @package harmoni.datamanager.versionconstraint
 * @copyright 2004, Middlebury College
 * @version $Id: VersionConstraint.interface.php,v 1.2 2004/04/21 13:43:08 adamfranco Exp $
 */
class VersionConstraint {
	
	/**
	 * Takes a {@link ValueVersions} object and sets "prune" flags for all versions based on whether it should be
	 * pruned from the database or not, depending on the constraint specified in this object. If the version
	 * is active, though, nothing is done!
	 * @param ref object $valueVers A {@link ValueVersions} object.
	 * @return void
	 */
	function checkValueVersions(&$valueVers) { }
	
	/**
	 * Takes a {@link FullDataSet} or a {@link CompactDataSet} and checks all the tags to make sure
	 * none of them fail the constraints. If they do, it asks the {@link DataSetTagManager} to delete
	 * them from the database.
	 * @param ref object $dataSet
	 * @return void
	 */
	function checkDataSetTags(&$dataSet) { }
	
	/**
	 * Takes a {@link FullDataSet} and returns if it is still valid or should be delete. TRUE if it's still OK.
	 * NOTE: if a dataset is flagged for deletion and the children are not, then
	 * there's gonna be broken data in the database.
	 * @param ref object $dataSet
	 * @return bool
	 */
	function checkDataSet(&$dataSet) { }
	
}