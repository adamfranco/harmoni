<?php
/**
 * @since 12/5/06
 * @package  harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileRecordStructure.class.php,v 1.2 2007/09/04 20:25:44 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/Fields/FileUrlPartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/RemoteFileSizePartStructure.class.php");

/**
 * The remote file record structure defines files who's data lives at a remote url. 
 *
 * Each Asset has one of the AssetType supported by the Repository.	 There are
 * also zero or more RecordStructures required by the Repository for each
 * AssetType. RecordStructures provide structural information.	The values for
 * a given Asset's RecordStructure are stored in a Record.	RecordStructures
 * can contain sub-elements which are referred to as PartStructures.  The
 * structure defined in the RecordStructure and its PartStructures is used in
 * for any Records for the Asset.  Records have Parts which parallel
 * PartStructures.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @since 12/5/06
 * @package  harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileRecordStructure.class.php,v 1.2 2007/09/04 20:25:44 adamfranco Exp $
 */
class RemoteFileRecordStructure 
	extends HarmoniFileRecordStructure
{
		
	/**
	 * Constructor
	 * 
	 * @param <##>
	 * @return object
	 * @access public
	 * @since 12/5/06
	 */
	function __construct () {
		if (!is_array($this->_partStructures))
			$this->_partStructures = array();
		
		$this->_partStructures['FILE_URL'] = new FileUrlPartStructure($this);
		
		parent::__construct();
		unset($this->_partStructures['FILE_DATA'], $this->_partStructures['FILE_SIZE']);
		
		$this->_partStructures['FILE_SIZE'] = new RemoteFileSizePartStructure($this);
	}
	
	/**
	 * Get the display name for this RecordStructure.
	 *	
	 * @return string
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
	function getDisplayName() {
		return "Remote File";
	}
	
	/**
	 * Get the unique Id for this RecordStructure.
	 *	
	 * @return object Id
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
	function getId() {
		$idManager = Services::getService("Id");
		return $idManager->getId('REMOTE_FILE');
	}
}

?>