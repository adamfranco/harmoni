<?php

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
 * @version $Id: HarmoniType.class.php,v 1.14 2008/02/06 15:37:56 adamfranco Exp $
 */

class HarmoniType
	extends Type
{

	/**
	 * Answer a type created from a string
	 * 
	 * @param string $typeString
	 * @param optional string $delimiter
	 * @return object Type
	 * @access public
	 * @since 2/5/08
	 * @static
	 */
	public static function fromString ($typeString, $delimiter = '::') {
		ArgumentValidator::validate($typeString, StringValidatorRule::getRule());

    	$parts = explode($delimiter, $typeString);
    	return new Type($parts[0], $parts[1], $parts[2]);
	}
	
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
     public static function typeToString(Type $type, $delimiter="::") {
    	return $type->getDomain() . $delimiter . $type->getAuthority() . $delimiter . $type->getKeyword();
    }
}

?>