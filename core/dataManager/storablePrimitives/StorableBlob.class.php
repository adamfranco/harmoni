<?

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link Blob} for the dm_blob table.
 * @package harmoni.datamanager.storableprimitives
 * @copyright 2004
 * @version $Id: StorableBlob.class.php,v 1.2 2004/08/12 20:21:16 gabeschine Exp $
 */
class StorableBlob extends StorableStringAbstract /* implements StorablePrimitive */ {

	function StorableBlob() {
		$this->_table = "dm_blob";
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
		$query->addTable("dm_blob",LEFT_JOIN,"dm_blob.id = fk_data");
		$query->addColumn("data","blob_data","dm_blob");
	}
	
	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return void
	 */
	function populate( $dbRow ) {
		$this->_string = (string) $dbRow["blob_data"];
	}
	
	function getBlobValue() {
		return $this->_string;
	}
	
}