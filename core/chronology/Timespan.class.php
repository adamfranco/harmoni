<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Timespan.class.php,v 1.4 2005/05/11 03:04:46 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 

require_once("Magnitude.class.php");

/**
 * Timespan represents a duration starting at a specific DateAndTime.
 *
 * Due to PHP's lack of decent date/time objects, handling of dates and times in
 * Harmoni here-to-for required swapping between various timestamp and date string 
 * represtations and other simple chronological objects that were never very 
 * universal. 
 * 
 * This package is a PHP implemenation of the Squeak (Smalltalk)
 * Kernel-Chronology package. The original Smalltalk implementation is licensed
 * under the Squeak License {@link http://squeak.org/download/license.html}.
 * 
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Timespan.class.php,v 1.4 2005/05/11 03:04:46 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Timespan 
	extends Magnitude
{
	/**
	 * Answer a new object that represents now.
	 * 
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &current () {
		die("Method ".__FUNCTION__." in class ".__CLASS__
		." should have been overridden by a child class.");
	}
	
	/**
	 * Create a new object starting now, with zero duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &starting ( &$aDateAndTime ) {
		die("Method ".__FUNCTION__." in class ".__CLASS__
		." should have been overridden by a child class.");
	}
	
	/**
	 * Create a new object starting now, with zero duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param object Duration $aDuration
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &startingDuration ( &$aDateAndTime, &$aDuration ) {
		die("Method ".__FUNCTION__." in class ".__CLASS__
		." should have been overridden by a child class.");
	}
	
/*********************************************************
 * Instance Methods - Private
 *********************************************************/
 
	/**
	 * Do not use this constructor for building objects, please use the 
	 * class-methods Timespan::new(), Timespan::starting(), etcetera, instead.
	 * 
	 * @return object Timespan
	 * @access private
	 * @since 5/2/05
	 */
	function Timespan () {
		
	}

	/**
	 * Store the start DateAndTime of this timespan
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @return void
	 * @access private
	 * @since 5/4/05
	 */
	function setStart ( &$aDateAndTime ) {
		$this->start =& $aDateAndTime;
	}
	
	/**
	 * Set the Duration of this timespan
	 * 
	 * @param object Duration $aDuration
	 * @return void
	 * @access private
	 * @since 5/4/05
	 */
	function setDuration ( &$aDuration ) {
		$this->duration =& $aDuration;
	}

/*********************************************************
 * Instance Methods - Accessing
 *********************************************************/
 
	/**
	 * Answer the start DateAndTime of this timespan
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &start () {
		return $this->start;
	}
	
	/**
	 * Answer the Duration of this timespan
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/4/05
	 */
	function &duration () {
		return $this->duration;
	}

/*********************************************************
 * Instance methods - Comparing/Testing
 *********************************************************/
	
	/**
	 * Test if this Timespan is equal to a Timespan.
	 * 
	 * @param object Timespan $aTimespan
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isEqualTo ( &$aTimespan ) {
		return ($this->start->isEqualTo($aTimespan->start())
			&& $this->duration->isEqualTo($aTimespan->duration()));
	}
	
	/**
	 * Test if this Timespan is less than a comparand.
	 * 
	 * @param object $aComparand
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isLessThan ( &$aComparand ) {
		return ($this->start->isLessThan($aComparand));
	}

/*********************************************************
 * Instance methods - Operations
 *********************************************************/
	
	/**
	 * Add a Duration.
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result.
	 * @access public
	 * @since 5/3/05
	 */
	function &plus ( &$aDuration ) {
		$classname = get_class($this);
		
		$operation = $classname.'::startingDuration($this->start, 
			$this->duration->plus($aDuration));';
		
		return eval($operation);
	}
	
	/**
	 * Subtract a Duration or DateAndTime.
	 * 
	 * @param object $operand
	 * @return object
	 * @access public
	 * @since 5/3/05
	 */
	function &minus ( &$operand ) {
		$methods = get_class_methods($operand);
		
		// If this conforms to the DateAndTimeProtocal
		if (in_array('asDateAndTime', $methods)) {
			return $this->start->minus($operand);
		} 
		// If this conforms to the Duration protocal
		else {
			return $this->plus($operand->negated());
		}
	}

	/**
	 * Answer the next object of our duration.
	 * 
	 * @return object Timespan
	 * @access public
	 * @since 5/10/05
	 */
	function &next () {
		$classname = get_class($this);
		
		$operation = $classname.'::startingDuration(
			$this->start->plus($this->duration), $this->duration);';
		
		return eval($operation);
	}
	
	/**
	 * Answer the previous object of our duration.
	 * 
	 * @return object Timespan
	 * @access public
	 * @since 5/10/05
	 */
	function &previous () {
		$classname = get_class($this);
		
		$operation = $classname.'::startingDuration(
			$this->start->minus($this->duration), $this->duration);';
		
		return eval($operation);
	}
}

?>