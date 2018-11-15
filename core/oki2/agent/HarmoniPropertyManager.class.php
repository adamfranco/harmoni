<?php

/**
 * <p>
 * Property manager handles the process of storing and retrieving agent
 * properties in the database.  It also contains functionality to get database
 * info on property types. It was designed to work with HarmoniEditableAgent
 * which implements functionality to modify, in the context of the program
 * properties and other agent attributes.  This manager allows the program to
 * store those changes.
 * </p>
 * 
 * <p>
 * THIS MANAGER IS NOT IN THE OSID 2.0!
 * However it does follow the outline of a normal OSID manager.
 *
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 *
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniPropertyManager.class.php,v 1.9 2008/02/06 15:37:46 adamfranco Exp $
 *
 * @author Ben Gore
 */

class HarmoniPropertyManager
{
	var $_dbIndex;
	var $_dbName;
	
	function __construct(){
		
	}
	
	/**
	 * Assigns the configuration of databases etc.
	 * 
	 * @param object $configuration
	 * 
	 * @access public
	 *
	 * @return void
	 */
	
	function assignConfiguration ( Properties $configuration ){
		$this->_configuration =$configuration;
		
		$dbIndex =$configuration->getProperty('database_index');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
	
	}
	
	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( OsidContext $context ) { 
		$this->_osidContext =$context;
	} 
	
	
	/**
	 * A public function that retrieves properties from the database associated 
	 * with the object represented by object_id_string. Each individual type
	 * has a separate object, which is placed in the array
	 *
	 * @param int $object_id_string
	 *
	 * @return array
	 *
	 * @access public
	 */

	function retrieveProperties($object_id_string){
		$current_property_type = null;//for distinguishing whether the type retrieved is new or not.  Obviously, the first one is
		$propertiesArray = array();//for storing each property object of type
		
		$dbHandler = Services::getService("DBHandler");
		
		//select the properties associated with this object (usually an agent)
		$query = new SelectQuery();
		$query->addTable("agent_properties");
		$query->addTable("type", LEFT_JOIN, "agent_properties.fk_type_id=type.type_id");
		$query->addColumn("*");
		$query->addWhereEqual("fk_object_id", $object_id_string);
		$query->addOrderBy("fk_type_id");
		
		
		$result =$dbHandler->query($query, $this->_dbIndex);
			
		//loop through the results
		while($result->hasMoreRows()){
			$row = $result->getCurrentRow();//grab a new row
			
			if($row['fk_type_id']!=$current_property_type){//if this is a new type (the results are sorted by type), we add a new property object to the array for that type
				$current_property_type = $row['fk_type_id'];
				$type = new HarmoniType($row['type_domain'], $row['type_authority'], $row['type_keyword'], $row['type_description']);
				
				$propertiesArray[$current_property_type] = new HarmoniProperties($type);//the property
	
			}
			
			$propertiesArray[$current_property_type]->addProperty($row['property_key'], $row['property_value']);//we can now add the values to the property object
			
			$result->advanceRow();//the next row
		}
		$result->free();
	
		return $propertiesArray;//return the properties
	}
	
	/**
	 * A public function that stores all of the properties of the property 		
	 * object sent to it.  
	 * It deletes the old entries no matter what to avoid arduous checking to
	 * if each needed to be deleted.  The properties are then rewritten to the
	 * database in the form the agent has them.
	 *
	 * @param int $object_id
	 * @param object Property $properties
	 *
	 * @return boolean
	 *
	 * @access public
	 */
	
	function storeProperties($object_id, $properties){
		$dbHandler = Services::getService("DBHandler");
	
		//ArgumentValidator::validate($object_id, new StringValidatorRule("Type"), true);

		if($properties===NULL){
			return false;
		}		
						
		$type =$properties->getType();//so we know the type
		$typeIdString = $this->getTypeId($type);//get the database id for type
		
		//If we don't delete them all every time we store then if we've deleted one off of the object it will remain in the DB
		$query = new DeleteQuery();
		$query->setTable("agent_properties");
		$query->addWhereEqual("fk_object_id", $object_id);
		$query->addWhereEqual('fk_type_id', $typeIdString, _AND);
		
		$dbHandler->query($query, $this->_dbIndex);
		
		$keys =$properties->getKeys();//all the keys for the various properties
		
		while($keys->hasNextObject()){//loop through all the properties
			$key =$keys->nextObject();//get the next key
			$propertyValue =$properties->getProperty($key);//get the value of the property
						
			$query = new InsertQuery();
			$query->setTable("agent_properties");
			$query->setColumns(array("fk_object_id","fk_type_id", "property_key", "property_value"));
			$query->addRowOfValues(array("'".addslashes($object_id)."'", $typeIdString, "'".addslashes($key)."'", "'".addslashes($propertyValue)."'"));
		//	}
			
			$result =$dbHandler->query($query, $this->_dbIndex);
			if(!$result){//at the first failure we'll stop and return false
				return false;
			}
		}
		
		return true;	
	}
	
		
	/**
	 * A public function for getting a type id (and ensuring that it exists
	 * in the database). One might consider implementing a Type manager for 
	 * stuff like this that has no proper home.
	 * 
	 * @param object Type $type
	 *
	 * @return integer
	 *
	 * @access public
	 *
	 * @since 11/18/04
	 */
	
	function getTypeId ( $type ) {
		$dbc = Services::getService("DBHandler");
		
		// Check to see if the type already exists in the DB
		$query = new SelectQuery;
		$query->addColumn("type_id");
		$query->addTable("type");
		$query->addWhereEqual("type_domain", $type->getDomain());
		$query->addWhereEqual("type_authority", $type->getAuthority(), _AND);
		$query->addWhereEqual("type_keyword", $type->getKeyword(), _AND);
		
		$result =$dbc->query($query, $this->_dbIndex);
		
		// If we have a type id already, use that
		if ($result->getNumberOfRows()) {
			$typeId = $result->field("type_id");
			$result->free();
		} 
		// otherwise insert a new one.
		else {
			$result->free();
			$query = new InsertQuery;
			$query->setTable("type");
			$query->setAutoIncrementColumn("type_id", "type_type_id_seq");
			$query->setColumns(array(
								"type_domain",
								"type_authority",
								"type_keyword",
								"type_description"));
			$query->setValues(array(
								"'".addslashes($type->getDomain())."'",
								"'".addslashes($type->getAuthority())."'",
								"'".addslashes($type->getKeyword())."'",
								"'".addslashes($type->getDescription())."'"));
			
			$result =$dbc->query($query, $this->_dbIndex);
			$typeId = $result->getLastAutoIncrementValue();
		}
		
		return $typeId;
	}
	
	/**
	 * Delete all properties associated with an object
	 * This is here partially to preserve the option of using non-editable agents
	 * If that ceases to be an issue, this more properly belongs in
	 * HarmoniEditableAgent.class
	 *
	 * @param string $object_id_string
	 * @return boolean
	 * @access public
	 */
	 
	 function deleteAllProperties($object_id_string){
	 	$dbHandler = Services::getService("DBHandler");
	 	
	 	//create a query to remove all properties associated with $object_id_string
	 	$query= new DeleteQuery();
	 	$query->setTable("agent_properties");
		$query->addWhereEqual("fk_object_id", $object_id_string);
	 	
	 	$result =$dbHandler->query($query, $this->_dbIndex);
	 	
	 	return $result ? true : false;
	 }
	
	
	
	/**
	 * A public function to take a key/value array of properties as might be
	 * gathered from a web form and turns it into a useable object
	 * 
	 * @param array $propertiesArray
	 * @param object Type $type
	 *
	 * @return object Property
	 *
	 * @acess public
	 */
	 
	 function convertArrayToObject($propertiesArray, $type){
	 	$property = new HarmoniProperties($type);
	 	
	 	foreach($propertiesArray as $key => $propertyValue){
	 		$property->addProperty($key, $propertyValue);
	 	}
	 	
	 	return $property;
	 }
	 
	
	/**
	 * Answer an array of all of the property keys inexistance
	 * 
	 * @return array
	 * @access public
	 * @since 11/1/05
	 */
	function getAllPropertyKeys(){
		$propertyKeys = array();
		$dbHandler = Services::getService("DBHandler");
		
		//select the propertykeys
		$query = new SelectQuery();
		$query->addTable("agent_properties");
		
		$query->addColumn("DISTINCT property_key");
		
// 		$query->addTable("type", LEFT_JOIN, "agent_properties.fk_type_id=type.type_id");
		
// 		$query->addColumn("property_key");
// 		$query->addColumn("type_domain");
// 		$query->addColumn("type_authority");
// 		$query->addColumn("type_keyword");
// 		$query->addColumn("type_description");
		
		$query->addOrderBy("property_key");
		
		
		$result =$dbHandler->query($query, $this->_dbIndex);
		while($result->hasMoreRows()){
			$propertyKeys[] = $result->field('property_key');
// 			$propertyKeys[$result->field('property_key')] = new Type(
// 				$result->field('type_domain'),
// 				$result->field('type_authority'),
// 				$result->field('type_keyword'),
// 				$result->field('type_description'));
			$result->advanceRow();
		}
		$result->free();
	
		return $propertyKeys;//return the properties
	}
}

?>