<?php

require_once(OKI2."/osid/agent/AgentIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * AgentIterator provides access to these objects sequentially, one at a time.
 * The purpose of all Iterators is to to offer a way for OSID methods to
 * return multiple values of a common type and not use an array.  Returning an
 * array may not be appropriate if the number of values returned is large or
 * is fetched remotely.	 Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentFilteringFromTraversalIterator.class.php,v 1.3 2007/04/12 15:37:26 adamfranco Exp $
 */
class AgentFilteringFromTraversalIterator
	extends HarmoniAgentIterator
//	implements AgentIterator
{
	/**
	 * @var object $_traversalInfoIterator;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_traversalInfoIterator;
	
	/**
	 * @var integer $_count;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_count;
	
	/**
	 * @var object Agent $_nextAgent;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_nextAgent;
	
	/**
	 * Constructor
	 * 
	 * @param object TraversalInfoIterator $traversalInfoIterator
	 * @return object
	 * @access public
	 * @since 8/30/05
	 */
	function AgentFilteringFromTraversalIterator ( &$traversalInfoIterator ) {
		$this->_traversalInfoIterator =& $traversalInfoIterator;
		$this->_idsToIgnore = array();
		
		for ($i = 1; $i < func_num_args(); $i++) {
			$nodeId = func_get_arg($i);
			$this->_idsToIgnore[] = $nodeId->getIdString();
		}
		
		// select our first group;
		$this->_selectNextAgent();
	}
	
	/**
	 * Return true if there is an additional  Agent ; false otherwise.
	 *	
	 * @return boolean
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
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function hasNext () { 
		if ($this->_nextAgent === null)
			return false;
		else
			return true;
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
	function &next () { 
		$next =& $this->_nextAgent;
		$this->_selectNextAgent();
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
	function _selectNextAgent () {
		// We just want to change the reference, leaving any existing references
		// untouched.
		$null = null;
		$this->_nextAgent =& $null;
				
		while ($this->_nextAgent == null 
			&& $this->_traversalInfoIterator->hasNext())
		{
			$info =& $this->_traversalInfoIterator->next();
			$nodeId =& $info->getNodeId();
			if ($this->_shouldSelect($nodeId)
				&& !in_array($nodeId->getIdString(), $this->_idsToIgnore)) 
			{
				$this->_nextAgent =& $this->_getAgent($nodeId);
				break;
			}
		}
	}
	
	/**
	 * Gives the number of items in the iterator
	 * 
	 * @return integer
	 * @access public
	 * @since 8/31/05
	 */
	function count () {
		if ($this->_count === null) {
			$this->_count = 0;
			
			$tempTraversalIterator =& $this->_traversalInfoIterator->shallowCopy();
			
			while ($tempTraversalIterator->hasNext()) {
				$info =& $tempTraversalIterator->next();
				if ($this->_shouldSelect($info->getNodeId())) {
					$this->_count++;
				}
			}
		}
		
		return $this->_count;
	}
	
	/**
	 * Return True if we should select the Agent with the given id, FALSE if
	 * we are filtering it.
	 * 
	 * @param object Id $id
	 * @return boolean
	 * @access private
	 * @since 8/31/05
	 */
	function _shouldSelect ( &$id ) {
		die("Method ".__FUNCTION__." in class ".__CLASS__
			." should have been overridden by a child class.");
	}
	
	/**
	 * create a new Agent of the appropriate class and return it.
	 * 
	 * @param object Id $id
	 * @return object Agent
	 * @access private
	 * @since 8/31/05
	 */
	function &_getAgent ( &$id ) {
		die("Method ".__FUNCTION__." in class ".__CLASS__
			." should have been overridden by a child class.");
	}
}

?>