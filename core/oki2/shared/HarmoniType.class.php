<?

require_once(OKI2."/osid/shared/Type.php");

/**
 * A generic type for Harmoni. Constructor takes the desired authority, domain, keyword,
 * and description.
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniType.class.php,v 1.4 2005/01/19 22:28:26 adamfranco Exp $
 */

class HarmoniType
	extends Type
{

}

function OKITypeToString(&$type, $glue=", ") {
	ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"));
	return $type->getDomain() . $glue . $type->getAuthority() . $glue . $type->getKeyword();
}

?>