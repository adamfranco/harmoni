<?php
/**
 * @since 3/6/08
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentNodeEntryItem.interface.php,v 1.1 2008/03/06 16:09:59 adamfranco Exp $
 */ 

/**
 * An interface for AgentNodeEntryItems. Entry items must extend this interface
 * when using Logging::edu.middlebury::AgentsAndNodes logging format type.
 * 
 * @since 3/6/08
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentNodeEntryItem.interface.php,v 1.1 2008/03/06 16:09:59 adamfranco Exp $
 */
interface AgentNodeEntryItemInterface {
		
	/**
	 * Answer the category
	 * 
	 * @return string
	 * @access public
	 * @since 3/2/06
	 */
	function getCategory ();
	
	/**
	 * Answer the description
	 * 
	 * @return string
	 * @access public
	 * @since 3/2/06
	 */
	function getDescription ();
	
	/**
	 * Answer the backtrace HTML if available
	 * 
	 * @return string
	 * @access public
	 * @since 3/6/06
	 */
	function getBacktrace ();
	
	/**
	 * Set the backtrace HTML
	 * 
	 * @param string $backtrace
	 * @return void
	 * @access public
	 * @since 3/6/06
	 */
	function setBacktrace ( $backtrace );
	
	/**
	 * Add HTML text to the bactrace, usefull for storing source URLs, etc
	 * 
	 * @param string $additionalText
	 * @return void
	 * @access public
	 * @since 8/1/06
	 */
	function addTextToBactrace ($additionalText);
	
	/**
	 * Add an node Id to this item
	 * 
	 * @param object Id $nodeId
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addNodeId ( $nodeId );
	
	/**
	 * Answer the nodes for this item
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 3/2/06
	 */
	function getNodeIds ();
	
	/**
	 * Add an agent Id to this item
	 * 
	 * @param object Id $agentId
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addAgentId ( $agentId );
	
	/**
	 * Add the current user ids to this item
	 * 
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addUserIds ();
	
	/**
	 * Answer the agents for this item. Anonymous will not be included unless
	 * there are no other agents.
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 3/2/06
	 */
	function getAgentIds ( $includeAnonymous = FALSE );
	
}

?>