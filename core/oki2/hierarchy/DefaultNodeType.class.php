<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 *
 * @package harmoni.osid_v2.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultNodeType.class.php,v 1.6 2005/04/13 21:58:05 adamfranco Exp $
 **/

class DefaultNodeType 
	extends HarmoniType 
{

	function DefaultNodeType() {
		$this->HarmoniType("Hierarchy", "Harmoni", "Node", "Default node type");
	}

}

?>