<?php

require_once(OKI2."/osid/shared/Id.php");

/**
 * Id represents a unique identifier. A String representation of the unique
 * identifier is available with getIdString().	To convert from a String
 * representation of the identifier to the identifier object,
 * org.osid.shared.Id, use getId(String). Id can determine if it is equal to
 * another Id.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniId.class.php,v 1.11 2007/04/12 15:37:33 adamfranco Exp $
 */
class HarmoniId 
	extends Id 
{

	/**
	 * @var string $_id The id of this id.
	 */
	 var $_id;
	
	/**
	 * Constructor. Creates a HarmoniId with id = $id or a new unique id if $id is NULL.
	 * @param string $id The desired id. If NULL, a new unique id is used.
	 *
	 */
	function HarmoniId ( $id  ) {
		// ** parameter validation
		ArgumentValidator::validate($id, 
			OrValidatorRule::getRule(
				NonzeroLengthStringValidatorRule::getRule(),
				IntegerValidatorRule::getRule()), 
			true);
		// ** end of parameter validation
		
// 		if (ereg('^#.+$', $id))
			$this->_id = $id;
// 		else
// 			$this->_id = '#'.md5($id);
	}

	/**
	 * Return the String representation of this unique Id.
	 *	
	 * @return string
	 * 
	 * @throws object SharedException An exception with one of the
	 *		   following messages defined in org.osid.shared.SharedException
	 *		   may be thrown:  {@link
	 *		   org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.shared.SharedException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.shared.SharedException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getIdString () { 
		return $this->_id;
	}
	
	/**
 	 * Answer a String whose characters are a description of the receiver.
 	 * Override this method as needed to provide a better representation
 	 * 
 	 * @return string
 	 * @access public
 	 * @since 7/11/05
 	 */
 	function printableString () {
 		return $this->getIdString();
 	}

	/**
	 * Tests if an unique Id equals this unique Id.
	 * 
	 * @param object Id $id
	 *	
	 * @return boolean
	 * 
	 * @throws object SharedException An exception with one of the
	 *		   following messages defined in org.osid.shared.SharedException
	 *		   may be thrown:  {@link
	 *		   org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.shared.SharedException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.shared.SharedException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.shared.SharedException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function isEqual ( &$id ) {
		// Validate the arguments
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"));
		
		return ($id->getIdString() == $this->_id) ? true : false;
	}

}

?>