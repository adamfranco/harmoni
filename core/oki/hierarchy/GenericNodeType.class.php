<?
/**
 * @package harmoni.osid_v1.hierarchy
 */

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GenericNodeType.class.php,v 1.6 2005/02/04 15:59:05 adamfranco Exp $
 */
class GenericNodeType
	extends HarmoniType
{ // begin Type

	function GenericNodeType() {
		$this->HarmoniType("harmoni", "hierarchy", "generic_node");
	}

} // end Type

?>