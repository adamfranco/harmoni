<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniNodeTaggedItem.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
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
 * @version $Id: HarmoniNodeTaggedItem.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
 */
class HarmoniNodeTaggedItem
	extends	TaggedItem
{
		
	/**
	 * Constructor
	 * 
	 * @param mixed object or string $id 
	 * @param string $system The system an Id is accessed through
	 * @return object
	 * @access public
	 * @since 11/2/06
	 */
	function &forId ( $id, $system, $class='HarmoniNodeTaggedItem' ) {
		if (is_string($id)) {
			$idManager =& Services::getService("Id");
			$id =& $idManager->getId($id);
		}
		$item =& TaggedItem::forId($id, $system, $class);
		return $item;
	}
	
	/**
	 * Answer the url to this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getUrl () {
		$this->_loadConfiguration();
		$callback = $this->_config['UrlCallback'];
		return $callback($this);
	}
	
	/**
	 * Answer the display name for this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getDisplayName () {
		$node =& $this->getNode();
		return $node->getDisplayName();
	}
	
	/**
	 * Answer the description of this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getDescription () {
		$node =& $this->getNode();
		return $node->getDescription();
	}
	
	/**
	 * Answer the thumbnail url of this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getThumbnailUrl () {
		$this->_loadConfiguration();
		if ($callback = $this->_config['ThumbUrlCallback'])
			return $callback($this);
		else
			return null;
	}
	
	/**
	 * Load the configuration for this item
	 * 
	 * @return void
	 * @access public
	 * @since 11/6/06
	 */
	function _loadConfiguration () {
		if (!isset($this->_config)) {
			$taggingManager =& Services::getService("Tagging");
			$this->_config = $taggingManager->getConfigurationForSystem($this->getSystem());
		
			// check for our parameters.
			if (!$this->_config['HierarchyId'])
				throwError(new Error("Invalid Configuration: Missing 'HierarchyId'", "Tagging"));
			if (!$this->_config['UrlCallback'])
				throwError(new Error("Invalid Configuration: Missing 'UrlCallback'", "Tagging"));
		}
	}
	
	/**
	 * Answer the node for this item
	 * 
	 * @return object
	 * @access public
	 * @since 11/6/06
	 */
	function getNode () {
		if (!isset($this->_node)) {
			$this->_loadConfiguration();
			$hierarchyManager =& Services::getService("Hierarchy");
			$hierarchy =& $hierarchyManager->getHierarchy($this->_config['HierarchyId']);
			$this->_node =& $hierarchy->getNode($this->getId());
		}
		
		return $this->_node;
	}
}

?>