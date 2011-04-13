<?php
/**
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2011, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */ 

/**
 * This is a basic interface for directory access, used to allow methods 
 * to return a single object that represents a directory.
 * 
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2011, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */
interface Harmoni_Filing_DirectoryInterface {
	
	/**
	 * Answer the directory name (base-name), including any extension.
	 * 
	 * @return string
	 */
	public function getBaseName ();
	
	/**
	 * [Re]Set the base name for the directory
	 * 
	 * @param string $baseName
	 * @return null
	 */
	public function setBaseName ($baseName);
	
	/**
	 * Answer a full path to the directory, including the directory name.
	 * 
	 * @return string
	 */
	public function getPath ();
	
	/**
	 * [Re]Set a full path to the directory, including the directory name.
	 * 
	 * @param string $path
	 * @return null
	 */
	public function setPath ($path);
	
	/**
	 * Delete the directory.
	 * 
	 * @param boolean $recursive
	 * @return null
	 */
	public function delete ($recursive);
	
	/**
	 * Answer the modification date/time
	 * 
	 * @return object DateAndTime
	 */
	public function getModificationDate ();
	
	/**
	 * Answer true if the directory is readable
	 * 
	 * @return boolean
	 */
	public function isReadable ();
	
	/**
	 * Answer true if the directory is writable
	 * 
	 * @return boolean
	 */
	public function isWritable ();
	
	/**
	 * Answer true if the directory is executable
	 * 
	 * @return boolean
	 */
	public function isExecutable ();
	
	/**
	 * Answer an array of the files in this directory.
	 * 
	 * @return array of Harmoni_Filing_FileInterface objects
	 */
	public function getFiles ();
	
	/**
	 * Answer a single file by name
	 * 
	 * @param string $name
	 * @return object Harmoni_Filing_FileInterface
	 */
	public function getFile ($name);
	
	/**
	 * Answer true if the filename passed exists in this directory
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function fileExists ($name);
	
	/**
	 * Add a file to this directory, copying the contents from the source file.
	 * 
	 * This method throws the following exceptions:
	 *		InvalidArgumentException 	- If incorrect parameters are supplied
	 *		OperationFailedException 	- If the file already exists.
	 *		PermissionDeniedException 	- If the user is unauthorized to manage media here.
	 * 
	 * @param object Harmoni_Filing_FileInterface $sourceFile
	 * @return object Harmoni_Filing_FileInterface The new file
	 */
	public function addFile (Harmoni_Filing_FileInterface $sourceFile);
	
	/**
	 * Create a new empty file in this directory. Similar to touch().
	 * 
	 * This method throws the following exceptions:
	 *		InvalidArgumentException 	- If incorrect parameters are supplied
	 *		OperationFailedException 	- If the file already exists.
	 *		PermissionDeniedException 	- If the user is unauthorized to manage media here.
	 * 
	 * @param string $name
	 * @return object Harmoni_Filing_FileInterface The new file
	 */
	public function createFile ($name);
}

?>