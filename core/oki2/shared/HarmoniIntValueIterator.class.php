<?php 

require_once(OKI2."/osid/shared/IntValueIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");
 
/**
 * IntValueIterator provides access to these objects sequentially, one at a
 * time.  The purpose of all Iterators is to to offer a way for OSID methods
 * to return multiple values of a common type and not use an array.  Returning
 * an array may not be appropriate if the number of values returned is large
 * or is fetched remotely.  Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.  To maximize
 * reuse and implementation substitutability, it is important not to reference
 * a class in one OSID implementation directly in another.  Interfaces should
 * be used and new called only on objects in the implementation package.  To
 * avoid binding a specific implementation of Shared to a specific
 * implementaiton of some other OSID, implementations TypeIterator and the
 * other primitative-type Iterators should reside in each OSID that requires
 * them and not in an implementation of Shared.  For example, if an
 * implementation of org.osid.logging.LoggingManager needs a class that
 * implements org.osid.shared.StringIterator, the class should be in the
 * package implementing Logging.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid.shared
 */
class HarmoniIntValueIterator
	extends HarmoniIterator
//	implements IntValueIterator
{
	/**
     * Return true if there is an additional  IntValue ; false otherwise.
     *  
     * @return boolean
     * 
     * @throws object SharedException An exception with one of the
     *         following messages defined in org.osid.shared.SharedException
     *         may be thrown:  {@link
     *         org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.shared.SharedException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.shared.SharedException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function hasNextIntValue () { 
        return $this->hasNext();
    } 

    /**
     * Return the next int.
     *  
     * @return int
     * 
     * @throws object SharedException An exception with one of the
     *         following messages defined in org.osid.shared.SharedException
     *         may be thrown:  {@link
     *         org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.shared.SharedException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.shared.SharedException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link
     *         org.osid.shared.SharedException#NO_MORE_ITERATOR_ELEMENTS
     *         NO_MORE_ITERATOR_ELEMENTS}
     * 
     * @public
     */
    function nextIntValue () { 
        return $this->next();
    } 
}

?>