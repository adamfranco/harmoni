<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The DatabaseStorableDataContainer stores several arguments that will be passed
 * to the constructor of a DatabaseHierarchicalAuthorizationMethod object.
 * 
 * @package harmoni.authorization
 * @version $Id: HarmoniSharedManagerDataContainer.class.php,v 1.2 2004/04/01 22:44:14 dobomode Exp $
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
	 * 
	 * <code>typeTable</code> - the name of the table that will store types
	 * <code>typeTable_idColumn</code> - the name of the column in the type table storing the id
	 * <code>typeTable_domainColumn</code> - the name of the column in the type table storing the domain
	 * <code>typeTable_authorityColumn</code> - the name of the column in the type table storing the authority
	 * <code>typeTable_keywordColumn</code> - the name of the column in the type table storing the keyword
	 * <code>typeTable_descriptionColumn</code> - the name of the column in the type table storing the description
	 * 
 	 * <code>agentTable</code> - the name of the table that will store the agents
	 * <code>agentTable_idColumn</code> - the name of the column in the agent table storing the id
	 * <code>agentTable_displayNameColumn</code> - the name of the column in the agent table storing the display name
	 * <code>agentTable_fkTypeColumnColumn</code> - the name of the column in the agent table storing the foreign key to the type table
	 * 
	 * <code>groupTable</code> - the name of the table that will store the groups
	 * <code>agentGroupJoinTable</code> - the name of the join table for the groups and agents.
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

		$this->add("typeTable", $stringValidatorRule);
		$this->add("typeTable_idColumn", $stringValidatorRule);
		$this->add("typeTable_domainColumn", $stringValidatorRule);
		$this->add("typeTable_authorityColumn", $stringValidatorRule);
		$this->add("typeTable_keywordColumn", $stringValidatorRule);
		$this->add("typeTable_descriptionColumn", $stringValidatorRule);

		$this->add("agentTable", $stringValidatorRule);
		$this->add("agentTable_idColumn", $stringValidatorRule);
		$this->add("agentTable_displayNameColumn", $stringValidatorRule);
		$this->add("agentTable_fkTypeColumn", $stringValidatorRule);
		
		$this->add("groupTable", $stringValidatorRule);
		$this->add("agentGroupJoinTable", $stringValidatorRule);
    } 
}

?>