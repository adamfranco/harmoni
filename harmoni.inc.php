<?

/**
 * This file sets up global harmoni options... ....
 *
 * @version $Id: harmoni.inc.php,v 1.2 2003/06/24 20:35:43 adamfranco Exp $
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

require_once(HARMONI."Services/Services.class.php");
// Create the globally referenced services object
$__services__ =& new Services;