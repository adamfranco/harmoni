<?php
/**
 * @since 12/5/06
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileSizePart.class.php,v 1.3 2007/09/04 20:25:46 adamfranco Exp $
 */ 

/**
 * <##>
 * 
 * @since 12/5/06
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileSizePart.class.php,v 1.3 2007/09/04 20:25:46 adamfranco Exp $
 */
class RemoteFileSizePart
	extends FileSizePart
{
		
	/**
	 * Update the value for this Part.
	 * 
	 * @param object mixed $value (original type: java.io.Serializable)
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateValue($value) {
		ArgumentValidator::validate($value, StringValidatorRule::getRule());
		
		// Store the size in the object in case its asked for again.
		try {
			$size = ByteSize::fromString($value);
		} catch (InvalidArgumentException $e) {
			$size = ByteSize::withValue(0);
		}
		$this->_size = $size->value();
		
	// then write it to the database.
		$dbHandler = Services::getService("DatabaseManager");
	
		// Check to see if the name is in the database
		$query = new SelectQuery;
		$query->addTable("dr_file");
		$query->addColumn("COUNT(*) as count");
		$query->addWhereEqual("id", $this->_recordId->getIdString());
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		// If it already exists, use an update query.
		if ($result->field("count") > 0) {
			$query = new UpdateQuery;
			$query->setTable("dr_file");
			$query->setColumns(array("size"));
			$query->setValues(array("'".addslashes($this->_size)."'"));
			$query->addWhereEqual("id", $this->_recordId->getIdString());
		}
		// If it doesn't exist, use an insert query.
		else {
			$query = new InsertQuery;
			$query->setTable("dr_file");
			$query->setColumns(array("id","size"));
			$query->setValues(array("'".$this->_recordId->getIdString()."'",
									"'".addslashes($this->_size)."'"));
		}
		$result->free();
		// run the query
		$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		$this->_asset->updateModificationDate();
	}
	
}

?>