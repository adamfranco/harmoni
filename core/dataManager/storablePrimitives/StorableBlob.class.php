<?

require_once(HARMONI."dataManager/storablePrimitives/StorableString.abstract.php");

/**
 * This is the {@link StorablePrimitive} equivalent of {@link Blob} for the dm_blob table.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableBlob.class.php,v 1.4 2005/07/13 19:56:15 adamfranco Exp $
 */
class StorableBlob 
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
	 * @return object StorableBlob
	 * @static
	 */
	function &populate( $dbRow ) {
		$blob =& new StorableBlob;
		$blob->_setValue($dbRow["blob_data"]);
		return $blob;
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
	
	function getBlobValue() {
		return $this->_string;
	}
	
}