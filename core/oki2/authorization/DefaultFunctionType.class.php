<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 * 
 * @version $Id: DefaultFunctionType.class.php,v 1.2 2005/01/18 16:39:59 adamfranco Exp $
 * @package harmoni.osid.authorization
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DefaultFunctionType 
	extends HarmoniType 
{

	function DefaultFunctionType() {
		$this->HarmoniType("harmoni", "authorization", "function");
	}

}

?>