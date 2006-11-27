<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TaggedItem.class.php,v 1.1.2.4 2006/11/27 20:30:52 adamfranco Exp $
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
 * @version $Id: TaggedItem.class.php,v 1.1.2.4 2006/11/27 20:30:52 adamfranco Exp $
 */
class TaggedItem {
		
	/**
	 * Constructor
	 * 
	 * @param mixed object or string $id 
	 * @param string $system The system an Id is accessed through
	 * @return object
	 * @access public
	 * @since 11/2/06
	 */
	function &forId ( $id, $system, $class='TaggedItem' ) {
		$item =& new $class;
		$item->_id = $id;
		if (method_exists($id, 'getIdString'))
			$item->_idString = $id->getIdString();
		else
			$item->_idString = $id;
		$item->_system = $system;
		return $item;
	}
	
	/**
	 * Create an Item for a database row
	 * 
	 * @param array $row
	 * @return object
	 * @access public
	 * @since 11/6/06
	 */
	function &forDatabaseRow ($row) {
		$taggingManager =& Services::getService("Tagging");
		$class = $taggingManager->getItemClassForSystem($row['system']);
		eval('$item =& '.$class.'::forId($row["id"], $row["system"]);');
		$item->_dbid = $row['db_id'];
		return $item;
	}
	
	/**
	 * Answer the id that was given to this object
	 * 
	 * @return mixed object or string
	 * @access public
	 * @since 11/3/06
	 */
	function getId () {
		return $this->_id;
	}
	
	/**
	 * Answer the string version of the id given to this object
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getIdString () {
		return $this->_idString;
	}
	
	/**
	 * Answer the name of the system this item is stored in
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getSystem () {
		return $this->_system;
	}
	
	/**
	 * Answer the tags for this  item
	 * 
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getTags ( $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$taggingManager =& Services::getService("Tagging");
		$tags =& $taggingManager->getTagsForItems($this, $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Answer the tags for this item created by a given agent
	 * 
	 * @param object Id $agentId
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getTagsByAgent ( &$agentId, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$taggingManager =& Services::getService("Tagging");
		$tags =& $taggingManager->getTagsForItemsByAgent($this, $agentId, $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Delete the tags for this item created by a given agent
	 * 
	 * @param object Id $agentId
	 * @return void
	 * @access public
	 * @since 11/27/06
	 */
	function deleteTagsByAgent ( &$agentId ) {
		$taggingManager =& Services::getService("Tagging");
		$tags =& $taggingManager->getTagsForItemsByAgent($this, $agentId);
		while ($tags->hasNext()) {
			$tag =& $tags->next();
			$tag->removeFromItemsForAgent($this, $agentId);
		}
	}
	
	/**
	 * Answer the tags for this item created by the current user
	 * 
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getUserTags ( $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$taggingManager =& Services::getService("Tagging");
		$tags =& $this->getTagsByAgent($taggingManager->getCurrentUserId(), $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Answer the tags for this item created by a given agent
	 * 
	 * @param object Id $agentId
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getTagsNotByAgent ( &$agentId, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$taggingManager =& Services::getService("Tagging");
		$tags =& $taggingManager->getTagsForItemsNotByAgent($this, $agentId, $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Answer the tags for this item not created by the current user
	 * 
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getNonUserTags ( $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$taggingManager =& Services::getService("Tagging");
		$tags =& $this->getTagsNotByAgent($taggingManager->getCurrentUserId(), $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Insert [if needed] into the item table and return the database id of this
	 * item
	 * 
	 * @return integer
	 * @access public
	 * @since 11/6/06
	 */
	function getDatabaseId () {
		if (!isset($this->_dbId)) {
			$dbc =& Services::getService("DatabaseManager");
			
			$query =& new SelectQuery;
			$query->addColumn('db_id');
			$query->addTable('tag_item');
			$query->addWhere("id='".addslashes($this->getIdString())."'");
			$query->addWhere("system='".addslashes($this->getSystem())."'");
			
			$result =& $dbc->query($query, $this->getDatabaseIndex());
			if ($result->getNumberOfRows() && $result->field('db_id')) {
				$this->_dbId = intval($result->field('db_id'));
			} 
			// Insert a new Row
			else {
				$query =& new InsertQuery;
				$query->setTable('tag_item');
				$query->setColumns(array('id', 'system'));
				$query->setValues(array(
					"'".addslashes($this->getIdString())."'",
					"'".addslashes($this->getSystem())."'"));
				
				$result =& $dbc->query($query, $this->getDatabaseIndex());
				$this->_dbId = intval($result->getLastAutoIncrementValue());
			}
		}
		
		return $this->_dbId;
	}
	/**
	 * Answer the url to this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getUrl () {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Answer the display name for this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getDisplayName () {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Answer the description of this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getDescription () {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Answer the thumbnail url of this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getThumbnailUrl () {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
}

?>