<?php
require_once(HARMONI."storageHandler/StorageHandler.interface.php");

/**
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
 * @version $Id: StorageHandler.class.php,v 1.1 2003/06/30 22:49:50 gabeschine Exp $
 * @copyright 2003
 */
class StorageHandler extends StorageHandlerInterface {
	/**
	 * @access private
	 * @var integer $_num The total number of methods we have registered.
	 **/
	var $_num;

	/**
	 * @access private
	 * @var array $_pathsRegistered An array of registered paths.
	 **/
	var $_pathsRegistered;
	
	/**
	 * @access private
	 * @var array $_paths An array of paths associated with methods.
	 **/
	var $_paths;
	
	/**
	 * @access private
	 * @var array $_methods An array of method objects.
	 **/
	var $_methods;
	
	/**
	 * @access private
	 * @var array $_types An array of storage types associated with methods.
	 **/
	var $_types;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function StorageHandler() {
		$this->_num = 0;
		$this->_pathsRegistered = array();
		$this->_paths = array();
		$this->_methods = array();
		$this->_types = array();
	}
	
	
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
		$this->_chopPath($path);
				
		// check if we have a "/" path defined.
		if ($path != '/' && !$this->_pathDefined('/')) {
			// this is bad.. the user needs to specify ONE '/' method
			// before defining any more
			throw(new Error("StorageHandler::addMethod() - You MUST add ONE method with '/' as the path before you can add any others (such as '$path', which was just attempted).","StorageHandler",true));
		}
		
		// add the method to our private arrays, if it's valid
		if (!$this->_pathDefined($path)) {
			// ok, this path hasn't been defined before
			$this->_addMethod($method, $path, STORAGE_PRIMARY);
		} else
			throw(new Error("StorageHandler::addMethod - can not add another primary storage method for '$path'. One already exists.","StorageHandler",true));
    }

    /**
     * Any path can have as many backup methods defined for it as desirable. 
	 * A backup method can be defined as either <b>shallow</b> or <b>deep</b>.
	 * See {@link MIRROR_SHALLOW} and {@link MIRROR_DEEP} for more information.
	 * Before a backup can be added, at ONE pimary method must be defined for
	 * the path to be backed up.
	 * @use MIRROR_DEEP
	 * @use MIRROR_SHALLOW
     * @param ref $object $method The instantiated {@link StorageMethodInterface StorageMethod}
     * object to add.
     * @param optional $string $path The base path for the method. Default = '/'.
	 * @param optional $bakcupType The type of mirrored backup to use. Options: MIRROR_SHALLOW, MIRROR_DEEP.
     * @access public 
     * @return void 
     */
    function addBackupMethod(&$method, $path = '/', $backupType = MIRROR_SHALLOW)
    {
		$this->_chopPath($path);
		
		// check to make sure we have a primary method defined for this path
		if (!$this->_hasPrimary($path))
			throw( new Error("StorageHandler::addBackupMethod - can not add a backup method for '$path' because it does not have a primary method defined yet!","StorageHandler",true));
		
		// ok, let's add this bugger
		$this->_addMethod($method, $path, $backupType);
    } 
	
	/**
	 * Chops the trailing '/' off a path.
	 * @param ref string $path The pathname.
	 * @access private
	 * @return string The new pathname.
	 **/
	function _chopPath( &$path ) {
		// lob off a trailing '/' on the path if it has one
		$newpath = ereg_replace("([^[:blank:]])+/$","",$path);
		$path =& $newpath;
	}
	
	
	/**
	 * Adds a method. See notes for addMethod() and addBackupMethod() for more info.
	 * @param ref $method The method object.
	 * @param string $path The pathname.
	 * @param integer $type The method type.
	 * @access private
	 * @return void
	 **/
	function _addMethod(&$method, $path, $type) {
        ArgumentValidator::validate($method,new ExtendsValidatorRule("StorageMethodAbstract"),true);
		ArgumentValidator::validate($path,new StringValidatorRule,true);
		// make sure it's a valid path
		ArgumentValidator::validate($path,new RegexValidatorRule("^/(([A-Za-z0-9_.-]+)/?)*$"));
		
		ArgumentValidator::validate($type,new ChoiceValidatorRule(STORAGE_PRIMARY,MIRROR_SHALLOW,MIRROR_DEEP));
		
		// ok, we should be good
		$id = $this->_num;
		$this->_methods[$id] =& $method;
		$this->_paths[$id] = $path;
		$this->_types[$id] = $type;
		if (!$this->_pathDefined($path)) $this->_pathsRegistered[] = $path;
		
		// done
		$this->_num++;
	}
	
	/**
	 * Check if $path has been defined before.
	 * @param string $path The pathname.
	 * @access private
	 * @return boolean TRUE if defined, FALSE otherwise.
	 **/
	function _pathDefined( $path ) {
		return in_array($path,$this->_pathsRegistered);
	}
	
	/**
	 * Checks to see if $path has a primary storage type.
	 * @param string $path The pathname.
	 * @access public
	 * @return boolean TRUE if it does, FALSE otherwise.
	 **/
	function _hasPrimary( $path ) {
		if (!$this->_pathDefined($path)) return false;
		$ids = $this->_getIDs($path);
		foreach ($ids as $id)
			if ($this->_types[$id] == STORAGE_PRIMARY) return true;
		return false;
	}
	
	/**
	 * Returns an array of indexes for methods that use $path.
	 * @param string $path The pathname.
	 * @access private
	 * @return array An array of numerical indexes.
	 **/
	function _getIDs( $path ) {
		$ids = array();
		for($i = 0; $i < $this->_num; $i++) {
			if ($this->_paths[$i] == $path) $ids[] = $i;
		}
		return $ids;
	}
	
	/**
	 * Gets the primary method for $path.
	 * @param string $path The path.
	 * @access private
	 * @return integer The Method ID for $path.
	 **/
	function _getPrimaryForPath( $path ) {
		// first, let's just check if we have a method defined specifically
		// for $path... that would save us some time
		if ($this->_pathDefined($path)) {
			$ids = $this->_getIDs($path);
			foreach ($ids as $id) {
				if ($this->_types[$id] == STORAGE_PRIMARY) return $id;
			}
			// if we get here, something is very wrong...
			// it means that we have a method registered specifically for $path,
			// but that none of them are primary.. this is very bad. someone
			// messed up.
			throw( new Error("StorageHandler::_getPimaryForPath('$path') - For some reason, a method is defined specifically for this path, but none of them seem to be primary. Something went wrong.","StorageHandler",true));
		}
		// ok, so let's just go through all the methods and see if we overlap
		// anywhere
		$level = 0;
		$primaryID = -1;
		foreach ($this->_types as $id=>$type) {
			if ($type == STORAGE_PRIMARY) { // this is a primary type... let's check it
				$methodPath = $this->_paths[$id];
				if (ereg("^$methodPath",$path)) { // looks like we have a match-up
					// now let's see how deep this bad-boy is
					$methodLevel = $this->_getLevel($methodPath);
					// if we're deeper than the last one, use it
					if ($methodLevel > $level) {
						$level = $methodLevel;
						$primaryID = $id;
					}
				}
			}
			unset($methodPath,$methodLevel);
		}
		// if we still don't have an ID, it means nobody ever added any
		// storage methods... shame on them!
		if ($primaryID == -1) {
			throw(new Error("StorageHandler::_getPrimaryForPath('$path') - Could not find a primary StorageMethod for '$path'. It is very likely that no storage methods were ever added to the Handler!","StorageHandler",true));
		}
		return $primaryID;
	}
	
	/**
	 * Returns how deep $path is in the hierarchy.
	 * @param string $path The pathname.
	 * @access private
	 * @return integer The level.
	 **/
	function _getLevel($path) {
		// root is level 0
		if ($path == '/') return 0;
		$choppedPath = $methodLevel = ereg_replace("^/","",$methodPath);
		$array = explode("/",$choppedPath);
		$count = count($array);
		return $count;
	}
	
	
	/**
	 * Gets all the methods that serve as backups for $path.
	 * @param string $path The path.
	 * @access private
	 * @return array An array of ID's that are backups for $path.
	 **/
	function _getBackupsForPath( $path ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Translates an absolute StorageHandler path into a relative one for
	 * a specific storage method specified by $id.
	 * @param integer $id The StorageMethod's ID.
	 * @param string $path The path to translate.
	 * @access private
	 * @return string A new relative path for the method.
	 **/
	function _translatePathForMethod( $id, $path ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	
	/**
	 * Store a file. Takes a {@link StorableInterface Storable}, name, and path
	 * and stores the file under $path/$name in the handler.
	 * @param ref object $storable The Storable object to store.
	 * @param string $path The path under which to store the file.
	 * @param string $name The name to store under.
	 * @see {@link StorableInterface}
	 * @access public
	 * @return boolean TRUE on success, FALSE otherwise.
	 **/
	function store( &$storable, $path, $name) {
		$this->_chopPath($path);
		
		// validate all the parameters
		$s = &new StringValidatorRule;
		ArgumentValidator::validate($storable,new ExtendsValidatorRule("StorableAbstract"));
		ArgumentValidator::validate($path,$s);
		ArgumentValidator::validate($name,$s);
		// done
		
		$id = $this->_getPrimaryForPath($path);
		$backupIDs = $this->_getBackupsForPath($path);
		
		// store on the primary, and then the backups
		$primaryError = $this->_methods[$id]->store( & $storable,
									$this->_translateAbsolutePathForMethod($id,$path),
									$name);

		$backupError = true; // assume we're good
		foreach ($backupIDs as $backupID) {
			$backupError &= $this->_methods[$backupID]->store( &$storable,
													$this->_translatePathForMethod($backupID,$path),
													$name);
		}
		
		// return false if both are not TRUE (no error)
		return $backupError & $primaryError;
	}
	
	/**
	 * Retrieves a file from the appropriate {@link StorageMethodInterface StorageMethod}.
	 * Will return a storable object.
	 * @param string $path The path leading to the file.
	 * @param string $name The name of the virtual file to retrieve.
	 * @access public
	 * @return object The Storable object associated with $path/$name. False if
	 * it could not be found.
	 **/
	function &retrieve( $path, $name) {
		$this->_chopPath($path);
		
		// validate all arguments
		$s = &new StringValidatorRule;
		ArgumentValidator::validate($path,$s);
		ArgumentValidator::validate($name,$s);
		
		// first, let's try and get $name from the primary method
		$id = $this->_getPrimaryForPath($path);
		$storable = &$this->_methods[$id]->retrieve($this->_translatePathForMethod($path),$name);
		if ($storable} return $storable;
		unset($storable);
		
		// hmm, that didn't work... let's try a backup server, or two, or more
		$ids = $this->_getBackupsForPath($path);
		foreach ($ids as $id) {
			$storable = &$this->_methods[$id]->retrieve($this->_translatePathForMethod($path),$name);
			if ($storable) // yay!
				return $storable;
			// ugh...
			unset($storable);
		}
		return false;
	}
	
	/**
	 * Removes the file specified by $name and $path from all applicable StorageMethods.
	 * @param string $path The path leading to $name.
	 * @param string $name The name of the file to delete.
	 * @access public
	 * @return void
	 **/
	function delete( $path, $name ) {
		
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