<?php

require_once(dirname(__FILE__)."/Set.interface.php");

/**
 * The Set provides an implementation of the set interface that stores the
 * sets of ids in a database. Note: Nothing should be implied in the order that
 * the ids are returned.
 * Sets provide for the easy storage of groups of ids.
 * 
 * @package polyphony.set
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: Set.class.php,v 1.1 2004/06/28 21:16:43 adamfranco Exp $
 */
 
class Set 
	extends SetInterface {
	
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
	function Set ( & $setId, $dbIndex = NULL ) {
		
		die ("Please use OrderedSet instead.");
		
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
		$query->addColumn("sets.item_id", "id");
		$query->addTable("sets");
		$query->addWhere("sets.id = '".$this->_setId->getIdString()."'");
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		while ($result->hasMoreRows()) {
			$this->_items[] =& $result->field("id");
			$result->advanceRow();
		}
		
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
	function & next () {
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
	 * @access public
	 * @return void
	 */
	function addItem ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		// Add the item to the database
		$query =& new InsertQuery;
		$query->setTable("sets");
		$columns = array("sets.id", "sets.item_id");
		$values = array($this->_setId->getIdString(), $id->getIdString());
		$query->setColumns($columns);
		$query->setValues($values);
		
		$dbHandler =& Services::getService("DBHandler");
		$dbHandler->query($query, $this->_dbIndex);
		
		// Add the item to our internal list
		$this->_items[] = $id->getIdString();
	}
	
	/**
	 * Remove an Id from the set.
	 * @access public
	 * @return void
	 */
	function removeItem ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		
		// Remove the item from the database
		$query =& new DeleteQuery;
		$query->setTable("sets");
		$query->addWhere("sets.id='".$this->_setId->getIdString()."'");
		$query->addWhere("sets.item_id='".$id->getIdString()."'");
		
		$dbHandler =& Services::getService("DBHandler");
		$dbHandler->query($query, $this->_dbIndex);
		
		// Remove the item from our internal list
		$key = array_search($id->getIdString());
		unset ($this->_items[$key]);
		sort ($this->_items);
	}
}