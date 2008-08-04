<?php

/**
 * @package harmoni.sets
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OrderedSet.class.php,v 1.20 2007/09/04 20:25:49 adamfranco Exp $
 */ 

require_once(HARMONI."Primitives/Objects/SObject.class.php");

/**
 * The OrderedSet provides an easy way to manage a group of Ids.
 * This set is not persistant. Please see the {@link TempOrderedSet} and the
 * {@link PersistentOrderedSet} for persisting sets.
 *
 * @package  harmoni.sets
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OrderedSet.class.php,v 1.20 2007/09/04 20:25:49 adamfranco Exp $
 * @author Adam Franco
 */
 
class OrderedSet 
	extends SObject
{
	
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
	 */
	function OrderedSet ( $setId ) {
		ArgumentValidator::validate($setId, ExtendsValidatorRule::getRule("Id"), true);
		
		// Create our internal array
		$this->_items = array();
		$this->_setId =$setId;
		$this->_i = -1;
	}
	
	/**
	 * Answer the id of this set
	 * 
	 * @return object Id
	 * @access public
	 * @since 8/5/05
	 */
	function getId () {
		return $this->_setId;
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
	function isInSet ( $id ) {
		return in_array($id->getIdString(), $this->_items);
	}
	
	/**
	 * Return the next id
	 * @access public
	 * @return object id
	 */
	function next () {
		$idManager = Services::getService("Id");
		if ($this->hasNext()) {
			$this->_i++;
			return $idManager->getId($this->_items[$this->_i]);
		} else {
			throw new NoMoreIteratorElementsException();
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
	function addItem ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
		// Add the item to our internal list
		$position = $this->count();
		$this->_items[$position] = $id->getIdString();
	}
	
	/**
	 * Remove an Id from the set.
	 * @param object Id $id The Id to remove.
	 * @access public
	 * @return void
	 */
	function removeItem ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
		if (!$this->isInSet($id))
			throwError(new Error("Item specified, ".$id->getIdString().", does not exist", "Set", 1));
		
		// Move it to the end to update the order keys
		$this->moveToPosition($id, $this->count()-1);
		
		// Remove the item from our internal list
		unset ($this->_items[$this->count()-1]);
	}
	
	/**
	 * Remove all Items from the set.
	 * @access public
	 * @return void
	 */
	function removeAllItems () {
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
	function getPosition ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
		return array_search($id->getIdString(), $this->_items);
	}
	
	/**
	 * Answer the id at the position specified, false if position is out of bounds.
	 * 
	 * @param integer $position
	 * @return object Id
	 * @access public
	 * @since 1/30/06
	 */
	function atPosition ( $position ) {
		$idManager = Services::getService("Id");
		if (isset($this->_items[$position]))
			return $idManager->getId($this->_items[$position]);
		else {
			$false = false;
			return $false;
		}
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
	function moveToPosition ( $id, $position ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
// 		printpre("Moving ".$id->getIdString()." from ".$this->getPosition($id)." to ".$position);
		
		if ($position != $this->getPosition($id) 
			&& $position >= 0
			&& $position < $this->count()) {
			
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
	function moveUp ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
		if (($position = $this->getPosition($id)) > 0) {
			$itemBefore = $this->_items[$position-1];
			$this->_items[$position-1] = $id->getIdString();
			$this->_items[$position] = $itemBefore;
		}
	}
	
	/**
	 * Move the specified id toward the end of the set.
	 * @param object Id $id The Id of the item to move.
	 * @access public
	 * @return void
	 */
	function moveDown ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		
		if (($position = $this->getPosition($id)) < ($this->count() - 1)) {
			$itemAfter = $this->_items[$position + 1];
			$this->_items[$position + 1] = $id->getIdString();
			$this->_items[$position] = $itemAfter;
		}
	}
	
	/**
	 * Move the specifiedId to the beginning of the set
	 * 
	 * @param object Id $id The Id of the item to move.
	 * @return void
	 * @access public
	 * @since 1/30/06
	 */
	function moveToBeginning ( $id ) {
		$this->moveToPosition($id, 0);
	}
	
	/**
	 * Move the specifiedId to the end of the set
	 * 
	 * @param object Id $id The Id of the item to move.
	 * @return void
	 * @access public
	 * @since 1/30/06
	 */
	function moveToEnd ( $id ) {
		$this->moveToPosition($id, $this->count() - 1);
	}
	
	/**
	 * Initialize from a data-string
	 * 
	 * @param string $data
	 * @return void
	 * @access public
	 * @since 1/30/06
	 */
	function initializeWithData ( $data ) {
		// Create our internal array
		$this->_i = -1;
		$items = explode("\t", $data);
		foreach ($items as $item) {
			if (preg_match('/^[^\s\t\n]+$/', $item) && !in_array($item, $this->_items))
				$this->_items[] = $item;
		}
	}
	
	/**
	 * Answer a data string for storage
	 * 
	 * @return string
	 * @access public
	 * @since 1/30/06
	 */
	function toDataString () {
		return implode("\t", $this->_items);
	}
}