<?php

require_once(dirname(__FILE__)."/OrderedSet.interface.php");

/**
 * The Set provides an implementation of the set interface that stores the
 * sets of ids in a database. Note: Nothing should be implied in the order that
 * the ids are returned.
 * Sets provide for the easy storage of groups of ids.
 * 
 * @package harmoni.sets
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: OrderedSet.class.php,v 1.4 2004/08/26 15:10:35 adamfranco Exp $
 */
 
class OrderedSet 
	extends OrderedSetInterface {
	
	/**
	 * @var int $_dbIndex The dbIndex where this set is stored.
	 * @access private
	 */
	var $_dbIndex;
	
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * @var object Id $_setId The Id of this set.
	 * @access private
	 */
	var $_setId;
	
	/**
	 * @var array $_items The items in this set.
	 * @access private
	 */
	var $_items;
	
	/**
	 * Constructor.
	 * @param object Id $setId The Id of this set.
 	 * @param optional integer $dbIndex The index of the database connection which has
	 * 		tables in which to store the set.
	 */
	function OrderedSet ( & $setId, $dbIndex = NULL ) {
		ArgumentValidator::validate($setId, new ExtendsValidatorRule("Id"), true);
//		if ($dbIndex !== NULL)
			ArgumentValidator::validate($dbIndex, new IntegerValidatorRule, true);
		
		// Create our internal array
		$this->_items = array();
		$this->_setId =& $setId;
		$this->_dbIndex = $dbIndex;
		$this->_i = -1;
		
		// populate our array with any previously stored items.
		$query =& new SelectQuery;
		$query->addColumn("sets.order", "item_order");
		$query->addColumn("sets.item_id", "item_id");
		$query->addTable("sets");
		$query->addWhere("sets.id = '".addslashes($this->_setId->getIdString())."'");
		$query->addOrderBy("sets.order");
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		$i = 0;
		while ($result->hasMoreRows()) {
			// Add the items to our array
			$this->_items[$i] = $result->field("item_id");
			
			// Store an array of the order-key/value relationships to reference
			// when updating any inconsistancies in order numbering.
			$oldItems[$result->field("item_order")] = $result->field("item_id");
									
			$i++;
			$result->advanceRow();
		}
		

		// Make sure that we have our set is filled from 0 to count()
		reset($oldItems);
		$this->_updateOrders($oldItems);
		
		// get a reference to the shared manager so we don't have to keep getting
		// it.
		$this->_sharedManager =& Services::getService("Shared");
	}
	
	/**
	 * Return TRUE if there are additional Ids; FALSE otherwise.
	 * @access public
	 * @return boolean
	 */
	function hasNext () {
		return ($this->_i < count($this->_items)-1);
	}
	
	/**
	 * Return TRUE if the given Id is in the set
	 * @param object Id $id The Id to check.
	 * @access public
	 * @return boolean
	 */
	function isInSet ( & $id ) {
		return in_array($id->getIdString(), $this->_items);
	}
	
	/**
	 * Return the next id
	 * @access public
	 * @return object id
	 */
	function &next () {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_sharedManager->getId($this->_items[$this->_i]);
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "Set", 1));
		}
	}
	
	/**
	 * Reset the internal pointer to the begining of the set.
	 * @access public
	 * @return void
	 */
	function reset () {
		$this->_i = -1;
	}
	
	/**
	 * Add a new Id to the set.
	 * @param object Id $id The Id to add.
	 * @access public
	 * @return void
	 */
	function addItem ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		// Add the item to our internal list
		$position = $this->count();
		$this->_items[$position] = $id->getIdString();
		$key = array_search($id->getIdString(), $this->_items);
		
		// Add the item to the database
		$query =& new InsertQuery;
		$query->setTable("sets");
		$columns = array("sets.id", "sets.item_id", "sets.order");
		$values = array($this->_setId->getIdString(), $id->getIdString(), $position);
		$query->setColumns($columns);
		$query->setValues($values);
		
		$dbHandler =& Services::getService("DBHandler");
		$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Remove an Id from the set.
	 * @param object Id $id The Id to remove.
	 * @access public
	 * @return void
	 */
	function removeItem ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		if (!$this->isInSet($id))
			throwError(new Error("Item specified does not exist", "Set", 1));
		
		// Move it to the end to update the order keys
		$this->moveToPosition($id, $this->count()-1);
		
		// Remove the item from our internal list
		unset ($this->_items[$this->count()-1]);
		
		// update the database with the new order keys.
		$this->_updateOrders($savedItems);
		
		// Remove the item from the database
		$query =& new DeleteQuery;
		$query->setTable("sets");
		$query->addWhere("sets.id='".addslashes($this->_setId->getIdString())."'");
		$query->addWhere("sets.item_id='".addslashes($id->getIdString())."'");
		
		$dbHandler =& Services::getService("DBHandler");
		$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Remove all Items from the set.
	 * @access public
	 * @return void
	 */
	function removeAllItems () {
		// Remove the item from the database
		$query =& new DeleteQuery;
		$query->setTable("sets");
		$query->addWhere("sets.id='".addslashes($this->_setId->getIdString())."'");
				
		$dbHandler =& Services::getService("DBHandler");
		$dbHandler->query($query, $this->_dbIndex);
		
		// Create our internal array
		$this->_items = array();
		$this->_i = -1;
	}
	
	/**
	 * Return the current position of the id in the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return integer
	 */
	function getPosition ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		return array_search($id->getIdString(), $this->_items);
	}
	
	/**
	 * Return the number of ids in the set.
	 * @access public
	 * @return integer
	 */
	function count () {
		return count($this->_items);
	}
	
	/**
	 * Move the specified id to the specified position in the set.
	 * @param object Id $id The Id of the item to move.
	 * @param integer $position The new position of the specified id.
	 * @access public
	 * @return void
	 */
	function moveToPosition ( & $id, $position ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		if ($position != $this->getPosition($id) 
			&& $position >= 0
			&& $position < $this->count()) {
			
			$oldOrder = $this->_items;
			$previousPosition = $this->getPosition($id);
			
			if ($position < $previousPosition) {
				for ($i = $previousPosition; $i > $position; $i--) {
					$this->_items[$i] = $this->_items[$i-1];
				}
			} else {
				for ($i = $previousPosition; $i < $position; $i++) {
					$this->_items[$i] = $this->_items[$i+1];
				}
			}
			
			$this->_items[$position] = $id->getIdString();
			
 			$this->_updateOrders($oldOrder);
		}
		
		if ($position < 0 || $position >= $this->count()) {
			throwError(new Error("Position specified, '".$position."', is out of bounds.", "Set", TRUE));
		}
	}
	
	/**
	 * Move the specified id toward the begining of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveUp ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		if (($position = $this->getPosition($id)) > 0) {
			$oldOrder = $this->_items;
			$itemBefore = $this->_items[$position-1];
			$this->_items[$position-1] = $id->getIdString();
			$this->_items[$position] = $itemBefore;
			
			$this->_updateOrders($oldOrder);
		}
	}
	
	/**
	 * Move the specified id toward the end of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveDown ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		if (($position = $this->getPosition($id)) < ($this->count() - 1)) {
			$oldOrder = $this->_items;
			$itemAfter = $this->_items[$position + 1];
			$this->_items[$position + 1] = $id->getIdString();
			$this->_items[$position] = $itemAfter;
			
			$this->_updateOrders($oldOrder);
		}
	}
	
	/**
	 * Update the orders of the ids in the database.
	 * @param array $oldOrders The previous orders to compare so that only 
	 *		updates will be done to changed orders.
	 * @access private
	 * @return void
	 */
	function _updateOrders ( $oldOrders ) {
		$dbHandler =& Services::getService("DBHandler");

		foreach ($this->_items as $key => $val) {
			// If the old key-value pairs don't match the current ones, 
			// update that row
			if ($oldOrders[$key] != $val) {
				$query =& new UpdateQuery;
				$query->setTable("sets");
				$columns = array("sets.order");
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