<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 *
 * @package harmoni.osid_v1.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAuthenticationType.class.php,v 1.3 2005/01/19 22:27:48 adamfranco Exp $
 **/

class HarmoniAuthenticationType extends HarmoniType {

	function HarmoniAuthenticationType() {
		$this->HarmoniType("Authentication", 
						   "Harmoni", 
						   "Login", 
						   "Authenticate using the Harmoni LoginHandler.");	
	}

}

?>