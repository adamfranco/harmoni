<?
/**
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FromNodesAssetIterator.class.php,v 1.1 2006/05/05 17:22:47 adamfranco Exp $
 */

require_once(dirname(__FILE__)."/HarmoniAssetIterator.class.php");

/**
 * The FromNodesAsset iterator lazily fetches assets as they are requested.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * 
 *
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: FromNodesAssetIterator.class.php,v 1.1 2006/05/05 17:22:47 adamfranco Exp $ 
 */
class FromNodesAssetIterator
	extends HarmoniAssetIterator
	//implements AssetIterator
{
	
	/**
	 * Constructor
	 * 
	 * @param object NodeIterator $nodes
	 * @param object Repository $repository
	 * @return object
	 * @access public
	 * @since 5/4/06
	 */
	function FromNodesAssetIterator ( &$nodes, &$repository ) {
// 		ArgumentValidator::validate($nodes, ExtendsValidatorRule::getRule("Iterator"));
		ArgumentValidator::validate($repository, ExtendsValidatorRule::getRule("Repository"));
		
		$this->_nodes =& $nodes;
		$this->_repository =& $repository;
	}
	
	/**
	 * Return true if there is an additional  Asset ; false otherwise.
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
	function hasNext () { 
		return $this->_nodes->hasNext();
	}
	
	/**
	 * Return the next Asset.
	 *	
	 * @return object Asset
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
		$child =& $this->_nodes->next();
		return $this->_repository->getAsset($child->getId());
	} 

}

?>