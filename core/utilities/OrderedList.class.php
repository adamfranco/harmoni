<?php

//require_once('OrderedList.interface.php');
/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: OrderedList.class.php,v 1.2 2003/11/27 04:55:41 gabeschine Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class OrderedList {

	/* @var the array, that represents the ordered list itself. */
	var $_list;

 	/**
	 * Constructor. Create a new ordered list.
	 * @access public
	 */
	function OrderedList(){
		$this->_list = array();
	}

 	/**
	 * Add a referenced object to the end of the list and reset the internal counter.
	 * @param object $object The object to add to the queue.
	 * @param string $key the key by which the object is referenced in the list. By default the key will be the integer position in the list.
	 * @access public
	 */
	function add(&$object,$key="") {
		if($key=="")
			$key = count($this->_array);

		$this->_list[$key] =& $object;
		
		reset($this->_list);
	}

	/**
     * Retrieve an element by reference.
	 * @param string $key The primary key of the object to retrieve.
	 * @return object The reference to the object with a given key. False if no object with such key exists.
	 * @access public
	 */
	function &retrieve($key) { 
		if(!isset($this->_list[$key]))
			return false;

		else return ($this->_list[$key]);
	}

	/**
     * Create a new instance of the object in the list with a given reference.
	 * @param string $key The primary key of the object to get a copy of.
	 * @return object A copy of an object with a given key.
	 * @access public
	 */
	function copy($key) { 
		if(!isset($this->_list[$key]))
			return false;

		else return($this->_list[$key]);
	}


	/**
     * Delete an element by reference.
	 * @param string $key The primary key of the object to delete.
	 * @return boolean True on success, false on failure (no such key exists).
	 * @access public
	 */
	function delete($key) { 
		$check = false;
		if(isset($this->_list[$key]))
			$check = true;

		unset($this->_list[$key]);
		return $check;
	}

	/**
     * Tell whether an element with a given reference exists in the list.
	 * @param string $key The primary key of the object to check.
	 * @return boolean True if the reference exists, false otherwise.
	 * @access public
	 */
	function exists($key) { 
		if(isset($this->_list[$key]))
			return true;
		else
			return false;
	}

	/**
     * Swap two elements in the list.
	 * @param string $key1 The primary key of first object to swap the position of.
	 * @param string $key2 The primary key of second object to swap the position of.
	 * @return boolean True on sucess, false on failure (either of the keys is non-existent in the list).
	 * @access public
	 */

	function swap($key1,$key2) {
		if((!isset($this->_list[$key1])) || (!isset($this->_list[$key2])))
		   return false;

		$tempArray = array();
		   
		foreach ($this->_list as $key=>$value) {
			if (($key!=$key1) && ($key!=$key2))
				$tempArray[$key] =& $this->_list[$key];
			elseif ($key==$key1)
				$tempArray[$key2] =& $this->_list[$key2];
			else
				$tempArray[$key1] =& $this->_list[$key1];
		}
		   
		$this->_list = $tempArray;
		reset($this->_list);
		return true;
	}

	/**
     * Move an element up (towards the beginning) the list.
	 * @param string $key The primary key of the object to move.
     * @return boolean True on success, false on failure (either the element is already at the top or it doesn't exist in the list).
	 * @access public
	 */

	function moveUp($key) { 
		$key1 = $key;
		foreach ($this->_list as $key=>$value) {
			if ($key1 == $key){
				if (isset($keyOld)) {
					$this->swap($key,$keyOld);
					return true;
				}
				else 
					return false;
			}
			$keyOld = $key;
		}
		return false;
	}

	/**
     * Move an element down (towards the end) the list.
	 * @param string $key The primary key of the object to move.
     * @return boolean True on success, false on failure (either the element is already at the bottom or it doesn't exist in the list).
	 * @access public
	 */

	function moveDown($key) { 
		$key1 = $key;
		foreach ($this->_list as $key=>$value) {
			if ($keyOld == $key1){
				$this->swap($key,$keyOld);
				return true;
			}		
			$keyOld = $key;
		}
		reset($this->_list);
		return false;
	}


	/**
     * Move an element to the position that preceeds that of another element or the end of the list.
	 * @param string $source The primary key of object to move.
	 * @param string $destination The primary key of object in front of which the source object is to be put. If $destination==="list_end" the source will be put at the end of the list, in the hope that there is no element whose key is "list_end,"
	 * @return boolean True on sucess false on falure (either the source or the destination keys do not exist).
	 * @access public
	 */

	function putBefore($source,$destination) { 
		/* See if both source and destintion are set or source is set and destination==list_end */
		if ((!isset($this->_list[$source])) || (($destination!=="list_end") && (!isset($this->_list[$destination])))){
			return false;
		}

		$tempArray = array();
		foreach ($this->_list as $key=>$value) {
			if ($key==$destination)
				$tempArray[$source] =& $this->_list[$source];
			if ($key!=$source)
				$tempArray[$key] =& $this->_list[$key];
		}
		
		if ($destination==="list_end")
			$tempArray[$source] =& $this->_list[$source];

		$this->_list = $tempArray;
		reset($this->_list);
		return true;
	}
	
	/**
     * Get the current element and increase the position by one.
	 * @return object The reference to the object at the current position in the queue.
	 * @access public
	 */
	function &next() { 
		$key = key($this->_list);
		next($this->_list);
		return $this->_list[$key];
	}

	/**
     * Tell whether there exists an object in the queue at the current position.
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() { 
		$key = key($this->_list);
		if (isset($this->_list[$key]))
			return true;
		else
			return false;
	}

	/**
     * Get the size of the list.
	 * @return integer The size of the list.
	 * @access public
	 */
	function getSize() { 
		return count($this->_list);
	}

	/**
	 * Clear the list.
	 *
	 * @access public
	 */
	function clear() { 
		$this->_list = array();
	}
}


?>
