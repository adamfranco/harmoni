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
 * @version $Id: HarmoniType.class.php,v 1.9 2005/06/01 18:48:46 adamfranco Exp $
 */

class HarmoniType
	extends Type
{

	/**
	 * Convert an OKI Type to a delimited string
	 * 
	 * @param object Type $aType
	 * @param string $glue
	 * @return string
	 * @access public
	 * @since 6/1/05
	 * @static
	 */
	 function typeToString(&$aType, $glue="::") {
		ArgumentValidator::validate($aType, ExtendsValidatorRule::getRule("Type"));
		return $aType->getDomain() . $glue . $aType->getAuthority() . $glue . $aType->getKeyword();
	}
	
	/**
	 * Convert a delimited string to an OKI Type
	 * 
	 * @param string $aString
	 * @param string $glue
	 * @return object Type
	 * @access public
	 * @since 6/1/05
	 * @static
	 */
	function &stringToType($aString, $glue="::") {
		ArgumentValidator::validate($string, StringValidatorRule::getRule());
		
		$parts = explode($glue, $string);
		
		return new Type($parts[0], $parts[1], $parts[2]);
	}
}

/**
 * Convert an OKI Type to a delimited string
 * 
 * @param object Type $aType
 * @param string $glue
 * @return string
 * @access public
 * @since 6/1/05
 */
 function OKITypeToString(&$aType, $glue="::") {
	return HarmoniType::typeToString($aType, $glue);
}

/**
 * Convert a delimited string to an OKI Type
 * 
 * @param string $aString
 * @param string $glue
 * @return object Type
 * @access public
 * @since 6/1/05
 */
function &stringToOKIType($aString, $glue="::") {
	return HarmoniType::stringToType($aString, $glue);
}

?>