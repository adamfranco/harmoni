<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 * 
 * @version $Id: DefaultFunctionType.class.php,v 1.4 2005/02/07 21:38:19 adamfranco Exp $
 *
 * @package harmoni.osid_v1.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultFunctionType.class.php,v 1.4 2005/02/07 21:38:19 adamfranco Exp $
 **/

class DefaultFunctionType extends HarmoniType {

	function DefaultFunctionType() {
		$this->HarmoniType("harmoni", "authorization", "function");
	}

}

?>