<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 * 
 * @version $Id: DefaultFunctionType.class.php,v 1.1 2004/06/14 03:38:19 dobomode Exp $
 * @package harmoni.osid.authorization
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DefaultFunctionType extends HarmoniType {

	function DefaultFunctionType() {
		$this->HarmoniType("harmoni", "authorization", "function");
	}

}

?>