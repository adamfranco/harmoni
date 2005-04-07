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
 * @package harmoni.storage
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: storage.cfg.php,v 1.4 2005/04/07 15:12:32 adamfranco Exp $
 */

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