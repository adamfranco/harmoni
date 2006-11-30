<?php
/**
 * @since 11/1/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagManager.class.php,v 1.2 2006/11/30 22:02:11 adamfranco Exp $
 */ 

/**
 * Constant to define sorting of search results the name of the tag.
 * @since 11/1/06
 */
define('TAG_SORT_ALFA', 'TAG_SORT_ALFA');

/**
 * Constant to define sorting of search results by most often used.
 * @since 11/1/06
 */
define('TAG_SORT_FREQ', 'TAG_SORT_FREQ');

require_once(dirname(__FILE__)."/Tag.class.php");
require_once(dirname(__FILE__)."/TaggedItem.class.php");
require_once(dirname(__FILE__)."/HarmoniNodeTaggedItem.class.php");
require_once(dirname(__FILE__)."/UrlTaggedItem.class.php");
require_once(dirname(__FILE__)."/StructuredMetaDataTagGenerator.class.php");

/**
 * The TagManager handles the creation and retreval of tags.
 * 
 * @since 11/1/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagManager.class.php,v 1.2 2006/11/30 22:02:11 adamfranco Exp $
 */
class TagManager
	extends OsidManager	
{
	
	/**
	 * Answer the tags created by a given agent
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
		$query =& new SelectQuery;
		$query->addColumn('value');
		$query->addColumn('COUNT(value)', 'occurances');
		$query->addTable('tag');
		$query->setGroupBy(array('value'));
		$query->addOrderBy('occurances', DESCENDING);
		
		$query->addWhere("user_id='".addslashes($agentId->getIdString())."'");
		
		if ($max)
			$query->limitNumberOfRows($max);
		
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($result->hasNext()) {
			$row = $result->next();
			$tags[$row['value']] =& new Tag($row['value']);
			$tags[$row['value']]->setOccurancesForAgent($agentId, $row['occurances']);
		}
		
		// If necessary, sort these top tags alphabetically
		if ($sortBy == TAG_SORT_ALFA)
			ksort($tags);
		
		$iterator =& new HarmoniIterator($tags);
		return $iterator;
	}
	
	/**
	 * Answer the tags created by the current user
	 * 
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getUserTags ( $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$tags =& $this->getTagsByAgent($this->getCurrentUserId(), $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Answer the tags created by any agent
	 * 
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getTags ( $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$query =& new SelectQuery;
		$query->addColumn('value');
		$query->addColumn('COUNT(value)', 'occurances');
		$query->addTable('tag');
		$query->setGroupBy(array('value'));
		$query->addOrderBy('occurances', DESCENDING);
				
		if ($max)
			$query->limitNumberOfRows($max);
		
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($result->hasNext()) {
			$row = $result->next();
			$tags[$row['value']] =& new Tag($row['value']);
			$tags[$row['value']]->setOccurances($row['occurances']);
		}
		
		// If necessary, sort these top tags alphabetically
		if ($sortBy == TAG_SORT_ALFA)
			ksort($tags);
		
		$iterator =& new HarmoniIterator($tags);
		return $iterator;
	}
	
	/**
	 * Answer the tags for one or more items
	 * 
	 * @param mixed $items The items to return tags for. This can be a single Item object,
	 *		an ItemIterator, or an array of Item objects.
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getTagsForItems ( &$items, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$query =& new SelectQuery;
		$query->addColumn('value');
		$query->addColumn('COUNT(value)', 'occurances');
		$query->addTable('tag');
		$query->setGroupBy(array('value'));
		$query->addOrderBy('occurances', DESCENDING);
		
		if ($max)
			$query->limitNumberOfRows($max);
		
		
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
			throwError(new Error("Invalid parameter, ".get_class($items).", for \$items", "Tagging"));
		}
		
		// Return an empty iterator if we have no item ids
		if (!count($itemDbIds)) {
			$iterator =& new HarmoniIterator($itemDbIds);
			return $iterator;
		}
		
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");
		
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($result->hasNext()) {
			$row = $result->next();
			$tags[$row['value']] =& new Tag($row['value']);
			$tags[$row['value']]->setOccurances($row['occurances']);
		}
		
		// If necessary, sort these top tags alphabetically
		if ($sortBy == TAG_SORT_ALFA)
			ksort($tags);
		
		$iterator =& new HarmoniIterator($tags);
		return $iterator;
	}
	
	/**
	 * Answer the tags by the given agent for one or more items
	 * 
	 * @param mixed $items The items to return tags for. This can be a single Item object,
	 *		an ItemIterator, or an array of Item objects.
	 * @param object Id $agentId
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/10/06
	 */
	function &getTagsForItemsByAgent ( &$items, &$agentId, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$query =& new SelectQuery;
		$query->addColumn('value');
		$query->addColumn('COUNT(value)', 'occurances');
		$query->addTable('tag');
		$query->setGroupBy(array('value'));
		$query->addOrderBy('occurances', DESCENDING);
		$query->addWhere("user_id='".addslashes($agentId->getIdString())."'");
		
		if ($max)
			$query->limitNumberOfRows($max);
		
		
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
			throwError(new Error("Invalid parameter, ".get_class($items).", for \$items", "Tagging"));
		}
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");
		
		
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($result->hasNext()) {
			$row = $result->next();
			$tags[$row['value']] =& new Tag($row['value']);
			$tags[$row['value']]->setOccurances($row['occurances']);
		}
		
		// If necessary, sort these top tags alphabetically
		if ($sortBy == TAG_SORT_ALFA)
			ksort($tags);
		
		$iterator =& new HarmoniIterator($tags);
		return $iterator;
	}
	
	/**
	 * Answer the tags created by the current user for one or more items
	 * 
	 * @param mixed $items The items to return tags for. This can be a single Item object,
	 *		an ItemIterator, or an array of Item objects.
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getUserTagsForItems ( &$items, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$tags =& $this->getTagsForItemsByAgent($items, $this->getCurrentUserId(), $sortBy, $max);
		return $tags;
	}
	
	/**
	 * Answer the tags not created by the given agent for one or more items
	 * 
	 * @param mixed $items The items to return tags for. This can be a single Item object,
	 *		an ItemIterator, or an array of Item objects.
	 * @param object Id $agentId
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/10/06
	 */
	function &getTagsForItemsNotByAgent ( &$items, &$agentId, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		$query =& new SelectQuery;
		$query->addColumn('value');
		$query->addColumn('COUNT(value)', 'occurances');
		$query->addTable('tag');
		$query->setGroupBy(array('value'));
		$query->addOrderBy('occurances', DESCENDING);
		$query->addWhere("user_id!='".addslashes($agentId->getIdString())."'");
		
		if ($max)
			$query->limitNumberOfRows($max);
		
		
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
			throwError(new Error("Invalid parameter, ".get_class($items).", for \$items", "Tagging"));
		}
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");
		
		
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($result->hasNext()) {
			$row = $result->next();
			$tags[$row['value']] =& new Tag($row['value']);
			$tags[$row['value']]->setOccurances($row['occurances']);
		}
		
		// If necessary, sort these top tags alphabetically
		if ($sortBy == TAG_SORT_ALFA)
			ksort($tags);
		
		$iterator =& new HarmoniIterator($tags);
		return $iterator;
	}
	
	/**
	 * Delete the item and all tags for it. This should be done when deleting
	 * the thing the item represents
	 * 
	 * @param mixed $items This can be a single Item object, an TaggedItemIterator, 
	 * 		or an array of Item objects.
	 * @return void
	 * @access public
	 * @since 11/2/06
	 */
	function deleteItems ( &$items ) {
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
		
		$dbc =& Services::getService("DatabaseManager");
		
		$query =& new DeleteQuery;
		$query->setTable('tag');
		$query->addWhere("tag.fk_item IN (".implode(", ", $itemDbIds).")");		
		
		$dbc->query($query, $this->getDatabaseIndex()); 
		
		$query =& new DeleteQuery;
		$query->setTable('tag_item');
		$query->addWhere("id IN (".implode(", ", $itemDbIds).")");		
		
		$dbc->query($query, $this->getDatabaseIndex()); 
	}
	
	/**
	 * Answer the tags for one or more item ids
	 * 
	 * @param mixed $ids The ids of the item to return tags for. This can be a single Id
	 * 		object, an IdIterator, or an array of Id objects.
	 * @param string $system The name of the system that the items are accessed through.
	 * @param string $sortBy Return tags in alphanumeric order or by frequency of usage.
	 * @param integer $max The maximum number of tags to return. The least frequently used
	 * 		tags will be dropped first. If $max is 0, all tags will be returned.
	 * @return object TagIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getTagsForItemIds ( &$ids, $system, $sortBy = TAG_SORT_ALFA, $max = 0 ) {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
     * Assign the configuration of this OsidManager.
     * 
     * @param object Properties $configuration (original type: java.util.Properties)
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.OsidException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignConfiguration ( &$configuration ) { 
       $this->_configuration =& $configuration;
    }
    
    /**
     * Return configuration of this OsidManager.
     *  
     * @param string $system
     * @return array
     * @access public
     */
    function getConfigurationForSystem ($system) { 
       $systems =& $this->_configuration->getProperty('Systems');
       return $systems[$system];
    }
    
    /**
     * Return the destination Item class for a given system
     * 
     * @param string $system
     * @return string
     * @access public
     * @since 11/6/06
     */
    function getItemClassForSystem ($system) {
    	if ($system == ARBITRARY_URL)
    		return "UrlTaggedItem";
    	
    	$systemConfiguration = $this->getConfigurationForSystem($system);
    	if (!$systemConfiguration['ItemClass'])
    		throwError(new Error("Unconfigured ItemClass for system, '$system'", "Tagging"));
    	return $systemConfiguration['ItemClass'];
    }
    
    /**
     * Answer the database index
     * 
     * @return integer
     * @access public
     * @since 11/6/06
     */
    function getDatabaseIndex () {
    	return $this->_configuration->getProperty('DatabaseIndex');
    }
    
    /**
	 * Answer agentIds that have stored tags
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 11/1/06
	 */
	function &getAgentIds () {
		$query =& new SelectQuery;
		$query->addColumn('user_id');
		$query->addColumn('COUNT(user_id)', 'occurances');
		$query->addTable('tag');
		$query->setGroupBy(array('user_id'));
		$query->addOrderBy('occurances', DESCENDING);
		
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$agentIds = array();
		$idManager =& Services::getService('Id');
		while ($result->hasNext()) {
			$row = $result->next();
			$agentIds[] =& $idManager->getId($row['user_id']);
		}
				
		$iterator =& new HarmoniIterator($agentIds);
		return $iterator;
	}
    
    /**
     * Answer the current user id
     * 
     * @return object
     * @access public
     * @since 11/6/06
     */
    function &getCurrentUserId () {
    	if (!isset($this->_currentUserId)) {
    		$authN =& Services::getService("AuthN");
			$idM =& Services::getService("Id");
			$authTypes =& $authN->getAuthenticationTypes();
			while ($authTypes->hasNext()) {
				$authType =& $authTypes->next();
				$id =& $authN->getUserId($authType);
				if (!$id->isEqual($idM->getId('edu.middlebury.agents.anonymous'))) {
					$this->_currentUserId =& $id;
					$this->_currentUserIdString = $id->getIdString();
					break;
				}
			}
		}
		return $this->_currentUserId;
    }
    
    /**
     * Answer the current user id string value
     * 
     * @return string
     * @access public
     * @since 11/6/06
     */
    function getCurrentUserIdString () {
    	if (!isset($this->_currentUserIdString))
    		$this->getCurrentUserId();
    		
    	if (isset($this->_currentUserIdString))
	    	return $this->_currentUserIdString;
	    else
	    	return null;
    }
    
	/**
     * Return context of this OsidManager.
     *  
     * @return object OsidContext
     * 
     * @throws object OsidException 
     * 
     * @access public
     */
    function &getOsidContext () { 
		return $this->_osidContext;
    } 

    /**
     * Assign the context of this OsidManager.
     * 
     * @param object OsidContext $context
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
    }  
	
}

?>