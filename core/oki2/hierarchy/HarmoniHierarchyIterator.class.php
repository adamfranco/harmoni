<?

require_once(OKI2."/osid/hierarchy/HierarchyIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * HierarchyIterator provides access to these objects sequentially, one at a
 * time.  The purpose of all Iterators is to to offer a way for OSID methods
 * to return multiple values of a common type and not use an array.  Returning
 * an array may not be appropriate if the number of values returned is large
 * or is fetched remotely.  Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid.hierarchy
 */
class HarmoniHierarchyIterator
	extends HarmoniIterator
//	implements HierarchyIterator
{

    /**
     * Return true if there is an additional  Hierarchy ; false otherwise.
     *  
     * @return boolean
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function hasNextHierarchy () { 
        return $this->hasNext();
    } 

    /**
     * Return the next Hierarchy.
     *  
     * @return object Hierarchy
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NO_MORE_ITERATOR_ELEMENTS
     *         NO_MORE_ITERATOR_ELEMENTS}
     * 
     * @public
     */
    function &nextHierarchy () { 
        return $this->next();
    } 
}

?>