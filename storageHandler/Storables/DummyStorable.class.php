<?php

require_once(HARMONI.'storageHandler/Storable.abstract.php');

/**
 * File Storable class provides functionality to create Storables
 * that are files (file uploads), images and such. To be used 
 * by the StorageMethod and StorageHandler.
 *
 * @version $Id: DummyStorable.class.php,v 1.1 2003/07/03 18:03:20 gabeschine Exp $
 * @package harmoni.Storagehandler
 * @copyright 2003
 * @access public
 */

class DummyStorable extends AbstractStorable {
	/**
	 * @access private
	 * @var string $_data
	 **/
	var $_data;
	
	/**
	 * @access private
	 * @var integer $_size
	 **/
	var $_size;
	
	/**
	 * @access private
	 * @var string $_name
	 **/
	var $_name;
	
	/**
	 * @access private
	 * @var string $_path
	 **/
	var $_path;
	
    /**
     * Constructor. Create a new storable.
     * @param string $name Name (primary key) of the storable.
     * @param string $path Path (descriptor) of the storable.
     * @param string $basePath The path to the base directory of the Storable.
     * @access public
     */
    function DummyStorable($path,$name,$content) { 
		$this->_name = $name;
		$this->_path = $path;
		$this->_data = $content;
		$this->_size = strlen($content);
	}

    /**
     * Gets the data content of the storable.
     * @return string Data content of the storable.
     * @access public
     */
    function getData() { 
		return $this->_data;
	}

    /**
     * Gets the size of the data content of the storable.
     * @return integer Size of the storable in bytes, or FALSE in case of an error.
     * @access public
     */
    function getSize() { 
		return $this->_size;
	}
}

?>