<?php
/**
 * @since 5/3/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeZone.class.php,v 1.2 2005/05/05 23:09:48 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 

require_once("SObject.class.php");

/**
 * TimeZone is a simple class to colect the information identifying a UTC time zone.
 * 
 * offset			-	Duration	- the time zone's offset from UTC
 * abbreviation	-	String		- the abbreviated name for the time zone.
 * name			-	String		- the name of the time zone.
 * 
 * TimeZone class >> #timeZones returns an array of the known time zones
 * TimeZone class >> #defaultTimeZone returns the default time zone (Grenwich Mean Time)
 * 
 * @since 5/3/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeZone.class.php,v 1.2 2005/05/05 23:09:48 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class TimeZone 
	extends SObject
{
	
	/**
	 * Create a new Timezone.
	 * 
	 * @param object Duration $aDuration
	 * @param string $aStringName
	 * @param string $aStringAbbriviation
	 * @return object TimeZone
	 * @access public
	 * @since 5/3/05
	 */
	function &offsetNameAbbreviation ( $aDuration, $aStringName, $aStringAbbreviation ) 
	{
		return new TimeZone ($aDuration, $aStringName, $aStringAbbreviation );
	}
	
	/**
	 * Answer the default time zone - GMT
	 * 
	 * @return object TimeZone
	 * @access public
	 * @since 5/3/05
	 * @static
	 */
	function &defaultTimeZone () {
		return TimeZone::offsetNameAbbreviation(
					Duration::withHours(0),
					'Greenwich Mean Time',
					'GMT');
	}
	
	/**
	 * Return an Array of TimeZones
	 * 
	 * @return array
	 * @access public
	 * @since 5/3/05
	 * @static
	 */
	function &timeZones () {
		return array (
			TimeZone::offsetNameAbbreviation(
				Duration::withHours(0),
				'Universal Time',
				'UTC'),
			TimeZone::offsetNameAbbreviation(
				Duration::withHours(0),
				'Greenwich Mean Time',
				'GMT'),
			TimeZone::offsetNameAbbreviation(
				Duration::withHours(0),
				'British Summer Time',
				'BST'),
			TimeZone::offsetNameAbbreviation(
				Duration::withHours(2),
				'South African Standard Time',
				'SAST'),
			TimeZone::offsetNameAbbreviation(
				Duration::withHours(-8),
				'Pacific Standard Time',
				'PST'),
			TimeZone::offsetNameAbbreviation(
				Duration::withHours(-7),
				'Pacific Daylight Time',
				'PDT'),
			
		);
	}
	
	/**
	 * Create a new Timezone.
	 * 
	 * @param object Duration $aDuration
	 * @param string $aStringName
	 * @param string $aStringAbbriviation
	 * @return object TimeZone
	 * @access private
	 * @since 5/3/05
	 */
	function TimeZone ( $aDuration, $aStringName, $aStringAbbreviation ) {
		$this->offset =& $aDuration;
		$this->name = $aStringName;
		$this->abbreviation = $aStringAbbreviation;
	}	
	
	/**
	 * Return the offset of this TimeZone
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/3/05
	 */
	function &offset () {
		return $this->offset;
	}
	
	
}

?>