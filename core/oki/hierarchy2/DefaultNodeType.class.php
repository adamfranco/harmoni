<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 *
 * @package harmoni.osid_v1.hierarchy2
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultNodeType.class.php,v 1.3 2005/01/19 22:28:10 adamfranco Exp $
 */

class DefaultNodeType extends HarmoniType {

	function DefaultNodeType() {
		$this->HarmoniType("harmoni", "hierarchy", "node");
	}

}

?>