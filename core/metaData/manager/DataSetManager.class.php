<?php

require_once HARMONI."metaData/manager/DataSet.class.php";

/**
 * The DataSetManager handles the creation, tagging and fetching of DataSets from the database.
 * @package harmoni.datamanager
 * @version $Id: DataSetManager.class.php,v 1.16 2004/01/09 22:40:52 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataSetManager extends ServiceInterface {
	
	var $_idManager;
	var $_dbID;
	var $_typeManager;
	
	function DataSetManager( &$idManager, $dbID, &$dataSetTypeManager) {
		$this->_idManager =& $idManager;
		$this->_dbID = $dbID;
		$this->_typeManager = $dataSetTypeManager;
	}
	
	/**
	*  Fetches and returns an array of DataSet IDs from the database in one Query.
	* @return ref array Indexed by DataSet ID, values are either {@link CompactDataSet}s or {@link FullDataSet}s.
	* @param array $dataSetIDs
	* @param optional bool $editable If TRUE will fetch the DataSets as Editable and with ALL versions. Default: FALSE (will only fetch ACTIVE values).
	* @param optional array $limitTypes An array of {@link HarmoniType}s specifying to ignore any datasets who's type doesn't match one in the array.
	*/
	function &fetchArrayOfIDs( $dataSetIDs, $editable=false, $limitTypes = null ) {
		ArgumentValidator::validate($dataSetIDs, new ArrayValidatorRuleWithRule(new NumericValidatorRule()));
		$dataSetIDs = array_unique($dataSetIDs);
		// first, make the new query
		$query =& new SelectQuery();

		$this->_setupSelectQuery($query);

		$t = array();
		foreach ($dataSetIDs as $dataSetID) {
			$t[] = "dataset_id=".$dataSetID;
		}
		$query->addWhere("(".implode(" OR ", $t).")");
		if (!$editable) $query->addWhere("datasetfield_active=1");
		
		// ok, if we have any limit types, add them to the query
		if (is_array($limitTypes)) {
			$wheres = array();
			foreach ($limitTypes as $type) {
				$id = $this->_typeManager->getIDForType($type);
				if ($id) {
					$wheres[] = "fk_datasettype=$id";
				}
			}
			
			$query->addWhere("(".implode(" OR ", $wheres).")");
		}
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,$this->_dbID);
		
		print "<pre>".MySQL_SQLGenerator::generateSQLQuery($query)."</pre>";
		
		if (!$result) {
			throwError(new UnknownDBError("DataSetManager"));
		}
		
		// now, we need to parse things out and distribute the lines accordingly
		$sets = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$id = $a['dataset_id'];
			if (!$sets[$id]) {
				$sets[$id] = array("count"=>0,"type"=>null,"vcontrol"=>false);
			}
			
			// let's get some basic info from the row
			if (!$sets[$id]["type"] && $a['fk_datasettype'])
				$sets[$id]["type"] = $a['fk_datasettype'];
			
			if (!$sets[$id]["vcontrol"] && $a['dataset_ver_control'])
				$sets[$id]["vcontrol"] = ($a['dataset_ver_control'])?true:false;
			
			$sets[$id]["count"]++;
			$sets[$id][] = $a;
		}
				
		$objs = array();
		foreach (array_keys($sets) as $id) {
			$dataSetTypeDef =& $this->_typeManager->getDataSetTypeDefinitionByID($sets[$id]["type"]);
			$dataSetTypeDef->load(); // get Definition from DB
			
			if ($editable) $newDataSet =& new FullDataSet($this->_idManager,
			$this->_dbID,
			$dataSetTypeDef,
			$sets[$id]["vcontrol"]
			);
			else $newDataSet =& new CompactDataSet($this->_idManager,
			$this->_dbID,
			$dataSetTypeDef,
			$sets[$id]["vcontrol"]
			);
			
			// get rid of these array elements so as not to confuse the dataset.
			unset($sets[$id]["count"], $sets[$id]["vcontrol"], $sets[$id]["type"]);
			$newDataSet->populate($sets[$id]);
			
			$objs[$id] =& $newDataSet;
		}
		
		return $objs;
	}
	
	/**
	*  Fetches a single DataSet from the database, editable if $editable=true.
	* @return ref object
	* @param int $dataSetID
	* @param optional bool $editable
	*/
	function &fetchDataSet( $dataSetID, $editable=false ) {
		$sets =& $this->fetchArrayOfIDs(array($dataSetID), $editable);
		return $sets[$dataSetID];
	}
	
	/**
	*  Initializes a SelectQuery with the complex JOIN structures of the HarmoniDataManager.
	* @return void
	* @param ref object $query
	* @access private
	*/
	function _setupSelectQuery(&$query) {
		// this function sets up the selectquery to include all the necessary tables
		
		$query->addTable("datasetfield");
		$query->addTable("dataset",INNER_JOIN,"fk_dataset=dataset_id");
		$query->addTable("datasettypedef",INNER_JOIN,"fk_datasettypedef=datasettypedef_id");
//		$query->addTable("datasettype",INNER_JOIN,"dataset.fk_datasettype=datasettype_id");
		
		$dataTypeManager =& Services::getService("DataTypeManager");
		$list = $dataTypeManager->getRegisteredTypeClasses();
		
		foreach ($list as $type) {
			eval("$type::alterQuery(\$query);");
		}
		
		/* dataset table */
		$query->addColumn("dataset_id");
		$query->addColumn("dataset_created");
		$query->addColumn("dataset_active");
		$query->addColumn("dataset_ver_control");
		$query->addColumn("fk_datasettype","","dataset"); //specify table to avoid ambiguity
		
		/* datasetfield table */
		$query->addColumn("datasetfield_id");
		$query->addColumn("datasetfield_index");
		$query->addColumn("datasetfield_active");
		$query->addColumn("datasetfield_modified");
		$query->addColumn("fk_data");
		
		/* datasettypedef table */
		$query->addColumn("datasettypedef_id");
		$query->addColumn("datasettypedef_label");
		
	}
	
	/**
	*  Returns a new {@link FullDataSet} object that can be inserted into the database.
	* @return ref object
	* @param ref object $type The {@link HarmoniType} object that refers to the DataSetTypeDefinition to associated this DataSet with.
	* @param optional bool $verControl Specifies if the DataSet should be created with Version Control. Default=no.
	*/
	function &newDataSet( &$type, $verControl = false ) {
		if (!$this->_typeManager->dataSetTypeExists($type)) {
			throwError ( new Error("DataSetManager::newDataSet('".OKITypeToString($type)."') - 
			could not create new DataSet because the requested type does not seem to be registered
			with the DataSetTypeManager.","DataSetManager",true));
		}
		
		// ok, let's make a new one.
		$typeDef =& $this->_typeManager->getDataSetTypeDefinition($type);
		// load from the DB
		$typeDef->load();
		debug::output("Creating new DataSet of type '".OKITypeToString($type)."', which allows fields: ".implode(", ",$typeDef->getAllLabels()),DEBUG_SYS4,"DataSetManager");
		$newDataSet =& new FullDataSet($this->_idManager, $this->_dbID, $typeDef, $verControl);
		return $newDataSet;
	}
	
	/**
	* @return array
	* @param ref object $type The {@link HarmoniType} to look for.
	*  Returns an array of DataSet IDs that are of the DataSetTypeDefinition type $type.
	*/
	function getDataSetIDsOfType(&$type) {
		// we're going to get all the IDs that match a given type.
		
		$query =& new SelectQuery();
		$query->addTable("dataset");
		$query->addTable("datasettype",INNER_JOIN,"datasettype_id=fk_datasettype");
		
		$query->addColumn("dataset_id");
		
		$query->setWhere("datasettype_domain='".addslashes($type->getDomain())."' AND ".
						"datasettype_authority='".addslashes($type->getAuthority())."' AND ".
						"datasettype_keyword='".addslashes($type->getKeyword())."'");
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,$this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("DataSetManager") );
			return false;
		}
		
		$array = array();
		while ($result->hasMoreRows()) {
			$array[] = $result->field(0);
			$result->advanceRow();
		}
		
		return $array;
	}
	
	function start() {}
	function stop() {}
	
}

?>