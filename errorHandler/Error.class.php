<?php

require_once("Error.interface.php");

/**
 * An error class interface provides functionality to create Error objects 
 * to be used by the ErrorHandler
 *
 * @version $Id: Error.class.php,v 1.1 2003/06/24 20:53:28 gabeschine Exp $
 * @package harmoni.errorhandler
 * @copyright 2003 
 * @access public
 **/

class Error extends ErrorInterface{
    /**
     * @var string $_description The discription of the error
     * @access private
     */
    var $_description;
    
    /**
     * @var string $_type The type of the error.
     * @access private
     */
    var $_type;
    
    /**
     * @var bolean $_isFatal True if the error should halt execution.
     * @access private
     */
    var $_isFatal;
	
	/**
	 * The constructor. Create a new error.
	 * The constructor. Create a new error.
	 * @param string $description A description of the error.
	 * @param string $type The type of error. For sorting purposes. ie.: "user", "db", etc.
	 * @param boolean $isFatal True if the error should halt execution.
	 * @access public
	 */
    function Error($description,$type = "",$isFatal = false) {
		$this->_description = $description;
		$this->_type = $type;
		$this->_isFatal = $isFatal;
    }
    
    /**
     * Gets a string description of the error.
     * Gets a string description of the error.
     * @return string Description of the error.
     * @access public
     */
    function getDescription() {
		return $this->_description;
    }

    /**
     * Gets the type of the error.
     * Gets the type of the error.
     * @return string Type of the error.
     * @access public
     */
    function getType() {
		return $this->_type;
    }

    /**
     * Whether the execution of the scirpt should be halted after this error has occured.
     * Whether the execution of the scirpt should be halted after this error has occured.
     * @return boolean True if the execution should be halted.
     * @access public
     */
    function isFatal() {
		return $this->_isFatal;
    }
}

?>