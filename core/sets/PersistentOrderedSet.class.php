<?php

require_once(dirname(__FILE__)."/OrderedSet.class.php");

/**
 * The Set provides an implementation of the set interface that stores the
 * sets of ids in a database. Note: Nothing should be implied in the order that
 * the ids are returned.
 * Sets provide for the easy storage of groups of ids.
 *
 * @package  harmoni.sets
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PersistentOrderedSet.class.php,v 1.4 2007/09/04 20:25:49 adamfranco Exp $
 * @author Adam Franco
 */
 
class PersistentOrderedSet 
	extends OrderedSet {
	
	/**
	 * @var int $_dbIndex The dbIndex where this set is stored.
	 * @access private
	 */
	var $_dbIndex;
	
	/**
	 * Constructor.
	 * @param object Id $setId The Id of this set.
 	 * @param integer $dbIndex The index of the database connection which has
	 * 		tables in which to store the set.
	 */
	function PersistentOrderedSet ( $setId, $dbIndex ) {
		parent::OrderedSet($setId);
		
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		
		// Create our internal array
		$this->_dbIndex = $dbIndex;
		
		// populate our array with any previously stored items.
		$query = new SelectQuery;
		$query->addColumn("sets.item_order", "item_order");
		$query->addColumn("sets.item_id", "item_id");
		$query->addTable("sets");
		$query->addWhere("sets.id = '".addslashes($this->_setId->getIdString())."'");
		$query->addOrderBy("sets.item_order");
		
		$dbHandler = Services::getService("DatabaseManager");
		$result =$dbHandler->query($query, $this->_dbIndex);
		
		$i = 0;
		$oldItems = array();
		while ($result->hasMoreRows()) {
			// Add the items to our array
			$this->_items[$i] = $result->field("item_id");
			
			// Store an array of the order-key/value relationships to reference
			// when updating any inconsistancies in order numbering.
			$oldItems[$result->field("item_order")] = $result->field("item_id");
									
			$i++;
			$result->advanceRow();
		}
		$result->free();

		// Make sure that we have our set is filled from 0 to count()
		reset($oldItems);
		$this->_updateOrders($oldItems);
	}
	
	/**
	 * Add a new Id to the set.
	 * @param object Id $id The Id to add.
	 * @access public
	 * @return void
	 */
	function addItem ( $id ) {
		parent::addItem($id);
		
		$position = $this->getPosition($id);
		
		// Add the item to the database
		$query = new InsertQuery;
		$query->setTable("sets");
		$columns = array("sets.id", "sets.item_id", "sets.item_order");
		$values = array("'".addslashes($this->_setId->getIdString())."'", "'".addslashes($id->getIdString())."'", "'".$position."'");
		$query->setColumns($columns);
		$query->setValues($values);
		
		$dbHandler = Services::getService("DatabaseManager");
		$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Remove an Id from the set.
	 * @param object Id $id The Id to remove.
	 * @access public
	 * @return void
	 */
	function removeItem ( $id ) {
		// Store the old order 
		$oldOrder = $this->_items;
		
		// remove the Item
		parent::removeItem($id);
		
		// update the database with the new order keys.
		$this->_updateOrders($oldOrder);
		
		// Remove the item from the database
		$query = new DeleteQuery;
		$query->setTable("sets");
		$query->addWhere("sets.id='".addslashes($this->_setId->getIdString())."'");
		$query->addWhere("sets.item_id='".addslashes($id->getIdString())."'");
		
		$dbHandler = Services::getService("DatabaseManager");
		$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Remove all Items from the set.
	 * @access public
	 * @return void
	 */
	function removeAllItems () {
		parent::removeAllItems();
		
		// Remove the item from the database
		$query = new DeleteQuery;
		$query->setTable("sets");
		$query->addWhere("sets.id='".addslashes(
			$this->_setId->getIdString())."'");
				
		$dbHandler = Services::getService("DatabaseManager");
		$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Move the specified id to the specified position in the set.
	 * @param object Id $id The Id of the item to move.
	 * @param integer $position The new position of the specified id.
	 * @access public
	 * @return void
	 */
	function moveToPosition ( $id, $position ) {
		// Store the old order 
		$oldOrder = $this->_items;
		
		// remove the Item
		parent::moveToPosition($id, $position);
		
		// update the database with the new order keys.
		$this->_updateOrders($oldOrder);
	}
	
	/**
	 * Move the specified id toward the begining of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveUp ( $id ) {
		// Store the old order 
		$oldOrder = $this->_items;
		
		// move the Item
		parent::moveUp($id);
		
		// update the database with the new order keys.
		$this->_updateOrders($oldOrder);
	}
	
	/**
	 * Move the specified id toward the end of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveDown ( $id ) {
		// Store the old order 
		$oldOrder = $this->_items;
		
		// move the Item
		parent::moveDown($id);
		
		// update the database with the new order keys.
		$this->_updateOrders($oldOrder);
	}
	
	/**
	 * Update the orders of the ids in the database.
	 * @param array $oldOrders The previous orders to compare so that only 
	 *		updates will be done to changed orders.
	 * @access private
	 * @return void
	 */
	function _updateOrders ( $oldOrders ) {
		$dbHandler = Services::getService("DatabaseManager");

		foreach ($this->_items as $key => $val) {
			// If the old key-value pairs don't match the current ones, 
			// update that row
			if ($oldOrders[$key] != $val) {
				$query = new UpdateQuery;
				$query->setTable("sets");
				$columns = array("sets.item_order");
				$query->setColumns($columns);
				$values = array($key);
				$query->setValues($values);
				$query->addWhere("sets.id = '".addslashes($this->_setId->getIdString())."'");
				$query->addWhere("sets.item_id = '".addslashes($val)."'");
				
				$dbHandler->query($query);
			}
		}
	}
}