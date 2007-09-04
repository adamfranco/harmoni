<?php

require_once HARMONI."dataManager/schema/Schema.class.php";

/**
 * Responsible for the synchronization of {@link Schema} classes with the database, and the
 * creation of new Types.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SchemaManager.class.php,v 1.32 2007/09/04 20:25:32 adamfranco Exp $
 * @author Gabe Schine
 */
class SchemaManager {
	
	var $_schemas;
	
	/**
	* Constructor.
	* @param array $preloadTypes An array containing a number of {@link Schema} type IDs to
	* pre-load structure data for. This will avoid queries later on.
	*/
	function SchemaManager( $preloadTypes ) {
		$this->_schemas = array();
		
		// talk to the DB
		$this->loadTypes($preloadTypes);
		
		$this->_idService = Services::getService("Id");
		
		debug::output("Initialized new SchemaManager with ".$this->numberOfTypes()." types.",DEBUG_SYS4,"DataManager");
	}
	
	/**
	* Fetches from the DB a list of registered DataSetTypes.
	* @return void
	* @param array $preloadTypes An array containing a number of {@link Schema} type IDs to
	* load structure data for. This will avoid queries later on.
	*/
	function loadTypes($preloadTypes) {
		debug::output("Fetching all our known Schemas from the database.",DEBUG_SYS1, "DataManager");
		
		// let's get all our known types
		$query = new SelectQuery;
		
		$query->addTable("dm_schema");
		$query->addColumn("id","","dm_schema");
		$query->addColumn("displayname","","dm_schema");
		$query->addColumn("description","","dm_schema");
		$query->addColumn("revision","","dm_schema");
		$query->addColumn("other_params","","dm_schema");
		$query->addWhere("dm_schema.active = 1");
		
		$dbHandler = Services::getService("DatabaseManager");
		$result =$dbHandler->query($query,DATAMANAGER_DBID);
		if (!$result) throwError(new UnknownDBError("DataManager"));
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$otherParams = $a['other_params']?unserialize($a['other_params']):null;
			$this->_schemas[$a['id']] = new Schema( $a['id'], $a['displayname'], $a['revision'], $a['description'], $otherParams);
			$this->_schemas[$a['id']]->setManagerFlag();
			
			debug::output("Found type ID ".$a['id'].", revision ".$a['revision'],DEBUG_SYS2,"DataManager");
			unset($type);
		}
		$result->free();
		
		// now let's preload
		if ($preloadTypes) {
			$this->loadMultiple($preloadTypes);
		}
	}
	
	/**
	* Will load the data structures for multiple {@link Schema}s.
	* @param ref object An array containing the list of types IDs to be loaded.
	* @return void
	* @access public
	*/
	function loadMultiple($preloadTypes) {
		$ids = $preloadTypes;
		
		if (count($ids)) {
			// let's do it
			$query = new SelectQuery;
			$query->addTable("dm_schema_field");
			$query->addColumn("id", "id", "dm_schema_field");
			$query->addColumn("name", "label", "dm_schema_field");
			$query->addColumn("mult", "mult", "dm_schema_field");
			$query->addColumn("required", "required", "dm_schema_field");
			$query->addColumn("active", "active", "dm_schema_field");
			$query->addColumn("fieldtype", "fieldtype", "dm_schema_field");
			$query->addColumn("fk_schema", "fk_schema", "dm_schema_field");
			
			$wheres = array();
			foreach ($ids as $id) {
				$wheres[] = "fk_schema='".addslashes($id)."'";
			}
			$query->setWhere("(".implode(" OR ",$wheres).")");
			
//			print "<PRE>".MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
			$dbHandler = Services::getService("DatabaseManager");
			$res = $dbHandler->query($query, DATAMANAGER_DBID);
			
			$rows = array();
			while ($res->hasMoreRows()) {
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$theID = $row["fk_schema"];
				if (!isset($rows[$theID])) $rows[$theID] = array();
				$rows[$theID][] = $row;
			}
			$res->free();
			
//			printpre($rows);
			
			// now distribute the rows among their respective objects
			foreach (array_keys($rows) as $id) {
				$obj =$this->getSchema($id);
				if (!$obj->loaded()) $obj->populate($rows[$id]);
			}
		}
	}
	
	/**
	* Returns the number of registered schemas.
	* @return integer
	*/
	function numberOfTypes() {
		return count($this->_schemas);
	}
	
	/**
	 * Returns a new {@link Schema} object of $type.
	 * @param string $type A DNS-style unique ID. Example: "edu.middlebury.schemas.person"
	 * @param string $displayName This Schema's display name. 
	 * @param optional int $revision The revision of this schema, useful for updating data structures. (default=1)
	 * @param optional string $description A longer description of this Schema.
	 * @return ref object The new Schema object.
	 * @access public
	 */
	function createSchema($type, $displayName, $revision=1, $description='') {
		$newDef = new Schema( $type, $displayName, $revision, $description );
		return $newDef;
	}
	
	/**
	 * Adds a {@link Schema} to the list of registered types, and
	 * makes sure that it is reference in the database as well.
	 * @param string $type A DNS-style unique ID. Example: "edu.middlebury.schemas.person"
	 * @param string $displayName This Schema's display name. 
	 * @param int $revision The revision of this schema, useful for updating data structures. (default=1)
	 * @param string $description A longer description of this Schema.
	 * @return ref object The new Schema object.
	 * @access private
	 */
	function _addSchema($type, $displayName, $revision, $description) {
		debug::output("Adding Schema type '".$type."' to database.",DEBUG_SYS1,"DataManager");
		if ($this->schemaExists($type)) {
			throwError( new Error(
				"A Schema for this Type already exists, so the existing one has been returned.",
				"DataManager",false));
			debug::output("Returning existing Schema for '".$type."'",DEBUG_SYS5, "DataManager");
			return $this->_schemas[$id];
		}
		
		$query = new InsertQuery;
		$query->setTable("dm_schema");
		$query->setColumns(array("id","displayname","description", "revision"));
		$query->addRowOfValues( array(
			"'".addslashes($type)."'",
			"'".addslashes($displayName)."'",
			"'".addslashes($description)."'",
			$revision
		));
		
		$dbHandler = Services::getService("DatabaseManager");
		$result =$dbHandler->query($query,DATAMANAGER_DBID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("DataManager") );
		}
		
		$newSchema = new Schema( $type, $displayName, $revision, $description);
		$newSchema->setManagerFlag();

		// add it to our local arrays
		$this->_schemas[$type] =$newSchema;
		debug::output("Created new Schema object for '".$type."', revision $revision.",DEBUG_SYS5,"DataManager");
		return $newSchema;
	}
	
	/**
	 * Returns TRUE/FALSE if we have a Schema for type $type.
	 * @param string $type A unique type/ID string.
	 * @return boolean
	 * @access public
	 */
	function schemaExists($type) {
		return (isset($this->_schemas[$type]))?true:false;
	}
	
	/**
	 * Returns the {@link Schema} object corresponding to $id.
	 * @param integer $id The ID of the definition.
	 * @return ref object The schema.
	 * @access public
	 */
	function getSchemaByID($id) {
		if (!isset($this->_schemas[$id])) {
			$list = array();
			foreach ($this->_schemas as $key => $val)
				$list[] = $key;
			
			throwError ( new Error(
				"Could not find Schema with ID '$id' in (".printpre($list, true).")!","DataManager",true));
		}
		return $this->_schemas[$id];
	}
	
	/** 
	 * Returns an array of all registered {@link Schema} IDs.
	 * @return array
	 * @access public
	 */
	function getAllSchemaIDs() {
		return array_keys($this->_schemas);
	}
	
	/**
	 * Delete a schema (mark it inactive
	 * 
	 * @param string $id
	 * @return void
	 * @access public
	 * @since 6/6/06
	 */
	function deleteSchema ($id) {
		// update the row in the table for this schema
		$query = new UpdateQuery();
		$query->setTable("dm_schema");
		$query->setWhere("id='".addslashes($id)."'");
		$query->setColumns(array("active"));
		$query->setValues(array("0"));
		
		$dbHandler= Services::getService("DatabaseManager");
		$dbHandler->query($query,DATAMANAGER_DBID);
		
		// Trash the schema object
		if (!isset($this->_schemas[$id])) {
			$this->_schemas[$id] = null;
			unset($this->_schemas[$id]);
		}
	}
	
	/**
	 * Passed a {@link Schema}, will make sure that the definition stored in the database
	 * reflects what is stored in the passed object.
	 * @param ref object A {@link Schema} object.
	 * @return boolean Success/failure.
	 * @access public
	 */
	function synchronize($new) {
		ArgumentValidator::validate($new, ExtendsValidatorRule::getRule("Schema"));
		
		$id = $new->getID();
		
		debug::output("Attempting to synchronize Schema type '".$id."' with
		the database.",DEBUG_SYS1,"DataManager");
		
		// check if we already have a definition for this type. if we don't, add a new one.
		if (!$this->schemaExists($id)) {
			$old =$this->_addSchema($id, $new->getDisplayName(), $new->getRevision(), $new->getDescription());
			debug::output("Creating new Schema in the database.",DEBUG_SYS3,"DataManager");
		} else {
			$old =$this->getSchemaByID($id);
			// make sure $oldDef has all its data loaded
			$old->load();
			debug::output("Using database version for synchronization.",DEBUG_SYS3,"DataManger");
		}
		
		/*
		The synchronization process is not simple. 
		
		compare revision numbers, and update them appropriately. do this last.
		
		get all field ids, from both old def (from DB) and new def, store in $ids[]
		
		For each $ids {
			if the field doesn't exist, add it to the DB
			if the field does exist {
				...in database, but not in new, delete it
				...in both new def and db {
					if mult value has changed ...
						... from yes to no, make the change.
						... from no to yes, make the change.
					if versionControl has changed ...
						... shouldn't be a problem -- just make the change
					if field type has changed ...
						... NOT ALLOWED!
					if active flag has changed ...
						... from yes to no, delete the old
						... from no to yes, re-activate the old
					if required flag has changed ...
						... from yes to no, ok, update it
						... from no to yes, throw an error. we can't validate all datasets
					if display name has changed
						... change it
					if desc has changed
						... change it
				}
			}
		}
		*/
		
		$allLabels = array_unique(array_merge( $new->getAllIDs(true), $old->getAllIDs(true) ));
		
		debug::output("Merged ids: ".implode(", ",$allLabels),DEBUG_SYS5,"DataManager");
		
		foreach ($allLabels as $label) {
			// now we're going to go through the logic above in the comment
			debug::output("Checking id '$label' ...", DEBUG_SYS5, "DataManager");
			// if the field exists in new and not in old, add it to old, and flag it to add to DB
			if (!$old->fieldExists($label) && $new->fieldExists($label)) {
				$field =$new->getField($label);
				$newField =$field->replicate();
				$newField->addToDB();
				$old->addField($newField);
				
				debug::output("Label '$label' flagged for addition to database.",DEBUG_SYS5,"DataManager");
				unset($newField, $field);
				continue;
			}
			
			// if the field exists in the old but not in the new, flag it for deletion.
			if ($old->fieldExists($label) && !$new->fieldExists($label)) {
				$field =$old->getField($label);
				$field->delete();
				
				debug::output("Label '$label' flagged for deletion from database.",DEBUG_SYS5,"DataManager");
				unset($field);
				continue;
			}
			
			// ok, if we're at this point it means the label is defined in both definitions.
			$oldField =$old->getField($label);
			$newField =$new->getField($label);
			
			// first let's check if the types match. if they don't, we're going to go psycho
			$oldType = $oldField->getType();
			$newType = $newField->getType();
			if ($newType != $oldType) {
				// go PSYCHO!!!!
				throwError( new Error(
					"While synchronizing Schema '".$this->_type."', it appears that the
					field type for id '$label' is different from what we have stored. It is not possible
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
					debug::output("ID '$label' is no longer active.", DEBUG_SYS5, "DataManager");
				}
				if (!$oldActive && $newActive) {
					$oldField->setActiveFlag(true);
					$oldField->update();
					debug::output("ID '$label' is to be reactivated.", DEBUG_SYS5, "DataManager");
				}
			}

			// now let's check the mult
			$oldMult = $oldField->getMultFlag();
			$newMult = $newField->getMultFlag();
			if ($oldMult !== $newMult) { // boolean-safe compare
				// ok, now, if we're changing from true to false, just go ahead, make the change
				if (!$oldMult && $newMult) {
					$oldField->setMultFlag(true);
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
				$oldField->updateDescription($newDesc);
				$oldField->update();
			}
			
			// check the display name
			$oldName = $oldField->getDisplayName();
			$newName = $newField->getDisplayName();
			if ($oldName != $newName) {
				$oldField->updateDisplayName($newName);
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
				
		// lastly, update the row in the table for this schema
		// change the database.
		$query = new UpdateQuery();
		$query->setTable("dm_schema");
		$query->setWhere("id='".addslashes($old->getID())."'");
		$query->setColumns(array("revision", "displayname", "description", "other_params"));
		$query->setValues(array($new->getRevision(),
						"'".addslashes($old->getDisplayName())."'",
						"'".addslashes($old->getDescription())."'",
						"'".addslashes(serialize($old->getOtherParameters()))."'"));
		
		$dbHandler= Services::getService("DatabaseManager");
		$dbHandler->query($query,DATAMANAGER_DBID);
		
		$old->loaded(true);
				
		debug::output("... synchronization finished.",DEBUG_SYS2,"DataManager");
	}

	/**
	 * Will return a string containing valid PHP code to generate the schema passed.
	 * @param ref object $schema The {@link Schema} from which to generate code.
	 * @param string $varName The name of the variable in the PHP code that will end up containing the {@link Schema} object.
	 * @return string
	 * @access public 
	 * @static
	 */
	function generatePHPCode($schema, $varName) {
		$v = $varName;
		$t = $schema->getID();
		$c = '';
		$c .= "\$$v = new Schema(";
		$c .= "\n\t\"".addslashes($t)."\",";
		$c .= "\n\t\"".addslashes($schema->getDisplayName())."\",";
		$c .= "\n\t".$schema->getRevision().",";
		$c .= "\n\t\"".addslashes($schema->getDescription)."\",";
		$c .= "\n);";

		$c .= "\n\n";

		// now add the fields
		$labels = $schema->getAllIDs(true);
		foreach ($labels as $label) {
			$f =$schema->getField($label);
			$c .= "\$".$v."->addField(\n";
			$c .= "\tnew SchemaField(\n";
			$c .= "\t\t\"$label\",\n";
			$c .= "\t\t\"".addslashes($f->getDisplayName)."\",\n";
			$c .= "\t\t\"".$f->getType()."\",\n";
			$c .= "\t\t\"".addslashes($f->getDescription())."\",\n";
			$c .= "\t\t".($f->getMultFlag()?"true":"false").",\n";
			$c .= "\t\t".($f->isRequired()?"true":"false").",\n";
			$c .= "\t\t".($f->isActive()?"true":"false")."\n";
			$c .= "\t)\n";
			$c .= ");\n";
		}
		return $c;
	}
}

?>
