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
 * @version $Id: DefaultQualifierType.class.php,v 1.4 2005/02/07 21:38:19 adamfranco Exp $
 **/
 
class DefaultQualifierType extends HarmoniType {

	function DefaultQualifierType() {
		$this->HarmoniType("harmoni", "authorization", "qualifier");
	}

}

?>