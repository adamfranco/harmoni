<?

/**
 * This is the {@link StorablePrimitive} equivalent of {@link Boolean}.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableBoolean.class.php,v 1.6 2005/04/04 18:23:25 adamfranco Exp $
 */
class StorableBoolean extends Boolean /* implements StorablePrimitive */ {

	function StorableBoolean() {
		// do nothing
	}
	
	/**
	 * Inserts a new row into the Database with the data contained in the object.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @access public
	 * @return integer Returns the new ID of the data stored.
	 */
	function insert($dbID) {
		if (OKI_VERSION > 1)
			$idManager =& Services::getService("Id");
		else
			$idManager =& Services::getService("Shared");
		$newID =& $idManager->createId();
		
		$query =& new InsertQuery();
		$query->setTable("dm_boolean");
		$query->setColumns(array("id","data"));
		
		$query->addRowOfValues(array($newID->getIdString(), $this->getBooleanValue()?1:0));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, $dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("Storable") );
			return false;
		}
		
		return $newID->getIdString();
	}
	
	/**
	 * Uses the ID passed and updates the database row with
	 * new data.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @param integer $dataID The ID in the database of the data to be updated.
	 * @access public
	 * @return void
	 */
	function update($dbID, $dataID) {
		if (!$dataID) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("dm_boolean");
		$query->setColumns(array("data"));
		$query->setWhere("id=".$dataID);
		
		$query->setValues(array($this->getBooleanValue()?1:0));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, $dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("Storable") );
			return false;
		}
		return true;
	}
	
	/**
	 * Takes an existing {@link SelectQuery} and adds a table join and some columns so that
	 * when it is executed the actual data can be retrieved from the row. The join condition must
	 * be "fk_data = data_id_field", since the field "fk_data" is already part of the DataManager's
	 * table structure.
	 * @access public
	 * @return void
	 */
	function alterQuery( &$query ) {
		$query->addTable("dm_boolean",LEFT_JOIN,"dm_boolean.id = fk_data");
		$query->addColumn("data","boolean_data","dm_boolean");
	}
	
	/**
	 * Returns a string that could be inserted into an SQL query's WHERE clause, based on the
	 * {@link Primitive} value that is passed. It is used when searching for datasets that contain a certain
	 * field=value pair.
	 * @param ref object $value The {@link Primitive} object to search for.
	 * @param int $searchType One of the SEARCH_TYPE_* constants, defining what type of search this should be (ie, equals, 
	 * contains, greater than, less than, etc)
	 * @return string or NULL if no searching is allowed.
	 */
	function makeSearchString(&$value, $searchType = SEARCH_TYPE_EQUALS) {
		if ($searchType == SEARCH_TYPE_EQUALS) {
			return "dm_boolean.data = ".($value->getBooleanValue()?"1":"0");
		}
		return null;
	}
	
	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return void
	 */
	function populate( $dbRow ) {
		$this->_bool = ($dbRow["boolean_data"]==1)?true:false;
	}
	
	/**
	 * Deletes the data row from the appropriate table.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @param integer $dataID The ID in the database of the data to be deleted.
	 * @access public
	 * @return void
	 */
	function prune($dbID, $dataID) {
		if (!$dataID) return;
		// delete ourselves from our data table
		$table = "dm_boolean";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere("id=".$dataID);
		
		$dbHandler =& Services::getService("DatabaseManager");
		$res =& $dbHandler->query($query, $dbID);
		
		if (!$res) throwError( new UnknownDBError("StorablePrimitive"));
	}
	
}