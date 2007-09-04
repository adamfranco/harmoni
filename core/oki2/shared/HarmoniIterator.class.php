<?php

require_once(HARMONI."Primitives/Objects/SObject.class.php");

/**
 * A class for passing an arbitrary input array as an iterator.
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniIterator.class.php,v 1.12 2007/09/04 20:25:48 adamfranco Exp $
 */
class HarmoniIterator
	extends SObject
{

	/**
	 * @var array $_elements The stored elements.
	 * @access private
	 */
	var $_elements = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniIterator ($elementArray) {
		if($elementArray===NULL){
			$elementArray=array();
		}
		// load the elements into our private array
		foreach (array_keys($elementArray) as $i => $key) {
			$this->_elements[] =$elementArray[$key];
		}
	}
	
	/**
	 * Add an item to the iterator.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param ref mixed $element
	 * @return void
	 * @access public
	 * @since 7/3/07
	 */
	function add ( $element ) {
		$this->_elements[] =$element;
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_elements)-1);
	}

	// public Type & next();
	function next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_elements[$this->_i];
		} else {
			throwError(new Error(SharedException::NO_MORE_ITERATOR_ELEMENTS(), get_class($this), 1));
		}
	}

	/**
	 * Gives the number of items in the iterator
	 *
	 * @return int
	 * @public
	 */
	 function count () {
	 	return count($this->_elements);
	 }
	 
	/**
	 * Skips the next item in the iterator
	 *
	 * @return void
	 * @public
	 */
	 function skipNext() {
	 	if ($this->hasNext())
		 	$this->_i++;
	 	else
	 		throwError(new Error(SharedException::NO_MORE_ITERATOR_ELEMENTS(),
	 			get_class($this), true));
	 }
}

?>