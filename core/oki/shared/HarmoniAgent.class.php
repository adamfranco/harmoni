<?php

/**
 * Agents are an abstraction for a principal or group.  The Agent may be granted authorization to perform specific functions.  Agents are created through implementations of osid.shared.SharedManager and have an immutable name, Type, and Unique Id.
 *
 * @package harmoni.osid_v1.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAgent.class.php,v 1.13 2005/01/19 22:28:11 adamfranco Exp $
 */
class HarmoniAgent extends Agent // :: API interface
//	extends java.io.Serializable
{

	/**
	 * The display name.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	
	/**
	 * The Id of this Agent.
	 * @attribute private object _Id
	 */
	var $_id;
	
	
	/**
	 * The type of this Agent.
	 * @attribute private object _type
	 */
	var $_type;
	
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the shared database.
	 * @attribute private string _sharedDB
	 */
	var $_sharedDB;
	

	
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
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($propertiesArray, new ArrayValidatorRuleWithRule(
					new OptionalRule(
						new ExtendsValidatorRule("Properties")
					)
				), true);
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
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
	 * @return String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.shared
	 */
	function getDisplayName() {
		return $this->_displayName;
	}

	/**
	 * Get the id of this Agent.
	 * @return id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.shared
	 */
	function &getId() {
		return $this->_id;
	}

	/**
	 * Get the type of this Agent.
	 * @return Type
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.shared
	 */
	function &getType() {
		return $this->_type;
	}

	/**
	 * Get all the Properties associated with this Agent.
	 * @return PropertiesIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.shared
	 */
	function &getProperties() {
		$iterator =& new HarmoniIterator($this->_propertiesArray);
		return $iterator;
	
	}

	/**
	 * Get the Properties of this Type associated with this Agent.
	 * @return Properties
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid_v1.shared
	 */
	function &getPropertiesByType(& $propertiesType) {
		$array = array();
		
		foreach (array_keys($this->_propertiesArray) as $key) {
			if ($propertiesType->isEqual(
					$this->_propertiesArray[$key]->getType()))
			{
				$array[] =& $this->_propertiesArray[$key];
			}
		}
		
		$iterator =& new HarmoniIterator($array);
		return $iterator;
	
	}

	/**
	 * Get the Properties Types supported by the implementation.
	 * @return TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.shared
	 */
	function &getPropertiesTypes() {
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
	 * @access public
	 * @return integer The dbIndex.
	 **/
	function getDBIndex() {
		return $this->_dbIndex;
	}
	
	
	/**
	 * Gets the sharedDB of this group.
	 * @access public
	 * @return integer The sharedDB.
	 **/
	function getSharedDB() {
		return $this->_sharedDB;
	}
	

	/**
	 * A method checking whether the specified agent exist in the database.
	 * @access public
	 * @static
	 * @param object memberOrGroup The group or agent to check for existence.
	 * @return boolean <code>tru</code> if it exists; <code>false</code> otherwise.
	 **/
	function exist(& $agent) {
		$dbHandler =& Services::requireService("DBHandler");
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