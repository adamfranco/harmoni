<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 * 
 * @version $Id: DefaultFunctionType.class.php,v 1.3 2005/01/19 22:27:48 adamfranco Exp $
 *
 * @package harmoni.osid_v1.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultFunctionType.class.php,v 1.3 2005/01/19 22:27:48 adamfranco Exp $
 **/

class DefaultFunctionType extends HarmoniType {

	function DefaultFunctionType() {
		$this->HarmoniType("harmoni", "authorization", "function");
	}

}

?>