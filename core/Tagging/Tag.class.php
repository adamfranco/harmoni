<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tag.class.php,v 1.9 2008/04/18 20:40:40 achapin Exp $
 */ 

require_once(dirname(__FILE__)."/TaggedItemIterator.class.php");
require_once(dirname(__FILE__)."/TagFilterIterator.class.php");
// require_once(HARMONI."/DBHandler/GenericSQLQuery.class.php");

/**
 * <##>
 * 
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tag.class.php,v 1.9 2008/04/18 20:40:40 achapin Exp $
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
	function __construct ($value) {
						// remove any trailing underbars
		$this->_value = trim(
						// use only one underbar at a time
						 preg_replace('/_{2,}/', '_', 
							// Replace anything not allowed with an underbar
							preg_replace('/[^a-z0-9_\-:]/i', '_', 
								// drop any quotes
								preg_replace('/[\'"]/', '',
									strtolower($value)))), '_');
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
	function tagItem ( $item ) {
		// Make sure the item is not already tagged
		if ($this->isItemTagged($item))
			return $item;
		
		// Make sure the tag has a non-zero length
		if (!$this->getValue())
			return $item;
		
		$query = new InsertQuery;
		$query->setTable('tag');
		$query->setColumns(array('value', 'user_id', 'fk_item'));
		$query->setValues(array(
			"'".addslashes($this->getValue())."'",
			"'".addslashes($this->getCurrentUserIdString())."'",
			"'".addslashes($item->getDatabaseId())."'"));
		
		$dbc = Services::getService("DatabaseManager");
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		return $item;
	}
	
	/**
	 * Add this tag to an Item for a particular agent
	 * 
	 * @param object TaggedItem $item
	 * @param object Id $agentId
	 * @param optional object DateAndTime $date An optional timestamp, used for importing historical tags.
	 * @return object The item
	 * @access public
	 * @since 11/6/06
	 */
	function tagItemForAgent ( TaggedItem $item, Id $agentId, DateAndTime $date = null) {
		// Make sure the item is not already tagged
		if ($this->isItemTagged($item))
			return $item;
		
		// Make sure the tag has a non-zero length
		if (!$this->getValue())
			return $item;
		
		$query = new InsertQuery;
		$query->setTable('tag');
		$query->addValue('value', $this->getValue());
		$query->addValue('user_id', $agentId->getIdString());
		$query->addValue('fk_item', $item->getDatabaseId());
		
		//printpre("'".addslashes($item->getDatabaseId())."'"))
		
		if (!is_null($date))
			$query->addValue('tstamp', $date->asString());
		
		$dbc = Services::getService("DatabaseManager");
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
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
			$query = new SelectQuery;
			$query->addColumn('COUNT(value)', 'occurances');
			$query->addTable('tag');
			$query->addWhereEqual("value", $this->getValue());
			
			$dbc = Services::getService("DatabaseManager");
			$result =$dbc->query($query, $this->getDatabaseIndex());
			$this->_allOccurances = $result->field('occurances');
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
	function getOccurancesForAgent ( $agentId ) {
		if (!isset($this->_agentOccurances))
			$this->_agentOccurances = array();
		
		if (!isset($this->_agentOccurances[$agentId->getIdString()])) {
			$query = new SelectQuery;
			$query->addColumn('COUNT(value)', 'occurances');
			$query->addTable('tag');
			$query->addWhereEqual("value", $this->getValue());
			$query->addWhereEqual("user_id", $agentId->getIdString());
			
			$dbc = Services::getService("DatabaseManager");
			$result =$dbc->query($query, $this->getDatabaseIndex());
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
	function setOccurancesForAgent ( $agentId, $num ) {
		if (!isset($this->_agentOccurances))
			$this->_agentOccurances = array();
		
		$this->_agentOccurances[$agentId->getIdString()] = $num;
	}
		
	/**
	 * Answer all items with this tag
	 * 
	 * @return object TaggedItemIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItems () {
		$dbc = Services::getService("DatabaseManager");
		
		$subQuery = new SelectQuery;
		$subQuery->addColumn('tag_item.db_id');
		$subQuery->addColumn('tag_item.id');
		$subQuery->addColumn('tag_item.system');
		$subQuery->addColumn('tag.tstamp');
		$subQuery->addTable('tag');
		$subQuery->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$subQuery->addWhereEqual("tag.value", $this->getValue());
		$subQuery->addOrderBy('tag.tstamp', DESCENDING);
	
		$query = new SelectQuery;
		$query->addColumn('*');
		$query->addTable("(".$dbc->generateSQL($subQuery, $this->getDatabaseIndex()).") AS tag_results");
		$query->setGroupBy(array('db_id'));
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		$iterator = new TaggedItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all items with this tag that match a particular list
	 * 
	 * @param object IdIterator $ids
	 * @return object ItemsIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItemsWithIdsInSystem ( $ids, $system) {
		$dbc = Services::getService("DatabaseManager");
		
		$subQuery = new SelectQuery;
		$subQuery->addColumn('tag_item.db_id');
		$subQuery->addColumn('tag_item.id');
		$subQuery->addColumn('tag_item.system');
		$subQuery->addColumn('tag.tstamp');
		$subQuery->addTable('tag');
		$subQuery->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$subQuery->addWhereEqual("tag.value", $this->getValue());
		$subQuery->addWhereEqual("tag_item.system", $system);
		$idList = array();
		while ($ids->hasNext()) {
			$id =$ids->next();
			$idList[] = "'".addslashes($id->getIdString())."'";
		}
		$subQuery->addWhere("tag_item.id IN (".implode(", ", $idList).")");
		$subQuery->addOrderBy('tag.tstamp', DESCENDING);
		
		$query = new SelectQuery;
		$query->addColumn('*');
		$query->addTable("(".$dbc->generateSQL($subQuery, $this->getDatabaseIndex()).") AS tag_results");
		$query->setGroupBy(array('db_id'));
		
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		$iterator = new TaggedItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all the items with this tag that match a particular list
	 * 
	 * @param array $items An array of TaggedItem objects
	 * @return object TaggedItemIterator
	 * @access public
	 * @since 4/9/08
	 */
	public function getItemsInList (array $items) {
		ArgumentValidator::validate($items, ArrayValidatorRuleWithRule::getRule(ExtendsValidatorRule::getRule('TaggedItem')));
		
		if (!count($items))
			return new HarmoniIterator(array());
		
		$id = array();
		$system = $items[0]->getSystem();
		foreach ($items as $item) {
			if ($system != $item->getSystem())
				throw new Exception("getItemsInList() currently only supports items from the same system. If needed, this method should be updated.");
			
			$ids[] = $item->getId();
		}
		
		return new HarmoniIterator($ids);
				
	}
	
	/**
	 * Answer all items with this tag in a particular system
	 * 
	 * @return object ItemsIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItemsInSystem ( $system) {
		$dbc = Services::getService("DatabaseManager");
		
		$subQuery = new SelectQuery;
		$subQuery->addColumn('tag_item.db_id');
		$subQuery->addColumn('tag_item.id');
		$subQuery->addColumn('tag_item.system');
		$subQuery->addColumn('tag.tstamp');
		$subQuery->addTable('tag');
		$subQuery->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$subQuery->addWhereEqual("tag.value", $this->getValue());
		$subQuery->addWhereEqual("tag_item.system", $system);
		$subQuery->addOrderBy('tag.tstamp', DESCENDING);
		
		$query = new SelectQuery;
		$query->addColumn('*');
		$query->addTable("(".$dbc->generateSQL($subQuery, $this->getDatabaseIndex()).") AS tag_results");
		$query->setGroupBy(array('db_id'));
		
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		$iterator = new TaggedItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all items with this tag where the tag was added by the given agent
	 * 
	 * @return object TaggedItemIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItemsForAgent ( $agentId ) {
		$query = new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $agentId->getIdString());
		
		$query->addOrderBy('tag.tstamp', DESCENDING);
		
		$dbc = Services::getService("DatabaseManager");
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		$iterator = new TaggedItemIterator($result);
		return $iterator;
	}

	/**
	 * Answer all items with this tag where the tag was added by the given agent
	 * 
	 * @return object TaggedItemIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItemsForAgentInListinSystem ($ids, $agentId, $system) {
		$query = new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $agentId->getIdString());
		$idList = array();
		while ($ids->hasNext()) {
			$id =$ids->next();
			$idList[] = "'".addslashes($id->getIdString())."'";
		}
		$query->addWhere("tag_item.id IN (".implode(", ", $idList).")");
		$query->addOrderBy('tag.tstamp', DESCENDING);
		
		$dbc = Services::getService("DatabaseManager");
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		$iterator = new TaggedItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer all items with this tag in a particular system
	 * 
	 * @return object ItemsIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItemsForAgentInSystem ( $agentId, $system ) {
		$query = new SelectQuery;
		$query->addColumn('tag_item.db_id');
		$query->addColumn('tag_item.id');
		$query->addColumn('tag_item.system');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $agentId->getIdString());
		$query->addWhereEqual("tag_item.system", $system);
		
		$query->addOrderBy('tag.tstamp', DESCENDING);
		
		$dbc = Services::getService("DatabaseManager");
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		$iterator = new TaggedItemIterator($result);
		return $iterator;
	}
	
	/**
	 * Answer true if the current agent has tagged the item
	 * 
	 * @param object TaggedItem $item
	 * @return boolean
	 * @access public
	 * @since 11/13/06
	 */
	function isItemTagged ( $item ) {
		$query = new SelectQuery;
		$query->addColumn('COUNT(*)', 'count');
		$query->addTable('tag');
		$query->addTable('tag_item', INNER_JOIN, "tag.fk_item = tag_item.db_id");
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $this->getCurrentUserIdString());
		$query->addWhereEqual("tag_item.id", $item->getIdString());
		$query->addWhereEqual("tag_item.system", $item->getSystem());
				
		$dbc = Services::getService("DatabaseManager");
		$result =$dbc->query($query, $this->getDatabaseIndex());
		
		if (intval($result->field('count')) > 0)
			return true;
		else
			return false;
	}
	
	/**
	 * Answer all items with this tag
	 * 
	 * @return object TaggedItemIterator
	 * @access public
	 * @since 11/2/06
	 */
	function getItemsForCurrentUser () {
		$iterator =$this->getItemsForAgent($this->getCurrentUserId());
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
	function getItemsForCurrentUserInSystem ( $system) {
		$iterator =$this->getItemsForAgentInSystem($this->getCurrentUserId(), $system);
		return $iterator;
	}
	
	/**
	 * Answer the Tags related to this one. Relation is defined as being attached
	 * to the same items as this tag.
	 * 
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 12/8/06
	 */
	function getRelatedTags ( $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$taggingManager = Services::getService("Tagging");
		$iterator = new TagFilterIterator(
			$taggingManager->getTagsForItems($this->getItems(), $sortBy, $max),
			array($this->getValue()));
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
	function canRemoveFromItem ( $item ) {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Remove the tag from one or more items, skipping those where authorization
	 * is lacking.
	 * 
	 * @param mixed $items This can be a single Item object, an TaggedItemIterator, 
	 * 		or an array of Item objects.
	 * @return void
	 * @access public
	 * @since 11/2/06
	 */
	function removeFromItems ( $items ) {
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
				$item =$items->next();
				$itemDbIds[] = "'".addslashes($item->getDatabaseId())."'";
			}
		} 
		// Single item
		else if (method_exists($items, 'getDatabaseId')) {
			$itemDbIds[] = "'".addslashes($items->getDatabaseId())."'";
		} else {
			throwError(new HarmoniError("Invalid parameter, $items, for \$items", "Tagging"));
		}
		
		$query = new DeleteQuery;
		$query->setTable('tag');
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $this->getCurrentUserIdString());
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");		
		
		$dbc = Services::getService("DatabaseManager");
		$dbc->query($query, $this->getDatabaseIndex()); 
	}
	
	/**
	 * Remove the tag from one or more items, skipping those where authorization
	 * is lacking.
	 * 
	 * @param mixed $items This can be a single Item object, an TaggedItemIterator, 
	 * 		or an array of Item objects.
	 * @param object Id $agentId
	 * @return void
	 * @access public
	 * @since 11/2/06
	 */
	function removeFromItemsForAgent ( $items, $agentId ) {
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
				$item =$items->next();
				$itemDbIds[] = "'".addslashes($item->getDatabaseId())."'";
			}
		} 
		// Single item
		else if (method_exists($items, 'getDatabaseId')) {
			$itemDbIds[] = "'".addslashes($items->getDatabaseId())."'";
		} else {
			throwError(new HarmoniError("Invalid parameter, $items, for \$items", "Tagging"));
		}
		
		$query = new DeleteQuery;
		$query->setTable('tag');
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $agentId->getIdString());
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");		
		
		$dbc = Services::getService("DatabaseManager");
		$dbc->query($query, $this->getDatabaseIndex()); 
	}
	
	/**
	 * Rename the tag for the given agent
	 * 
	 * @param object Id $agentId
	 * @param string $newValue
	 * @return void
	 * @access public
	 * @since 11/27/06
	 */
	function renameForAgent ( $agentId, $newValue ) {
		$newTag = new Tag($newValue);
		
		$query = new UpdateQuery;
		$query->setTable('tag');
		$query->setColumns(array('value'));
		$query->setValues(array("'".addslashes($newTag->getValue())."'"));
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $agentId->getIdString());
		
		$dbc = Services::getService("DatabaseManager");
		$dbc->query($query, $this->getDatabaseIndex());
	}
	
	/**
	 *Rename the tag for the current user
	 * 
	 * @param string $newValue
	 * @return void
	 * @access public
	 * @since 11/27/06
	 */
	function renameForCurrentUser ( $newValue ) {
		$this->renameForAgent($this->getCurrentUserId(), $newValue);
	}
	
	/**
	 * Remove the tag everywhere where the current user has added it.
	 * 
	 * @return void
	 * @access public
	 * @since 11/2/06
	 */
	function removeAllMine () {
		$query = new DeleteQuery;
		$query->setTable('tag');
		$query->addWhereEqual("tag.value", $this->getValue());
		$query->addWhereEqual("tag.user_id", $this->getCurrentUserIdString());
		
		$dbc = Services::getService("DatabaseManager");
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
    		$taggingManager = Services::getService("Tagging");
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
    		$taggingManager = Services::getService("Tagging");
    		$this->_currentUserId = $taggingManager->getCurrentUserId();
		}
		return $this->_currentUserId;
    }
    
    /**
     * Answer the current user id
     * 
     * @return string
     * @access public
     * @since 11/6/06
     */
    function getCurrentUserIdString () {
    	if (!isset($this->_currentUserIdString)) {
    		$taggingManager = Services::getService("Tagging");
    		$this->_currentUserIdString = $taggingManager->getCurrentUserIdString();
		}
		return $this->_currentUserIdString;
    }
}

?>