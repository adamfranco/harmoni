<?php

require_once(HARMONI.'storageHandler/Storable.abstract.php');

/**
 * The VirtualStorable is a wrapper for another kind of storable. The StorageHandler
 * creates a class of this type which wraps around the file returned by a StorageMethod,
 * allowing the StorageMethod's storable object to remain entirely intact, but not
 * allowing the end user any direct access to it. This class also handles translation
 * of virtual paths relative to the StorageHandler to take place transparently.
 *
 * @version $Id: VirtualStorable.class.php,v 1.4 2003/07/10 02:34:21 gabeschine Exp $
 * @package harmoni.storage.storables
 * @copyright 2003
 * @access public
 */

class VirtualStorable extends AbstractStorable {
	/**
	 * @access private
	 * @var object Storable $_storable
	 **/
	var $_storable;
	
	/**
	 * @access private
	 * @var string $_basePath
	 **/
	var $_basePath;
	
    /**
     * Constructor. Create a new storable.
	 * @param string $basePath The basepath of this storable.
	 * @param ref object Storable $storable The storable object to be wrapped.
     * @access public
     */
    function VirtualStorable($basePath, &$storable) { 
		$this->_storable =& $storable;
		// strip the trailing /
		if (ereg("/$", $basePath))
			$basePath = substr($basePath, 0, strlen($basePath)-1);
		$this->_basePath = $basePath;
	}

    /**
     * Gets the name (primary key) of the storable.
     * @return string Name of the storable.
     * @access public
     */
    function getName() { 
		return $this->_storable->getName();
	}
	
    /**
     * Gets the data content of the storable.
     * @return string Data content of the storable.
     * @access public
     */
    function getData() { 
		return $this->_storable->getData();
	}

    /**
     * Gets the size of the data content of the storable.
     * @return integer Size of the storable in bytes, or FALSE in case of an error.
     * @access public
     */
    function getSize() { 
		return $this->_storable->getSize();
	}

    /**
     * Gets the path (descriptor) of the storable.
     * @return string Path of the storable.
     * @access public
     */
    function getPath() {
		$base = $this->_basePath;
		$path = $this->_storable->getPath();
		$base = ereg_replace("/$","",$base);
		return $base . $path;
	}

    /**
     * Sets the path (descriptor) of the storable.
     * @param string $path Path of the storable.
     * @access public
     */
    function setPath($path) { 
		// don't do anything -- this function should not be called.
	}
}

?>