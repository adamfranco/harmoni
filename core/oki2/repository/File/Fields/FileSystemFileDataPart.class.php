<?

/**
 * This Part stores the File data on the filesytem, in a file whose name is the id
 * of our record.
 *
 * Important configuration options:
 *		- 'use_filesystem_for_files'
 *		- 'file_data_path'
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: FileSystemFileDataPart.class.php,v 1.1 2005/02/16 22:48:11 adamfranco Exp $
 */
 
class FileSystemFileDataPart 
	extends FileDataPart 
{

	/**
	 * Get the value for this Part.
	 *	
	 * @return object mixed (original type: java.io.Serializable)
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
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getValue() {
		$file = $this->_getFilePath();
		
		if (!file_exists($file))
			return "";
		
		if (!is_readable($file))
			throwError(new Error(RepositoryException::OPERATION_FAILED()
				.": '$file' could not read.", "FileSystemFileDataPart", true));
		
		return file_get_contents($file);
	}
	
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
		$file = $this->_getFilePath();
		
		if (!$handle = fopen($file, 'w')) {
			throwError(new Error(RepositoryException::OPERATION_FAILED()
				.": '$file' could not be opened for writing.", "FileSystemFileDataPart", true));
		}
		
		if (fwrite($handle, $value) === FALSE) {
			fclose($handle);
			throwError(new Error(RepositoryException::OPERATION_FAILED()
				.": '$file' could not be written to.", "FileSystemFileDataPart", true));
		}
		
		fclose($handle);
		
		
		// Check to see if the size is in the database
		$dbHandler =& Services::getService("DBHandler");
		
		$query =& new SelectQuery;
		$query->addTable("dr_file");
		$query->addColumn("COUNT(*) as count");
		$query->addWhere("id = '".$this->_recordId->getIdString()."'");
		$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
		
		// If it already exists, use an update query.
		if ($result->field("count") > 0) {
			$query =& new UpdateQuery;
			$query->setTable("dr_file");
			$query->setColumns(array("size"));
			$query->setValues(array("'".strlen($value)."'"));
			$query->addWhere("id = '".$this->_recordId->getIdString()."'");
		}
		// If it doesn't exist, use an insert query.
		else {
			$query =& new InsertQuery;
			$query->setTable("dr_file");
			$query->setColumns(array("id","size"));
			$query->setValues(array("'".$this->_recordId->getIdString()."'",
									"'".strlen($value)."'"));
		}
		
		// run the query
		$dbHandler->query($query, $this->_configuration["dbId"]);
	}
	
	/**
	 * Build the file path where we will store our data
	 * 
	 * @return string
	 * @access public
	 * @since 2/16/05
	 */
	function _getFilePath () {
		if (!$this->_configuration['file_data_path'])
			throwError(new Error(RepositoryException::CONFIGURATION_ERROR()
				.": 'file_data_path' was not specified.", "FileSystemFileDataPart", true));
		
		$path = $this->_configuration['file_data_path'];
		
		if (!file_exists($path))
			throwError(new Error(RepositoryException::CONFIGURATION_ERROR()
				.": The 'file_data_path' specified, '$path', was does not exist.", "FileSystemFileDataPart", true));

		if (!is_readable($path))
			throwError(new Error(RepositoryException::CONFIGURATION_ERROR()
				.": The 'file_data_path' specified, '$path', is not readable.", "FileSystemFileDataPart", true));
		
		if (!is_writable($path))
			throwError(new Error(RepositoryException::CONFIGURATION_ERROR()
				.": The 'file_data_path' specified, '$path', is not writable.", "FileSystemFileDataPart", true));
				
		return $this->_configuration['file_data_path']."/".$this->_recordId->getIdString();
	}
	
	
}
