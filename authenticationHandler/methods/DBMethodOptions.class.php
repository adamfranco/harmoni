<?php

require_once(HARMONI."utilities/DataContainer.abstract.php");

/**
 * The DBMethodOptions is a data container for the {@link DBAuthenticationMethod}.
 * 
 * @package harmoni.authenticationHandler
 * @version $Id: DBMethodOptions.class.php,v 1.4 2003/06/27 13:51:38 gabeschine Exp $
 * @copyright 2003 
 **/

class DBMethodOptions extends DataContainer {
	/**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
	 * @see {@link DBAuthenticationMethod}
	 * @see {@link DataContainer}
     * @access protected
	 * @return void
     */
	function DBMethodOptions(){
		// initialize the data container
		$this->init();
		
		// add the fields we want to allow
		// @todo implement all the errors!!
		$this->add("databaseType", new NumericValidatorRule);
		$this->add("databaseName", new FieldRequiredValidatorRule);
		$this->add("databaseUsername", new FieldRequiredValidatorRule);
		$this->add("databasePassword", new FieldRequiredValidatorRule);
		$this->add("databaseHost", new FieldRequiredValidatorRule);
		
		$this->add("tableName", new FieldRequiredValidatorRule);
		$this->add("usernameField", new FieldRequiredValidatorRule);
		$this->add("passwordField", new FieldRequiredValidatorRule);
		
		$this->add("passwordFieldEncrypted", new BooleanValidatorRule);
		$this->add("passwordFieldEncryptionType", new ChoiceValidatorRule("database","crypt"));
		
		$this->add("agentInformationFields", new ArrayValidatorRule);
		$this->set("agentInformationFields", array());
	}
}
 
?>