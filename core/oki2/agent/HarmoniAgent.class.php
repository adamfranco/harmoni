<?php

require_once(OKI2."/osid/agent/Agent.php");
require_once(HARMONI."/oki2/shared/HarmoniPropertiesIterator.class.php");

/**
 * Agent is an abstraction that includes Id, display name, type, and
 * Properties.	Agents are created using implementations of
 * org.osid.agent.AgentManager.
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
 * @version $Id: HarmoniAgent.class.php,v 1.16 2005/09/07 21:17:57 adamfranco Exp $
 */
class HarmoniAgent 
	extends Agent
{

	/**
	 * The node that this group corresponds to.
	 * @var object _node 
	 * @access protected
	 */
	var $_node;
	
	/**
	 * @var object $_hierarchy;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_hierarchy;
	
	/**
	 * The constructor.
	 * @param object Hierarchy $hierarchy
	 * @param object Node $node
	 * @access public
	 */
	function HarmoniAgent($hierarchy, $node) {
		// ** parameter validation
		ArgumentValidator::validate($node, ExtendsValidatorRule::getRule("Node"), true);
		ArgumentValidator::validate($hierarchy, ExtendsValidatorRule::getRule("Hierarchy"), true);
		
		$this->_hierarchy =& $hierarchy;
		$this->_node =& $node;
	}
	

	/**
	 * Get the name of this Agent.
	 *	
	 * @return string
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
	function getDisplayName () { 
		return $this->_node->getDisplayName();
	}

	/**
	 * Get the id of this Agent.
	 *	
	 * @return object Id
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
	function &getId () { 
		return $this->_node->getId();
	}

	/**
	 * Get the type of this Agent.
	 *	
	 * @return object Type
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
	function &getType () { 
		return $this->_node->getType();
	}

	/**
	 * Get the Properties associated with this Agent.
	 *	
	 * @return object PropertiesIterator
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
	function &getProperties () { 
		$propertyManager =& Services::getService("Property");
		$iterator =& new HarmoniPropertiesIterator(
			$propertyManager->retrieveProperties($this->getId()));
			
		return $iterator;
	
	}

	/**
	 * Get the Properties of this Type associated with this Agent.
	 * 
	 * @param object Type $propertiesType
	 *	
	 * @return object Properties
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
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getPropertiesByType ( &$propertiesType ) { 
		$propertyManager =& Services::getService("Property");
		$propertiesArray =& $propertyManager->retrieveProperties($this->getId());
		
		//if we don't have an object of the type, we'll want to return Null so we know that
		$propertiesOfType=null;
		
		foreach (array_keys($propertiesArray) as $key) {
			if ($propertiesType->isEqual(
					$propertiesArray[$key]->getType()))
			{
				$propertiesOfType =& $propertiesArray[$key];
			}
		}
		
		return $propertiesOfType;
	
	}

	/**
	 * Get the Properties Types supported by this Agent.
	 *	
	 * @return object TypeIterator
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
	function &getPropertyTypes () { 
		$array = array();
		$propertyManager =& Services::getService("Property");
		$propertiesArray =& $propertyManager->retrieveProperties($this->getId());
		
		foreach (array_keys($propertiesArray) as $key) {
			$type =& $propertiesArray[$key]->getType();
			$typeString = $type->getDomain()
							."::".$type->getAuthority()
							."::".$type->getKeyword();
			$array[$typeString] =& $type;
		}
		
		$iterator =& new HarmoniIterator($array);
		return $iterator;
	
	}	
}

?>