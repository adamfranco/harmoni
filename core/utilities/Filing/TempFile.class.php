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
	implements Harmoni_FileInterface 
{

	/**
	 * Constructor.
	 * 
	 * @param string $baseName A name for the file.
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function __construct ($baseName) {
		ArgumentValidator::validate($baseName, NonzeroLengthStringValidatorRule::getRule());
		
		$this->baseName = $baseName;
		$this->contents = '';
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
}

?>