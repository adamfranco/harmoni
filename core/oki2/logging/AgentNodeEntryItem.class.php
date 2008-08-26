<?php
/**
 * @since 3/2/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentNodeEntryItem.class.php,v 1.10 2008/03/06 16:09:32 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/AgentNodeEntryItem.interface.php");

/**
 * The AgentNodeEntryItem encapsulates data about a log entry
 * 
 * @since 3/2/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentNodeEntryItem.class.php,v 1.10 2008/03/06 16:09:32 adamfranco Exp $
 */
class AgentNodeEntryItem 
	implements AgentNodeEntryItemInterface
{
		
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
	function __construct ( $category, $description, $nodeIds = array() ) {
		ArgumentValidator::validate($category, StringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		ArgumentValidator::validate($nodeIds, ArrayValidatorRule::getRule());
		
		$this->_category = htmlspecialchars($category);
		$this->_description = HtmlString::getSafeHtml($description);
		$this->_nodeIds = $nodeIds;
		$this->_agentIds = array();
		$this->_backtrace = '';
		$this->_additionalBactraceText = '';
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
		ob_start();
		if (strlen(trim($this->_backtrace)))
			print "\n<div class='backtrace'>\n\t".$this->_backtrace."\n</div>";
		
		if (strlen(trim($this->_additionalBactraceText)))
			print "\n<div class='additional_backtrace'>\n\t".$this->_additionalBactraceText."\n</div>";
		
		return ob_get_clean();
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
			HarmoniErrorHandler::printDebugBacktrace($backtrace);
			$this->_backtrace = HtmlString::getSafeHtml(ob_get_clean());
		} else
			$this->_backtrace = HtmlString::getSafeHtml($backtrace);
	}
	
	/**
	 * Add HTML text to the bactrace, usefull for storing source URLs, etc
	 * 
	 * @param string $additionalText
	 * @return void
	 * @access public
	 * @since 8/1/06
	 */
	function addTextToBactrace ($additionalText) {
		$this->_additionalBactraceText .= HtmlString::getSafeHtml($additionalText);
	}
	
	/**
	 * Add an node Id to this item
	 * 
	 * @param object Id $nodeId
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addNodeId ( $nodeId ) {
		$this->_nodeIds[] =$nodeId;
	}
	
	/**
	 * Answer the nodes for this item
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 3/2/06
	 */
	function getNodeIds () {
		$iterator = new HarmoniIterator($this->_nodeIds);
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
	function addAgentId ( $agentId ) {
		foreach ($this->_agentIds as $id) {
			if ($id->isEqual($agentId))
				return;
		}
		$this->_agentIds[] =$agentId;
	}
	
	/**
	 * Add the current user ids to this item
	 * 
	 * @return void
	 * @access public
	 * @since 3/2/06
	 */
	function addUserIds () {
		$authN = Services::getService("AuthN");
		$authNTypes =$authN->getAuthenticationTypes();
		while ($authNTypes->hasNext())
			$this->addAgentId($authN->getUserId($authNTypes->next()));
		
		// Add the Admin Users if they are acting as another user
		if (isset($_SESSION['__ADMIN_IDS_ACTING_AS_OTHER'])) {
			foreach ($_SESSION['__ADMIN_IDS_ACTING_AS_OTHER'] as $adminId)
				$this->addAgentId($adminId);
			
			$this->_description .= "<div>"
				.implode(", ", $_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER'])
				." ".((count($_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER']) > 1)?"are":"is")
				." acting as the current user.</div>";
		}
	}
	
	/**
	 * Answer the agents for this item. Anonymous will not be included unless
	 * there are no other agents.
	 * 
	 * @return object IdIterator
	 * @access public
	 * @since 3/2/06
	 */
	function getAgentIds ( $includeAnonymous = FALSE ) {
		$idManager = Services::getService("Id");
		$idsToReturn = array();
		$anonymousId = $idManager->getId("edu.middlebury.agents.anonymous");
		foreach (array_keys($this->_agentIds) as $key) {
			if (!$anonymousId->isEqual($this->_agentIds[$key]))
				$idsToReturn[] =$this->_agentIds[$key];
		}
		
		if ($includeAnonymous && !count($idsToReturn))
			$idsToReturn[] =$anonymousId;
		
		$iterator = new HarmoniIterator($idsToReturn);
		return $iterator;
	}
}

?>