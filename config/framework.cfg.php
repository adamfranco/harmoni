<?php

/**
* Framework Configuration
*
*
* @package harmoni.services
* @version $Id: framework.cfg.php,v 1.1 2005/04/04 19:57:38 adamfranco Exp $
* @copyright 2005 Middlebury College
**/


/**
 * functionality affected: almost everything but basic services: Harmoni architecture, LoginHandler, ActionHandler
 */
if (!defined("LOAD_ARCHITECTURE")) 			define("LOAD_ARCHITECTURE", true);

/* :: load the harmoni class :: */
if (LOAD_ARCHITECTURE) require_once(HARMONI."architecture/harmoni/Harmoni.class.php");

/**
 * load ArgumentValidator
 */
require_once(HARMONI."utilities/ArgumentValidator.class.php");