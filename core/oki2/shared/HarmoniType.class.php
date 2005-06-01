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
 * @version $Id: HarmoniType.class.php,v 1.8 2005/06/01 18:33:37 adamfranco Exp $
 */

class HarmoniType
	extends Type
{

}

function OKITypeToString(&$type, $glue="::") {
	ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"));
	return $type->getDomain() . $glue . $type->getAuthority() . $glue . $type->getKeyword();
}

function &stringToOKIType($string, $glue="::") {
	ArgumentValidator::validate($string, StringValidatorRule::getRule());
	
	$parts = explode($glue, $string);
	
	return new HarmoniType($parts[0], $parts[1], $parts[2]);
}

?>