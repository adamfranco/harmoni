<?php

require_once(HARMONI.'storageHandler/Storable.abstract.php');
require_once(HARMONI.'storageHandler/Storables/DatabaseStorableDataContainer.class.php');

/**
 * A DatabaseStorable is like a FileStorable, with the exception that all data
 * is stored in a database, and not on a file system.
 *
 * @version $Id: DatabaseStorable.class.php,v 1.5 2003/07/16 19:08:55 movsjani Exp $
 * @package harmoni.storage.storables
 * @copyright 2003
 * @access public
 */

class DatabaseStorable extends AbstractStorable {

	//all the information about the storable.
	var $_parameters;

	/**
	 * The constructor takes a DataStorableDataContainer.
	 * @param object databaseStorableDataContainer The data container that contains
	 * the following arguments: <code>dbIndex</code>
	 * <code>dbTable</code>, <code>pathColumn</code>, <code>nameColumn</code>,
	 * <code>sizeColumn</code>, and <code>dataColumn</code>.
	 * @access public
	 */
	function DatabaseStorable($databaseStorableDataContainer,$path,$name) {
		// validate the type of the parameter (dbSDC)
		$extendsRule =& new ExtendsValidatorRule("DatabaseStorableDataContainer");
		ArgumentValidator::validate($databaseStorableDataContainer, $extendsRule, true);
		// now, validate the data container itself
		$databaseStorableDataContainer->checkAll();

		$this->_parameters = $databaseStorableDataContainer;
		$this->_name = $name;
		$this->_path = $path;
	}

    /**
     * Gets the data content of the storable.
     * @return string Data content of the storable.
     * @access public
     */
    function getData() {
		Services::requireService("DBHandler");
		$dbHandler =& Services::getService("DBHandler");
		
		$query =& new SelectQuery();

		$query->addTable($this->_parameters->get("dbTable"));

		$query->addColumn($this->_parameters->get("dataColumn"));

		$name = addslashes($this->_name); $path = addslashes($this->_path);
		$query->setWhere($this->_parameters->get("nameColumn")." = '$name' AND ".
						 $this->_parameters->get("pathColumn")." = '$path'");

		if(!$dbHandler->isConnected($this->_parameters->get("dbIndex")))   
			$dbHandler->connect($this->_parameters->get("dbIndex"));
		$result =& $dbHandler->query($query,$this->_parameters->get("dbIndex"));

		
		$data = $result->field($this->_parameters->get("dataColumn"));

		return $data;
	}

    /**
     * Gets the size of the data content of the storable.
     * @return integer Size of the storable in bytes.
     * @access public
     */
    function getSize() { 
		Services::requireService("DBHandler");
		$dbHandler =& Services::getService("DBHandler");
		
		$query =& new SelectQuery();

		$query->addTable($this->_parameters->get("dbTable"));

		$sizeColumn = $this->_parameters->get("sizeColumn");
		$dataColumn = $this->_parameters->get("dataColumn");
		
		$selectColumn = (empty($sizeColumn))?$sizeColumn:$dataColumn;

		$query->addColumn($selectColumn);

		$name = addslashes($this->_name); $path = addslashes($this->_path);
		$query->setWhere($this->_parameters->get("nameColumn")." = '$name' AND ".
						 $this->_parameters->get("pathColumn")." = '$path'");

		if(!$dbHandler->isConnected($this->_parameters->get("dbIndex")))
			$dbHandler->connect($this->_parameters->get("dbIndex"));
		$result =& $dbHandler->query($query,$this->_parameters->get("dbIndex"));

		$data = $result->field($selectColumn);

		if($selectColumn == $dataColumn)
			$data = strlen((string)$data);

		return $data;
	}
	
}

?>