<?php

require_once(HARMONI.'storageHandler/Storable.abstract.php');
require_once(HARMONI.'storageHandler/Storables/DatabaseStorableDataContainer.class.php');

/**
 * A DatabaseStorable is like a FileStorable, with the exception that all data
 * is stored in a database, and not on a file system.
 *
 * @version $Id: DatabaseStorable.class.php,v 1.2 2003/07/10 02:34:21 gabeschine Exp $
 * @package harmoni.storage.storables
 * @copyright 2003
 * @access public
 */

class DatabaseStorable extends AbstractStorable {


	/**
	 * The constructor takes a DataStorableDataContainer.
	 * @param object databaseStorableDataContainer The data container that contains
	 * the following arguments: <code>dbIndex</code>, <code>dbName</code>,
	 * <code>dbTable</code>, <code>pathColumn</code>, <code>nameColumn</code>,
	 * <code>sizeColumn</code>, and <code>dataColumn</code>.
	 * @access public
	 */
	function DatabaseStorable($databaseStorableDataContainer) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("DatabaseStorableDataContainer");
		ArgumentValidator::validate($databaseStorableDataContainer, $extendsRule, true);
		// ** end of parameter validation
		
		// now, validate the data container
		$databaseStorableDataContainer->checkAll();
	}

    /**
     * Gets the data content of the storable.
     * @return string Data content of the storable.
     * @access public
     */
    function getData() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Gets the size of the data content of the storable.
     * @return integer Size of the storable in bytes.
     * @access public
     */
    function getSize() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
}

?>