<?php

/**
 * This class provides a mechanism for caching different authorization components and
 * also acts as an interface between the datastructures and the database.
 * 
 * @version $Id: AuthorizationCache.class.php,v 1.1 2004/06/14 03:38:19 dobomode Exp $
 * @package harmoni.osid.authorization
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class AuthorizationCache {

	/**
	 * An array of the cached Qualifier objects. The index of each element is the Id
	 * of the corresponding Qualifier.
	 * @attribute protected array _qualifiers
	 */
	var $_qualifiers;


	/**
	 * An array of the cached Function objects. The index of each element is the Id
	 * of the corresponding Function.
	 * @attribute protected array _functions
	 */
	var $_functions;
	
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute protected integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @attribute protected string _hierarchyDB
	 */
	var $_authzDB;
	
	
	/**
     * Constructor
     * @access protected
     */
	function AuthorizationCache($dbIndex, $authzDB) {
		// ** argument validation **
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($authzDB, new StringValidatorRule(), true);
		// ** end of argument validation **

		$this->_dbIndex = $dbIndex;
		$this->_authzDB = $authzDB;
		$this->_qualifiers = array();
		$this->_functions = array();
	}
	
	
	/**
	 * Returns the Function with the specified id.
	 * @access public
	 * @param string id The id of the function.
	 * @return ref object The Function with the specified id.
	 **/
	function & getFunction(& $idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		if (isset($this->_functions[$idValue]))
		    return $this->_functions[$idValue];

		$dbHandler =& Services::requireService("DBHandler");
		
		$db = $this->_authzDB;
		$dbt = $db.".az_function";
		$query =& new SelectQuery();
		$query->addColumn("function_id", "id", $dbt);
		$query->addColumn("function_reference_name", "reference_name", $dbt);
		$query->addColumn("function_description", "description", $dbt);
		$query->addColumn("fk_qualifier_hierarchy", "hierarchy_id", $dbt);
		$query->addColumn("type_domain", "domain", $db.".type");
		$query->addColumn("type_authority", "authority", $db.".type");
		$query->addColumn("type_keyword", "keyword", $db.".type");
		$query->addColumn("type_description", "type_description", $db.".type");
		$query->addTable($dbt);
		$joinc = $dbt.".fk_type = ".$db.".type.type_id";
		$query->addTable($db.".type", INNER_JOIN, $joinc);
		$where = $dbt.".function_id = '$idValue'";
		$query->addWhere($where);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
		    $str = "Exactly one row must have been returned";
			throwError($str, "authorization", true);
		}
		
		$row = $queryResult->getCurrentRow();
		$type =& new HarmoniType($row['domain'], $row['authority'], 
							     $row['keyword'], $row['type_description']);
		
		$function =& new HarmoniFunction(new HarmoniId($row['id']), $row['reference_name'],
										 $row['description'], $type, new HarmoniId($row['hierarchy_id']),
										 $this->_dbIndex, $this->_authzDB);
		
		$this->_functions[$idValue] =& $function;
		
		return $function;
	}
	
	
	/**
	 * Returns the Qualifier with the specified id.
	 * @access public
	 * @param string id The id of the Qualifier .
	 * @return ref object The Qualifier with the specified id.
	 **/
	function & getQualifier($qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		$idValue =& $qualifierId->getIdString();

		if (isset($this->_qualifiers[$idValue]))
		    return $this->_qualifiers[$idValue];

		// get the node for the qualifier		
		$hierarchyManager =& Services::requireService("Hierarchy");
		$node =& $hierarchyManager->getNode($qualifierId);
		// now create the qualifier
		$qualifier =& new HarmoniQualifier($node, $this);
		
		$this->_qualifiers[$idValue] =& $qualifier;
		
		return $qualifier;

	}
	
	
}

?>