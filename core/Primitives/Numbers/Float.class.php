<?

/**
 * @since 7/14/05
 * @package harmoni.primitives.numbers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Float.class.php,v 1.2 2005/07/14 16:23:21 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/Number.class.php");

/**
 * A simple Float data type.
 *
 * @package harmoni.primitives.numbers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Float.class.php,v 1.2 2005/07/14 16:23:21 adamfranco Exp $
 */
class Float 
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
	 * @return object Float
	 * @access public
	 * @since 7/14/05
	 */
	function &withValue ( $value, $class = 'Float') {
		return parent::withValue($value, $class);
	}
	
	/**
	 * Answer a new object with the value zero
	 * 
	 * @param optional string $class The class to instantiate. Do NOT use outside 
	 *		of this package.
	 * @return object Float
	 * @access public
	 * @since 7/14/05
	 */
	function &zero ( $class = 'Float') {
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
		$class =& get_class($this);
		eval('return '.$class.'::withValue($this->value() + $aNumber->value());');
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
		$class =& get_class($this);
		eval('return '.$class.'::withValue($this->value() * $aNumber->value());');
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
		$class =& get_class($this);
		eval('return '.$class.'::withValue($this->value() / $aNumber->value());');
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
		$this->_value = floatval($value);
	}
}