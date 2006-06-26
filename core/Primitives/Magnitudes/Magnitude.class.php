<?php
/**
 * @since 5/4/05
 * @package harmoni.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Magnitude.class.php,v 1.3 2006/06/26 12:55:11 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once(dirname(__FILE__)."/../Objects/SObject.class.php");

/**
 * Magnitude has methods for dealing with linearly ordered collections.
 *
 * Subclasses represent dates, times, and numbers.
 *
 * Example for interval-testing (answers a Boolean):
 *	$seven->between($five, $ten);
 *
 * No instance-variables.
 * 
 * @since 5/4/05
 * @package harmoni.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Magnitude.class.php,v 1.3 2006/06/26 12:55:11 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Magnitude 
	extends SObject
{

	/**
	 * Test if this is less than aMagnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 */
	function isLessThan ( &$aMagnitude ) {
		die("Method ".__FUNCTION__." in class ".__CLASS__
			." should have been overridden by a child class.");
	}
	
	/**
	 * Test if this is equal to aMagnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 */
	function isEqualTo ( &$aMagnitude ) {
		die("Method ".__FUNCTION__." in class ".__CLASS__
		." should have been overridden by a child class.");
	}
		
	/**
	 * Test if this is greater than aMagnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isGreaterThan ( &$aMagnitude ) {
		return $aMagnitude->isLessThan($this);
	}
	
	/**
	 * Test if this is greater than aMagnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isLessThanOrEqualTo ( &$aMagnitude ) {
		return ! $this->isGreaterThan($aMagnitude);
	}
	
	/**
	 * Test if this is greater than aMagnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isGreaterThanOrEqualTo ( &$aMagnitude ) {
		return ! $this->isLessThan($aMagnitude);
	}
	
	/**
	 * Answer whether the receiver is less than or equal to the argument, max, 
	 * and greater than or equal to the argument, min.
	 * 
	 * @param object Magnitude $min
	 * @param object Magnitude $max
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 */
	function isBetween ( &$min, &$max ) {
		return ($this->isGreaterThanOrEqualTo($min) && $this->isLessThanOrEqualTo($max));
	}
	
	/**
	 * Answer the receiver or the argument, whichever has the greater 
	 * magnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return object Magnitude
	 * @access public
	 * @since 5/4/05
	 */
	function &max ( &$aMagnitude ) {
		if ($this->isGreaterThan($aMagnitude))
			return $this;
		else
			return $aMagnitude;
	}
	
	/**
	 * Answer the receiver or the argument, whichever has the lesser 
	 * magnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return object Magnitude
	 * @access public
	 * @since 5/4/05
	 */
	function &min ( &$aMagnitude ) {
		if ($this->isLessThan($aMagnitude))
			return $this;
		else
			return $aMagnitude;
	}
}

?>