<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tag.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
 */ 

/**
 * <##>
 * 
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tag.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
 */
class Tag {
	
	/**
	 * Constructor
	 * 
	 * @param string value
	 * @return object
	 * @access public
	 * @since 11/6/06
	 */
	function Tag ($value) {
						// remove any trailing underbars
		$this->_value = trim(
						// use only one underbar at a time
						 preg_replace('/_{2,}/', '_', 
							// Replace anything not allowed with an underbar
							preg_replace('/[^a-z0-9_\-:]/i', '_', 
								strtolower($value))), '_');
	}
	
	/**
	 * Answer the value
	 * 
	 * @return string
	 * @access public
	 * @since 11/6/06
	 */
	function getValue () {
		return $this->_value;
	}
	
	/**
	 * Add this tag to an Item
	 * 
	 * @param object TaggedItem $item
	 * @return object The item
	 * @access public
	 * @since 11/6/06
	 */
	function &tagItem ( &$item ) {
		// Make sure the item is not already tagged
		if ($this->isItemTagged($item))
			return $item;
		
		$query =& new InsertQuery;
		$query->setTable('tag');
		$query->setColumns(array('value', 'user_id', 'fk_item'));
		$query->setValues(array(
			"'".addslashes($this->getValue())."'",
			"'".addslashes($this->getCurrentUserId())."'",
			"'".addslashes($item->getDabaseId())."'"));
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		return $item;
	}
	
	/**
	 * Answer the number of occurances of this tag across all users
	 * 
	 * @return integer
	 * @access public
	 * @since 11/7/06
	 */
	function getOccurances () {
		if (!isset($this->_allOccurances)) {
			$query =& new SelectQuery;
			$query->addColumn('COUNT(value)', 'occurances');
			$query->addTable('tag');
			$query->addWhere("value='".addslashes($this->getValue())."'");
			
			$dbc =& Services::getService("Database");
			$result =& $dbc->query($query, $this->getDatabaseIndex());
			$this->_allOccurances = $result->field('occurrances');
		}
		return $this->_allOccurances;
	}
	
	/**
	 * Set the number of occurances
	 * 
	 * @param integer $num
	 * @return void
	 * @access protected
	 * @since 11/7/06
	 */
	function setOccurances ($num) {
		$this->_allOccurances = $num;
	}
	
	/**
	 * Answer the number of occurances of this tag across all users
	 * 
	 * @param object Id $agentId
	 * @return integer
	 * @access public
	 * @since 11/7/06
	 */
	function getOccurancesForAgent ( &$agentId ) {
		if (!isset($this->_agentOccurances))
			$this->_agentOccurances = array();
		
		if (!isset($this->_agentOccurances[$agentId->getIdString()])) {
			$query =& new SelectQuery;
			$query->addColumn('COUNT(value)', 'occurances');
			$query->addTable('tag');
			$query->addWhere("value='".addslashes($this->getValue())."'");
			$query->addWhere("user_id='".addslashes($agentId->getIdString())."'");
			
			$dbc =& Services::getService("Database");
			$result =& $dbc->query($query, $this->getDatabaseIndex());
			$this->_agentOccurances[$agentId->getIdString()] = $result->field('occurrances');
		}
		return $this->_agentOccurances[$agentId->getIdString()];
	}
	
	/**
	 * Set the number of occurances
	 * 
	 * @param object Id $agentId
	 * @param integer $num
	 * @return void
	 * @access protected
	 * @since 11/7/06
	 */
	function setOccurancesForAgent ( &$agentId, $num ) {
		if (!isset($this->_agentOccurances))
			$this->_agentOccurances = array();
		
		$this->_agentOccurances[$agentId->getIdString()] = $num;
	}
		
	/**
	 * Answer all items with this tag
	 * 
	 * @return object ItemIterator
	 * @access public
	 * @since 11/2/06
	 */
	function &getItems () {
		$query =& new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhere("tag.value='".addslashes($this->getValue())."'");
		
		$query->addOrderBy('tag.tstamp', DESC);
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		$iterator =& new ItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all items with this tag in a particular system
	 * 
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object ItemsIterator
	 * @access public
	 * @since 11/2/06
	 */
	function &getItemsInSystem ( $system) {
		$query =& new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhere("tag.value='".addslashes($this->getValue())."'");
		$query->addWhere("tag_item.system='".addslashes($system)."'");
		
		$query->addOrderBy('tag.tstamp', DESC);
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		$iterator =& new ItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all items with this tag
	 * 
	 * @return object ItemIterator
	 * @access public
	 * @since 11/2/06
	 */
	function &getItemsForCurrentUser () {
		$query =& new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhere("tag.value='".addslashes($this->getValue())."'");
		$query->addWhere("tag.user_id='".addslashes($this->getCurrentUserId())."'");
		
		$query->addOrderBy('tag.tstamp', DESC);
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		$iterator =& new ItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all items with this tag in a particular system
	 * 
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object ItemsIterator
	 * @access public
	 * @since 11/2/06
	 */
	function &getItemsForCurrentUserInSystem ( $system) {
		$query =& new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhere("tag.value='".addslashes($this->getValue())."'");
		$query->addWhere("tag.user_id='".addslashes($this->getCurrentUserId())."'");
		$query->addWhere("tag_item.system='".addslashes($system)."'");
		
		$query->addOrderBy('tag.tstamp', DESC);
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		$iterator =& new ItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer true if the current user can remove a tag from an item
	 * 
	 * @param object $item 
	 * @return boolean
	 * @access public
	 * @since 11/2/06
	 */
	function canRemoveFromItem ( &$item ) {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Remove the tag from one or more items, skipping those where authorization
	 * is lacking.
	 * 
	 * @param mixed $items This can be a single Item object, an ItemIterator, 
	 * 		or an array of Item objects.
	 * @return void
	 * @access public
	 * @since 11/2/06
	 */
	function removeFromItems ( &$items ) {
		$itemDbIds = array();
		
		// array
		if (is_array($items)) {
			foreach(array_keys($items) as $key) {
				$itemDbIds[] = "'".addslashes($items[$key]->getDatabaseId())."'";
			}
		} 
		// iterator
		else if (method_exists($items, 'next')) {
			while($items->hasNext()) {
				$item =& $items->next();
				$itemDbIds[] = "'".addslashes($item->getDatabaseId())."'";
			}
		} 
		// Single item
		else if (method_exists($items, 'getDatabaseId')) {
			$itemDbIds[] = "'".addslashes($items->getDatabaseId())."'";
		} else {
			throwError(new Error("Invalid parameter, $items, for \$items", "Tagging"));
		}
		
		$query =& new DeleteQuery;
		$query->setTable('tag');
		$query->addWhere("tag.value='".addslashes($this->getValue())."'");
		$query->addWhere("tag.user_id='".addslashes($this->getCurrentUserId())."'");
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");		
		
		$dbc =& Services::getService("Database");
		$dbc->query($query, $this->getDatabaseIndex()); 
	}
	
	/**
	 * Remove the tag everywhere where the current user has added it.
	 * 
	 * @return void
	 * @access public
	 * @since 11/2/06
	 */
	function removeAllMine () {
		$query =& new DeleteQuery;
		$query->setTable('tag');
		$query->addWhere("tag.value='".addslashes($this->getValue())."'");
		$query->addWhere("tag.user_id='".addslashes($this->getCurrentUserId())."'");
		
		$dbc =& Services::getService("Database");
		$dbc->query($query, $this->getDatabaseIndex());
	}
	
	/**
     * Answer the database index
     * 
     * @return integer
     * @access public
     * @since 11/6/06
     */
    function getDatabaseIndex () {
    	if (!isset($this->_databaseIndex)) {
    		$taggingManager =& Services::getService("Tagging");
    		$this->_databaseIndex = $taggingManager->getDatabaseIndex();
		}
		return $this->_databaseIndex;
    }
    
    /**
     * Answer the current user id
     * 
     * @return string
     * @access public
     * @since 11/6/06
     */
    function getCurrentUserId () {
    	if (!isset($this->_currentUserId)) {
    		$taggingManager =& Services::getService("Tagging");
    		$this->_currentUserId = $taggingManager->getCurrentUserId();
		}
		return $this->_currentUserId;
    }
}

?>