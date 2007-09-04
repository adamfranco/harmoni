<?php

require_once(dirname(__FILE__)."/Set.interface.php");

/**
 * The OrderedSet interface defines methods that are needed for ordering
 * sets of ids. Sets provide for the easy storage of groups of ids.
 *
 * @package  harmoni.sets
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OrderedSet.interface.php,v 1.4 2007/09/04 20:25:49 adamfranco Exp $
 * @author Adam Franco
 */
 
class OrderedSetInterface 
	extends SetInterface {

	/**
	 * Add a new Id to the set. The new item will be placed at the end of the set.
	 * @param object Id $id The Id of the item to add.
	 * @access public
	 * @return void
	 */
	function addItem ( $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Move the specified id toward the begining of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveUp ( $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Move the specified id toward the end of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveDown ( $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Return the current position of the id in the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return integer
	 */
	function getPosition ( $id ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Return the number of ids in the set.
	 * @access public
	 * @return integer
	 */
	function count () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Move the specified id to the specified position in the set.
	 * @param object Id $id The Id of the item to move.
	 * @param integer $position The new position of the specified id.
	 * @access public
	 * @return void
	 */
	function moveToPosition ( $id, $position ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}