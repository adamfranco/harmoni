<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The LDAPMethodOptions is a {@link DataContainer} for the {@link LDAPAuthenticationMethod}.
 * 
 * @package harmoni.authentication.ldap
 * @version $Id: LDAPMethodOptions.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @copyright 2003
 */

class LDAPMethodOptions extends DataContainer {
    /**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
     * 
     * @see {@link LDAPAuthenticationMethod}
     * @see {@link DataContainer}
     * @access protected 
     * @return void 
     */
    function LDAPMethodOptions()
    { 
        // initialize the data container
        $this -> init(); 
        // add the fields we want to allow
        $this -> add("LDAPPort", new NumericValidatorRule, new Error("The LDAPPort must be a valid number!", "LDAPMethodOptions",true));
        $this -> set("LDAPPort", 389);
        $this -> add("LDAPHost", new FieldRequiredValidatorRule, new Error("You must set the LDAPHost!", "LDAPMethodOptions",true));
		$this -> add("baseDN", new FieldRequiredValidatorRule, new Error("You must set the baseDN!", "LDAPMethodOptions",true));
        $this -> add("bindDN", new OptionalRule(new StringValidatorRule), new Error("The bindDN must be a valid string!", "LDAPMethodOptions",true)); // optional
        $this -> add("bindDNPassword", new OptionalRule(new StringValidatorRule), new Error("the bindDNPassword must be a valid string!", "LDAPMethodOptions",true)); // optional
        // on some, systems (which suck -- like ours), the DN used for authentication
        // is DIFFERENT than the DN stored in the DB. Why one would do this, fails me.
        // However, if this is the case, specify what should be appended onto "cn=<username>,"
        // (like, for us, "cn=midd") and the bind process will go just fine.
        $this -> add("userDNSuffix", new OptionalRule(new StringValidatorRule), new Error("The userDNSuffix must be a valid string!", "LDAPMethodOptions",true)); // optional
        $this -> add("usernameField", new FieldRequiredValidatorRule, new Error("You must provide the username field for LDAP (such as 'uid').", "LDAPMethodOptions",true));
		$this -> set("usernameField","uid");

        $this -> add("agentInformationFields", new ArrayValidatorRule, new Error("The agent information fields must be an array of the format: [key1]=>[LDAP_attr1], [key2]=>[LDAP_attr2], ...", "LDAPMethodOptions",true));
        $this -> set("agentInformationFields", array());
		$this -> add("agentInformationFieldsFetchMultiple", new ArrayValidatorRule, new Error("The agent information fields fetch multiple array must be of the format: [key1]=>[true/false], [key2]=>...", "LDAPMethodOptions",true));
		$this -> set("agentInformationFieldsFetchMultiple", array());
    } 
} 

?>