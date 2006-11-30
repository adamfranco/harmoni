<?

/**
 * The RecordSet class holds a list of IDs and their Records in a specific record set.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RecordSet.class.php,v 1.10 2006/11/30 22:02:16 adamfranco Exp $
 */
class RecordSet {
	
	var $_records;
	
	var $_dirty;
	
	function RecordSet() {
		$this->_records = array();
		
		$this->_dirty = false;
	}
	
	/**
	 * Adds the records in the passed array to our set.
	 * @param ref array $records An array of {@link Record} objects.
	 * @access public
	 * @return void
	 */
	function addRecords(&$records)
	{
		$this->_dirty = true;
		for ($i = 0; $i < count($records); $i++) {
			$this->_records[] =& $records[$i];
		}
	}

	/**
	 * Returns the number of records in this set.
	 * @access public
	 * @return int
	 */
	function numRecords()
	{
		return count($this->_records);
	}
	
	/**
	 * Returns an array of records.
	 * @access public
	 * @return ref array
	 */
	function &getRecords()
	{
		return $this->_records;
	}
	
	/**
	 * Returns if this set contains the passed {@link Record}
	 * @param ref object $record
	 * @access public
	 * @return boolean
	 */
	function contains(&$record)
	{
		$id = $record->getID();
		if (!$id) return false;
		
		for ($i = 0; $i < count($this->_records); $i++) {
			if ($this->_records[$i]->getID() == $id) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Removes the given record from the set.
	 * @param ref object $record A {@link Record} object.
	 * @access public
	 * @return void
	 */
	function removeRecord(&$record)
	{
		$id = $record->getID();
		if (!$id) {
			throwError(new Error("Could not remove record from set because the record does not yet have an ID.","RecordSet",false));
			return;
		}
		
		$newArr = array();
		for ($i = 0; $i < count($this->_records); $i++) {
			if ($this->_records[$i]->getID() != $id) $newArr[] =& $this->_records[$i];
		}
		
		unset($this->_records);
		$this->_records =& $newArr;
		
		$this->_dirty = true;
	}
	
	/**
	 * Returns an array of Record IDs that we know about.
	 * @return array
	 */
	function getRecordIDs() {
		$ids = array();
		for ($i = 0; $i < count($this->_records); $i++) {
			$id = $this->_records[$i]->getID();
			if ($id) $ids[] = $id;
		}
		
		return array_unique($ids);
	}
	
	/**
	 * Returns an array of {@link Records} of the passed {@link Schema} {@link HarmoniType Type}.
	 * @param string $id A type/ID string linked with a {@link Schema}.
	 * @access public
	 * @return ref array
	 */
	function &getRecordsByType($id)
	{
		$records =& $this->getRecords();
		
		$return = array();
		for ($i = 0; $i < count($records); $i++) {
			if ($id == $records[$i]->getSchemaID()) {
				$return[] =& $records[$i];
			}
		}
		
		return $return;
	}
	
	/**
	 * Returns an array of records based on a label assigned previously. NOTE: this is a proposed method and has not been implemented.
	 * @param string $label The string label of the {@link Records} to return.
	 * @access public
	 * @return ref array
	 */
	function &getRecordsByLabel($label)
	{
		// @todo decide if this is useful or if getRecordsByType is sufficient.
	}
	
	/**
	 * Adds the given {@link Record} to our list.
	 * @param ref object $record
	 * @return void
	 */
	function add(&$record) {
		$this->_dirty = true;
		
		$this->_records[] =& $record;
	}
	
	/**
	 * This is a synonym for {@link RecordSet::add()}.
	 * @param ref object $record
	 * @access public
	 * @return void
	 */
	function addRecord(&$record)
	{
		$this->add($record);
	}
	
	/**
	 * Returns an array of merged tag-dates (as {@link DateAndTime} objects) which can be used to setup our Records as they were on a specific date.
	 * @access public
	 * @return array
	 */
	function &getMergedTagDates()
	{
		// first get all the tags for each of our Records, then ask them for their dates. avoid duplicates
		$tagManager =& Services::getService("RecordTagManager");
		$dates = array();
		$dateStrings = array();
		foreach ($this->getRecordIDs() as $id) {
			$tags =& $tagManager->fetchTagDescriptors($id);
			foreach (array_keys($tags) as $key) {
				$date =& $tags[$key]->getDate();
				$str = $date->asString();
				if (!in_array($str, $dateStrings)) {
					$dateStrings[] = $str;
					$dates[] =& $date;
				}
			}
		}
		
		return $dates;
	}
	
	/**
	 * Returns all of the {@link Record}s within this Set to the state they were in on the given date.
	 * @param ref object $date A {@link DateAndTime} object.
	 * @access public
	 * @return boolean
	 */
	function revertToDate(&$date)
	{
		// this function goes through each Record, gets all the tags, and finds the one that has the closest tag
		// date to $date, as long as the tag date is *before* $date.
		// then, we activate that tag on the Record and commit it to the database
		$tagManager =& Services::getService("RecordTagManager");
		
		for ($i = 0; $i < count($this->_records); $i++) {
			$id = $this->_records[$i]->getID();
			if (!$id) continue;
			$tags =& $tagManager->fetchTags($id);
			
			$closest = null;
			$closestDate = null;
			foreach (array_keys($tags) as $key) {
				$tagDate =& $tags[$key]->getDate();
				if ($tagDate->isLessThanOrEqualTo($date) 
					&& ($closestDate == null || $tagDate->isGreaterThan($closestDate))) 
				{
//					print "-> for record $id, new best is " . $tagDate->asString() . " with sep = $sep<br/>";
					$closestDate =& $tagDate;
					$closest =& $tags[$key];
				}
			}
			
			if ($closest) {
				// we're going to activate the tag, then commit the Record
				$d =& $closest->getDate();
				$this->_records[$i]->activateTag($closest);
				$this->_records[$i]->commit();
			}
		}
		return true;
	}
	
}

?>