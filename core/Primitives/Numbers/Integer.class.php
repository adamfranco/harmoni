<?

/**
 * @since 7/14/05
 * @package harmoni.primitives.numbers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Integer.class.php,v 1.2 2005/07/14 16:23:21 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/Number.class.php");

/**
 * A simple Integer data type.
 *
 * @package harmoni.primitives.numbers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Integer.class.php,v 1.2 2005/07/14 16:23:21 adamfranco Exp $
 */
class Integer 
	extends Number
{
	
/*********************************************************
 * Class Methods - Instance Creation
 *********************************************************/

	/**
	 * Answer a new object with the value specified
	 * 
	 * @param mixed $value
	 * @param optional string $class The class to instantiate. Do NOT use outside 
	 *		of this package.
	 * @return object Integer
	 * @access public
	 * @since 7/14/05
	 */
	function &withValue ( $value, $class = 'Integer') {
		return parent::withValue($value, $class);
	}
	
	/**
	 * Answer a new object with the value zero
	 * 
	 * @param optional string $class The class to instantiate. Do NOT use outside 
	 *		of this package.
	 * @return object Integer
	 * @access public
	 * @since 7/14/05
	 */
	function &zero ( $class = 'Integer') {
		return parent::zero($class);
	}
		
/*********************************************************
 * Instance Methods - Arithmatic
 *********************************************************/
	
	/**
	 * Answer the sum of the receiver and aNumber.
	 * 
	 * @param object Number $aNumber
	 * @return object Number
	 * @access public
	 * @since 7/14/05
	 */
	function &plus ( &$aNumber ) {
		if (!(strtolower($class) == strtolower('Integer')
			|| is_subclass_of(new $class, 'Integer')))
		{
			return Integer::withValue($this->value() + $aNumber->value());
		} else {
			return Float::withValue($this->value() + $aNumber->value());
		}
	}
	
	/**
	 * Answer the result of multiplying the receiver and aNumber.
	 * 
	 * @param object Number $aNumber
	 * @return object Number
	 * @access public
	 * @since 7/14/05
	 */
	function &multipliedBy ( &$aNumber ) {
		if (!(strtolower($class) == strtolower('Integer')
			|| is_subclass_of(new $class, 'Integer')))
		{
			return Integer::withValue($this->value() * $aNumber->value());
		} else {
			return Float::withValue($this->value() * $aNumber->value());
		}
	}
	
	/**
	 * Answer the result of dividing the receiver and aNumber.
	 * 
	 * @param object Number $aNumber
	 * @return object Number
	 * @access public
	 * @since 7/14/05
	 */
	function &dividedBy ( &$aNumber ) {
		return Float::withValue($this->value() / $aNumber->value());
	}
	
/*********************************************************
 * Instance Methods - Private
 *********************************************************/
	
	/**
	 * Set the internal value to a PHP primitive.
	 * 
	 * @param mixed $value
	 * @return void
	 * @access private
	 * @since 7/14/05
	 */
	function _setValue ( $value ) {
		$this->_value = intval($value);
	}
}