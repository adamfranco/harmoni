<?php

/**
 * StorageHandler config file.
 * 
 * In this file, you can set up options specific to the StorageHandler,
 * assuming you choose to use it. 
 * 
 * Please read the documentation specific to the StorageHandler if you
 * need more information as to how it works and how to set it up.
 *
 * @version $Id: storage.cfg.php,v 1.3 2005/04/04 19:57:39 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni.storage
 **/

/**
 * REQUIRED INCLUDES & COMMANDS 
 *		no need to change these options -- go below
 **/

// start the service
require_once(OKI2."osid/OsidContext.php");
$context =& new OsidContext;
$context->assignContext('harmoni', $harmoni);

require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
$configuration =& new ConfigurationProperties;
Services::startManagerAsService("Storage", $context, $configuration);

// get the Storage service and store in $storage
$storage =& Services::getService("Storage");


/**
 * USER-CONFIGURABLE AUTHENTICATION 
 *		here, set up your methods of storage and other options. examples are
 * 		given in commented blocks below. 
 **/







/**
 * also don't touch this 
 **/
unset($storage);

?>