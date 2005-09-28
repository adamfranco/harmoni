<?PHP

/**
 * This file sets up global harmoni options, includes important files,
 * and defines a few crucial functions.
 *
 *
 * @package harmoni
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: harmoni.inc.php,v 1.42 2005/09/28 20:51:24 gabeschine Exp $
 */

 /* :: start the output buffer, if it's not already :: */
if (!ob_get_level()) ob_start();
 
/**
 * Defines the global harmoni directory.
 * @const string HARMONI The harmoni core directory.
 **/

define("HARMONI",dirname(__FILE__).DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR);

/**
 * Defines the global harmoni directory.
 * @const string HARMONI_BASE The base harmoni directory.
 **/

define("HARMONI_BASE",dirname(__FILE__).DIRECTORY_SEPARATOR);
define("HARMONIBASE",HARMONI_BASE);

define("SIMPLE_TEST",HARMONI.DIRECTORY_SEPARATOR."simple_test".DIRECTORY_SEPARATOR);

/**
 * Defines where OKI interfaces for PHP are located.
 * @const string OKI The OKI interfaces location.
 */
define("OKI",dirname(__FILE__).DIRECTORY_SEPARATOR."oki".DIRECTORY_SEPARATOR);
define("OKI2",dirname(__FILE__).DIRECTORY_SEPARATOR."oki2".DIRECTORY_SEPARATOR);
//require_once(OKI."inc.php");

/*********************************************************
 * if magic quotes on then get rid of them as we assume that
 * they are off.
 *********************************************************/
if (get_magic_quotes_gpc()) {
	// but really throw an error
	print '
	<HTML>
		<HEAD>
			<TITLE>ERROR</TITLE>
			<STYLE TYPE="text/css">
				body {
					background-color: #eee;
					margin: 50px 150px 50px 150px;
					padding: 30px;
					color: #333;
					font-family: Verdana;

					border: 1px dotted #555;
				}

				body p {
					font-size: 12px;
					text-align: center;
					color: #955;
				}

				body div {
					font-size: 18px;
					font-weight: normal;
				}
			</STYLE>
		</HEAD>

		<BODY>
			<P>Harmoni could not be initialized for the following reason:</P>
			<DIV>
				PHP\'s config directive <b>magic_quotes_gpc</b> is set to <b>On</b> and should be <b>Off</b>.
			</DIV>
		</BODY>
	</HTML>';
	exit(1);
	
	function array_walk_stripslashes(&$val, $key) {
		if (is_array($val)) array_walk($val, 'array_walk_stripslashes');
		else $val = stripslashes($val);
	}
   array_walk($_GET, 'array_walk_stripslashes');
   array_walk($_POST, 'array_walk_stripslashes');
   array_walk($_COOKIE, 'array_walk_stripslashes');
}


/*********************************************************
 *  Create the Harmoni object - required
 *********************************************************/
/* :: load the Framework config file :: */
require_once(HARMONIBASE."config/framework.cfg.php");
$harmoni =& Harmoni::instance();

/*********************************************************
 * Services
 *********************************************************/
/**
 * The name of the services variable.
 * @const SERVICES_OBJECT The name of the services variable.
 **/
define("SERVICES_OBJECT","__services__");

/* :: load the services :: */
require_once(HARMONI."services/Services.class.php");

/**
 * The global Services object.
 * @var object Services $__services__ The global Services object.
 **/
$__services__ =& new Services();
$GLOBALS[SERVICES_OBJECT] =& $__services__;

/* :: load the Services registration config file :: */
require_once(HARMONIBASE."config/services.cfg.php");


/*********************************************************
 * include other useful things
 *********************************************************/
require_once(HARMONI."utilities/TemplateFactory.class.php");
require_once(HARMONI."utilities/StringFunctions.class.php");
require_once(HARMONI."utilities/MIMETypes.class.php");
require_once(HARMONI."architecture/events/EventTrigger.abstract.php");
require_once(HARMONI."architecture/events/EventListener.interface.php");


?>