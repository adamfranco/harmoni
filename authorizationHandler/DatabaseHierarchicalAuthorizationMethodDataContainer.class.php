<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The DatabaseStorableDataContainer stores several arguments that will be passed
 * to the constructor of a DatabaseHierarchicalAuthorizationMethod object.
 * 
 * @package harmoni.authorizationHandler
 * @version $Id: DatabaseHierarchicalAuthorizationMethodDataContainer.class.php,v 1.1 2003/07/04 03:32:34 dobomode Exp $
 * @copyright 2003
 */

class DatabaseHierarchicalAuthorizationMethodDataContainer extends DataContainer {

    /**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
     * <br><br>
	 * This container includes the following fields:
	 * <br>
	 * <code>dbIndex</code> - the index of the database connection that the
	 * authorization method will use as returned by the DBHandler service.
	 * <br>
	 * <code>agentIdColumn</code> - the name of the database table column that stores
	 * the agent id. The column must be set up to store integers.
	 * <br>
	 * <code>agentTypeColumn</code> - the name of the database table column that stores
	 * the agent type. The column must be set up to store integers.
	 * <br>
	 * <code>functionIdColumn</code> - the name of the database table column that stores
	 * the function id. The column must be set up to store integers.
	 * <br>
	 * <code>contextIdColumn</code> - the name of the database table column that stores
	 * the context id. The column must be set up to store integers.
	 * <br>
	 * <code>contextDepthColumn</code> - the name of the database table column that stores
	 * the context hierarchy level. The column must be set up to store integers.
	 * <br>
	 * <code>authorized</code> - the name of the database table column that stores
	 * whether the agent is authorized to perform this function in this context.
	 * The column must be set up to store integers. <code>0</code> means not
	 * authorized. Anything else means authorized (though <code>1</code> is
	 * the recommended value).
	 * 
     * @see {@link DatabaseHierarchicalAuthorizationMethod}
     * @see {@link DataContainer}
     * @access public
     */
    function DatabaseHierarchicalAuthorizationMethodDataContainer()
    { 
        // initialize the data container
        $this->init(); 
		
        // add the fields we want to allow
		$integerValidatorRule =& new IntegerValidatorRule();
		$stringValidatorRule =& new StringValidatorRule();

		$this->add("dbIndex", new IntegerValidatorRule());
		$this->add("agentIdColumn", new StringValidatorRule());
		$this->add("agentTypeColumn", new StringValidatorRule());
		$this->add("functionIdColumn", new StringValidatorRule());
		$this->add("contextIdColumn", new StringValidatorRule());
		$this->add("contextDepthColumn", new StringValidatorRule());
		$this->add("authorizedColumn", new StringValidatorRule());
    } 
} 

?>