<?php

/**
 * Storage Method interface provides functionality to create StorageMethods
 * to handle Storables. A collection of StorageMethods can be used by StorageHandler. 
 *
 * @package harmoni.storage
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorageMethod.interface.php,v 1.5 2007/09/04 20:25:51 adamfranco Exp $
 */

class StorageMethodInterface {

    /**
     * Store a given storable in a given location. This is the basic function that should 
     * be used to put a storable in the location of choice. 
     * @param ref object Storable $storable The Storable to be stored.
	 * @param string $path The path (descriptor) under which the storable is to be stored.
     * @param string $name The name (primary key) under which the storable is to be stored.
	 * @return boolean True on success False on falure.
     * @access public
     */

    function store($storable,$path,$name) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Returns a storable with a given name and path.
	 * @param string $path The path of the storable to return.
     * @param string $name The name of the storable to return.
	 * @return object Storable The storable, which can be used to retreive the data. False if no such storable exists.
     * @access public
     */
    function retrieve($path,$name) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Deletes the storable with a given name and path.
	 * @param string $path The path of the storable to delete.
     * @param string $name The name of the storable to delete.
     * @access public
     */
    function delete($path,$name) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * *Deprecated* Moves a storable with a given name and path to a new location. 
     * For security reasons you have to specify the source name and path
     * rather than the storable itself. It is up to the method to locate
     * the storable before moving it.
	 * @param string $sourcePath The path of the storable to move.
     * @param string $sourceName The name of the storable to move.
     * @param string $locationPath The new path of the storable.
     * @param string $locationName The new name of the storable.
	 * @deprecated Move functionality is handled by StorageHandler now.
     * @access public
     */
    function move($sourcePath,$sourceName,$locationPath,$locationName) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * *Deprecated* Copies a storable with a given name and path to a specified location. 
     * For security reasons you have to specify the source name and path
     * rather than the storable itself. It is up to the method to locate
     * the storable before moving it.
	 * @param string $sourcePath The path of the storable to copy.
     * @param string $sourceName The name of the storable to copy.
	 * @param string $locationPath The path of the location to copy into.
     * @param string $locationName The name of the location to copy into.
	 * @deprecated Copy functionality is handled by StorageHandler now.
     * @access public
     */
    function copy($sourcePath,$sourceName,$locationPath,$locationName) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Tells whether a certain storable exists.
	 * @param string $path The path of the storable to check.
     * @param string $name The name of the storable to check.
     * 
     * @return boolean True if storable exists, false otherwise.
     * @access public
     */
    function exists($path,$name=null) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Get the size of either one Storable or the whole tree within a certain path.
	 * @param string $path The path of the storable(s) to get the size of.
     * @param string $name The name of the storable to get the size of. 
     * If ommited, the returned size will represent the total size of all storables within a certain path.
     * 
     * @return integer The size of the storable(s).
     * @access public
     */
    function getSizeOf($path,$name=null) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Delete a whole tree of storables.
     * @param string $path Path to the storable to delete.
     * @access public
     */
    function deleteRecursive($path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * List all the storables within a certain path.
     * @param string $path The path within which the storables should be listed
     * @param boolean $recursive Whether to list files only in the path (recursive=false) or in and under it (recursive=true).
     * @return array The array of storables found within the path.
     * @access public
     */
    function listInPath($path,$recursive=true) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Count all the storables within a certain path.
     * @param string $path The path within which the storables should be counted
     * @param optional boolean $recursive Whether to count files only in the path (recursive=false) or in and under it (recursive=true).
     * @return integer The number of storables found within the path.
     * @access public
     */
    function getCount($path,$recursive=true) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>