<?php

require_once(HARMONI.'storageHandler/StorageMethod.interface.php');
require_once(HARMONI.'storageHandler/Storables/DatabaseStorable.class.php');

/**
 * Database Storage Method interface provides functionality to store and handle
 * Storables on a file system. To be used by StorageHandler.
 *
 * Note: All methods assume the path parameter has a trailing slash ('/'). Otherwise
 * all recursive functions may get hold of paths that are unrelated.
 *
 * @version $Id: DatabaseStorageMethod.class.php,v 1.2 2003/07/16 16:51:35 movsjani Exp $
 * @package harmoni.storage.methods
 * @copyright 2003
 * @access public
 */

class DatabaseStorageMethod extends StorageMethodInterface {

	/**
	 * @variable databaseStorableDataContainer The storage specifications (dbIndex, tableName, etc.) within 
	 * which all storables are to be stored. Look at the source for details.
	 */
	var $_parameters;

	var $_dbHandler;

    /**
     * Constructor. Create new FileStorageMethod.
	 * @param object databaseStorableDataContainer The data container that contains
	 * the following arguments: <code>dbIndex</code>
	 * <code>dbTable</code>, <code>pathColumn</code>, <code>nameColumn</code>,
	 * <code>sizeColumn</code>, and <code>dataColumn</code>.
	 * @return boolean True if was able to connect to the database, false if couldn't.
	 * @access public
	 */

	function DatabaseStorageMethod($databaseStorableDataContainer) {
        // validate the type of the parameter (dbSDC)
        $extendsRule =& new ExtendsValidatorRule("DatabaseStorableDataContainer");
		ArgumentValidator::validate($databaseStorableDataContainer, $extendsRule, true);
        // now, validate the data container itself
        $databaseStorableDataContainer->checkAll();

        $this->_parameters = $databaseStorableDataContainer;

		Services::requireService("DBHandler");
		$this->_dbHandler =& Services::getService("DBHandler");

		if(!$this->_dbHandler->isConnected($this->_parameters->get("dbIndex")))
            return $this->_dbHandler->pConnect($this->_parameters->get("dbIndex"));
	}

    /**
     * Store a given storable in a given location. This is the basic function that should 
     * be used to put a storable in the location of choice. 
     * @param object Storable $storable The Storable to be stored.
     * @param string $name The name (primary key) under which the storable is to be stored.
	 * @param string $path The path (descriptor) under which the storable is to be stored.
     * @access public
     */

    function store($storable,$path,$name) { 
        $extendsRule =& new ExtendsValidatorRule("FileStorable");
		ArgumentValidator::validate($storable, $extendsRule, true);

		Services::requireService("DBHandler");
		$dbHandler =& Services::getService("DBHandler");

		// create a new queue of queries to execuete
		$queryQueue =& new Queue();

		// if the row does not exist in the database - create it first.
		if(!$this->exists($path,$name)){

			$query =& new InsertQuery();
			
			$query->setTable($this->_parameters->get("dbTable"));

			$query->setColumns(array($this->_parameters->get("nameColumn"),$this->_parameters->get("pathColumn")));

			$query->addRowOfValues(array("'$name'","'$path'"));
			$queryQueue->add($query);
		}

		// now add the data. If there is no Size Column (Data Column must be there imperatively), ommit it.

		$query =& new UpdateQuery();
		$query->setTable($this->_parameters->get("dbTable"));

		$sizeColumn = $this->_parameters->get("sizeColumn");
		$size = $storable->getSize();
		$data = $storable->getData();

		if(!empty($sizeColumn)){
			$query->setColumns(array($this->_parameters->get("dataColumn"),$sizeColumn));
			$query->setValues(array("'$data'",$size));
	
		}
		else{
			$query->setColumns(array($this->_parameters->get("dataColumn")));
			$query->setValues(array("'$data'"));
		}

		$query->setWhere($this->_parameters->get("nameColumn")." = '$name' AND ".
						 $this->_parameters->get("pathColumn")." = '$path'");

		$queryQueue->add($query);
		$result =& $this->_dbHandler->queryQueue($queryQueue,$this->_parameters->get("dbIndex"));
	}

    /**
     * Returns a storable with a given name and path.
     * @param string $name The name of the storable to return.
     * @param string $path The path of the storable to return.
	 * @return object DatabaseStorable A reference to the storable, which can be used to retrieve the data. False if no such storable exists.
     * @access public
     */
    function &retrieve($path,$name) { 
		if ($this->exists($path,$name)){
			$storable =& new DatabaseStorable($this->_parameters,$path,$name);
			return $storable;
		}
		else return false;
	}

    /**
     * Deletes the storable with a given name and path.
     * @param string $name The name of the storable to delete.
     * @param string $path The path of the storable to delete.
     * @access public
     */
    function delete($path,$name) { 
		if($this->exists($path,$name)){
			$query =& new DeleteQuery();
			$query->setTable($this->_parameters->get("dbTable"));
			$query->setWhere($this->_parameters->get("nameColumn")."= '$name' AND ".
							 $this->_parameters->get("pathColumn")."= '$path'");

			$this->_dbHandler->query($query,$this->_parameters->get("dbIndex"));
		}
	}

    /**
     * Tells whether a certain storable exists.
     * @param string $name The name of the storable to check.
     * @param string $path The path of the storable to check.
     * @return boolean True if storable[s] exist[s], false otherwise.
     * @access public
     */
    function exists($path,$name=null) { 

		$query =& new SelectQuery();
		$query->addTable($this->_parameters->get("dbTable"));
		$query->addColumn($this->_parameters->get("pathColumn"));

		$query->addWhere($this->_parameters->get("pathColumn")." = '$path.'");
		if($name!=null)
			$query->addWhere($this->_parameters->get("nameColumn")." = '$name'",_AND);

		$result =& $this->_dbHandler->query($query,$this->_parameters->get("dbIndex"));

		if($result->getNumberOfRows()>0)
			return true;
		else
			return false;
	}

    /**
     * Get the size of either one Storable or the whole tree within a certain path.
     * @param string $name The name of the storable to get the size of. 
     * If ommited, the returned size will represent the total size of all storables within a certain path.
     * @param string $path The path of the storable(s) to get the size of.
     * @return integer The size of the storable(s).
     * @access public
     */
    function getSizeOf($path,$name=null) { 
		$query =& new SelectQuery();

		$query->addTable($this->_parameters->get("dbTable"));
		$query->addColumn($this->_parameters->get("pathColumn"));
		$query->addColumn($this->_parameters->get("nameColumn"));
		
		if($name!=null)
			$query->addWhere($this->_parameters->get("pathColumn")." = '$path' AND ".$this->_parameters->get("nameColumn")." = '$name'");
		else
			$query->addWhere($this->_parameters->get("pathColumn")." LIKE '$path%'");

		$result =& $this->_dbHandler->query($query,$this->_parameters->get("dbIndex"));

		$totalsize = 0;
		while($result->hasMoreRows()){
			$path_value = $result->field($this->_parameters->get("pathColumn"));
			$name_value = $result->field($this->_parameters->get("nameColumn"));
			$storable =& $this->retrieve($path_value,$name_value);
			$totalsize += $storable->getSize();
			$result->advanceRow();
		}

		return $totalsize;
	}

    /**
     * Delete a whole tree of storables.
     * @param string $path Path to the storable to delete.
     * @access public
     */
    function deleteRecursive($path) {
		$query =& new DeleteQuery();
		$query->setTable($this->_parameters->get("dbTable"));
		$query->setWhere($this->_parameters->get("pathColumn")." LIKE '$path%'");

		$this->_dbHandler->query($query,$this->_parameters->get("dbIndex"));
	}

    /**
     * List all the storables within a certain path.
     * @param string $path The path within which the storables should be listed
     * @return array The array of storables found within the path.
     * @access public
     */
    function listInPath($path,$recursive=true) {
		$query =& new SelectQuery();

		$query->addTable($this->_parameters->get("dbTable"));
		$query->addColumn($this->_parameters->get("pathColumn"));
		$query->addColumn($this->_parameters->get("nameColumn"));
		
		if($recursive)
			$query->addWhere($this->_parameters->get("pathColumn")." LIKE '$path%'");
		else
			$query->addWhere($this->_parameters->get("pathColumn")." = '$path'");

		$result =& $this->_dbHandler->query($query,$this->_parameters->get("dbIndex"));

		$storables = array();
		while($result->hasMoreRows()){
			$path_value = $result->field($this->_parameters->get("pathColumn"));
			$name_value = $result->field($this->_parameters->get("nameColumn"));
			$storables[] =& $this->retrieve($path_value,$name_value);
			$result->advanceRow();
		}

		return $storables;
	}

    /**
     * Count all the storables within a certain path.
     * @param string $path The path within which the storables should be counted
     * @return integer The number of storables found within the path.
     * @access public
     */
    function getCount($path,$recursive=true) { 
		$query =& new SelectQuery();

		$query->addTable($this->_parameters->get("dbTable"));
		$query->addColumn($this->_parameters->get("pathColumn"));
		
		if($recursive)
			$query->addWhere($this->_parameters->get("pathColumn")." LIKE '$path%'");
		else
			$query->addWhere($this->_parameters->get("pathColumn")." = '$path'");

		$result =& $this->_dbHandler->query($query,$this->_parameters->get("dbIndex"));

		return $result->getNumberOfRows();
	}

}

?>