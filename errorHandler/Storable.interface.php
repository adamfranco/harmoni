<?php

/**
 * Storable class interface provides functionality to create Storable objects 
 * to be used by the StorageMethod and StorageHandler.
 *
 * @version $Id: Storable.interface.php,v 1.1 2003/06/29 20:40:19 movsjani Exp $
 * @package harmoni.Storagehandler
 * @copyright 2003
 * @access public
 */

class StorableInterface {

    /**
     * Constructor. Create a new storable.
     * @param string $name Name (primary key) of the storable.
     * @param string $path Path (descriptor) of the storable.
     * @access public
     */
    function Storable($name,$path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	

    /**
     * Gets the name (primary key) of the storable.
     * @return string Name of the storable.
     * @access public
     */
    function getName() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Sets the name (primary key) of the storable.
     * @param string $name Name of the storable.
     * @access public
     */
    function setName($name) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Gets the path (descriptor) of the storable.
     * @return string Path of the storable.
     * @access public
     */
    function getPath() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Sets the path (descriptor) of the storable.
     * @param string $path Path of the storable.
     * @access public
     */
    function setPath($path) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Gets the data content of the storable.
     * @return mixed Data content of the storable.
     * @access public
     */
    function getData() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Gets the size of the data content of the storable.
     * @return integer Size of the storable in bytes.
     * @access public
     */
    function getSize() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>