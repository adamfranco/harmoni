<?php
/**
 * @since 3/2/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentNodeEntryItem.class.php,v 1.4 2006/03/07 21:34:15 adamfranco Exp $
 */ 

require_once(HARMONI."errorHandler/SimpleHTMLErrorPrinter.class.php");

/**
 * The AgentNodeEntryItem encapsulates data about a log entry
 * 
 * @since 3/2/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentNodeEntryItem.class.php,v 1.4 2006/03/07 21:34:15 adamfranco Exp $
 */
class AgentNodeEntryItem {
		
	/**
	 * Constructor
	 * 
	 * @param string $category
	 * @param string $description
	 * @param optional array $nodeIds
	 * @return object
	 * @access public
	 * @since 3/2/06
	 */
	function AgentNodeEntryItem ( $category, $description, $nodeIds = array() ) {
		ArgumentValidator::validate($category, StringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		ArgumentValidator::validate($nodeIds, ArrayValidatorRule::getRule());
		
		$this->_category = $category;
		$this->_description = $description;
		$this->_nodeIds = $nodeIds;
		$this->_agentIds = array();
		$this->_backtrace = '';
	}
	
	/**
	 * Answer the category
	 * 
	 * @return string
	 * @access public
	 * @since 3/2/06
	 */
	function getCategory () {
		return $this->_category;
	}
	
	/**
	 * Answer the description
	 * 
	 * @return string
	 * @access public
	 * @since 3/2/06
	 */
	function getDescription () {
		return $this->_description;
	}
	
	/**
	 * Answer the backtrace HTML if available
	 * 
	 * @return string
	 * @access public
	 * @since 3/6/06
	 */
	function getBacktrace () {
		return $this->_backtrace;
	}
	
	/**
	 * Set the backtrace HTML
	 * 
	 * @param string $backtrace
	 * @return void
	 * @access public
	 * @since 3/6/06
	 */
	function setBacktrace ( $backtrace ) {
		if (is_array($backtrace)) {
			ob_start();
			printDebugBacktrace($backtrace);
			$this->_backtrace = ob_get_clean();
		} else
			$this->_backtrace = $backtrace;
	}
	
	/**
	 * Add an node Id to this item
	 * 
	 * @param object Id $nodeId
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addNodeId ( &$nodeId ) {
		$this->_nodeIds[] =& $nodeId;
	}
	
	/**
	 * Answer the nodes for this item
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 3/2/06
	 */
	function &getNodeIds () {
		$iterator =& new HarmoniIterator($this->_nodeIds);
		return $iterator;
	}
	
	/**
	 * Add an agent Id to this item
	 * 
	 * @param object Id $agentId
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addAgentId ( &$agentId ) {
		$this->_agentIds[] =& $agentId;
	}
	
	/**
	 * Add the current user ids to this item
	 * 
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addUserIds () {
		$authN =& Services::getService("AuthN");
		$authNTypes =& $authN->getAuthenticationTypes();
		while ($authNTypes->hasNext())
			$this->addAgentId($authN->getUserId($authNTypes->next()));
	}
	
	/**
	 * Answer the agents for this item. Anonymous will not be included unless
	 * there are no other agents.
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 3/2/06
	 */
	function &getAgentIds ( $includeAnonymous = FALSE ) {
		$idManager =& Services::getService("Id");
		$idsToReturn = array();
		$anonymousId = $idManager->getId("edu.middlebury.agents.anonymous");
		foreach (array_keys($this->_agentIds) as $key) {
			if (!$anonymousId->isEqual($this->_agentIds[$key]))
				$idsToReturn[] =& $this->_agentIds[$key];
		}
		
		if ($includeAnonymous && !count($idsToReturn))
			$idsToReturn[] =& $anonymousId;
		
		$iterator =& new HarmoniIterator($idsToReturn);
		return $iterator;
	}
}

?>