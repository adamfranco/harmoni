<?php

require_once('Storable.interface.php');

/**
 * Storable abstract provides functionality to create generic Storable objects 
 * to be used by the StorageMethod and StorageHandler. Must be further extended
 * to implement getData and getSize
 *
 * @package harmoni.storage
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Storable.abstract.php,v 1.2 2005/01/19 21:10:13 adamfranco Exp $
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