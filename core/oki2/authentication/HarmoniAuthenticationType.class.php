<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 * 
 * @version $Id: HarmoniAuthenticationType.class.php,v 1.1 2005/01/11 17:40:07 adamfranco Exp $
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