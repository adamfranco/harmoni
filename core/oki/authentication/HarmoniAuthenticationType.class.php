<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 * 
 * @version $Id: HarmoniAuthenticationType.class.php,v 1.1 2004/07/02 19:28:59 adamfranco Exp $
 * @package harmoni.osid.hierarchy2
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
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