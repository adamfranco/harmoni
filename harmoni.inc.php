<?PHP

/**
 * This file sets up global harmoni options, includes important files,
 * and defines a few crucial functions.
 *
 * @version $Id: harmoni.inc.php,v 1.20 2003/08/26 15:47:16 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni
 * @access public
 **/

/* :: start the output buffer, if it's not already :: */
if (!ob_get_level()) ob_start();
 
/**
 * Defines the global harmoni directory.
 * @const string HARMONI The harmoni core directory.
 * @const string HARMONI_BASE The base harmoni directory.
 **/

define("HARMONI",dirname(__FILE__).DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR);
define("HARMONI_BASE",dirname(__FILE__).DIRECTORY_SEPARATOR);
define("HARMONIBASE",dirname(__FILE__).DIRECTORY_SEPARATOR);
define("SIMPLE_TEST",HARMONI.DIRECTORY_SEPARATOR."simple_test".DIRECTORY_SEPARATOR);

/**
 * Defines where OKI interfaces for PHP are located.
 * @const string OKI The OKI interfaces location.
 */
define("OKI",dirname(__FILE__).DIRECTORY_SEPARATOR."oki".DIRECTORY_SEPARATOR);
//require_once(OKI."inc.php");

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
require_once(HARMONIBASE."config/services.cfg.php");

/* :: load the harmoni class :: */
require_once(HARMONI."architecture/harmoni/Harmoni.class.php");


/* :: include other useful things :: */
require_once(HARMONI."utilities/TemplateFactory.class.php");

?>
