<?php

/**
 * An error class interface provides functionality to create Error objects 
 * to be used by the ErrorHandler
 *
 * @version $Id: Error.interface.php,v 1.2 2003/06/26 16:05:44 movsjani Exp $
 * @package harmoni.errorhandler
 * @copyright 2003
 * @access public
 */

class ErrorInterface {

    /**
     * Gets a string description of the error.
     * Gets a string description of the error.
     * @return string Description of the error.
     * @access public
     */
    function getDescription() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Gets the type of the error.
     * Gets the type of the error.
     * @return string Type of the error.
     * @access public
     */
    function getType() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Whether the execution of the scirpt should be halted after this error has occured.
     * Whether the execution of the scirpt should be halted after this error has occured.
     * @return boolean True if the execution should be halted.
     * @access public
     */
    function isFatal() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Gets the debug backtrace information for the error.
     * Gets the debug backtrace information for the error.
     * @return The debug backtrace information the way it is stored by the debug_backtrace() function.
     * @access public
     */
    function getDebugBacktrace() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

}



?>