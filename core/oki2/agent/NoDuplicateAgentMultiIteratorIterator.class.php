<?php
/**
 * @since 2/18/09
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

require_once(HARMONI."/oki2/shared/MultiIteratorIterator.class.php");

/**
 * This is a MultiIteratorIterator that skips duplicates. It only supports iterators of Agents
 * 
 * @since 2/18/09
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class NoDuplicateAgentMultiIteratorIterator
	extends MultiIteratorIterator
{
	/**
	 * Constructor
	 * 
	 * @return void
	 * @access public
	 * @since 2/18/09
	 */
	public function __construct () {
		parent::__construct();
		$this->_seen = array();
	}
		
	/**
	 * Answer true if there are more iterator elements.
	 * 
	 * @return boolean
	 * @access public
	 * @since 2/18/09
	 */
	public function hasNext () {
		if (!isset($this->_nextAgent))
			$this->_selectNextAgent();
		
		return (!is_null($this->_nextAgent));
	}
	
	/**
	 * Return the next Agent.
	 *	
	 * @return object Agent
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NO_MORE_ITERATOR_ELEMENTS
	 *		   NO_MORE_ITERATOR_ELEMENTS}
	 * 
	 * @access public
	 */
	public function next () { 
		$next = $this->_nextAgent;
		$this->_selectNextAgent();
		
		if (is_null($next))
			throw new NoMoreIteratorElementsException();
		return $next;
	}
	
	/**
	 * Select the next id in the TraversalInfoIterator that corresponds to a
	 * Group.
	 * 
	 * @return void
	 * @access private
	 * @since 8/30/05
	 */
	private function _selectNextAgent () {
		// We just want to change the reference, leaving any existing references
		// untouched.
		$null = null;
		$this->_nextAgent = $null;
				
		while ($this->_nextAgent == null && parent::hasNext()) {
			$agent = parent::next();
			if (!in_array($agent->getId()->getIdString(), $this->_seen)) {
				$this->_nextAgent = $agent;
				$this->_seen[] = $agent->getId()->getIdString();
				break;
			}
		}
	}
	
	/**
	 * Skips the next item in the iterator
	 *
	 * @return void
	 * @public
	 */
	 public function skipNext() {
	 	$this->next();
	 }
}

?>