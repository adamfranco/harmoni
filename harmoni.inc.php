<?PHP

/**
 * This file sets up global harmoni options, includes important files,
 * and defines a few crucial functions.
 *
 * @version $Id: harmoni.inc.php,v 1.16 2003/08/20 21:20:03 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni
 * @access public
 **/

/* :: start the output buffer, if it's not already :: */
if (!ob_get_level()) ob_start();
 
/**
 * Defines the global harmoni directory.
 * @const string HARMONI The harmoni directory.
 * @const string HARMONI_BASE The base harmoni directory.
 **/
define("HARMONI",dirname(__FILE__)."/core/");
define("HARMONI_BASE",dirname(__FILE__)."/");

/**
 * Defines where OKI interfaces for PHP are located.
 * @const string OKI The OKI interfaces location.
 */
define("OKI",dirname(__FILE__)."/oki/");
require_once(OKI."inc.php");

/**
 * The name of the services variable.
 * @const SERVICES_OBJECT The name of the services variable.
 **/
define("SERVICES_OBJECT","__services__");

/* :: load the services :: */
require_once(HARMONI."services/Services.class.php");

/**
 * The global Services object.
 * @global object Services $__services__ The global Services object.
 **/
$__services__ =& new Services();

/* :: load the Services registration config file :: */
require_once(HARMONI_BASE."config/services.cfg.php");

/* :: load the harmoni class :: */
require_once(HARMONI."architecture/harmoni/Harmoni.class.php");

?>