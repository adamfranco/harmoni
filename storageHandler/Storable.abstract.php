<?php

require_once('Storable.interface.php');

/**
 * Storable abstract provides functionality to create generic Storable objects 
 * to be used by the StorageMethod and StorageHandler. Must be further extended
 * to implement getData and getSize
 *
 * @version $Id: Storable.abstract.php,v 1.4 2003/07/06 22:07:41 gabeschine Exp $
 * @package harmoni.Storagehandler.storables
 * @copyright 2003
 * @access public
 */

class AbstractStorable extends StorableInterface{

	/**
	 * @variable string $_name Name (primary key) of the storable
	 */
	var $_name;

	/** 
	 * @variable string $_path Path (descriptor) of the storable
	 */
	var $_path;

    /**
     * Gets the name (primary key) of the storable.
     * @return string Name of the storable.
     * @access public
     */
    function getName() { 
		return $this->_name;
	}

    /**
     * Sets the name (primary key) of the storable.
     * @param string $name Name of the storable.
     * @access public
     */
    function setName($name) { 
		$this->_name = $name;
	}

    /**
     * Gets the path (descriptor) of the storable.
     * @return string Path of the storable.
     * @access public
     */
    function getPath() { 
		return $this->_path;
	}

    /**
     * Sets the path (descriptor) of the storable.
     * @param string $path Path of the storable.
     * @access public
     */
    function setPath($path) { 
		$this->_path = $path;
	}
}

?>