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
 * @version $Id: storage.cfg.php,v 1.2 2003/07/10 02:34:20 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.storage
 **/

/**
 * REQUIRED INCLUDES & COMMANDS 
 *		no need to change these options -- go below
 **/

// start the service
Services::startService("Storage");

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