<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This Type is that which makes use of the Harmoni AuthenticationHandler.
 *
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAuthenticationType.class.php,v 1.5 2005/02/07 21:38:24 adamfranco Exp $
 */
class HarmoniAuthenticationType
	 extends HarmoniType 
{

	function HarmoniAuthenticationType() {
		$this->HarmoniType("Authentication", 
						   "Harmoni", 
						   "Login", 
						   "Authenticate using the Harmoni LoginHandler.");	
	}

}

?>