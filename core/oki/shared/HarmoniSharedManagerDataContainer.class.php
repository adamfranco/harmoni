<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The DatabaseStorableDataContainer stores several arguments that will be passed
 * to the constructor of a DatabaseHierarchicalAuthorizationMethod object.
 * 
 * @package harmoni.authorization
 * @version $Id: HarmoniSharedManagerDataContainer.class.php,v 1.1 2004/03/30 23:39:26 dobomode Exp $
 * @copyright 2003
 */

class HarmoniSharedManagerDataContainer extends DataContainer {

    /**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
     * <br /><br />
	 * This container includes the following fields:
	 * <br />
	 * <code>dbIndex</code> - the index of the database connection that the
	 * shared manager will use as returned by the DBHandler service.
	 * <code>sharedDB</code> - the name of the database where the various tables
	 * for the ids, agents, and groups will be.
	 * <code>idTable</code> - the name of the table that will store the ids
	 * <code>idTable_valueColumn</code> - the name of the column that stores all the ids
	 * <code>idTable_sequenceName</code> - the name of the autoincrement sequence for the id column
	 * <code>agentTable</code> - the name of the table that will store the agents
	 * <code>groupTable</code> - the name of the table that will store the groups
	 * <code>agentGroupJoinTable</code> - the name of the join table for the groups and agents.
	 * 
	 * 
     * @see {@link HarmoniSharedManager}
     * @see {@link DataContainer}
     * @access public
     */
    function HarmoniSharedManagerDataContainer()
    { 
        // initialize the data container
        $this->init(); 
		
        // add the fields we want to allow
		$integerValidatorRule =& new IntegerValidatorRule();
		$stringValidatorRule =& new StringValidatorRule();

		$this->add("dbIndex", $integerValidatorRule);
		$this->add("sharedDB", $stringValidatorRule);

		$this->add("idTable", $stringValidatorRule);
		$this->add("idTable_valueColumn", $stringValidatorRule);
		$this->add("idTable_sequenceName", $stringValidatorRule);

		$this->add("agentTable", $stringValidatorRule);
		$this->add("groupTable", $stringValidatorRule);
		$this->add("agentGroupJoinTable", $stringValidatorRule);
    } 
} 

?>