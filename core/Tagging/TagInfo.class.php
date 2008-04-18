<?php
/**
 * @since 4/18/08
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagInfo.class.php,v 1.1 2008/04/18 14:56:12 adamfranco Exp $
 */ 

/**
 * The TagInfo class gives information on the application of a tag to an item by an agent.
 * TagInfo can not be used for modify tags and is for informational purposes only.
 * 
 * @since 4/18/08
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagInfo.class.php,v 1.1 2008/04/18 14:56:12 adamfranco Exp $
 */
class TagInfo {
		
	/**
	 * Constructor
	 * 
	 * @param object Tag $tag
	 * @param object Item $item
	 * @param object Id $agentId
	 * @param object DateAndTime $timestamp
	 * @return void
	 * @access public
	 * @since 4/18/08
	 */
	public function __construct (Tag $tag, TaggedItem $item, Id $agentId, DateAndTime $timestamp) {
		$this->tag = $tag;
		$this->item = $item;
		$this->agentId = $agentId;
		$this->timestamp = $timestamp;
	}
	
}

?>