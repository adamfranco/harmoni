<?php

/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: OrderedList.interface.php,v 1.2 2003/07/04 02:13:15 movsjani Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class OrderedListInterface {

 	/**
	 * Add a referenced object to the end of the list and reset the internal counter.
	 * @param object $object The object to add to the queue.
	 * @param string $key the key by which the object is referenced in the list. By default the key will be the integer position in the list.
	 * @access public
	 */	function add(& $object,$key="") { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Retrieve an element by reference.
	 * @param string $key The primary key of the object to retrieve.
	 * @return object The reference to the object with a given key. False if no object with such key exists.
	 * @access public
	 */
	function &retrieve($key) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}

	/**
     * Create a new instance of the object in the list with a given reference.
	 * @param string $key The primary key of the object to get a copy of.
	 * @return object A copy of an object with a given key.
	 * @access public
	 */
	function copy($key) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }


	/**
     * Delete an element by reference.
	 * @param string $key The primary key of the object to delete.
	 * @return boolean True on success, false on failure (no such key exists).
	 * @access public
	 */
	function delete($key) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
     * Tell whether an element with a given reference exists in the list.
	 * @param string $key The primary key of the object to check.
	 * @return boolean True if the reference exists, false otherwise.
	 * @access public
	 */
	function exists($key) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	/**
     * Swap two elements in the list.
	 * @param string $key1 The primary key of first object to swap the position of.
	 * @param string $key2 The primary key of second object to swap the position of.
	 * @return boolean True on sucess, false on failure (either of the keys is non-existent in the list).
	 * @access public
	 */

	function swap($key1,$key2) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Move an element down (towards the beginning of) the list.
	 * @param string $key The primary key of the object to move.
     * @return boolean True on success, false on failure (either the element is already at the top or it doesn't exist in the list).
	 * @access public
	 */

	function moveUp($key) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Move an element down (towards the end of) the list.
	 * @param string $key The primary key of the object to move.
     * @return boolean True on success, false on failure (either the element is already at the bottom or it doesn't exist in the list).
	 * @access public
	 */

	function moveDown($key) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Move an element to the position that preceeds that of another element or the end of the list.
	 * @param string $source The primary key of object to move.
	 * @param string $destination The primary key of object in front of which the source object is to be put. If $destination==="list_end" the source will be put at the end of the list, in the hope that there is no element whose key is "list_end,"
	 * @return boolean True on sucess false on falure (either the source or the destination keys do not exist).
	 * @access public
	 */

	function putBefore($source,$destination) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
     * Get the current element and increase the position by one.
	 * @return object The reference to the object at the current position in the queue.
	 * @access public
	 */
	function next() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Tell whether there exists an object in the queue at the current position.
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Get the size of the list.
	 * @return integer The size of the list.
	 * @access public
	 */
	function getSize() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Clear the list.
	 *
	 * @access public
	 */
	function clear() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}


?>
