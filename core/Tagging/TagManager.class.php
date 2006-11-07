<?php
/**
 * @since 11/1/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagManager.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
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

/**
 * The TagManager handles the creation and retreval of tags.
 * 
 * @since 11/1/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagManager.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
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
		$query->addGroupBy('value');
		$query->addOrderBy('occurances', DESC);
		
		$query->addWhere("user_id='".addslashes($agentId->getIdString())."'");
		
		if ($max)
			$query->addLimit($max);
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($results->hasNext()) {
			$row = $results->next();
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
		$query->addGroupBy('value');
		$query->addOrderBy('occurances', DESC);
				
		if ($max)
			$query->addLimit($max);
		
		$dbc =& Services::getService("Database");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
		
		// Add tag objects to an array, still sorted by frequency of usage
		$tags = array();
		while ($results->hasNext()) {
			$row = $results->next();
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
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
    	$systemConfiguration = $this->getConfigurationForSystem($system);
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
     * Answer the current user id
     * 
     * @return string
     * @access public
     * @since 11/6/06
     */
    function getCurrentUserId () {
    	if (!isset($this->_currentUserId)) {
    		$authN =& Services::getService("AuthN");
			$idM =& Services::getService("Id");
			$authTypes =& $authN->getAuthenticationTypes();
			while ($authTypes->hasNext()) {
				$authType =& $authTypes->next();
				$id =& $authN->getUserId($authType);
				if (!$id->isEqual($idM->getId('edu.middlebury.agents.anonymous'))) {
					$this->_currentUserId = $id->getIdString();
					break;
				}
			}
		}
		return $this->_currentUserId;
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
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    }  
	
}

?>