<?php

require_once(HARMONI."utilities/DataContainer.abstract.php");

/**
 * The DBMethodOptions is a data container for the {@link DBAuthenticationMethod}.
 *
 * @package harmoni.authentication.methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBMethodOptions.class.php,v 1.6 2005/03/29 19:44:12 adamfranco Exp $
 **/

class DBMethodOptions extends DataContainer {
	/**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
	 * @see DBAuthenticationMethod
	 * @see DataContainer
     * @access protected
	 * @return void
     */
	function DBMethodOptions(){
		// initialize the data container
		$this->init();
		
		// add the fields we want to allow
		// @todo change this to accept just a DBIndex.
/*		$this->add("databaseType", NumericValidatorRule::getRule(), new Error("'databaseType' must be a valid pre-defined database type constant, such as MYSQL or ORACLE.","DBMethodOptions",true));
		$this->add("databaseName", FieldRequiredValidatorRule::getRule(), new Error("You must provide a valid 'databaseName'!","DBMethodOptions",true));
		$this->add("databaseUsername", FieldRequiredValidatorRule::getRule(), new Error("You must provide a valid 'databaseUsername'","DBMethodOptions",true));
		$this->add("databasePassword", FieldRequiredValidatorRule::getRule(), new Error("You must provide a valid 'databasePassword'","DBMethodOptions",true));
		$this->add("databaseHost", FieldRequiredValidatorRule::getRule(), new Error("You must specify the Database Host to connect to!","DBMethodOptions",true));
*/
		$this->add("databaseIndex", IntegerValidatorRule::getRule());
		
		$this->add("tableName", FieldRequiredValidatorRule::getRule(), new Error("You must specify what database table contains user information!","DBMethodOptions",true));
		$this->add("usernameField", FieldRequiredValidatorRule::getRule(), new Error("You must specify what field within the table contains the username!","DBMethodOptions",true));
		$this->add("passwordField", FieldRequiredValidatorRule::getRule(), new Error("You must specify what field within the table contains the password!","DBMethodOptions",true));
		
		$this->add("passwordFieldEncrypted", BooleanValidatorRule::getRule(), new Error("'passwordFieldEncrypted' must be set to either TRUE or FALSE.","DBMethodOptions",true));
		$this->set("passwordFieldEncrypted",false);
		$this->add("passwordFieldEncryptionType", OptionalRule::getRule(ChoiceValidatorRule::getRule("databaseSHA1","databaseMD5","crypt")), new Error("Password encryption type must be one of: databaseSHA1, databaseMD5 or crypt.","DBMethodOptions",true));
		
		$this->add("agentInformationFields", OptionalRule::getRule(ArrayValidatorRule::getRule()), new Error("The agent information fields array must be of the format: [key1]=>[DBField1], [key2]=>[DBField2], ...","DBMethodOptions",true));
		$this->set("agentInformationFields", array());
	}
}
 
?>