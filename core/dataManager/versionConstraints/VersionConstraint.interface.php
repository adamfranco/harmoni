<?

/**
 * A VersionConstraint specifies, upon {@link FullDataSet::prune()}, what values to actually prune, and which to
 * keep, what {@link DataSetTag}s to keep, and if the whole DataSets should be deleted or not.
 *
 * @package harmoni.datamanager.versionconstraint
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: VersionConstraint.interface.php,v 1.3.2.1 2006/11/07 21:19:19 adamfranco Exp $
 */
class VersionConstraint {
	
	/**
	 * Takes a {@link RecordFieldValue} object and sets "prune" flags for all versions based on whether it should be
	 * pruned from the database or not, depending on the constraint specified in this object. If the version
	 * is active, though, nothing is done!
	 * @param ref object $value A {@link RecordFieldValue} object.
	 * @return void
	 */
	function checkRecordFieldValue(&$value) { }
	
	/**
	 * Takes a {@link Record} and checks all the tags to make sure
	 * none of them fail the constraints. If they do, it asks the {@link RecordTagManager} to delete
	 * them from the database.
	 * @param ref object $record
	 * @return void
	 */
	function checkTags(&$record) { }
	
	/**
	 * Takes a {@link Record} and returns if it is still valid or should be deleted. TRUE if it's still OK.
	 * NOTE: if a Record is flagged for deletion and the children are not, then
	 * there's gonna be broken data in the database.
	 * @param ref object $record
	 * @return bool
	 * @deprecated no longer used - Jul 13, 2005
	 */
	function checkRecord(&$record) { }
	
}