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

require_once(dirname(__FILE__)."/File.interface.php");

/**
 * This is a basic object that represents a file-system file.
 * 
 * @since 5/6/08
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class Harmoni_Filing_TempFile
	implements Harmoni_Filing_FileInterface 
{

	/**
	 * Constructor.
	 * 
	 * @param string $baseName A name for the file.
	 * @param optional DateAndTime $timestamp The Modification date/time
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function __construct ($baseName, DateAndTime $timestamp = null) {
		ArgumentValidator::validate($baseName, NonzeroLengthStringValidatorRule::getRule());
		
		$this->baseName = $baseName;
		$this->contents = '';
		$this->timestamp = $timestamp;
	}
		
	/**
	 * Answer the MIME type of this file.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getMimeType () {
		if (!isset($this->mimeType)) {
			$mimeMgr = Services::getService("MIME");
			$this->mimeType = $mimeMgr->getMIMETypeForFileName($this->getBaseName());
		}
		return $this->mimeType;
	}
	
	/**
	 * Set the MIME type of the file
	 * 
	 * @param string $mimeType
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function setMimeType ($mimeType) {
		if (!preg_match('/^(text|image|audio|video|application)/[a-z0-9_-]+$', $mimeType))
			throw new OperationFailedException("Invalid MIME Type '$mimeType'.");
		$this->mimeType = $mimeType;
	}
	
	/**
	 * Answer the file name (base-name), including any extension.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getBaseName () {
		return $this->baseName;
	}
	
	/**
	 * [Re]Set the base name for the file
	 * 
	 * @param string $baseName
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function setBaseName ($baseName) {
		if (!preg_match('/^[a-z0-9_\.-]+$/i', $baseName))
			throw new OperationFailedException("'$basename' is not an allowed file name.");
		
		$this->baseName = $baseName;
	}
	
	/**
	 * Answer a full path to the file, including the file name.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getPath () {
		throw new UnimplementedException();
	}
	
	/**
	 * [Re]Set a full path to the file, including the file name.
	 * 
	 * @param string $path
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setPath ($path) {
		throw new UnimplementedException();
	}
	
	/**
	 * Answer the size (bytes) of the file
	 * 
	 * @return int
	 * @access public
	 * @since 5/6/08
	 */
	public function getSize () {
		return strlen($this->contents);
	}
	
	/**
	 * Answer the contents of the file
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getContents () {
		return $this->contents;
	}
	
	/**
	 * Set the contents of the file
	 * 
	 * @param string $contents
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setContents ($contents) {
		$this->contents = $contents;
	}
	
	/**
	 * Set the contents of the file. Alias for setContents()
	 * 
	 * @param string $contents
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function putContents ($contents) {
		$this->setContents($contents);
	}
	
	/**
	 * Delete the file.
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function delete () {
		$this->contents = '';
	}
	
	/**
	 * Answer the modification date/time
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/13/08
	 */
	public function getModificationDate () {
		if (is_null($this->timestamp))
			throw new OperationFailedException("Could not get timestamp of '".$this->getBaseName()."'.");
		return $this->timestamp;
	}
}

?>