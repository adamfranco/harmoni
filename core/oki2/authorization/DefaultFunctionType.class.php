<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultFunctionType.class.php,v 1.4 2005/01/19 22:28:15 adamfranco Exp $
 */

class DefaultFunctionType 
	extends HarmoniType 
{

	function DefaultFunctionType() {
		$this->HarmoniType("harmoni", "authorization", "function");
	}

}

?>