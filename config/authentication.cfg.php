<?php

/**
 * The Authentication config file.
 * 
 * Here, set up your various AuthenticationMethods and their options and add them to the AuthenticationHandler.
 *
 * @version $Id: authentication.cfg.php,v 1.2 2003/07/06 21:31:28 gabeschine Exp $
 * @package harmoni.authenticationHandler
 * @copyright 2003 
 **/

/**
 * REQUIRED INCLUDES & COMMANDS 
 *		no need to change these options -- go below
 **/

// start the service
Services::startService("Authentication");

// get the Authentication service and store in $auth
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