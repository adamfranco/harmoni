<?php

/**
 * Framework Configuration
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: framework.cfg.php,v 1.2 2005/04/07 15:12:31 adamfranco Exp $
 */



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

/**
 * Define the path of our custom version of Archive/Tar with a fix for
 * bug #14058
 *		http://pear.php.net/bugs/bug.php?id=14058
 */
if (!defined('ARCHIVE_TAR_PATH'))
	define('ARCHIVE_TAR_PATH', HARMONI_BASE.'/Pear/Archive/Tar.php');