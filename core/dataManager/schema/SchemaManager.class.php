<?php

require_once HARMONI."dataManager/schema/Schema.class.php";

/**
 * Responsible for the synchronization of {@link Schema} classes with the database, and the
 * creation of new Types.
 * @package harmoni.datamanager
 * @version $Id: SchemaManager.class.php,v 1.8 2004/09/09 16:53:41 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class SchemaManager
	extends ServiceInterface {
	
	var $_types;
	var $_schemas;
	var $_typeIDs;
	
	var $_hashSeparator;
	
	/**
	* Constructor.
	* @param int $dbID The {@link DBHandler} connection ID to use for data type storage.
	* @param ref object $preloadTypes A {@link HarmoniTypeIterator} containing a number of {@link HarmoniType}s to
	* pre-load structure data for. This will avoid queries later on.
	*/
	function SchemaManager( &$preloadTypes ) {
		$this->_types = array();
		$this->_typeIDs = array();
		$this->_schemas = array();
		
		// talk to the DB
		$this->loadTypes($preloadTypes);
		
		debug::output("Initialized new SchemaManager with ".$this->numberOfTypes()." types.",DEBUG_SYS4,"DataManager");
	}
	
	/**
	* Fetches from the DB a list of registered DataSetTypes.
	* @return void
	* @param ref object $preloadTypes A {@link HarmoniTypeIterator} containing a number of {@link HarmoniType}s to
	* pre-load structure data for. This will avoid queries later on.
	*/
	function loadTypes(&$preloadTypes) {
		debug::output("Fetching all our known Schemas from the database.",DEBUG_SYS1, "DataManager");
		
		// let's get all our known types
		$query =& new SelectQuery;
		
		$query->addTable("dm_schema");
		$query->addColumn("id","","dm_schema");
		$query->addColumn("domain","","dm_schema");
		$query->addColumn("authority","","dm_schema");
		$query->addColumn("keyword","","dm_schema");
		$query->addColumn("description","","dm_schema");
		$query->addColumn("revision","","dm_schema");
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,DATAMANAGER_DBID);
		if (!$result) throwError(new UnknownDBError("DataManager"));
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$type =& new HarmoniType(
					$a['domain'],
					$a['authority'],
					$a['keyword'],
					$a['description']);
			
			$this->_schemas[$a['id']] =& new Schema( $type, $a['revision']);
			$this->_schemas[$a['id']]->setManagerFlag();
			
			$this->_types[$a['id']] =& $type;
			
			$this->_typeIDs[$this->_mkHash($type)] = $a['id'];
			
			debug::output("Found type ID ".$a['id']." of type '".OKITypeToString($type)."', revision ".$a['revision'],DEBUG_SYS2,"DataManager");
			unset($type);
		}
		
		// now let's preload
		if ($preloadTypes) {
			$this->loadMultiple($preloadTypes);
		}
	}
	
	/**
	* Will load the data structures for multiple {@link Schema}s.
	* @param ref object A {@link HarmoniTypeIterator} containing the list of types to be loaded.
	* @return void
	* @access public
	*/
	function loadMultiple(&$preloadTypes) {
		$ids = array();
		while ($preloadTypes->hasNext()) {
			$type =& $preloadTypes->next();
			$id = $this->getIDByType($type);
			if (!$id) continue;
			$obj =& $this->getSchemaByType($type);
			if ($obj->loaded()) continue;
			$ids[] = $id;
		}
		
		if (count($ids)) {
			// let's do it
			$query =& new SelectQuery;
			$query->addTable("dm_schema_field");
			$query->addColumn("id");
			$query->addColumn("label");
			$query->addColumn("mult");
			$query->addColumn("required");
			$query->addColumn("active");
			$query->addColumn("fieldtype");
			$query->addColumn("fk_schema");
			
			$wheres = array();
			foreach ($ids as $id) {
				$wheres[] = "fk_schema=$id";
			}
			$query->setWhere("(".implode(" OR ",$wheres).")");
			
//			print "<PRE>".MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
			$dbHandler =& Services::getService("DBHandler");
			$res = $dbHandler->query($query, DATAMANAGER_DBID);
			
			$rows = array();
			while ($res->hasMoreRows()) {
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$theID = $row["fk_schema"];
				if (!isset($rows[$theID])) $rows[$theID] = array();
				$rows[$theID][] = $row;
			}
			
//			printpre($rows);
			
			// now distribute the rows among their respective objects
			foreach (array_keys($rows) as $id) {
				$obj =& $this->getSchemaByID($id);
				if (!$obj->loaded()) $obj->populate($rows[$id]);
			}
		}
	}
	
	/**
	* Returns the number of registered schemas.
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
			ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"));
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
	 * Returns the ID for the Schema of $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return integer
	 * @access public
	 */
	function getIDByType(&$type) {
		$hash = $this->_mkHash($type);
		return (isset($this->_typeIDs[$hash]))?$this->_typeIDs[$hash]:null;
	}
	
	/**
	 * Returns a new {@link Schema} object of $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @param optional int $revision The revision of this schema, useful for updating data structures. (default=1)
	 * @return ref object The new Schema object.
	 * @access public
	 */
	function &createSchema(&$type, $revision=1) {
		$newDef =& new Schema( $type, $revision );
		return $newDef;
	}
	
	/**
	 * Adds a {@link Schema} to the list of registered types, and
	 * makes sure that it is reference in the database as well.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @param int $revision The revision number of this schema.
	 * @return ref object The new Schema object.
	 * @access private
	 */
	function &_addSchema(&$type, $revision) {
		debug::output("Adding Schema type '".OKITypeToString($type)."' to database.",DEBUG_SYS1,"DataManager");
		if ($id = $this->getIDByType($type)) {
			throwError( new Error(
				"A Schema for this Type already exists, so the existing one has been returned.",
				"DataManager",false));
			debug::output("Returning existing Schema for '".OKITypeToString($type)."'",DEBUG_SYS5, "DataManager");
			return $this->_schemas[$id];
		}
		
		// add somethin' to the database
		$sharedManager =& Services::getService("Shared");
		$newID =& $sharedManager->createId();
		
		$query =& new InsertQuery;
		$query->setTable("dm_schema");
		$query->setColumns(array("id","domain","authority","keyword","description", "revision"));
		$query->addRowOfValues( array(
			$newID->getIdString(),
			"'".addslashes($type->getDomain())."'",
			"'".addslashes($type->getAuthority())."'",
			"'".addslashes($type->getKeyword())."'",
			"'".addslashes($type->getDescription())."'",
			$revision
		));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,DATAMANAGER_DBID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("DataManager") );
		}
		
		$newSchema =& new Schema( $type, $revision);
		$newSchema->setManagerFlag();

		// add it to our local arrays
		$this->_schemas[$newID->getIdString()] =& $newSchema;
		$this->_types[$newID->getIdString()] =& $type;
		$this->_typeIDs[$this->_mkHash($type)] = $newID->getIdString();
		debug::output("Created new Schema object for '".OKITypeToString($type)."', revision $revision.",DEBUG_SYS5,"DataManager");
		return $newSchema;
	}
	
	/**
	 * Returns TRUE/FALSE if we have a Schema for type $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return boolean
	 * @access public
	 */
	function schemaExists(&$type) {
		return (isset($this->_typeIDs[$this->_mkHash($type)]))?true:false;
	}
	
	/**
	 * Returns the {@link Schema} object corresponding to $type.
	 * @param ref object $type A {@link HarmoniType} object.
	 * @return ref object The {@link Schema} object.
	 * @access public
	 */
	function &getSchemaByType(&$type) {
		if (!($id = $this->getIDByType($type))) {
			throwError( new Error(
				"No Schema exists for type '".OKITypeToString($type)."'.",
				"DataManager",true));
			return false;
		}
		return $this->_schemas[$id];
	}
	
	/**
	 * Returns the {@link Schema} object corresponding to $id.
	 * @param integer $id The DataBase ID of the definition.
	 * @return ref object The schema.
	 * @access public
	 */
	function &getSchemaByID($id) {
		if (!isset($this->_schemas[$id])) {
			throwError ( new Error(
				"Could not find Schema with ID '$id'!","DataManager",true));
			return false;
		}
		
		return $this->_schemas[$id];
	}
	
	/**
	 * Returns an iterator of all the registered {@link Schema} types.
	 * @return ref object A {@link HarmoniTypeIterator}
	 * @access public
	 */
	function &getAllSchemaTypes() {
		return new HarmoniTypeIterator($this->_types);
	}
	
	/** 
	 * Returns an array of all registered {@link Schema} IDs.
	 * @return array
	 * @access public
	 */
	function getAllSchemaIDs() {
		return array_values($this->_typeIDs);
	}
	
	/**
	 * Returns the Type object associated with database $id.
	 * @param integer $id The Database ID.
	 * @return ref object The {@link HarmoniType} object.
	 * @access public
	 */
	function &getSchemaTypeByID( $id ) {
		return $this->_types[$id];
	}
	
	/**
	 * Passed a {@link Schema}, will make sure that the definition stored in the database
	 * reflects what is stored in the passed object.
	 * @param ref object A {@link Schema} object.
	 * @return boolean Success/failure.
	 * @access public
	 */
	function synchronize(&$new) {
		ArgumentValidator::validate($new, new ExtendsValidatorRule("Schema"));
		
		$type =& $new->getType();
		
		debug::output("Attempting to synchronize Schema type '".OKITypeToString($type)."' with
		the database.",DEBUG_SYS1,"DataManager");
		
		// check if we already have a definition for this type. if we don't, add a new one.
		if (!$this->schemaExists($type)) {
			$old =& $this->_addSchema($type, $new->getRevision());
			debug::output("Creating new Schema in the database.",DEBUG_SYS3,"DataManager");
		} else {
			$old =& $this->getSchemaByType($type);
			// make sure $oldDef has all its data loaded
			$old->load();
			debug::output("Using database version for synchronization.",DEBUG_SYS3,"DataManger");
		}
		
		/*
		The synchronization process is not simple. 
		
		compare revision numbers, and update them appropriately. do this last.
		
		get all labels, from both old def (from DB) and new def, store in $label[]
		
		For each $label {
			if the field doesn't exist, add it to the DB
			if the field does exist {
				...in database, but not in new, delete it, including all values in datasets
					that reference the field
				...in both new def and db {
					if mult value has changed ...
						... from yes to no, make the change.
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
		
		$allLabels = array_unique(array_merge( $new->getAllLabels(), $old->getAllLabels() ));
		
		debug::output("Merged labels: ".implode(", ",$allLabels),DEBUG_SYS5,"DataManager");
		
		foreach ($allLabels as $label) {
			// now we're going to go through the logic above in the comment
			debug::output("Checking label '$label' ...", DEBUG_SYS5, "DataManager");
			// if the field exists in new and not in old, add it to old, and flag it to add to DB
			if (!$old->fieldExists($label) && $new->fieldExists($label)) {
				$field =& $new->getField($label);
				$newField =& $field->clone();
				$newField->addToDB();
				$old->addField($newField);
				
				debug::output("Label '$label' flagged for addition to database.",DEBUG_SYS5,"DataManager");
				unset($newField, $field);
				continue;
			}
			
			// if the field exists in the old but not in the new, flag it for deletion.
			if ($old->fieldExists($label) && !$new->fieldExists($label)) {
				$field =& $old->getField($label);
				$field->delete();
				
				debug::output("Label '$label' flagged for deletion from database.",DEBUG_SYS5,"DataManager");
				unset($field);
				continue;
			}
			
			// ok, if we're at this point it means the label is defined in both definitions.
			$oldField =& $old->getField($label);
			$newField =& $new->getField($label);
			
			// first let's check if the types match. if they don't, we're going to go psycho
			$oldType = $oldField->getType();
			$newType = $newField->getType();
			if ($newType != $oldType) {
				// go PSYCHO!!!!
				throwError( new Error(
					"While synchronizing Schema '".OKITypeToString($this->_type)."', it appears that the
					field type for label '$label' is different from what we have stored. It is not possible
					to synchronize without potential data loss. Aborting.","DataManager",true));
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
					
					debug::output("Label '$label': activating multiple-values.",DEBUG_SYS5,"DataManager");
				}
				// otherwise, we'll have to do some smart updating
				if ($oldMult && !$newMult) {					
					// now, make the change
					$oldField->setMultFlag(false);
					$oldField->update();
					
					debug::output("Label '$label': deactivating multiple values, deleted any additional data entries that would conflict with this setting.",DEBUG_SYS5,"DataManager");
				}
			}
			
			// check the description
			$oldDesc = $oldField->getDescription();
			$newDesc = $newField->getDescription();
			if ($oldDesc != $newDesc) {
				$oldField->setDescription($newDesc);
				$oldField->update();
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
					throwError( new Error("synchronize() can not change a field's required flag from NO to YES!","DataManager",true));
					return false;
				}
			}
		}
		
		// now that we're done syncrhonizing $newDef with $oldDef, let's commit everything to the DB
		$old->commitAllFields();
		
		// lastly, compare the revision numbers of the two definitions
		if ($old->getRevision() != $new->getRevision()) {
			// change the database.
			$query =& new UpdateQuery();
			$query->setTable("dm_schema");
			$query->setWhere("id=".$old->getID());
			$query->setColumns(array("revision"));
			$query->setValues(array($new->getRevision()));
			
			$dbHandler=& Services::getService("DBHandler");
			$dbHandler->query($query,DATAMANAGER_DBID);
		}
		
		$old->loaded(true);
		
		debug::output("... synchronization finished.",DEBUG_SYS2,"DataManager");
	}
	
	function start() {}
	function stop() {}
}

?>
