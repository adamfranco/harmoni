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
 * @version $Id: HarmoniAuthenticationType.class.php,v 1.4 2005/02/07 21:38:19 adamfranco Exp $
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