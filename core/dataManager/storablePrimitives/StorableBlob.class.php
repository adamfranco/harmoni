<?php

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link Blob} for the dm_blob table.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableBlob.class.php,v 1.11 2007/10/10 22:58:36 adamfranco Exp $
 */
class StorableBlob 
	extends StorableStringAbstract 
	implements StorablePrimitive
{

/*********************************************************
 * Class Methods
 *********************************************************/
 
 	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return object StorableBlob
	 * @static
	 */
	static function createAndPopulate( $dbRow ) {
		$blob = new StorableBlob;
		$blob->_setValue($dbRow["blob_data"]);
		return $blob;
	}
	
	/**
	 * Takes an existing {@link SelectQuery} and adds a table join and some columns so that
	 * when it is executed the actual data can be retrieved from the row. The join condition must
	 * be "fk_data = data_id_field", since the field "fk_data" is already part of the DataManager's
	 * table structure.
	 * @access public
	 * @return void
	 */
	static function alterQuery( $query ) {
		$query->addTable("dm_blob",LEFT_JOIN,"dm_blob.id = fk_data");
		$query->addColumn("data","blob_data","dm_blob");
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
	static function makeSearchString($value, $searchType = SEARCH_TYPE_EQUALS) {
		throw new UnimplementedException();
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
		$this->_table = "dm_blob";
		return parent::insert($dbID);
	}
		
	/**
	 * Set the value
	 * 
	 * @param $value
	 * @return void
	 * @access private
	 * @since 7/13/05
	 */
	function _setValue ($value) {
		$this->_string = (string) $value;
	}

	function __construct() {
		$this->_table = "dm_blob";
	}
	
	function value() {
		return $this->_string;
	}
	

	
/*********************************************************
 * Conversion Methods
 *********************************************************/
	
	/**
	 * Convert this object to a StorableBlob
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asABlob () {
		return $this;
	}
	
	/**
	 * Convert this object to a StorableString
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asAString () {
		return HarmoniString::fromString($this->asString());
	}
	
	/**
	 * Convert this object to a StorableShortString
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asAShortString () {
		return HarmoniString::fromString($this->asString());
	}	
}