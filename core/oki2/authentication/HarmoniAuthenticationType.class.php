<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This Type is that which makes use of the Harmoni AuthenticationHandler.
 * 
 * @version $Id: HarmoniAuthenticationType.class.php,v 1.2 2005/01/18 16:38:58 adamfranco Exp $
 * @package harmoni.osid.authentication
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

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