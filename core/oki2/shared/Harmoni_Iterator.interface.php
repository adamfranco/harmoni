<?php
/**
 * @since 12/4/07
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_Iterator.interface.php,v 1.1 2007/12/06 21:06:45 adamfranco Exp $
 */ 

/**
 * An interface for all Iterators used in Harmoni
 * 
 * @since 12/4/07
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_Iterator.interface.php,v 1.1 2007/12/06 21:06:45 adamfranco Exp $
 */
interface Harmoni_Iterator {
		
	/**
	 * Return true if there is an additional item.
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
	 * @return boolean
	 * @access public
	 * @since 12/4/07
	 */
	public function hasNext ();
	
	/**
	 * Return the next item.
	 *  
	 * @return mixed
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
	 * @access public
	 * @since 12/4/07
	 */
	function next ();
	
	/**
	 * Skip past the next item without returning it.
	 *  
	 * @return void
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
	 * @access public
	 * @since 12/4/07
	 */
	function skipNext ();
	
	/**
	 * Gives an estimate of the number of items in the iterator. This may not be
	 * accurate or the iterator may be infinite. Use hasNext() and next() to find 
	 * the actual number if needed and possible.
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
	 * @return int
	 * @access public
	 * @since 12/4/07
	 */
	public function count ();
}

/**
 * An interface for an iterator that can have items added to it.
 * 
 * @since 12/4/07
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_Iterator.interface.php,v 1.1 2007/12/06 21:06:45 adamfranco Exp $
 */
interface Harmoni_AppendableIterator
	extends Harmoni_Iterator
{
		
	/**
	 * Add an item to the end of the iterator.
	 * 
	 * @param mixed $item
	 * @return void
	 * @access public
	 * @since 12/4/07
	 */
	public function add ($item);
	
}

?>