<?php
/**
 * @since 12/5/06
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileSizePartStructure.class.php,v 1.1 2006/12/06 20:45:00 adamfranco Exp $
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
 * @version $Id: RemoteFileSizePartStructure.class.php,v 1.1 2006/12/06 20:45:00 adamfranco Exp $
 */
class RemoteFileSizePartStructure
	extends FileSizePartStructure
{
		
	/**
	 * Return true if this PartStructure is automatically populated by the
	 * Repository; false otherwise.	 Examples of the kind of PartStructures
	 * that might be populated are a time-stamp or the Agent setting the data.
	 *	
	 * @return boolean
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
	function isPopulatedByRepository() {
		return FALSE;
	}
	
}

?>