<?

/**
 * This file sets up global harmoni options... ....
 *
 * @version $Id: harmoni.inc.php,v 1.3 2003/06/24 21:14:41 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni
 * @access public
 **/

/**
 * Define the global harmoni directory.
 * 
 * Define the global harmoni directory.
 * @const HARMONI The harmoni directory.
 **/
define("HARMONI",dirname(__FILE__)."/");

/**
 * @const SERVICES_OBJECT The name of the services variable.
 **/
define("SERVICES_OBJECT","__services__");

require_once(HARMONI."services/Services.class.php");
// Create the globally referenced services object
$__services__ =& new Services;