<?php
require_once(HARMONI . "storageHandler/StorageHandler.interface.php");
require_once(HARMONI . "storageHandler/Storables/VirtualStorable.class.php");

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
* @package harmoni.storage
* @author Middlebury College, ETS 
* @version $Id: StorageHandler.class.php,v 1.10 2003/07/11 00:20:25 gabeschine Exp $
* @copyright 2003
*/
class StorageHandler extends StorageHandlerInterface {
	/**
	* 
	* @access private 
	* @var integer $_num The total number of methods we have registered.
	*/
	var $_num;

	/**
	* 
	* @access private 
	* @var array $_pathsRegistered An array of registered paths.
	*/
	var $_pathsRegistered;

	/**
	* 
	* @access private 
	* @var array $_paths An array of paths associated with methods.
	*/
	var $_paths;

	/**
	* 
	* @access private 
	* @var array $_methods An array of method objects.
	*/
	var $_methods;

	/**
	* 
	* @access private 
	* @var array $_types An array of storage types associated with methods.
	*/
	var $_types;

	/**
	* The constructor.
	* 
	* @access public 
	* @return void 
	*/
	function StorageHandler()
	{
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
	* @param ref object $method The instantiated {@link StorageMethodInterface StorageMethod}
	* object to add.
	* @param optional string $path The base path for the method. Default = '/'.
	* @access public 
	* @return void 
	*/
	function addMethod(& $method, $path = "/")
	{
		$this->_checkPath($path); 
		// check if we have a "/" path defined.
		if ($path != '/' && !$this->_pathDefined('/')) {
			// this is bad.. the user needs to specify ONE '/' method
			// before defining any more
			throwError(new Error("StorageHandler::addMethod - You MUST add ONE method with '/' as the path before you can add any others (such as '$path', which was just attempted).", "StorageHandler", true));
		} 
		// add the method to our private arrays, if it's valid
		if (!$this->_pathDefined($path)) {
			// ok, this path hasn't been defined before
			$this->_addMethod($method, $path, STORAGE_PRIMARY);
		}else
			throwError(new Error("StorageHandler::addMethod - can not add another primary storage method for '$path'. One already exists.", "StorageHandler", true));
	}

	/**
	* Any path can have as many backup methods defined for it as desirable. 
	* A backup method can be defined as either <b>shallow</b> or <b>deep</b>.
	* See {@link MIRROR_SHALLOW} and {@link MIRROR_DEEP} for more information.
	* Before a backup can be added, at ONE pimary method must be defined for
	* the path to be backed up.
	* 
	* @use MIRROR_DEEP
	* @use MIRROR_SHALLOW
	* @param ref object $method The instantiated {@link StorageMethodInterface StorageMethod}
	* object to add.
	* @param optional string $path The base path for the method. Default = '/'.
	* @param optional integer $bakcupType The type of mirrored backup to use. Options: MIRROR_SHALLOW, MIRROR_DEEP.
	* @access public 
	* @return void 
	*/
	function addBackupMethod(& $method, $path = '/', $backupType = MIRROR_SHALLOW)
	{
		$this->_checkPath($path); 
		// check to make sure we have a primary method defined for this path
		if (!$this->_hasPrimary($path)) {
			throwError(new Error("StorageHandler::addBackupMethod - can not add a backup method for '$path' because it does not have a primary method defined yet!", "StorageHandler", true)); 
			return false;
		}
		// ok, let's add this bugger
		$this->_addMethod($method, $path, $backupType);
	}

	/**
	* Makes sure paths have a trailing and leading /.
	* 
	* @param ref string $path The pathname.
	* @access private 
	* @return string The new pathname.
	*/
	function _checkPath(& $path)
	{
		if ($path[strlen($path) - 1] != '/') $path .= '/';
		if ($path[0] != '/') $path = '/' . $path;
	}

	/**
	* Chops the trailing / off a path.
	* 
	* @param ref string $path The pathname.
	* @access private 
	* @return string The new path.
	*/
	function _chopPath (& $path)
	{
		if (ereg(".+/$", $path))
			$path = substr($path, 0, strlen($path)-1);
	}

	/**
	* Adds a method. See notes for addMethod() and addBackupMethod() for more info.
	* 
	* @param ref object $method The method object.
	* @param string $path The pathname.
	* @param integer $type The method type.
	* @access private 
	* @return void 
	*/
	function _addMethod(& $method, $path, $type)
	{
		ArgumentValidator::validate($method, new ExtendsValidatorRule("StorageMethodInterface"), true);
		ArgumentValidator::validate($path, new StringValidatorRule, true); 
		// make sure it's a valid path
		ArgumentValidator::validate($path, new RegexValidatorRule("^/(([A-Za-z0-9_.-]+)/?)*$"));

		ArgumentValidator::validate($type, new ChoiceValidatorRule(STORAGE_PRIMARY, MIRROR_SHALLOW, MIRROR_DEEP)); 
		// ok, we should be good
		$id = $this->_num;
		$this->_methods[$id] = & $method;
		$this->_paths[$id] = $path;
		$this->_types[$id] = $type;
		if (!$this->_pathDefined($path)) $this->_pathsRegistered[] = $path; 
		// done
		$this->_num++;
	}

	/**
	* Check if $path has been defined before.
	* 
	* @param string $path The pathname.
	* @access private 
	* @return boolean TRUE if defined, FALSE otherwise.
	*/
	function _pathDefined($path)
	{
		return in_array($path, $this->_pathsRegistered);
	}

	/**
	* Checks to see if $path has a primary storage type.
	* 
	* @param string $path The pathname.
	* @access public 
	* @return boolean TRUE if it does, FALSE otherwise.
	*/
	function _hasPrimary($path)
	{
		if (!$this->_pathDefined($path)) return false;
		$ids = $this->_getIDs($path);
		foreach ($ids as $id)
		if ($this->_types[$id] == STORAGE_PRIMARY) return true;
		return false;
	}

	/**
	* Returns an array of indexes for methods that use $path.
	* 
	* @param string $path The pathname.
	* @access private 
	* @return array An array of numerical indexes.
	*/
	function _getIDs($path)
	{
		$ids = array();
		for($i = 0; $i < $this->_num; $i++) {
			if ($this->_paths[$i] == $path) $ids[] = $i;
		}
		return $ids;
	}

	/**
	* Gets the primary method for $path.
	* 
	* @param string $path The path.
	* @access private 
	* @return integer The Method ID for $path.
	*/
	function _getPrimaryForPath($path)
	{ 
		// ok, let's find the deepest path defined for $path
		$deepestPath = $this->_findDeepestDefinedFor($path);
		$ids = $this->_getIDs($deepestPath);
		foreach ($ids as $id) {
			if ($this->_types[$id] == STORAGE_PRIMARY) return $id;
		} 
		// if we get here, something is very wrong...
		// it means that we don't have a primary method defined that handles
		// this path... bad.
		throwError(new Error("StorageHandler::_getPimaryForPath('$path') - Could not find a method to handle the path '$path'. This is bad -- maybe there are not methods defined.", "StorageHandler", true));
	}

	/**
	* Returns how deep $path is in the hierarchy.
	* 
	* @param string $path The pathname.
	* @access private 
	* @return integer The level.
	*/
	function _getLevel($path)
	{ 
		// root is level 0
		if ($path == '/') return 0;
		$this->_chopPath($path);
		$array = explode("/", ereg_replace("^/", "", $path));
		$count = count($array);
		return $count;
	}

	/**
	* Finds the deepest (most sub-dirs) path defined that overlaps with $path.
	* 
	* @param string $path The path.
	* @access private 
	* @return string The deepest path.
	*/
	function _findDeepestDefinedFor($path)
	{
		$deepestPath = '';
		$level = -1;
		foreach ($this->_paths as $id => $definedPath) {
			if (ereg("^$definedPath", $path)) { // looks like we have a match-up
				// now let's see how deep this bad-boy is
				$methodLevel = $this->_getLevel($definedPath); 
				// if we're deeper than the last one, use it
				if ($methodLevel > $level) {
					$level = $methodLevel;
					$deepestPath = $definedPath;
				}
			}
		}
		if ($deepestPath == '') // something is very wrong (again)
			throwError(new Error("StorageHandler::_findDeepestDefinedFor('$path') - Could not find a defined path for '$path'. Storage not possible! Fix this!", "StorageHandler", true));
		return $deepestPath;
	}

	/**
	* Finds any methods that are defined as subdirs of $path.
	* 
	* @param string $path The path.
	* @param optional integer $type The type of method to return.
	* @access public 
	* @return array An array of $ids.
	*/
	function _findDefinedMethodsBelow($path, $type = null)
	{
		$ids = array();
		foreach ($this->_paths as $id => $definedPath) {
			if (ereg("^$path.+", $definedPath) && ($type == null || ($this->_types[$id] == $type))) $ids[] = $id;
		}
		return $ids;
	}

	/**
	* 
	* @access public 
	* @return void 
	*/
	function _findDefinedPathsBelow($path)
	{
		$paths = array();
		foreach ($this->_pathsRegistered as $definedPath) {
			if (ereg("^$path.+", $definedPath)) $paths[] = $definedPath;
		}
		return $paths;
	}

	/**
	* Makes sure that we have at least one valid StorageMethod defined before we
	* go ahead and try to store thigns. Throws an error if not.
	* 
	* @access public 
	* @return void 
	*/
	function _checkMethods()
	{
		if (!$this->_pathDefined('/')) // sure enough, things are not good
			throwError(new Error("StorageHandler::_checkMethods() - Could not procede because no path for '/' (root) has been defined! Before you do any operations using the StorageHandler, you must define at least one method.", "StorageHandler", true));
	}

	/**
	* Gets all the methods that serve as backups for $path.
	* 
	* @param string $path The path.
	* @access private 
	* @return array An array of ID's that are backups for $path.
	*/
	function _getBackupsForPath($path)
	{ 
		// before we get any backup methods, we need to find the deepest
		// path assigned to a method that overlaps with this $path.
		$deepestPath = $this->_findDeepestDefinedFor($path); 
		// let's first find any MIRROR_SHALLOW backup types for this path
		$backups = array();

		$ids = $this->_getIDs($deepestPath);
		foreach ($ids as $id)
			if ($this->_types[$id] == MIRROR_SHALLOW) $backups[] = $id; 
		// now let's go through and get all the methods that are MIRROR_DEEP
		// that overlap with this path
		foreach ($this->_types as $id => $type) {
			if ($type == MIRROR_DEEP) {
				$thePath = $this->_paths[$id];
				if (ereg("^$thePath", $path)) $backups[] = $id;
			}
		} 
		// just in case we have any duplcates, remove them
		return array_unique($backups);
	}

	/**
	* Translates an absolute StorageHandler path into a relative one for
	* a specific storage method specified by $id.
	* 
	* @param integer $id The StorageMethod's ID.
	* @param string $path The path to translate.
	* @access private 
	* @return string A new relative path for the method.
	*/
	function _translatePathForMethod($id, $path)
	{ 
		// we are going to turn an absolute path into a relative path
		// for a specific method.
		// get the method's defined path
		$methodPath = $this->_paths[$id]; 
		// if our $methodPath is *longer* than the $path, we will use
		// the method's root folder ('/').
		if (strlen($methodPath) > strlen($path)) return '/'; 
		// remove them $methodPath from the beginning
		$this->_chopPath($methodPath);

		$translatedPath = (ereg("^$methodPath/",$path))?
							ereg_replace("^$methodPath", "", $path):$path;
		// now we should have relative path like "/path/to/something/"
		// we're done
		return $translatedPath;
	}

	/**
	* Store a file. Takes a {@link StorableInterface Storable}, name, and path
	* and stores the file under $path/$name in the handler.
	* 
	* @param ref object $storable The Storable object to store.
	* @param string $path The path under which to store the file.
	* @param string $name The name to store under.
	* @see {@link StorableInterface}
	* @access public 
	* @return boolean TRUE on success, FALSE otherwise.
	*/
	function store(& $storable, $path, $name)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// validate all the parameters
		$s = & new StringValidatorRule;
		ArgumentValidator::validate($storable, new ExtendsValidatorRule("AbstractStorable"));
		ArgumentValidator::validate($path, $s);
		ArgumentValidator::validate($name, $s); 
		// done
		$id = $this->_getPrimaryForPath($path);
		$backupIDs = $this->_getBackupsForPath($path); 
		// store on the primary, and then the backups
		$primaryError = $this->_methods[$id]->store(& $storable,
			$this->_translatePathForMethod($id, $path),
			$name);

		$backupError = true; // assume we're good
		foreach ($backupIDs as $backupID) {
			$backupError &= $this->_methods[$backupID]->store(& $storable,
				$this->_translatePathForMethod($backupID, $path),
				$name);
		} 
		// return false if both are not TRUE (no error)
		return $backupError & $primaryError;
	}

	/**
	* Retrieves a file from the appropriate {@link StorageMethodInterface StorageMethod}.
	* Will return a storable object.
	* 
	* @param string $path The path leading to the file.
	* @param string $name The name of the virtual file to retrieve.
	* @access public 
	* @return object The Storable object associated with $path/$name. False if
	* it could not be found.
	*/
	function & retrieve($path, $name)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// validate all arguments
		$s = & new StringValidatorRule;
		ArgumentValidator::validate($path, $s);
		ArgumentValidator::validate($name, $s); 
		// first, let's try and get $name from the primary method
		$id = $this->_getPrimaryForPath($path);
		$storable = & $this->_methods[$id]->retrieve($this->_translatePathForMethod($id, $path), $name);
		if ($storable)
			return $this->_createVirtual($storable, $id);
		unset($storable); 
		// hmm, that didn't work... let's try a backup server, or two, or more
		$ids = $this->_getBackupsForPath($path);
		foreach ($ids as $id) {
			$storable = & $this->_methods[$id]->retrieve($this->_translatePathForMethod($id, $path), $name);
			if ($storable) // yay!
				return $this->_createVirtual($storable, $id); 
			// ugh...
			unset($storable);
		}
		return false;
	}

	/**
	* Creates a virtual Storable wrapper for $storable for method defined by $id.
	* 
	* @param ref object Storable $storable The storable object.
	* @param integer $id The Method ID.
	* @access public 
	* @return object VirtualStorable
	*/
	function & _createVirtual(& $storable, $id)
	{
		$virtual = & new VirtualStorable($this->_paths[$id], $storable);
		return $virtual;
	}

	/**
	* Creates an array of VirtualStorables from an array of Storables
	* 
	* @param ref array $array
	* @param integer $id 
	* @access public 
	* @return array 
	*/
	function & _createVirtualsArray(& $array, $id)
	{
		$newArray = array();
		for ($i = 0; $i < count($array); $i++) {
			$newArray[] = & $this->_createVirtual($array[$i], $id);
		}
		return $newArray;
	}

	/**
	* Removes the file specified by $name and $path from all applicable StorageMethods.
	* 
	* @param string $path The path leading to $name.
	* @param string $name The name of the file to delete.
	* @access public 
	* @return void 
	*/
	function delete($path, $name)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// validate all arguments
		$s = & new StringValidatorRule;
		ArgumentValidator::validate($path, $s);
		ArgumentValidator::validate($name, $s); 
		// let's delete it from the primary first.
		$id = $this->_getPrimaryForPath($path);
		$this->_methods[$id]->delete($this->_translatePathForMethod($id, $path), $name); 
		// now let's go through all the backups and delete from them too.
		$ids = $this->_getBackupsForPath($path);
		foreach ($ids as $id) {
			$this->_methods[$id]->delete($this->_translatePathForMethod($id, $path), $name);
		}
	}

	/**
	* Moves a file from one location to another, across StorageMethods if required.
	* 
	* @param string $sourcePath The current path leading to the file.
	* @param string $sourceName The current name of the file.
	* @param string $destinationPath The desired destination path for the new file.
	* @param string $destinationName The desired name of the file.
	* @access public 
	* @return void 
	*/
	function move($sourcePath, $sourceName, $destinationPath, $destinationName)
	{ 
		// since moving files accross methods could be very tedious and annoying
		// we're going to define a move as a retrieve, a store, and a delete
		// let's first validate our arguments though
		$s = & new FieldRequiredValidatorRule;
		ArgumentValidator::validate($sourcePath, $s);
		ArgumentValidator::validate($sourceName, $s);
		ArgumentValidator::validate($destinationPath, $s);
		ArgumentValidator::validate($destinationName, $s); 
		// ok, now let's check if they're trying to move this guy to the same place.
		// would be useless.
		if (($sourcePath == $destinationPath) &&
				($sourceName == $destinationName)) // retards
			return false; 
		// now let's actually do the dirty
		$storable = & $this->retrieve($sourcePath, $sourceName);
		if ($storable) { // we found it, good
			if ($this->store($storable, $destinationPath, $destinationName)) {
				// only if we successfully stored the new one do we delete
				// the old one -- could be trouble otherwise!
				$this->delete($sourcePath, $sourceName);
			}
		}
	}

	/**
	* Copies a file from one location to another, across StorageMethods if required.
	* 
	* @param string $sourceName The current name of the file.
	* @param string $sourcePath The current path leading to the file.
	* @param string $destinationName The desired name of the new file.
	* @param string $destinationPath The desired destination path for the new file.
	* @access public 
	* @return void 
	*/
	function copy($sourcePath, $sourceName, $destinationPath, $destinationName)
	{ 
		// since copying files accross methods could be very tedious and annoying
		// we're going to define a move as a retrieve and a store
		// let's first validate our arguments though
		$s = & new FieldRequiredValidatorRule;
		ArgumentValidator::validate($sourcePath, $s);
		ArgumentValidator::validate($sourceName, $s);
		ArgumentValidator::validate($destinationPath, $s);
		ArgumentValidator::validate($destinationName, $s); 
		// ok, now let's check if they're trying to copy this guy to the same place.
		// would be useless.
		if (($sourcePath == $destinationPath) &&
				($sourceName == $destinationName)) // retards
			return false; 
		// now let's actually do the dirty
		$storable = & $this->retrieve($sourcePath, $sourceName);
		if ($storable) { // we found it, good
			$this->store($storable, $destinationPath, $destinationName);
		}
	}

	/**
	* Recursively deletes any files under $path.
	* 
	* @param string $path The path to delete.
	* @access public 
	* @return void 
	*/
	function deleteRecursive($path)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// first, get the ID of the primary
		$id = $this->_getPrimaryForPath($path); 
		// and the backups
		$ids = $this->_getBackupsForPath($path); 
		// join the two
		$ids[] = $id; 
		// now get the IDs of any methods that are sub-dirs of $path
		$subDirs = $this->_findDefinedMethodsBelow($path);
		$ids = array_unique(array_merge($ids, $subDirs)); 
		// go through them ALL and do a recursive delete
		foreach ($ids as $id) {
			$this->_methods[$id]->deleteRecursive($this->_translatePathForMethod($id, $path));
		}
	}

	/**
	* Gets the size of either a path or a file. If $name is specified, the size
	* of the virtual file is retrieved, otherwise, the full size of $path is
	* retrieved.
	* 
	* @param string $path The path to use.
	* @param optional string $name The name of the virtual file.
	* @access public 
	* @return integer The size of the Storable(s).
	*/
	function getSizeOf($path, $name = null)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// validate all arguments
		$s = & new StringValidatorRule;
		ArgumentValidator::validate($path, $s); 
		// we have two options... either we are looking for the size of a file,
		// or the recursive size of a path.
		if ($name != null) {
			// a file.
			return $this->_getSizeOf($path, $name);
		} 
		// a directory
		$totalSize = 0;
		$totalSize += $this->_getSizeOf($path); 
		// now go through any sub-dirs that are defined on other methods.
		$paths = $this->_findDefinedPathsBelow($path);
		foreach ($paths as $path) {
			$totalSize += $this->_getSizeOf($path);
		}

		return $totalSize;
	}

	/**
	* A private _getSizeOf() method -- used by the public method
	* 
	* this method is responsible for, essentially, trying the primary, and then
	* any backups that exist for a certain path or path/name, and getting the size
	* of the given.
	* 
	* @param string $path 
	* @param optional string $name
	* @access private 
	* @return integer 
	*/
	function _getSizeOf($path, $name = null)
	{ 
		// first, let's try and get the size of $path/[$name] from the primary method
		$id = $this->_getPrimaryForPath($path);
		$size = & $this->_methods[$id]->getSizeOf($this->_translatePathForMethod($id, $path), $name); 
		// if we're just getting the size of one file, and the primary succeeded in finding
		// it, return that value.
		if ($size) return $size; 
		// hmm, that didn't work... let's try a backup server, or two, or more
		$ids = $this->_getBackupsForPath($path);
		foreach ($ids as $id) {
			$size = & $this->_methods[$id]->getSizeOf($this->_translatePathForMethod($id, $path), $name);
			if ($size) // yay!
				return $size;
		}
		return 0;
	}

	/**
	* Lists all the Storables in $path. If $recursive is TRUE, will recurse
	* through the entire tree.
	* 
	* @param string $path The path to list.
	* @param optional boolean $recursive Should we recurse the tree?
	* @access public 
	* @return array An array of Storables in $path.
	*/
	function listInPath($path, $recursive = false)
	{ 
		// we're going to get a huge list of method ID's to go through
		// including backups, etc. we're going to remove duplicates later.
		$ids = $this->_getBackupsForPath($path);
		$ids[] = $this->_getPrimaryForPath($path);
		if ($recursive) {
			$ids = array_merge($ids, $this->_findDefinedMethodsBelow($path));
		}

		$storables = array();
		foreach ($ids as $id) {
			$tempArray =& $this->_methods[$id]->listInPath($this->_translatePathForMethod($id, $path), $recursive);
			$storables = array_merge($storables, $this->_createVirtualsArray($tempArray, $id));
		}
		return $this->_removeDuplicateStorables($storables);
	}

	/**
	* Removes duplicate Storable entries from an array.
	* 
	* @param ref array $array
	* @access public 
	* @return void 
	*/
	function & _removeDuplicateStorables(& $array)
	{
		$files = array();
		$newArray = array();
		for($i = 0; $i < count($array); $i++) {
			$file = $array[$i]->getPath() . '/' . $array[$i]->getName();
			if (!in_array($file, $files)) {
				$files[] = $file;
				$newArray[] = & $array[$i];
			}
		} // for
		return $newArray;
	}

	/**
	* Checks if $path or $path/$name exists. If only $path is specified, will
	* check if at least one file is stored within it.
	* 
	* @param string $path The path to check.
	* @param optional string $name The name of the Storable to check for.
	* @access public 
	* @return boolean TRUE if found, FALSE otherwise.
	*/
	function exists($path, $name = null)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// validate all arguments
		$s = & new StringValidatorRule;
		ArgumentValidator::validate($path, $s); 
		// first check the primary, then the backups
		$id = $this->_getPrimaryForPath($path);
		if ($this->_methods[$id]->exists($this->_translatePathForMethod($id, $path), $name))
			return true;

		$ids = $this->_getBackupsForPath($path);
		foreach ($ids as $id) {
			if ($this->_methods[$id]->exists($this->_translatePathForMethod($id, $path), $name))
				return true;
		}
		return false;
	}

	/**
	* Gets the total number of Storables under $path.
	* 
	* @param string $path The path to check under.
	* @param optional boolean $recursive Should we recurse into directories?
	* @access public 
	* @return integer The number of Storables.
	*/
	function getCount($path, $recursive = false)
	{
		$this->_checkMethods();
		$this->_checkPath($path); 
		// validate all arguments
		$s = & new StringValidatorRule;
		ArgumentValidator::validate($path, $s); 
		// we can only use primaries for this
		// an alternative is to do a listInPath with recursive = true and then count the array
		// but that's a VERY slow process. this is better.
		$totalCount = 0;
		$ids = ($recursive)?$this->_findDefinedMethodsBelow($path, STORAGE_PRIMARY):array();
		$ids[] = $this->_getPrimaryForPath($path);

		foreach ($ids as $id) {
			$totalCount += $this->_methods[$id]->getCount($this->_translatePathForMethod($id, $path),$recursive);
		}
		return $totalCount;
	}



	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}
	

}

?>