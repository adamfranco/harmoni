<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 * 
 * @version $Id: DefaultFunctionType.class.php,v 1.2 2005/01/19 21:10:02 adamfranco Exp $
 *
 * @package harmoni.osid.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultFunctionType.class.php,v 1.2 2005/01/19 21:10:02 adamfranco Exp $
 **/

class DefaultFunctionType extends HarmoniType {

	function DefaultFunctionType() {
		$this->HarmoniType("harmoni", "authorization", "function");
	}

}

?>