<?php

/**
 * The Authentication config file.
 * 
 * Here, set up your various AuthenticationMethods and their options and add them to the AuthenticationHandler
 *
 * @version $Id: authentication.cfg.php,v 1.1 2003/06/30 02:16:08 gabeschine Exp $
 * @package harmoni.authenticationHandler
 * @copyright 2003 
 **/

/**
 * REQUIRED INCLUDES & COMMANDS 
 *		no need to change these options -- go below
 **/

// register the Authentication Service
require_once(HARMONI."authenticationHandler/AuthenticationHandler.class.php");
Services::registerService("Authentication","AuthenticationHandler");

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