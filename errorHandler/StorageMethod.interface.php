<?php

/**
 * Storage Method interface provides functionality to create StorageMethods
 * to handle Storables. A collection of StorageMethods can be used by StorageHandler. 
 *
 * @version $Id: StorageMethod.interface.php,v 1.1 2003/06/30 03:55:38 movsjani Exp $
 * @package harmoni.Storagehandler
 * @copyright 2003
 * @access public
 */

class StorageMethodInterface {

    /**
     * Store a given storable in a given location. This is the basic function that should 
     * be used to put a storable in the location of choice. 
     * @param object Storable $storable The Storable to be stored.
     * @param string $name The name (primary key) under which the storable is to be stored.
	 * @param string $path The path (descriptor) under which the storable is to be stored.
	 * @return boolean True on success False on falure.
     * @access public
     */

    function store($storable,$name,$path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Returns a storable with a given name and path.
     * @param string $name The name of the storable to return.
     * @param string $path The path of the storable to return.
	 * @return object Storable The storable, which can be used to retreive the data. False if no such storable exists.
     * @access public
     */
    function retrieve($name,$path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Deletes the storable with a given name and path.
     * @param string $name The name of the storable to delete.
     * @param string $path The path of the storable to delete.
     * @access public
     */
    function delete($name,$path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Moves a storable with a given name and path to a new location. 
     * For security reasons you have to specify the source name and path
     * rather than the storable itself. It is up to the method to locate
     * the storable before moving it.
     * @param string $sourceName The name of the storable to move.
     * @param string $sourcePath The path of the storable to move.
     * @param string $locationName The new name of the storable.
     * @param string $locationPath The new path of the storable.
     * @access public
     */
    function move($sourceName,$sourcePath,$locationName,$locationPath) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Copies a storable with a given name and path to a specified location. 
     * For security reasons you have to specify the source name and path
     * rather than the storable itself. It is up to the method to locate
     * the storable before moving it.
     * @param string $sourceName The name of the storable to copy.
     * @param string $sourcePath The path of the storable to copy.
     * @param string $locationName The name of the location to copy into.
     * @param string $locationPath The path of the location to copy into.
     * @access public
     */
    function copy($sourceName,$sourcePath,$locationName,$locationPath) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Tells whether a certain storable exists.
     * @param string $name The name of the storable to check.
     * @param string $path The path of the storable to check.
     * @return boolean True if storable exists, false otherwise.
     * @access public
     */
    function exists($name,$path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Get the size of either one Storable or the whole tree within a certain path.
     * @param string $name The name of the storable to get the size of. 
     * If ommited, the returned size will represent the total size of all storables within a certain path.
     * @param string $path The path of the storable(s) to get the size of.
     * @return integer The size of the storable(s).
     * @access public
     */
    function getSizeOf($name="",$path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Delete a whole tree of storables.
     * @param string $path Path to the storable to delete.
     * @access public
     */
    function deleteRecursive($path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * List all the storables within a certain path.
     * @param string $path The path within which the storables should be listed
     * @return array The array of storables found within the path.
     * @access public
     */
    function listInPath($path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Count all the storables within a certain path.
     * @param string $path The path within which the storables should be counted
     * @return integer The number of storables found within the path.
     * @access public
     */
    function getCount($path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>