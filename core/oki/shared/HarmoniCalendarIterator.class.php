<?
/**
 * @package harmoni.osid_v1.shared
 */

require_once(OKI."shared.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 *
 * @package harmoni.osid_v1.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniCalendarIterator.class.php,v 1.5 2005/02/04 15:59:07 adamfranco Exp $
 */
class HarmoniCalendarIterator
	extends CalendarIterator
{ // begin CalendarIterator

	/**
	 * @var array $_calendars The stored Calendars.
	 * @access private
	 */
	var $_calendars = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniCalendarIterator (& $calendarArray) {
		// make sure that we get an array of DigitalRepository objects
		ArgumentValidator::validate($calendarArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("DateTime")));
		
		// load the types into our private array
		foreach ($calendarArray as $key => $val) {
			$this->_calendars[] =& $calendarArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_calendars)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_calendars[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "CalendarIterator", 1));
		}
	}

} // end CalendarIterator

?>