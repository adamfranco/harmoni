<?php

require_once('Storable.interface.php');

/**
 * Storable abstract provides functionality to create generic Storable objects 
 * to be used by the StorageMethod and StorageHandler. Must be further extended
 * to implement getData and getSize
 *
 * @version $Id: Storable.abstract.php,v 1.1 2003/06/30 14:17:27 adamfranco Exp $
 * @package harmoni.Storagehandler
 * @copyright 2003
 * @access public
 */

class AbstractStorable extends StorableInterface{

	/*@var string $_name Name (primary key) of the storable*/
	var $_name;

	/*@var string $_path Path (descriptor) of the storable*/
	var $_path;

    /**
     * Constructor. Create a new storable.
     * @param string $name Name (primary key) of the storable.
     * @param string $path Path (descriptor) of the storable.
     * @access public
     */
    function AbstractStorable($name,$path) { 
		$this->_name = $name;
		$this->_path = $path;
	}
	

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