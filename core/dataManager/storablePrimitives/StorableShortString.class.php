<?

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link String} for the dm_shortstring table.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableShortString.class.php,v 1.3 2005/01/19 21:09:43 adamfranco Exp $
 */
class StorableShortString extends StorableStringAbstract /* implements StorablePrimitive */ {

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
	
	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return void
	 */
	function populate( $dbRow ) {
		$this->_string = (string) $dbRow["shortstring_data"];
	}
	
}