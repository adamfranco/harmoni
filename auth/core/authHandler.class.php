<?php
/************************************************************************
  			authhandler.php - Copyright gabe

**************************************************************************/


/**
  * class authHandler
  * the authentication handler - creates and administers authModules for user
  * authentication
  */

class authHandler
{


  /**Attributes: */

    /**
      * array of authModules installed
      * @access private
      */
    var $modules = array();
    /**
      * number of modules we've registered
      * @access private
      */
    var $numModules = 0;
    /**
      * config handler
      * @access private
      */
    var $cfg = NULL;
    /**
      * has there been a login error?
      * @access private
      */
    var $error = false;
    /**
      * number of validated authModules
      * @access private
      */
    var $numValid = 0;
    /**
      * have we checked a user this session?
      * @access private
      */
    var $checked;

  /**
    * called upon instantiation
    */
  function authHandler( )
  {
    $this->cfg = & new configHandler();
    // setup the config-options
    
  }


  /**
    * checks user's password against all authModules
    * @param username
    *      username to be checked
    * @param password
    *      user's password
    */
  function checkUser( $username,  $password )
  {
    
  }


  /**
    * will check if the user (checked by checkUser) was valid.
    * @param inMods
    *      (optional) command-separated list of modules to check, otherwise checks all.
    */
  function isValid( $inMods = "" )
  {
    
  }


}
?>
