<?

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
	 * @param ref object
	 * @return bool
	 */
	function checkDataSet(&$dataSet) { }
	
}