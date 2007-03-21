<?php

require_once("HarmoniAgent.class.php"); 

/**
 * EditableAgent is an extension of the OSID Agent to allow for
 * modifications.
 * 
 * <p>
 * WARNING: NOT IN OSID! Use at your own risk
 * </p>
 *
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniEditableAgent.class.php,v 1.4 2007/03/21 15:51:56 adamfranco Exp $
 */

class HarmoniEditableAgent
	extends HarmoniAgent
{
	
	/***
	 * changes the agent's display name to $newDisplayName
	 * and store it in the DB
	 *
	 * @param string $newDisplayName
	 *
	 * @access public
	 * @return boolean
	 */
		
	function updateDisplayName($newDisplayName){
		//make sure its a string
		ArgumentValidator::validate($newDisplayName, new StringValidatorRule(), true);
		//set the display name in the object
		
		$this->_node->updateDisplayName($newDisplayName);
	}
	
	/***
	 * adds a property to the agent and stores it
	 *
	 * @param object Type $type
	 * @param string $key
	 * @param mixed $value
	 *
	 * @access public
	 *
	 * @return boolean
	 */
	
	function addProperty(& $type, $key, & $value){
		//properties manager is used to store properties
		$propertiesManager =& Services::getService("Property");
		
		//get the database id of the type				
		$typeIdString = $propertiesManager->getTypeId($type);
		
		//an agent has one properties object for each Type, this gets the one for the type we're adding.
		$property =& $this->getPropertiesByType($type);		
		
		//if there aren't any properties of Type yet, create a new object		
		if($property===null){//if agent has no properties of type
			$property =& new HarmoniProperties($type);//create a new property of type $type
		}
		
		//add the property
		$property->addProperty($key, $value);
		
		//store the property to the database
		return $propertiesManager->storeProperties($this->_idString, $property);
				
	}
	
	/***
	 * Updates a property of the agent
	 *
	 * @param object Type $type
	 * @param string $key
	 * @param mixed $value
	 *
	 * @access public
	 *
	 * @return boolean
	 */
	
	function updateProperty( &$type, $key, &$value ){
		//get the properties object for Type		
		$property =& $this->getPropertiesByType($type);
		
		//if it doesn't exist, the property doesn't exit, quit
		if($property===null){
			return false;
		}
		
		//get the value
		$propertyValue = $property->getProperty($key);
		
		//if the value is null, the key doesn't exist (cleared values are set to FALSE not NULL)
		if($propertyValue===null) {
			return false;
		}
		
		//get rid of the old property
		$property->deleteProperty($key);
		//add the new value
		$property->addProperty($key, $value);
		
		//the property manager is for setting properties in the DB
		$propertyManager =& Services::getService("Property");
		
		//store the new values and return true or false				
		return $propertyManager->storeProperties($this->_idString, $property);		
	}
		
	/***
	 * Removes a property key/value pair from an agent and agent DB entries
	 *
	 * @param object Type $type
	 * @param string $key
	 *
	 * @return boolean
	 * @access public
	 */
	 
	function deleteProperty( &$type, $key ) {
		//the properties object hold properties of this type
		$property =& $this->getPropertiesByType($type);
		
		//our default assumption is that the key sent was bad
		$keyExists = false;
		
		//if there is no properties object of that type, there's no property to delete
		if($property===null){
			return false;
		}
		
		//get all the keys for the object and compare them to the target if any one matches, it will be set to true
		$keys =& $property->getKeys();
		while($keys->hasNextObject()){
			$tempKey = $keys->nextObject();
			if($tempKey==$key){
				//remove the property from the object
				$property->deleteProperty($key);

				//property manager is for storing properties info in the DB
				$propertyManager =& Services::getService("Property");

				//store property				
				return $propertyManager->storeProperties($this->_idString, $property);
			}
		}

		//if we didn't have a key return false
		return false;
	}
	
	/***
	 * Clears the values (replaces them with false) but leaves the properties in
	 * in existence.  The function above destroys them completely.
	 *
	 * @return void
	 * @access public
	 */
	  
	function clearAllProperties() {
		$value = false;//indicating set but empty.  NULL would confuse things if the property key didn't exist (which would be a true null)
		$properties =& $this->getProperties();
		//cycle through the properties
		while($properties->hasNext()){
		$property =& $properties->next();
			//keys for properties of this type
			$keys = $property->getKeys();
			//cycle through each key value pair
			while($keys->hasNextObject()){
				$key = $keys->nextObject();
				//set value to false
				$this->updateProperty($property->getType(), $key, $value);
			}
		}
	 	 	
		return;
	}
	
	/***
	 * Deletes the values for all the properties.
	 *
	 * @return void
	 * @access public
	 */
	  
	function deleteAllProperties() {
		$properties =& $this->getProperties();
		//cycle through the properties
		while($properties->hasNext()){
		$property =& $properties->next();
			//keys for properties of this type
			$keys = $property->getKeys();
			//cycle through each key value pair
			while($keys->hasNextObject()){
				$key = $keys->nextObject();
				//set value to false
				$this->deleteProperty($property->getType(), $key);
			}
		}
	 	 	
		return;
	}
	

}


?>