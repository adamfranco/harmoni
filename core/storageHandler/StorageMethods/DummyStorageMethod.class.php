<?php

require_once(HARMONI."storageHandler/StorageMethod.interface.php");
require_once(HARMONI."storageHandler/Storables/DummyStorable.class.php");

/**
* Storage Method interface provides functionality to create StorageMethods
* to handle Storables. A collection of StorageMethods can be used by StorageHandler.
 *
 * @package harmoni.storage.methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DummyStorageMethod.class.php,v 1.4 2005/01/19 21:10:13 adamfranco Exp $
*/

class DummyStorageMethod extends StorageMethodInterface {
	/**
	 * @access private
	 * @var array $_files A dummy array of "files" that "exist".
	 **/
	var $_files;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void 
	 **/
	function DummyStorageMethod() {
		$this->_files = array();
	}
	
	
	/**
	* Store a given storable in a given location. This is the basic function that should 
	* be used to put a storable in the location of choice.
	* 
	* @param ref object Storable $storable The Storable to be stored.
	* @param string $name The name (primary key) under which the storable is to be stored.
	* @param string $path The path (descriptor) under which the storable is to be stored.
	* @return boolean True on success False on falure.
	* @access public 
	*/

	function store(&$storable, $path, $name)
	{
		$filename = $path . $name;
		$file = array('data'=>$storable->getData(),
						'size'=>$storable->getSize());
		$this->_files[$filename] = $file;
		return true;
	}

	/**
	* Returns a storable with a given name and path.
	* 
	* @param string $name The name of the storable to return.
	* @param string $path The path of the storable to return.
	* @return object Storable The storable, which can be used to retreive the data. False if no such storable exists.
	* @access public 
	*/
	function &retrieve($path, $name)
	{
		if (is_array($this->_files[$path.$name])) {
			$file = $this->_files[$path.$name];
			$storable = & new DummyStorable($path,$name,$file['data'],$file['size']);
			return $storable;
		}
		return false;
	}

	/**
	* Deletes the storable with a given name and path.
	* 
	* @param string $name The name of the storable to delete.
	* @param string $path The path of the storable to delete.
	* @access public 
	*/
	function delete($path, $name)
	{
		$filename = $path.$name;
		if (isset($this->_files[$filename])) unset($this->_files[$filename]);
	}

	/**
	* *Deprecated* Moves a storable with a given name and path to a new location. 
	* For security reasons you have to specify the source name and path
	* rather than the storable itself. It is up to the method to locate
	* the storable before moving it.
	* 
	* @param string $sourceName The name of the storable to move.
	* @param string $sourcePath The path of the storable to move.
	* @param string $locationName The new name of the storable.
	* @param string $locationPath The new path of the storable.
	* @deprecated Move functionality is handled by StorageHandler now.
	* @access public 
	*/
	function move($sourcePath, $sourceName, $locationPath, $locationName)
	{
		// deprecated;
	}

	/**
	* *Deprecated* Copies a storable with a given name and path to a specified location. 
	* For security reasons you have to specify the source name and path
	* rather than the storable itself. It is up to the method to locate
	* the storable before moving it.
	* 
	* @param string $sourceName The name of the storable to copy.
	* @param string $sourcePath The path of the storable to copy.
	* @param string $locationName The name of the location to copy into.
	* @param string $locationPath The path of the location to copy into.
	* @deprecated Copy functionality is handled by StorageHandler now.
	* @access public 
	*/
	function copy($sourcePath, $sourceName, $locationPath, $locationName)
	{
		// deprecated;
	}

	/**
	* Tells whether a certain storable exists.
	* 
	* @param string $name The name of the storable to check.
	* @param string $path The path of the storable to check.
	* @return boolean True if storable exists, false otherwise.
	* @access public 
	*/
	function exists($path, $name = null)
	{
		if ($name == null) {
			// if a "folder" exists
			foreach ($this->_files as $filename=>$file) {
				if (ereg("^$path",$filename)) return true;
			}
		}
		else {
			$filename = $path.$name;
			return (is_array($this->_files[$filename]))?true:false;
		}
		return false;
	}

	/**
	* Get the size of either one Storable or the whole tree within a certain path.
	* 
	* @param string $name The name of the storable to get the size of. 
	* If ommited, the returned size will represent the total size of all storables within a certain path.
	* @param string $path The path of the storable(s) to get the size of.
	* @return integer The size of the storable(s).
	* @access public 
	*/
	function getSizeOf($path, $name = null)
	{
		if ($name != null) {
			$filename = $path.$name;
			if (is_array($this->_files[$filename]))
				return $this->_files[$filename]['size'];
			return 0;
		}
		// it's recursive... ugh
		$size = 0;
		foreach ($this->_files as $filename=>$file) {
			if (ereg("^$path",$filename)) $size += $file['size'];
		}
		return $size;
	}

	/**
	* Delete a whole tree of storables.
	* 
	* @param string $path Path to the storable to delete.
	* @access public 
	*/
	function deleteRecursive($path)
	{
		foreach ($this->_files as $filename=>$file) {
			if (ereg("^$path",$filename)) unset($this->_files[$filename]);
		}
	}

	/**
	* List all the storables within a certain path.
	* 
	* @param string $path The path within which the storables should be listed
	* @param boolean $recursive Whether to list files only in the path (recursive=false) or in and under it (recursive=true).
	* @return array The array of storables found within the path.
	* @access public 
	*/
	function listInPath($path, $recursive = true)
	{
		if ($recursive) $regex = "^$path";
		else $regex = "^$path"."([^/]+)$";
		$storables = array();
		foreach ($this->_files as $filename=>$file) {
			if (ereg($regex,$filename)) $storables[] =& $this->_mkStorable($filename);
		}
		return $storables;
	}

	/**
	* Count all the storables within a certain path.
	* 
	* @param string $path The path within which the storables should be counted
	* @param optional boolean $recursive Whether to count files only in the path (recursive=false) or in and under it (recursive=true).
	* @return integer The number of storables found within the path.
	* @access public 
	*/
	function getCount($path, $recursive = true)
	{
		$storables = $this->listInPath($path, $recursive);
		return count($storables);
	}

	/**
	 * Makes a storable from a filename.
	 * @param string $filename The full path to the file.
	 * @access private
	 * @return object Storable
	 **/
	function &_mkStorable($filename) {
		$name = basename($filename);
		$path = dirname($filename) . '/';
		$file = $this->_files[$filename];
		$storable = & new DummyStorable($path,$name,$file['data'],$file['size']);
		return $storable;
	}
	
}

?>