<?php

require_once(HARMONI.'storageHandler/Storable.abstract.php');

/**
 * File Storable class provides functionality to create Storables
 * that are files (file uploads), images and such. To be used 
 * by the StorageMethod and StorageHandler.
 *
 * @version $Id: FileStorable.class.php,v 1.2 2003/06/30 15:41:56 adamfranco Exp $
 * @package harmoni.Storagehandler
 * @copyright 2003
 * @access public
 */

class FileStorable extends AbstractStorable {

    /**
     * Gets the data content of the storable.
     * @return string Data content of the storable.
     * @access public
     */
    function getData() { 
		$filename = $this->_path."/".$this->_name;

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
		$filename = $this->_path."/".$this->_name;

		$size = filesize($filename);
		
		return $size;
	}
}

?>