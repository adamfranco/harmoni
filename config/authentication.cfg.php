<?php

/**
 * The Authentication config file.
 * 
 * Here, set up your various AuthenticationMethods and their options and add them to the AuthenticationHandler.
 *
 * @version $Id: authentication.cfg.php,v 1.4 2003/08/23 23:56:20 gabeschine Exp $
 * @package harmoni.authentication
 * @copyright 2003 
 **/

/**
 * REQUIRED INCLUDES & COMMANDS 
 *		no need to change these options -- go below
 **/

// :: start the service ::
Services::startService("Authentication");

// :: get the Authentication service and store in $auth ::
$auth =& Services::getService("Authentication");



/**
 * USER-CONFIGURABLE AUTHENTICATION 
 *		here, add your own methods and options for authentication. 
 * 		examples are given in commented blocks for various types of authentication.
 **/


 
 
 
 
 
 
 
/**
 * also don't touch this 
 **/
unset($auth);
?>