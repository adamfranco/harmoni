<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Qualifier objects.
 *
 * @package harmoni.osid_v1.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultQualifierType.class.php,v 1.3 2005/01/19 22:27:48 adamfranco Exp $
 **/
 
class DefaultQualifierType extends HarmoniType {

	function DefaultQualifierType() {
		$this->HarmoniType("harmoni", "authorization", "qualifier");
	}

}

?>