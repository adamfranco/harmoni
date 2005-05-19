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
 * @version $Id: HarmoniAgent.class.php,v 1.14 2005/05/19 17:25:48 thebravecowboy Exp $
 */
class HarmoniAgent 
	extends Agent
{

	/**
	 * The display name.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	
	/**
	 * The Id of this Agent.
	 * @var object _Id 
	 * @access private
	 */
	var $_id;
	
	
	/**
	 * The type of this Agent.
	 * @var object _type 
	 * @access private
	 */
	var $_type;
	
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access private
	 */
	var $_dbIndex;

	
	/**
	 * The name of the shared database.
	 * @var string _sharedDB 
	 * @access private
	 */
	var $_sharedDB;
	
	/**
	 * An array of properties objects
	 * @var array _propertiesArray
	 * @access private
	 */
	var $_propertiesArray;
	

	
	/**
	 * The constructor.
	 * @param string displayName The display name.
	 * @param object id The id.
	 * @param object type The type.
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string sharedDB The name of the shared database.
	 * @access public
	 */
	function HarmoniAgent($displayName, & $id, & $type, & $propertiesArray, $dbIndex, $sharedDB) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($propertiesArray, ArrayValidatorRuleWithRule::getRule(
					OptionalRule::getRule(
						ExtendsValidatorRule::getRule("Properties")
					)
				), true);
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($sharedDB, $stringRule, true);
		// ** end of parameter validation
		
		$this->_displayName = $displayName;
		$this->_id =& $id;
		$this->_type =& $type;
		$this->_propertiesArray =& $propertiesArray;
		$this->_dbIndex = $dbIndex;
		$this->_sharedDB = $sharedDB;
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
		return $this->_displayName;
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
		return $this->_id;
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
		return $this->_type;
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
		
		$iterator =& new HarmoniPropertiesIterator($this->_propertiesArray);
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
		$array = array();
		
		//if we don't have an object of the type, we'll want to return Null so we know that
		$propertiesOfType=null;
		
		foreach (array_keys($this->_propertiesArray) as $key) {
			if ($propertiesType->isEqual(
					$this->_propertiesArray[$key]->getType()))
			{
				$propertiesOfType =& $this->_propertiesArray[$key];
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
		
		foreach (array_keys($this->_propertiesArray) as $key) {
			$type =& $this->_propertiesArray[$key]->getType();
			$typeString = $type->getDomain()
							."::".$type->getAuthority()
							."::".$type->getKeyword();
			$array[$typeString] =& $type;
		}
		
		$iterator =& new HarmoniIterator($array);
		return $iterator;
	
	}	
	
	
	/**
	 * Gets the dbIndex of this group.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @return integer The dbIndex.
	 **/
	function getDBIndex() {
		return $this->_dbIndex;
	}
	
	
	/**
	 * Gets the sharedDB of this group.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @return integer The sharedDB.
	 **/
	function getSharedDB() {
		return $this->_sharedDB;
	}
	

	/**
	 * A method checking whether the specified agent exist in the database.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @static
	 * @param object memberOrGroup The group or agent to check for existence.
	 * @return boolean <code>tru</code> if it exists; <code>false</code> otherwise.
	 **/
	function exist(& $agent) {
		$dbHandler =& Services::getService("DatabaseManager");
		$query =& new SelectQuery();
		
		// get the id
		$id =& $agent->getId();
		$idValue = $id->getIdString();

		// string prefix
		$db = $agent->_sharedDB.".";
		
		// set the tables
		$query->addTable($db."agent");
		// set the columns to select
		$query->addColumn("agent_id", "id");
		// set where
		$where = "agent_id = '".addslashes($idValue)."' AND ";
		$where .= "agent_display_name = '".addslashes($agent->getDisplayName())."'";
		$query->setWhere($where);

		$queryResult =& $dbHandler->query($query, $agent->getDBIndex());
		if ($queryResult->getNumberOfRows() == 1)
			return true;
		else
			return false;
	}	
}


?>