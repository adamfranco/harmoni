<?php
/**
 * @since 5/6/08
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * This is a basic interface for file access, used to allow methods 
 * to return a single object that represents a file.
 * 
 * @since 5/6/08
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Filing_FileInterface {
		
	/**
	 * Answer the MIME type of this file.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getMimeType ();
	
	/**
	 * Set the MIME type of the file
	 * 
	 * @param string $mimeType
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function setMimeType ($mimeType);
	
	/**
	 * Answer the file name (base-name), including any extension.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getBaseName ();
	
	/**
	 * [Re]Set the base name for the file
	 * 
	 * @param string $baseName
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function setBaseName ($baseName);
	
	/**
	 * Answer a full path to the file, including the file name.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getPath ();
	
	/**
	 * [Re]Set a full path to the file, including the file name.
	 * 
	 * @param string $path
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setPath ($path);
	
	/**
	 * Answer the size (bytes) of the file
	 * 
	 * @return int
	 * @access public
	 * @since 5/6/08
	 */
	public function getSize ();
	
	/**
	 * Answer the contents of the file
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getContents ();
	
	/**
	 * Set the contents of the file
	 * 
	 * @param string $contents
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setContents ($contents);
	
	/**
	 * Set the contents of the file. Alias for setContents()
	 * 
	 * @param string $contents
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function putContents ($contents);
	
	/**
	 * Delete the file.
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function delete ();
	
	/**
	 * Answer the modification date/time
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/13/08
	 */
	public function getModificationDate ();
}

?>