<?php

require_once(dirname(__FILE__)."/HarmoniIterator.class.php");

/**
 * A class for passing an arbitrary input array as an iterator.
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MultiIteratorIterator.class.php,v 1.5 2007/11/07 19:09:29 adamfranco Exp $
 */
class MultiIteratorIterator
	extends HarmoniIterator
{
	
	/**
	 * Constructor
	 * 
	 * @return object
	 * @access public
	 * @since 12/6/06
	 */
	function __construct () {
		if (func_num_args())
			throw new HarmoniException(__CLASS__." does not take any constructor arguments.");
		parent::__construct($null = null);
	}
	
	/**
	 * Add a new iterator to this iterator
	 * 
	 * @param object Iterator $iterator
	 * @return void
	 * @access public
	 * @since 5/9/06
	 */
	function addIterator ( $iterator ) {
		$this->_elements[] =$iterator;
		unset($this->_count);
	}

	// public boolean hasNext();
	function hasNext() {
		for ($i = max(0, $this->_i); $i < count($this->_elements); $i++) {
			if ($this->_elements[$i]->hasNext())
				return true;
		}
		return false;
	}

	// public Type & next();
	function next() {
		for ($i = max(0, $this->_i); $i < count($this->_elements); $i++) {
			if ($this->_elements[$i]->hasNext())
				return $this->_elements[$i]->next();
			else
				$this->_i++;
		}
		throwError(new HarmoniError(SharedException::NO_MORE_ITERATOR_ELEMENTS(), get_class($this), 1));
	}

	/**
	 * Gives the number of items in the iterator
	 *
	 * @return int
	 * @public
	 */
	 function count () {
	 	if (!isset($this->_count)) {
	 		$this->_count = 0;
	 		foreach ($this->_elements as $iterator)
	 			$this->_count += $iterator->count();
	 	}
	 	return $this->_count;
	 }
	 
	/**
	 * Skips the next item in the iterator
	 *
	 * @return void
	 * @public
	 */
	 function skipNext() {
	 	for ($i = max(0, $this->_i); $i < count($this->_elements); $i++) {
			if ($this->_elements[$i]->hasNext()) {
				$this->_elements[$i]->skipNext();
				return;
			} else
				$this->_i++;
		}
		throwError(new HarmoniError(SharedException::NO_MORE_ITERATOR_ELEMENTS(), get_class($this), 1));
	 }
}

?>