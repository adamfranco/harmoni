<?php

require_once(HARMONI."oki/shared/HarmoniIterator.class.php");

/**
 * The Set interface defines methods that are needed for sets of ids. 
 * Sets provide for the easy storage of groups of ids.
 * 
 * @package polyphony.set
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: Set.interface.php,v 1.1 2004/06/28 21:16:43 adamfranco Exp $
 */
 
class SetInterface 
	extends HarmoniIterator {

	/**
	 * Return TRUE if there are additional Ids; FALSE otherwise.
	 * @access public
	 * @return boolean
	 */
	function hasNext () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Return TRUE if the given Id is in the set
	 * @access public
	 * @return boolean
	 */
	function isInSet ( & $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Return the next id
	 * @access public
	 * @return object id
	 */
	function & next () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Reset the internal pointer to the begining of the set.
	 * @access public
	 * @return void
	 */
	function reset () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Add a new Id to the set.
	 * @param object Id $id The Id of the item to add.
	 * @access public
	 * @return void
	 */
	function addItem ( & $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Remove an Id from the set.
	 * @param object Id $id The Id of the item to remove.
	 * @access public
	 * @return void
	 */
	function removeItem ( & $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Remove all Items from the set.
	 * @access public
	 * @return void
	 */
	function removeAllItems () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}