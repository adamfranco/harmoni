<?php

require_once("Error.interface.php");

/**
 * An error class interface provides functionality to create Error objects 
 * to be used by the ErrorHandler
 *
 * @version $Id: Error.class.php,v 1.2 2003/06/25 15:13:07 movsjani Exp $
 * @package harmoni.errorhandler
 * @copyright 2003 
 **/

class Error extends ErrorInterface{
    
    var $_description;
    var $_type;
    var $_isFatal;

    function Error($description,$type = "",$isFatal = false) {
		$this->_description = $description;
		$this->_type = $type;
		$this->_isFatal = $isFatal;
    }
    
    /**
     * @return string Description of the error.
     * @access public
     */
    function getDescription() {
		return $this->_description;
    }

    /**
     * @return string Type of the error.
     * @access public
     */
    function getType() {
		return $this->_type;
    }

    /**
     * @return boolean Whether the execution of the scirpt should be halted after this error has occured.
     * @access public
     */
    function isFatal() {
		return $this->_isFatal;
    }
}

?>