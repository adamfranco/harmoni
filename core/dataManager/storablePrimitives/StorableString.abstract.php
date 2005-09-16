<?

/**
 * This is the {@link StorablePrimitive} abstract for classes with string-type data values.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableString.abstract.php,v 1.9 2005/09/16 18:36:09 cws-midd Exp $
 */
class StorableStringAbstract extends String /* implements StorablePrimitive */ {

/*********************************************************
 * Instance Methods
 *********************************************************/
 
	var $_table;
	
	/**
	 * Inserts a new row into the Database with the data contained in the object.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @access public
	 * @return integer Returns the new ID of the data stored.
	 */
	function insert($dbID) {
		$idManager =& Services::getService("Id");
		$newID =& $idManager->createId();
		
		$query =& new InsertQuery();
		$query->setTable($this->_table);
		$query->setColumns(array("id","data"));
		
		$query->addRowOfValues(array("'".addslashes($newID->getIdString())."'", "'".addslashes($this->asString())."'"));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, $dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("StorableString") );
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
		$query->setTable($this->_table);
		$query->setColumns(array("data"));
		$query->setWhere("id='".addslashes($dataID)."'");
		
		$query->setValues(array("'".addslashes($this->asString())."'"));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, $dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("StorableString") );
			return false;
		}
		return true;
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
		$table = $this->_table;
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere("id='".addslashes($dataID)."'");
		
		$dbHandler =& Services::getService("DatabaseManager");
		$res =& $dbHandler->query($query, $dbID);
		
		if (!$res) throwError( new UnknownDBError("StorablePrimitive"));
	}
	
}