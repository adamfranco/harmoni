<?php

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link String} for the dm_shortstring table.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableShortString.class.php,v 1.9 2007/04/12 15:37:26 adamfranco Exp $
 */
class StorableShortString
	extends StorableStringAbstract 
	/* implements StorablePrimitive */ 
{

/*********************************************************
 * Class Methods
 *********************************************************/
 
 	/**
	 * Inserts a new row into the Database with the data contained in the object.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @access public
	 * @return integer Returns the new ID of the data stored.
	 */
	function insert($dbID) {
		$this->_table = "dm_shortstring";
		return parent::insert($dbID);
	}
 
 	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return object StorableShortString
	 * @static
	 */
	function &createAndPopulate( $dbRow ) {
		$string =& new StorableShortString;
		$string->_setValue($dbRow["shortstring_data"]);
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
		switch ($searchType) {
			case SEARCH_TYPE_EQUALS:
				return "dm_shortstring.data='".addslashes($value->asString())."'";
			case SEARCH_TYPE_CONTAINS:
				return "dm_shortstring.data LIKE '%".addslashes($value->asString())."%'";
			case SEARCH_TYPE_IN_LIST:
				$string = "dm_shortstring.data IN (";
				while ($value->hasNext()) {
					$valueObj =& $value->next();
					$string .= "'".addslashes($valueObj->asString())."'";
					if ($value->hasNext())
						$string .= ", ";
				}
				$string .= ")";
				return $string;
			case SEARCH_TYPE_NOT_IN_LIST:
				$string = "dm_shortstring.data NOT IN (";
				while ($value->hasNext()) {
					$valueObj =& $value->next();
					$string .= "'".addslashes($valueObj->asString())."'";
					if ($value->hasNext())
						$string .= ", ";
				}
				$string .= ")";
				return $string;
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
	

	function StorableShortString() {
		$this->_table = "dm_shortstring";
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
		$query->addTable("dm_shortstring",LEFT_JOIN,"dm_shortstring.id = fk_data");
		$query->addColumn("data","shortstring_data","dm_shortstring");
	}
	
}