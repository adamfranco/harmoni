<?

/**
 * This is the {@link StorablePrimitive} abstract for classes with string-type data values.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableString.abstract.php,v 1.4 2005/04/04 17:39:22 adamfranco Exp $
 */
class StorableStringAbstract extends String /* implements StorablePrimitive */ {
	
	var $_table;
	
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
		$query->setTable($this->_table);
		$query->setColumns(array("id","data"));
		
		$query->addRowOfValues(array($newID->getIdString(), "'".addslashes($this->toString())."'"));
		
		$dbHandler =& Services::getService("DBHandler");
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
		$query->setWhere("id=".$dataID);
		
		$query->setValues(array("'".addslashes($this->toString())."'"));
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("StorableString") );
			return false;
		}
		return true;
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
			return $this->_table.".data='".addslashes($value->toString())."'";
		}
		if ($searchType == SEARCH_TYPE_CONTAINS) {
			return $this->_table.".data LIKE '%".addslashes($value->toString())."%'";
		}
		return null;
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
		$query->setWhere("id=".$dataID);
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $dbID);
		
		if (!$res) throwError( new UnknownDBError("StorablePrimitive"));
	}
	
}