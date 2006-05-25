<?

require_once(OKI2."osid/repository/RepositoryIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * RepositoryIterator provides access to these objects sequentially, one at a
 * time.  The purpose of all Iterators is to to offer a way for OSID methods
 * to return multiple values of a common type and not use an array.	 Returning
 * an array may not be appropriate if the number of values returned is large
 * or is fetched remotely.	Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
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
 * @version $Id: HarmoniRepositoryIterator.class.php,v 1.7 2006/05/25 14:45:43 adamfranco Exp $ 
 */
class HarmoniRepositoryIterator
	extends HarmoniIterator
	//implements RepositoryIterator
{	
	/**
	 * Return true if there is an additional  Repository ; false otherwise.
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
	function hasNextRepository () { 
		return $this->hasNext();
	}

	/**
	 * Return the next Repository.
	 *	
	 * @return object Repository
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
	 *		   org.osid.repository.RepositoryException#NO_MORE_ITERATOR_ELEMENTS
	 *		   NO_MORE_ITERATOR_ELEMENTS}
	 * 
	 * @access public
	 */
	function &nextRepository () { 
		return $this->next();
	}
	
	/**
	 * Return the next Repository.
	 *	
	 * @return object Repository.
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NO_MORE_ITERATOR_ELEMENTS
	 *		   NO_MORE_ITERATOR_ELEMENTS}
	 * 
	 * @access public
	 */
	function &next () {
		// If this is the first element access, inform our AZ cache that we are 
		// working with this set of nodes so that it can fetch AZs for all of 
		// them at once.
		if ($this->_i == -1) {
			$isAuthorizedCache =& IsAuthorizedCache::instance();
			$isAuthorizedCache->queueAssetArray($this->_elements);
		}
		
		return parent::next();
	} 

}

?>