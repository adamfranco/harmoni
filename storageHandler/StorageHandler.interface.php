<?php

/**
 * A regular mirror defines that only files that would be stored on the primary
 * server for the mirrored path will also be stored on the mirror.
 * 
 * @package harmoni.StorageHandler
 * @const integer MIRROR_REGULAR
 */
define("MIRROR_REGULAR", 1);

/**
 * A deep mirror is like a regular mirror, but it will save ALL files stored
 * under its path, no matter if other methods control sub-paths or not. One can
 * look at it like a "master backup" for a certain path.
 * 
 * @package harmoni.StorageHandler
 * @const integer MIRROR_DEEP
 */
define("MIRROR_DEEP", 1);

/**
 * A primary storage method defines the primary method to be used under any given
 * path. Any path must have ONE defined primary server and as many backups as is
 * desired.
 * 
 * @package harmoni.StorageHandler
 * @const integer STORAGE_PRIMARY
 */
define("STORAGE_PRIMARY", 2);

/**
 * The StorageHandler interface defines the methods required for any StorageHandler class or child.
 * 
 * The StorageHandler is responsible for handling the storage and retrieval of
 * "virtual files" (see {@link StorableInterface Storable}). It is also responsible
 * for keeping track of multiple {@link StorageMethodInterface StorageMethod}'s,
 * each being either a primary or backup method for any given "base path". The
 * structure of the StorageHandler is modelled after a UNIX filesystem, allowing
 * different methods to be used depending on where a file should be stored in
 * your virtual filesystem. This allows primitive load balancing and mirror backups,
 * along with basic organization of data.
 * 
 * @package harmoni.StorageHandler
 * @author Middlebury College, ETS 
 * @version $Id: StorageHandler.interface.php,v 1.1 2003/06/30 18:04:19 gabeschine Exp $
 * @copyright 2003
 */
class StorageHandlerInterface extends ServiceInterface {
    /**
     * Adds a {@link StorageMethodInterface StorageMethod} to the StorageHandler.
     * $path specifies the "mount path" of the method, so that any files that are
     * stored within $path use this method. At least <b>one</b> method must specify
     * "/" as its path. Any path must have ONE primary method, added here.
     * 
     * @param ref $object $method The instantiated {@link StorageMethodInterface StorageMethod}
     * object to add.
     * @param optional $string $path The base path for the method. Default = '/'.
     * @access public 
     * @return void 
     */
    function addMethod(&$method, $path = "/")
    {
        die ("Method <b>" . __FUNCTION__ . "()</b> declared in interface<b> " . __CLASS__ . "</b> has not been overloaded in a child class.");
    } 

    /**
     * Any path can have as many backup methods defined for it as desirable. 
	 * A backup method can be defined as either <b>regular</b> or <b>deep</b>.
	 * See {@link MIRROR_REGULAR} and {@link MIRROR_DEEP} for more information.
	 * Before a backup can be added, at ONE pimary method must be defined for
	 * the path to be backed up.
	 * @use MIRROR_DEEP
	 * @use MIRROR_REGULAR
     * @param ref $object $method The instantiated {@link StorageMethodInterface StorageMethod}
     * object to add.
     * @param optional $string $path The base path for the method. Default = '/'.
	 * @param optional $bakcupType The type of mirrored backup to use. Options: MIRROR_REGULAR, MIRROR_DEEP.
     * @access public 
     * @return void 
     */
    function addBackupMethod(&$method, $path = '/', $backupType = MIRROR_REGULAR)
    {
        die ("Method <b>" . __FUNCTION__ . "()</b> declared in interface<b> " . __CLASS__ . "</b> has not been overloaded in a child class.");
    } 

	/**
	 * Store a file. Takes a {@link StorableInterface Storable}, name, and path
	 * and stores the file under $path/$name in the handler.
	 * @param object $storable The Storable object to store.
	 * @param string $path The path under which to store the file.
	 * @param string $name The name to store under.
	 * @see {@link StorableInterface}
	 * @access public
	 * @return boolean TRUE on success, FALSE otherwise.
	 **/
	function store( $storable, $path, $name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Retrieves a file from the appropriate {@link StorageMethodInterface StorageMethod}.
	 * Will return a storable object.
	 * @param string $path The path leading to the file.
	 * @param string $name The name of the virtual file to retrieve.
	 * @access public
	 * @return object The Storable object associated with $path/$name.
	 **/
	function retrieve( $path, $name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Removes the file specified by $name and $path from all applicable StorageMethods.
	 * @param string $path The path leading to $name.
	 * @param string $name The name of the file to delete.
	 * @access public
	 * @return void
	 **/
	function delete( $path, $name ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Moves a file from one location to another, across StorageMethods if required.
	 * @param string $sourcePath The current path leading to the file.
	 * @param string $sourceName The current name of the file.
	 * @param string $destinationPath The desired destination path for the new file.
	 * @param string $destinationName The desired name of the file.
	 * @access public
	 * @return void
	 **/
	function move( $sourcePath, $sourceName, $destinationPath, $destinationName ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Copies a file from one location to another, across StorageMethods if required.
	 * @param string $sourceName The current name of the file.
	 * @param string $sourcePath The current path leading to the file.
	 * @param string $destinationName The desired name of the new file.
	 * @param string $destinationPath The desired destination path for the new file.
	 * @access public
	 * @return void
	 **/
	function copy( $sourcePath, $sourceName, $destinationPath, $destinationName ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Recursively deletes any files under $path.
	 * @param string $path The path to delete.
	 * @access public
	 * @return void
	 **/
	function deleteRecursive( $path ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Gets the size of either a path or a file. If $name is specified, the size
	 * of the virtual file is retrieved, otherwise, the full size of $path is
	 * retrieved.
	 * @param string $path The path to use.
	 * @param optional string $name The name of the virtual file.
	 * @access public
	 * @return integer The size of the Storable(s).
	 **/
	function getSizeOf( $path, $name = NULL ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Lists all the Storables in $path. If $recursive is TRUE, will recurse
	 * through the entire tree.
	 * @param string $path The path to list.
	 * @param optional boolean $recursive Should we recurse the tree?
	 * @access public
	 * @return array An array of Storables in $path.
	 **/
	function listInPath( $path, $recursive = false ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Checks if $path or $path/$name exists. If only $path is specified, will
	 * check if at least one file is stored within it.
	 * @param string $path The path to check.
	 * @param optional string $name The name of the Storable to check for.
	 * @access public
	 * @return boolean TRUE if found, FALSE otherwise.
	 **/
	function exists( $path, $name = NULL ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Gets the total number of Storables under $path.
	 * @param string $path The path to check under.
	 * @access public
	 * @return integer The number of Storables.
	 **/
	function getCount( $path ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
} 

?>