<?php

require_once(HARMONI.'StorageHandler/StorageMethod.interface.php');
require_once(HARMONI.'StorageHandler/Storables/FileStorable.class.php');

/**
 * File Storage Method interface provides functionality to store and handle
 * Storables on a file system. To be used by StorageHandler
 *
 * @version $Id: FileStorageMethod.class.php,v 1.1 2003/06/30 14:17:27 adamfranco Exp $
 * @package harmoni.Storagehandler
 * @copyright 2003
 * @access public
 */

class FileStorageMethod extends StorageMethodInterface {

	/*@var string The path, within which all storables are to be stored.*/
	var $_basePath;

    /**
     * Constructor. Create new FileStorageMethod.
	 * @param string $basePath The path, within which all storables are to be stored.
     * @access public
     */

	function FileStorageMethod($basePath="") {
		$this->_basePath = $this->_convertPath($basePath);
	}

    /**
     * Store a given storable in a given location. This is the basic function that should 
     * be used to put a storable in the location of choice. 
     * @param object Storable $storable The Storable to be stored.
     * @param string $name The name (primary key) under which the storable is to be stored.
	 * @param string $path The path (descriptor) under which the storable is to be stored.
	 * @return integer File size on success False on falure.
     * @access public
     */

    function store($storable,$name,$path="") { 
		$path = $this->_convertPath($path);

		$filename = $this->_basePath.$path.$name;
		
		$handle = fopen($filename,'w');
		$contents = $storable->getData();
		$size = fwrite($handle,$contents);

		return $size;
	}

    /**
     * Returns a storable with a given name and path.
     * @param string $name The name of the storable to return.
     * @param string $path The path of the storable to return.
	 * @return object FileStorable A reference to the storable, which can be used to retreive the data. False if no such storable exists.
     * @access public
     */
    function &retrieve($name,$path="") { 
		$path = $this->_convertPath($path);

		if (file_exists($this->_basePath.$path.$name)){
			$storable =& new FileStorable($name,$this->_basePath.$path);
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
    function delete($name,$path="") { 
		$path = $this->_convertPath($path);
		echo "<br>".$this->_basePath.$path.$name;
		unlink($this->_basePath.$path.$name);
	}

    /**
     * Moves a storable with a given name and path to a new location. 
     * For security reasons you have to specify the source name and path
     * rather than the storable itself. It is up to the method to locate
     * the storable before moving it.
     * @param string $sourceName The name of the storable to move.
     * @param string $sourcePath The path of the storable to move.
     * @param string $destinationName The new name of the storable.
     * @param string $destinationPath The new path of the storable.
     * @access public
     */
    function move($sourceName,$sourcePath,$destinationName,$destinationPath) { 
		$sourcePath = $this->_convertPath($sourcePath);
		$destinationPath = $this->_convertPath($destinationPath);

		if (file_exists($this->_basePath.$sourcePath.$sourceName))
			rename($this->_basePath.$sourcePath.$sourceName,$this->_basePath.$destinationPath.$destinationName);
	}

    /**
     * Copies a storable with a given name and path to a specified location. 
     * For security reasons you have to specify the source name and path
     * rather than the storable itself. It is up to the method to locate
     * the storable before moving it.
     * @param string $sourceName The name of the storable to copy.
     * @param string $sourcePath The path of the storable to copy.
     * @param string $destinationName The name of the location to copy into.
     * @param string $destinationPath The path of the location to copy into.
     * @access public
     */
    function copy($sourceName,$sourcePath,$destinationName,$destinationPath) { 
		$sourcePath = $this->_convertPath($sourcePath);
		$destinationPath = $this->_convertPath($destinationPath);

		if (file_exists($this->_basePath.$sourcePath.$sourceName))
			copy($this->_basePath.$sourcePath.$sourceName,$this->_basePath.$destinationPath.$destinationName);
	}

    /**
     * Tells whether a certain storable exists.
     * @param string $name The name of the storable to check.
     * @param string $path The path of the storable to check.
     * @return boolean True if storable exists, false otherwise.
     * @access public
     */
    function exists($name,$path) { 
		$path = $this->_convertPath($path);
		return file_exists($this->_basePath.$path.$name);
	}

    /**
     * Get the size of either one Storable or the whole tree within a certain path.
     * @param string $name The name of the storable to get the size of. 
     * If ommited, the returned size will represent the total size of all storables within a certain path.
     * @param string $path The path of the storable(s) to get the size of.
     * @return integer The size of the storable(s).
     * @access public
     */
    function getSizeOf($path,$name="") { 
		if($name!=""){
			clearstatcache();
			return filesize($this->_basePath.$path.$name);
		}
		else {
			$totalsize = 0;
			$path = $this->_convertPath($path);
			if ($dirstream = @opendir($this->_basePath.$path)) {
				while (false !== ($filename = readdir($dirstream))) {
					if ($filename!="." && $filename!="..") {
						if (is_file($this->_basePath.$path.$filename))
							$totalsize+=filesize($this->_basePath.$path.$filename);
					
						elseif (is_dir($this->_basePath.$path.$filename))
							$totalsize+=$this->getSizeOf($path.$filename);
					}
				}
			}
			closedir($dirstream);
			return $totalsize;
		}
	}

    /**
     * Delete a whole tree of storables.
     * @param string $path Path to the storable to delete.
     * @access public
     */
    function deleteRecursive($path) {
		$path = $this->_convertPath($path);
		if ($dirstream = @opendir($this->_basePath.$path)) {
			while (false !== ($filename = readdir($dirstream))) {
				if ($filename!="." && $filename!="..") {
					if (is_file($this->_basePath.$path.$filename))
						unlink($this->_basePath.$path.$filename);
					
					elseif (is_dir($this->_basePath.$path.$filename))
						$this->deleteRecursive($path.$filename);
				}
			}
		}
		closedir($dirstream);
	}

    /**
     * List all the storables within a certain path.
     * @param string $path The path within which the storables should be listed
     * @return array The array of storables found within the path.
     * @access public
     */
    function listInPath($path) {
		$path = $this->_convertPath($path);
		$storables = array();
		if ($dirstream = @opendir($this->_basePath.$path)) {
			while (false !== ($filename = readdir($dirstream))) {
				if ($filename!="." && $filename!="..") {
					if (is_file($this->_basePath.$path.$filename))
						$storables[] =& $this->retrieve($filename,$path);
					
					elseif (is_dir($this->_basePath.$path.$filename))
						$storables = array_merge($storables,$this->listInPath($path.$filename));
				}
			}
		}
		closedir($dirstream);
		return $storables;
	}

    /**
     * Count all the storables within a certain path.
     * @param string $path The path within which the storables should be counted
     * @return integer The number of storables found within the path.
     * @access public
     */
    function getCount($path) { 
		return count(listInPath($path));
	}

	function _convertPath($path){
		if ($path!="" && $path[strlen($path)-1]!='/') $path.="/";
		return $path;
	}
}

?>