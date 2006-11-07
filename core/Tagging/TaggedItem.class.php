<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TaggedItem.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
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
 * @version $Id: TaggedItem.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
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
		$this->_id = $id;
		if (method_exists($id, 'getIdString'))
			$this->_idString = $id->getIdString();
		else
			$this->_idString = $id;
		$this->_system = $system;
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
	function forDatabaseRow ($row) {
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
	 * Insert [if needed] into the item table and return the database id of this
	 * item
	 * 
	 * @return integer
	 * @access public
	 * @since 11/6/06
	 */
	function getDabaseId () {
		if (!isset($this->_dbid)) {
			$dbc =& Services::getService("Database");
			
			$query =& new SelectQuery;
			$query->addColumn('db_id');
			$query->addTable('tag_item');
			$query->addWhere("id='".addslashes($this->getIdString())."'");
			$query->addWhere("system='".addslashes($this->getSystem())."'");
			
			$result =& $dbc->query($query, $this->_config['DatabaseIndex']);
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
		
		return $this->_dbid;
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