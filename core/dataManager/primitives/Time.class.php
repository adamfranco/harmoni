<?

require_once(HARMONI."utilities/DateTime.class.php");

/**
 * A simple Time (and date) data type, which takes advantage of the {@link DateTime} utility class.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Time.class.php,v 1.5 2005/03/29 19:44:13 adamfranco Exp $
 */
class Time extends DateTime /* implements Primitive */ {
	
	function Time(/* variable-length parameter list */) {
		$numargs = func_num_args();
		$args = func_get_args();
		
		switch ($numargs) {
			// input for no arguments.
			case 0:
				// we weren't passed anything, so just initilize with defaults.
				$this->_year = 1970;
				$this->_month = 1;
				$this->_day = 1;
				$this->_hours = 0;
				$this->_minutes = 0;
				$this->_seconds = 0;
				
				break;
			
			// input for one argument.
			case 1:
				$arg = $args[0];
				
				switch (TRUE) {
				
					// If we are passed a DateTime
					case (is_object($arg)):
						ArgumentValidator::validate($arg, ExtendsValidatorRule::getRule("DateTime"));
						$this->_year = $arg->getYear();
						$this->_month = $arg->getMonth();
						$this->_day = $arg->getDay();
						$this->_hours = $arg->getHours();
						$this->_minutes = $arg->getMinutes();
						$this->_seconds = $arg->getSeconds();
						break;
					
					// YYYYMMDDHHmmSS timestamp form (or substring)
					case (preg_match("/^[0-9]{4,14}$/", $arg)):
						$this->_year = substr($arg, 0,4);
						$this->_month = substr($arg, 4,2);
						$this->_day = substr($arg, 6,2);
						$this->_hours = substr($arg, 8,2);
						$this->_minutes = substr($arg, 10,2);
						$this->_seconds = substr($arg, 12,2);
						break;
					
					// YYYY-MM-DD HH:mm:SS timestamp form (or substring)
					case (preg_match("/^([0-9]{4})-?([0-9]{2})?-?([0-9]{2})?\s?([0-9]{2})?:?([0-9]{2})?:?([0-9]{2})?$/", $arg, $parts)):
						$this->_year = intval($parts[1]);
						$this->_month = intval($parts[2]);
						$this->_day = intval($parts[3]);
						$this->_hours = intval($parts[4]);
						$this->_minutes = intval($parts[5]);
						$this->_seconds = intval($parts[6]);
						break;
					
					default:
						throwError(new Error("Unsupported Time form, '$arg'.", "Time", TRUE));
				}
				
				break;
			
			default:
				throwError(new Error("Invalid number of arguments, $numargs.", "Time", TRUE));
		}
		
		// Check that our values are in the correct range
		if (!$this->_year)
			$this->_year = 1970;
			
		if (!$this->_month)
			$this->_month = 1;
		if ($this->_month < 1 || $this->_month > 12)
			throwError(new Error("Month, '".$this->_month."', is out of range.", "Time", TRUE));
			
		if (!$this->_day)
			$this->_day = 1;
		if ($this->_day < 1 || $this->_day > 31)
			throwError(new Error("Day, '".$this->_day."', is out of range.", "Time", TRUE));
			
		if (!$this->_hours)
			$this->_hours = 0;
		if ($this->_hours < 0 || $this->_hours > 24)
			throwError(new Error("Hours, '".$this->_hours."', is out of range.", "Time", TRUE));
			
		if (!$this->_minutes)
			$this->_minutes = 0;
		if ($this->_minutes < 0 || $this->_minutes > 60)
			throwError(new Error("Minutes, '".$this->_minutes."', is out of range.", "Time", TRUE));
			
		if (!$this->_seconds)
			$this->_seconds = 0;
		if ($this->_seconds < 0 || $this->_seconds > 60)
			throwError(new Error("Seconds, '".$this->_seconds."', is out of range.", "Time", TRUE));
	}
	
	/**
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 */
	function isEqual(&$object)
	{
		return DateTime::compare($this,$object)==0?true:false;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->setDate($object->toTimestamp());
	}
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &clone()
	{
		$new =& new Time();
		$new->setDate($this->toTimestamp());
		return $new;
	}
	
	/**
	 * This function is the same as {@link DateTime::now()} but returns a Time object instead of a DateTime.
	 * @access public
	 * @return ref object A new Time object representing the current date and time.
	 * @static
	 */
	function &now()
	{
		$newTime =& new Time();
		$newTime->setDate(time());
		
		return $newTime;
	}
	
}