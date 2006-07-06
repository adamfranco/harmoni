<?php 

require_once(OKI2."/osid/scheduling/Timespan.php");
 
/**
 * Timespan defines a time span in terms of a start and end date and time.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package org.osid.scheduling
 */
class HarmoniTimespan
extends Timespan
{
	
	/**
	 * @variable  long $_start the start of the time span
	 * @access private
	 * @variable long $_end the end of the time span
	 * @access private
	 **/
	var $_start;
	var $_end;
	
	/**
	 * The constructor.
	 * 
	 * @param long $_start the start of the time span
	 * @param long $_end the end of the time span
	 * 
	 * @access public
	 * @return void
	 */
	function HarmoniTimespan($_start, $_end)
	{
		$this->_start = $_start;
		$this->_end = $_end;
		
	}
	
	
    /**
     * Get the Start date and time of this Timespan.
     *  
     * @return int
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getStart () { 
       return $this->_start;     
    } 

    /**
     * Get the End date and time of this Timespan.
     *  
     * @return int
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getEnd () { 
        return $this->_end;  
    } 
}

?>