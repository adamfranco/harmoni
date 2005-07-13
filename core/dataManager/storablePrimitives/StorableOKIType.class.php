<?

/**
 * This is the {@link StorablePrimitive} equivalent of {@link OKIType}.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableOKIType.class.php,v 1.8 2005/07/13 19:56:15 adamfranco Exp $
 */
class StorableOKIType 
	extends Type 
	/* implements StorablePrimitive */ 
{

/*********************************************************
 * Class Methods
 *********************************************************/

	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return object StorableOKIType
	 */
	function &populate( $dbRow ) {
		return new StorableOKIType(	$dbRow["okitype_domain"], 
									$dbRow["okitype_authority"],
									$dbRow["okitype_keyword"]);
	}
	
	/**
	 * Returns a string that could be inserted into an SQL query's WHERE clause, based on the
	 * {@link Primitive} value that is passed. It is used when searching for datasets that contain a certain
	 * field=value pair.
	 * @param ref object $value The {@link Primitive} object to search for.
	 * @param int $searchType One of the SEARCH_TYPE_* constants, defining what type of search this should be (ie, equals, 
	 * contains, greater than, less than, etc)
	 * @return string or NULL if no searching is allowed.
	 * @static
	 */
	function makeSearchString(&$type, $searchType = SEARCH_TYPE_EQUALS) {
		if ($searchType == SEARCH_TYPE_EQUALS) return "(dm_okitype.domain='".addslashes($type->getDomain())."' AND ".
		 "dm_okitype.authority='".addslashes($type->getAuthority())."' AND ".
		 "dm_okitype.keyword='".addslashes($type->getKeyword())."')";
		 return null;
	}

/*********************************************************
 * Instance Methods
 *********************************************************/
 	
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
		$query->setTable("dm_okitype");
		$query->setColumns(array("id","domain","authority","keyword"));
		
		$query->addRowOfValues(array("'".addslashes($newID->getIdString())."'", "'".addslashes($this->getDomain())."'",
															"'".addslashes($this->getAuthority())."'",
															"'".addslashes($this->getKeyword())."'"));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, $dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("StorableOKIType") );
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
		$query->setTable("dm_okitype");
		$query->setColumns(array("domain","authority","keyword"));
		$query->setWhere("id='".addslashes($dataID)."'");
		
		$query->setValues(array("'".addslashes($this->getDomain())."'",
								"'".addslashes($this->getAuthority())."'",
								"'".addslashes($this->getKeyword())."'"));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, $dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("StorableOKIType") );
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
		$query->addTable("dm_okitype",LEFT_JOIN,"dm_okitype.id = fk_data");
		$query->addColumn("domain","okitype_domain","dm_okitype");
		$query->addColumn("authority","okitype_authority","dm_okitype");
		$query->addColumn("keyword","okitype_keyword","dm_okitype");
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
		$table = "dm_okitype";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere("id='".addslashes($dataID)."'");
		
		$dbHandler =& Services::getService("DatabaseManager");
		$res =& $dbHandler->query($query, $dbID);
		
		if (!$res) throwError( new UnknownDBError("StorablePrimitive"));
	}
	
}