<?php

require_once(HARMONI."utilities/DataContainer.abstract.php");

/**
 * The DBMethodOptions is a data container for the {@link DBAuthenticationMethod}.
 * 
 * @package harmoni.authentication.database
 * @version $Id: DBMethodOptions.class.php,v 1.10 2003/07/10 02:34:20 gabeschine Exp $
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
		$this->add("databaseType", new NumericValidatorRule, new Error("'databaseType' must be a valid pre-defined database type constant, such as MYSQL or ORACLE.","DBMethodOptions",true));
		$this->add("databaseName", new FieldRequiredValidatorRule, new Error("You must provide a valid 'databaseName'!","DBMethodOptions",true));
		$this->add("databaseUsername", new FieldRequiredValidatorRule, new Error("You must provide a valid 'databaseUsername'","DBMethodOptions",true));
		$this->add("databasePassword", new FieldRequiredValidatorRule, new Error("You must provide a valid 'databasePassword'","DBMethodOptions",true));
		$this->add("databaseHost", new FieldRequiredValidatorRule, new Error("You must specify the Database Host to connect to!","DBMethodOptions",true));
		
		$this->add("tableName", new FieldRequiredValidatorRule, new Error("You must specify what database table contains user information!","DBMethodOptions",true));
		$this->add("usernameField", new FieldRequiredValidatorRule, new Error("You must specify what field within the table contains the username!","DBMethodOptions",true));
		$this->add("passwordField", new FieldRequiredValidatorRule, new Error("You must specify what field within the table contains the password!","DBMethodOptions",true));
		
		$this->add("passwordFieldEncrypted", new BooleanValidatorRule, new Error("'passwordFieldEncrypted' must be set to either TRUE or FALSE.","DBMethodOptions",true));
		$this->set("passwordFieldEncrypted",false);
		$this->add("passwordFieldEncryptionType", new OptionalRule(new ChoiceValidatorRule("databaseSHA1","databaseMD5","crypt")), new Error("Password encryption type must be one of: databaseSHA1, databaseMD5 or crypt.","DBMethodOptions",true));
		
		$this->add("agentInformationFields", new OptionalRule(new ArrayValidatorRule), new Error("The agent information fields array must be of the format: [key1]=>[DBField1], [key2]=>[DBField2], ...","DBMethodOptions",true));
		$this->set("agentInformationFields", array());
	}
}
 
?>