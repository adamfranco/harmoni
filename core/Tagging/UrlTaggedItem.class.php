<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UrlTaggedItem.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
 */ 
 
 
define('ARBITRARY_URL', 'ARBITRARY_URL');

/**
 * <##>
 * 
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UrlTaggedItem.class.php,v 1.1.2.1 2006/11/07 21:19:43 adamfranco Exp $
 */
class UrlTaggedItem 
	extends TaggedItem
{
		
	/**
	 * Constructor
	 * 
	 * @param string $url
	 * @param string $system The system an Id is accessed through
	 * @return object
	 * @access public
	 * @since 11/2/06
	 */
	function &forUrl ( $url, $displayName=null, $description=null, $class='UrlTaggedItem' ) {
		eval('$item =& '.$class.'::forId($url, ARBITRARY_URL);');
		$item->_displayName = $displayName;
		$item->_description = $description;
		return $item;
	}
	
	/**
	 * Constructor
	 * 
	 * @param mixed object or string $id 
	 * @param string $system The system an Id is accessed through
	 * @return object
	 * @access public
	 * @since 11/2/06
	 */
	function &forId ( $id, $system, $class='UrlTaggedItem' ) {
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
		return $this->getIdString();
	}
	
	/**
	 * Answer the display name for this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getDisplayName () {
		return $this->_displayName;
	}
	
	/**
	 * Answer the description of this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getDescription () {
		return $this->_description;
	}
	
	/**
	 * Answer the thumbnail url of this item
	 * 
	 * @return string
	 * @access public
	 * @since 11/3/06
	 */
	function getThumbnailUrl () {
		return null;
	}
}

?>