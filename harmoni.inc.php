<?

/**
 * This file sets up global harmoni options... ....
 *
 * @version $Id: harmoni.inc.php,v 1.5 2003/06/25 20:43:49 gabeschine Exp $
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


/**
 * @global object Services $__services__ The global Services object.
 **/
$__services__ =& new Services();
