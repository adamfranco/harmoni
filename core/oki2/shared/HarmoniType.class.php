<?

require_once(OKI2."/osid/shared/Type.php");

/**
 * A generic type for Harmoni. Constructor takes the desired authority, domain, keyword,
 * and description.
 *
 * @package harmoni.osid.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniType.class.php,v 1.3 2005/01/19 17:39:40 adamfranco Exp $
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