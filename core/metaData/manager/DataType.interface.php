<?php

/**
 * The DataTypeInterface defines the required functions for any DataType for use within the
 * {@link HarmoniDataManager}.
 * @package harmoni.datamanager.interfaces
 * @version $Id: DataType.interface.php,v 1.7 2004/01/07 21:20:19 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataTypeInterface {
	
	/**
	 * Returns a string value representation of the data.
	 * @access public
	 * @return string
	 */
	function toString() { }
	
	/**
	 * Takes a DataType of the same class and compares to see if it is equal.
	 * @access public
	 * @return bool
	 */
	function isEqual( &$dataType ) { }
	
	/**
	 * Returns the ID in the database of the DataType object.
	 * @access public
	 * @return int
	 */
	function getID() { }
	
	/**
	 * Inserts a new row into the Database with the data contained in the object.
	 * @access public
	 * @return void
	 */
	function insert() { }
	
	/**
	 * Uses the existing database ID available from getID() and updates the database row with
	 * new data.
	 * @access public
	 * @return void
	 */
	function update() { }
	
	/**
	 * Decides whether to call insert() or update(), usually depending on if an ID has been
	 * set already or not.
	 * @access public
	 * @return void
	 */
	function commit() { }
	
	/**
	 * Takes an existing {@link SelectQuery} and adds a table join and some columns so that
	 * when it is executed the actual data can be retrieved from the row. The join condition must
	 * be "fk_data = data_id_field", since the field "fk_data" is already part of the DataManager's
	 * table structure.
	 * @access public
	 * @return void
	 */
	function alterQuery( &$query ) { }
	
	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the DataType object with the appropriate data.
	 * @param array $dbRow
	 * @access public
	 * @return void
	 */
	function populate( $dbRow ) { }
	
	/**
	 * Takes a DataType object of the same class and "steals" its value.
	 * @param ref object A {@link DataType} object.
	 * @access public
	 * @return void
	 */
	function takeValue(&$fromObject) { }
	
	/**
	 * Creates a new DataType object of the same class containing the same data.
	 * @access public
	 * @return ref object The new {@link DataType} object.
	 */
	function &clone() { }
	
	/**
	 * Takes an idManager and database ID and stores them within the object. The IDManager is used
	 * upon insert() to generate a new unique ID. The dbID is stored so that upon update() the correct
	 * row will be modified.
	 * @param ref object A reference to the {@link IDManager} object.
	 * @param int $dbID The DB index in the {@link DBHandler} to use.
	 * @access public
	 * @return void
	 */
	function setup(&$idManager, $dbID) { }
	
	/**
	 * Sets the database id to $id. Used upon calls to update().
	 * @param int $id
	 * @access public
	 * @return void
	 */
	function setID( $id ) { }
	
	/**
	 * Deletes the data row from the appropriate table, if an ID has been set.
	 * @access public
	 * @return void
	 */
	function prune() { }
	
}

?>