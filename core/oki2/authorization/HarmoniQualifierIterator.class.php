<?php 

require_once(OKI2."/osid/authorization/QualifierIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");
 
/**
 * QualifierIterator is the iterator for a collection of Qualifiers.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniQualifierIterator.class.php,v 1.7 2006/05/25 17:23:28 adamfranco Exp $
 */
class HarmoniQualifierIterator
	extends HarmoniIterator
//	implements QualifierIterator
{
	/**
	 * Return true if there is an additional  Qualifier ; false otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function hasNextQualifier () { 
		return $this->hasNext();
	} 

	/**
	 * Return the next Qualifier.
	 *	
	 * @return object Qualifier
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &nextQualifier () { 
		return $this->next();
	}
	
	/**
	 * Return the next Qualifier.
	 *	
	 * @return object Qualifier
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