<?php

require_once(HARMONI.'storageHandler/Storable.abstract.php');

/**
 * File Storable class provides functionality to create Storables
 * that are files (file uploads), images and such. To be used 
 * by the StorageMethod and StorageHandler.
 *
 * @version $Id: FileStorable.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @package harmoni.storage.storables
 * @copyright 2003
 * @access public
 */

class FileStorable extends AbstractStorable {

    /**
     * Constructor. Create a new storable.
     * @param string $name Name (primary key) of the storable.
     * @param string $path Path (descriptor) of the storable.
     * @param string $basePath The path to the base directory of the Storable.
     * @access public
     */
    function FileStorable($basePath,$path,$name) { 
		$this->_name = $name;
		$this->_path = $path;
		$this->_basePath = $this->_convertPath($basePath);
	}

    /**
     * Gets the data content of the storable.
     * @return string Data content of the storable.
     * @access public
     */
    function getData() { 
		$filename = $this->_basePath.$this->_convertPath($this->_path).$this->_name;

		$handle = fopen ($filename, "r");
		$contents = fread ($handle, filesize ($filename));
		fclose ($handle);
		
		return $contents;
	}

    /**
     * Gets the size of the data content of the storable.
     * @return integer Size of the storable in bytes, or FALSE in case of an error.
     * @access public
     */
    function getSize() { 
		$filename = $this->_basePath.$this->_convertPath($this->_path).$this->_name;

		$size = filesize($filename);
		
		return $size;
	}

	/**
   	 * Internal function used to convert (mostly empty Paths) to avoid double slashes and such
	 * @acess private
	 */
	function _convertPath($path){
		if ($path!="" && $path[strlen($path)-1]!='/') $path.="/";
		return $path;
	}
}

?>