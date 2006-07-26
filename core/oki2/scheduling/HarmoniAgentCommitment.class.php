<?php 
 
require_once(OKI2."/osid/scheduling/AgentCommitment.php");

/**
 * AgentCommitment joins an Agent to a Status Type.  This is the Status of the
 * Commitment and not the Status of the Agent.
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
class HarmoniAgentCommitment
extends AgentCommitment
{
	
	/**
	 * @variable object $_id the unique id for this AgentCommitment.
	 * @access private
	 * @variable object $_table the AgentCommitment table.
	 * @access private
	 **/
	var $_id;
	var $_table;
	
	/**
	 * The constructor.
	 * 
	 * @param object Id $id
	 * 
	 * @access public
	 * @return void
	 */
	function HarmoniAgentCommitment(&$id)
	{
		$this->_id =& $id;
		$this->_table = 'sc_commit';
		
	}
	
	
	
    /**
     * Get the agentId of the individual associated with this Commitment.
     *  
     * @return object Id
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
    function &getAgentId () { 
    	$idManager =& Services::getService("Id");
    	$id = $this->_getField('fk_agent_id');
    	return $idManager->getId($id);
       
    } 

    /**
     * Get the Status associated with this Commitment.  For example, if the
     * commitment is a meeting, each particpant might have one of the Status
     * Type values "invited", "confirmed", "declined".
     *  
     * @return object Type
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
    function &getStatus () { 
        return $this->_getType('commit_stat');
    } 
    
    
     /**
     * Get the Schedule Item this AgentCommitment is associated with.
     *
     * <b>Warning!</b> Not in the OSID.  Use at your own risk.
     *  
     * @return object ScheduleItem
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
    function &getScheduleItem () { 
    	$ret =& new ScheduleItem($this->_id);
        return $ret;
    } 
    
    
    function _typeToIndex($typename, &$type)
	{	
		$sc=Services::getService("Scheduling");
		return $sc->_typeToIndex($typename, $type);
	}
	
	function &_getTypes($typename)
	{	
		$sc=Services::getService("Scheduling");
		return $sc->_getTypes($typename);
	}
	
	function _getField($key)
	{
		$sc=Services::getService("Scheduling");
		return $sc->_getField($this->_id,$this->_table,$key);
	}
	
	
	function &_getType($typename){
		$sc=Services::getService("Scheduling");
		return $sc->_getType($this->_id,$this->_table,$typename);
	}
	
	function _setField($key, $value)
	{
		$sc=Services::getService("Scheduling");
		return $sc->_setField($this->_id,$this->_table,$key, $value);		
	}
    
}

?>