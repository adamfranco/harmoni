<?

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link String} for the dm_string table.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableString.class.php,v 1.4 2005/07/13 19:59:42 adamfranco Exp $
 */
class StorableString 
	extends StorableStringAbstract 
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
	 * @return object StorableString
	 * @static
	 */
	function &createAndPopulate( $dbRow ) {
		$string =& new StorableString;
		$string->_setValue($dbRow["string_data"]);
		return $string;
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
	function makeSearchString(&$value, $searchType = SEARCH_TYPE_EQUALS) {
		if ($searchType == SEARCH_TYPE_EQUALS) {
			return "dm_string.data='".addslashes($value->toString())."'";
		}
		if ($searchType == SEARCH_TYPE_CONTAINS) {
			return "dm_string.data LIKE '%".addslashes($value->toString())."%'";
		}
		return null;
	}
 
 /*********************************************************
  * Instance Methods
  *********************************************************/
		
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
	
	function StorableString() {
		$this->_table = "dm_string";
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
		$query->addTable("dm_string",LEFT_JOIN,"dm_string.id = fk_data");
		$query->addColumn("data","string_data","dm_string");
	}
	
}