<?php

require_once HARMONI."oki/shared/HarmoniType.class.php";
require_once HARMONI."oki/shared/HarmoniTypeIterator.class.php";
require_once HARMONI."metaData/manager/DataSetTypeDefinition.class.php";

/**
 * Responsible for the synchronization of {@link DataSetTypeDefinition} classes with the database, and the
 * creation of new Types.
 * @package harmoni.datamanager
 * @version $Id: DataSetTypeManager.class.php,v 1.21 2004/01/16 04:43:26 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataSetTypeManager
	extends ServiceInterface {
	
	var $_idmanager;
	var $_dbID;
	
	var $_types;
	var $_typeDefinitions;
	var $_typeIDs;
	
	var $_hashSeparator;
	
	/**
	* Constructor.
	* @param object $idmanager The {@link IDManager} to use for ID generation.
	* @param int $dbID The {@link DBHandler} connection ID to use for data type storage.
	* @param ref object $preloadTypes A {@link HarmoniTypeIterator} containing a number of {@link HarmoniType}s to
	* pre-load structure data for. This will avoid queries later on.
	*/
	function DataSetTypeManager( &$idmanager, $dbID, &$preloadTypes ) {
		$this->_idmanager =& $idmanager;
		$this->_dbID = $dbID;
		$this->_types = array();
		
		// talk to the DB
		$this->populate($preloadTypes);
		
		debug::output("Initialized new DataSetTypeManager with ".$this->numberOfTypes()." types.",DEBUG_SYS4,"DataSetTypeManager");
	}
	
	/**
	* Fetches from the DB a list of registered DataSetTypes.
	* @return void
	* @param ref object $preloadTypes A {@link HarmoniTypeIterator} containing a number of {@link HarmoniType}s to
	* pre-load structure data for. This will avoid queries later on.
	*/
	function populate(&$preloadTypes) {
		debug::output("Fetching all our known DataSetTypes from the database.",DEBUG_SYS1, "DataSetTypeManager");
		
		// let's get all our known types
		$query =& new SelectQuery;
		
		$query->addTable("datasettype");
		$query->addColumn("datasettype_id");
		$query->addColumn("datasettype_domain");
		$query->addColumn("datasettype_authority");
		$query->addColumn("datasettype_keyword");
		$query->addColumn("datasettype_description");
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,$this->_dbID);
		if (!$result) throwError(new UnknownDBError("DataSetTypeManager"));
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$type =& new HarmoniType($a['datasettype_authority'],
					$a['datasettype_domain'],
					$a['datasettype_keyword'],
					$a['datasettype_description']);
			
			$this->_typeDefinitions[$a['datasettype_id']] =& new DataSetTypeDefinition($this, $this->_idmanager, $this->_dbID, $type, $a['datasettype_id']);
			$this->_types[$a['datasettype_id']] =& $type;
			
			$this->_typeIDs[$this->_mkHash($type)] = $a['datasettype_id'];
			
			debug::output("Found type ID ".$a['datasettype_id']." of type '".OKITypeToString($type)."'",DEBUG_SYS2,"DataSetTypeManager");
			unset($type);
		}
		
		// now let's preload
		if ($preloadTypes) {
			$this->loadMultiple($preloadTypes);
		}
	}
	
	/**
	* Will load the data structures for multiple DataSetTypes.
	* @param ref object A {@link HarmoniTypeIterator} containing the list of types to be loaded.
	* @return void
	* @access public
	*/
	function loadMultiple(&$preloadTypes) {
		$ids = array();
		while ($preloadTypes->hasNext()) {
			$type =& $preloadTypes->next();
			$id = $this->getIDForType($type);
			if (!$id) continue;
			$obj =& $this->getDataSetTypeDefinition($type);
			if ($obj->loaded()) continue;
			$ids[] = $id;
		}
		
		if (count($ids)) {
			// let's do it
			$query =& new SelectQuery;
			$query->addTable("datasettypedef");
			$query->addColumn("datasettypedef_id");
			$query->addColumn("datasettypedef_label");
			$query->addColumn("datasettypedef_mult");
			$query->addColumn("datasettypedef_active");
			$query->addColumn("datasettypedef_fieldtype");
			$query->addColumn("fk_datasettype");
			
			$wheres = array();
			foreach ($ids as $id) {
				$wheres[] = "fk_datasettype=$id";
			}
			$query->setWhere("(".implode(" OR ",$wheres).")");
			
//			print "<PRE>".MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
			$dbHandler =& Services::getService("DBHandler");
			$res = $dbHandler->query($query, $this->_dbID);
			
			$rows = array();
			while ($res->hasMoreRows()) {
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$theID = $row["fk_datasettype"];
				if (!isset($rows[$theID])) $rows[$theID] = array();
				$rows[$theID][] = $row;
			}
			
//			printpre($rows);
			
			// now distribute the rows among their respective objects
			foreach (array_keys($rows) as $id) {
				$obj =& $this->getDataSetTypeDefinitionByID($id);
				if (!$obj->loaded()) $obj->populate($rows[$id]);
			}
		}
	}
	
	/**
	* Returns the number of registered dataset types.
	* @return integer
	*/
	function numberOfTypes() {
		return count($this->_types);
	}
	
	/**
	* Creates a hash of the OKI type for keying a type to an ID in a hash array. The hashes should be unique.
	* @return string The hash as a string.
	* @param mixed $type Either an OKI Type object or the Domain string.
	* @param optional string $auth The Authority.
	* @param optional string $key The Keyword.
	*/
	function _mkHash($type, $auth=null, $key=null) {
		if (!$this->_hashSeparator)
			$this->_hashSeparator = time();
		
		$parts = array();	
		
		if (is_object($type)) {
			$parts[] = $type->getDomain();
			$parts[] = $type->getAuthority();
			$parts[] = $type->getKeyword();
		} else if ($type && $auth && $key) {
			$parts[] = $type;
			$parts[] = $auth;
			$parts[] = $key;
		} else return "";
		
		return implode($this->_hashSeparator, $parts);
	}
	
	/**
	 * Returns the ID for the DataType of $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return integer
	 * @access public
	 */
	function getIDForType(&$type) {
		$hash = $this->_mkHash($type);
		return (isset($this->_typeIDs[$hash]))?$this->_typeIDs[$hash]:null;
	}
	
	/**
	 * Returns a new {@link DataSetTypeDefinition} object of $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return ref object The new DataSetTypeDefinition object.
	 * @access public
	 */
	function & newDataSetType(&$type) {
		$null = null;
		$newDef =& new DataSetTypeDefinition($this, $null, null, $type);
		return $newDef;
	}
	
	/**
	 * Adds a {@link DataSetTypeDefinition} to the list of registered types, and
	 * makes sure that it is reference in the database as well.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return ref object The new DataSetTypeDefinition object.
	 * @access private
	 */
	function & _addDataSetType(&$type) {
		debug::output("Adding DataSetType '".OKITypeToString($type)."' to database.",DEBUG_SYS1,"DataSetTypeManager");
		if ($id = $this->getIDForType($type)) {
			throwError( new Error(
				"DataSetTypeManager::newDataSetType(".OKITypeToString($type).") - a DataSetType for this Type already exists, so the existing one has been returned.",
				"DataSetTypeManager",false));
			debug::output("Returning existing DataSetType for '".OKITypeToString($type)."'",DEBUG_SYS5, "DataSetTypeManager");
			return $this->_types[$id];
		}
		
		// add somethin' to the database
		$newID = $this->_idmanager->newID(new HarmoniDataSetType);
		
		$query =& new InsertQuery;
		$query->setTable("datasettype");
		$query->setColumns(array("datasettype_id","datasettype_domain","datasettype_authority","datasettype_keyword","datasettype_description"));
		$query->addRowOfValues( array(
			$newID,
			"'".addslashes($type->getDomain())."'",
			"'".addslashes($type->getAuthority())."'",
			"'".addslashes($type->getKeyword())."'",
			"'".addslashes($type->getDescription())."'"
		));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,$this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("DataSetTypeManager") );
		}
		
		$newDataSetType =& new DataSetTypeDefinition($this, $this->_idmanager, $this->_dbID, $type, $newID);

		// add it to our local arrays
		$this->_typeDefinitions[$newID] =& $newDataSetType;
		$this->_types[$newID] =& $type;
		$this->_typeIDs[$this->_mkHash($type)] = $newID;
		debug::output("Created new DataSetType object for '".OKITypeToString($type)."'",DEBUG_SYS5,"DataSetTypeManager");
		return $newDataSetType;
	}
	
	/**
	 * Returns TRUE/FALSE if we have a DataSetTypeDefinition responsible for $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return boolean
	 * @access public
	 */
	function dataSetTypeExists(&$type) {
		return (isset($this->_typeIDs[$this->_mkHash($type)]))?true:false;
	}
	
	/**
	 * Returns the {@link DataSetTypeDefinition} object corresponding to $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return ref object The {@link DataSetTypeDefinition} object.
	 * @access public
	 */
	function & getDataSetTypeDefinition(&$type) {
		if (!($id = $this->getIDForType($type))) {
			throwError( new Error(
				"DataSetTypeManager::getDataSetTypeDefinition(".OKITypeToString($type).") - no DataSetTypeDefinition exists.",
				"DataSetTypeManager",true));
			return false;
		}
		return $this->_typeDefinitions[$id];
	}
	
	/**
	 * Returns the {@link DataSetTypeDefinition} object corresponding to $id.
	 * @param integer $id The DataBase ID of the definition.
	 * @return ref object The definition.
	 * @access public
	 */
	function & getDataSetTypeDefinitionByID($id) {
		if (!isset($this->_typeDefinitions[$id])) {
			throwError ( new Error(
				"Could not find DataSetTypeDefinition with ID '$id'!","DataSetTypeManager",true));
			return false;
		}
		
		return $this->_typeDefinitions[$id];
	}
	
	/**
	 * Returns an iterator of all the registered DataSet types.
	 * @return ref object A {@link HarmoniTypeIterator}
	 * @access public
	 */
	function & getAllDataSetTypes() {
		return new HarmoniTypeIterator($this->_types);
	}
	
	/** 
	 * Returns an array of all registered DataSetType IDs.
	 * @return array
	 * @access public
	 */
	function getAllDataSetTypeIDs() {
		return array_values($this->_typeIDs);
	}
	
	/**
	 * Returns the Type object associated with database $id.
	 * @param integer $id The Database ID.
	 * @return ref object The {@link HarmoniType} object.
	 * @access public
	 */
	function & getDataSetTypeByID( $id ) {
		return $this->_types[$id];
	}
	
	/**
	 * Is passed a {@link DataSetTypeDefinition} will make sure that the definition stored in the database
	 * reflects what is stored in the passed object.
	 * @param ref object A {@link DataSetTypeDefinition} object.
	 * @return boolean Success/failure.
	 * @access public
	 */
	function synchronize(&$newDef) {
		$type =& $newDef->getType();
		
		debug::output("Attempting to synchronize DataSetTypeDefinition type '".OKITypeToString($type)."' with
		the database.",DEBUG_SYS1,"DataSetTypeManager");
		
		// check if we already have a definition for this type. if we don't, add a new one.
		if (!$this->dataSetTypeExists($type)) {
			$oldDef =& $this->_addDataSetType($type);
			debug::output("Creating new DataSetType in the database.",DEBUG_SYS3,"DataSetTypeManager");
		} else {
			$oldDef =& $this->getDataSetTypeDefinition($type);
			// make sure $oldDef has all its data loaded
			$oldDef->load();
			debug::output("Using database version for synchronization.",DEBUG_SYS3,"DataSetTypeManger");
		}
		
		/*
		The synchronization process is not simple. 
		
		get all labels, from both old def (from DB) and new def, store in $label[]
		
		For each $label {
			if the field doesn't exist, add it to the DB
			if the field does exist {
				...in database, but not in new, delete it, including all values in datasets
					that reference the field
				...in both new def and db {
					if mult value has changed ...
						... from yes to no, make the change, go through all values in datasets
							that reference this field -- make sure there is only one active value
						... from no to yes, make the change.
					if versionControl has changed ...
						... shouldn't be a problem -- just make the change
					if field type has changed ...
						... --> should we just not allow this?
						... if values already exist (even inactive ones), throw a huge ugly error.
						... otherwise, make the change but throw a warning too.
					if active flag has changed ...
						... from yes to no, delete the old
						... from no to yes, re-activate the old
					if required flag has changed ...
						... from yes to no, ok, update it
						... from no to yes, throw an error. we can't validate all datasets
				}
			}
		}
		*/
		
		$allLabels = array_unique(array_merge( $newDef->getAllLabels(), $oldDef->getAllLabels() ));
		
		debug::output("Merged labels: ".implode(", ",$allLabels),DEBUG_SYS5,"DataSetTypeManager");
		
		foreach ($allLabels as $label) {
			// now we're going to go through the logic above in the comment
			
			// if the field exists in new and not in old, add it to old, and flag it to add to DB
			if (!$oldDef->fieldExists($label) && $newDef->fieldExists($label)) {
				$field =& $newDef->getFieldDefinition($label);
				$newField =& $field->clone();
				$newField->addToDB();
				$oldDef->addNewField($newField);
				
				debug::output("Label '$label' flagged for addition to database.",DEBUG_SYS5,"DataSetTypeManager");
				unset($newField, $field);
				continue;
			}
			
			// if the field exists in the old but not in the new, flag it for deletion.
			if ($oldDef->fieldExists($label) && !$newDef->fieldExists($label)) {
				$field =& $oldDef->getFieldDefinition($label);
				$field->delete();
				
				debug::output("Label '$label' flagged for deletion from database.",DEBUG_SYS5,"DataSetTypeManager");
				unset($field);
				continue;
			}
			
			// ok, if we're at this point it means the label is defined in both definitions.
			$oldField =& $oldDef->getFieldDefinition($label);
			$newField =& $newDef->getFieldDefinition($label);
			
			// first let's check if the types match. if they don't, we're going to go psycho
			$oldType = $oldField->getType();
			$newType = $newField->getType();
			if ($newType != $oldType) {
				// go PSYCHO!!!!
				throwError( new Error(
					"While synchronizing DataSetType '".OKITypeToString($this->_type)."', it appears that the
					field type for label '$label' is different from what we have stored. It is not possible
					to synchronize without possible data loss. Aborting.","DataSetTypeManager",true));
				return false;
			}
			unset($newType,$oldType);

			// let's check the active flag
			$oldActive = $oldField->isActive();
			$newActive = $newField->isActive();
			if ($oldActive != $newActive) {
				if ($oldActive && !$newActive) {
					$oldField->delete();
				}
				if (!$oldActive && $newActive) {
					$oldField->setActiveFlag(true);
					$oldField->update();
				}
			}

			// now let's check the mult
			$oldMult = $oldField->getMultFlag();
			$newMult = $newField->getMultFlag();
			if ($oldMult !== $newMult) { // boolean-safe compare
				// ok, now, if we're changing from true to false, just go ahead, make the change
				if (!$oldMult && $newMult) {
					$oldField->setMultFlat(true);
					$oldField->update();
					
					debug::output("Label '$label': activating multiple-values.",DEBUG_SYS5,"DataSetTypeManager");
				}
				// otherwise, we'll have to do some smart updating
				if ($oldMult && !$newMult) {
					// for this field, we'll have to make sure that there aren't multiple values
					// already set for this. we'll try to keep the most recent active value as the
					// only value.
					
					// @todo - how to do this:
					// select all rows from datasetfield where fk_datasettypedef=$oldField->getID()
					// and datasetfield_active=1, ordering by datasetfield_created ASC
					// then, go through from count to count-1 and set active to 0. that should do it
					
					// now, make the change
					$oldField->setMultFlag(false);
					$oldField->update();
					
					debug::output("Label '$label': deactivating multiple values, deleted any additional data entries that would conflict with this setting.",DEBUG_SYS5,"DataSetTypeManager");
				}
			}

			// now let's check the req
			$oldReq = $oldField->isRequired();
			$newReq = $newField->isRequired();
			if ($oldReq !== $newReq) { // boolean-safe compare
				// ok, now, if we're changing from true to false, just go ahead, make the change
				if (!$oldReq && $newReq) {
					$oldField->setRequired(true);
					$oldField->update();
				}
				// otherwise, throw an error!
				if ($oldReq && !$newReq) {
					throwError( new Error("synchronize() can not change a field's required flag from NO to YES!","DataSetTypeManager",true));
					return false;
				}
			}
		}
		
		// now that we're done syncrhonizing $newDef with $oldDef, let's commit everything to the DB
		$oldDef->commitAllFields();
		
		debug::output("... synchronization finished.",DEBUG_SYS2,"DataSetTypeManager");
	}
	
	function start() {}
	function stop() {}
}

/**
 * @package harmoni.datamanager
 */
class HarmoniDataSetType extends HarmoniType {
	function HarmoniDataSetType() {
		parent::HarmoniType("Harmoni","HarmoniDataManager","DataSetType",
				"Defines a DataSet definition within Harmoni's MetaData Manager system.");
	}
}
?>