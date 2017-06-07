<?php
/**
 * @since 11/2/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UrlTaggedItem.class.php,v 1.4 2007/10/10 22:58:35 adamfranco Exp $
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
 * @version $Id: UrlTaggedItem.class.php,v 1.4 2007/10/10 22:58:35 adamfranco Exp $
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
	function forUrl ( $url, $displayName=null, $description=null, $class='UrlTaggedItem' ) {
		eval('$item = '.$class.'::forId($url, ARBITRARY_URL);');
		if ($displayName)
			$item->_displayName = $displayName;
		if ($description)
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
	 * @static
	 */
	static function forId ( $id, $system, $class='UrlTaggedItem' ) {
		$item = TaggedItem::forId($id, $system, $class);
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
		$this->_loadInfo();
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
		$this->_loadInfo();
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
	
	/**
	 * Populate the info for this item
	 * 
	 * @return void
	 * @access public
	 * @since 11/8/06
	 */
	function _loadInfo () {
		if (!isset($this->_displayName) || !isset($this->_description)) {
			$query = new SelectQuery;
			$query->addColumn('db_id');
			$query->addColumn('display_name');
			$query->addColumn('description');
			$query->addTable('tag_item');
			$query->addWhereEqual("id", $this->getIdString());
			
			$dbc = Services::getService("DatabaseManager");
			$result =$dbc->query($query, $this->getDatabaseIndex());
			$this->_dbId = intval($result->field('db_id'));
			$this->_displayName = $result->field('display_name');
			$this->_description = $result->field('description');
		}
	}
}

?>