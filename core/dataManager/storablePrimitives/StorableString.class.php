<?

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link String} for the dm_string table.
 * @package harmoni.datamanager.storableprimitives
 * @copyright 2004
 * @version $Id: StorableString.class.php,v 1.1 2004/07/27 18:15:26 gabeschine Exp $
 */
class StorableString extends StorableStringAbstract /* implements StorablePrimitive */ {

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
	
	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return void
	 */
	function populate( $dbRow ) {
		$this->_string = (string) $dbRow["string_data"];
	}
	
}