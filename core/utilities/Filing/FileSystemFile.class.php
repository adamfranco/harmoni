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
class Harmoni_Filing_FileSystemFile
	implements Harmoni_Filing_FileInterface 
{

	/**
	 * Constructor.
	 * 
	 * @param string $path
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function __construct ($path) {
		ArgumentValidator::validate($path, NonzeroLengthStringValidatorRule::getRule());
		if (!file_exists($path) || is_dir($path))
			throw new InvalidArgumentException("'".$path."' is not a valid file.", 78345);
		$this->path = $path;
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
		if (!preg_match('/^(text|image|audio|video|application)\/[a-z0-9_-]+$/', $mimeType))
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
		return basename($this->path);
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
		throw new UnimplementedException();
		
		if (!preg_match('/^[a-z0-9_\.-]+$/i', $baseName))
			throw new OperationFailedException("'$basename' is not an allowed file name.");
		
	}
	
	/**
	 * Answer a full path to the file, including the file name.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getPath () {
		return $this->path;
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
	 * Answer any file-extension
	 * 
	 * @return string
	 * @access public
	 * @since 9/24/09
	 */
	public function getExtension () {
		$pathInfo = pathinfo($this->getBasename());
		return $pathInfo['extension'];
	}
	
	/**
	 * Answer the size (bytes) of the file
	 * 
	 * @return int
	 * @access public
	 * @since 5/6/08
	 */
	public function getSize () {
		return filesize($this->path);
	}
	
	/**
	 * Answer the contents of the file
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getContents () {
		return file_get_contents($this->path);
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
		file_put_contents($this->path, $contents);
		clearstatcache();
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
		unlink($this->path);
	}
	
	/**
	 * Answer the modification date/time
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/13/08
	 */
	public function getModificationDate () {
		$tstamp = filemtime($this->path);
		if ($tstamp === false)
			throw new OperationFailedException("Could not get timestamp of '".$this->getBaseName()."'.");
		return TimeStamp::fromUnixTimeStamp($tstamp)->asDateAndTime();
	}
	
	/**
	 * Answer true if the file is readable
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/19/08
	 */
	public function isReadable () {
		return is_readable($this->path);
	}
	
	/**
	 * Answer true if the file is writable
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/19/08
	 */
	public function isWritable () {
		return is_writeable($this->path);
	}
	
	/**
	 * Answer true if the file is executable
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/19/08
	 */
	public function isExecutable () {
		return is_executable($this->path);
	}
}

?>