<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The LDAPMethodOptions is a {@link DataContainer} for the {@link LDAPAuthenticationMethod}.
 * 
 * @package harmoni.authenticationHandler
 * @version $Id: LDAPMethodOptions.class.php,v 1.3 2003/06/30 21:42:53 adamfranco Exp $
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
        //  @todo implement all the errors!!
        $this -> add("LDAPPort", new NumericValidatorRule);
        $this -> set("LDAPPort", 389);
        $this -> add("LDAPHost", new FieldRequiredValidatorRule);
		$this -> add("baseDN", new FieldRequiredValidatorRule);
        $this -> add("bindDN", new AlwaysTrueValidatorRule); // optional
        $this -> add("bindDNPassword", new AlwaysTrueValidatorRule); // optional
        // on some, systems (which suck -- like ours), the DN used for authentication
        // is DIFFERENT than the DN stored in the DB. Why one would do this, fails me.
        // However, if this is the case, specify what should be appended onto "cn=<username>,"
        // (like, for us, "cn=midd") and the bind process will go just fine.
        $this -> add("userDNSuffix", new AlwaysTrueValidatorRule); // optional
        $this -> add("usernameField", new FieldRequiredValidatorRule);
		$this -> set("usernameField","uid");

        $this -> add("agentInformationFields", new ArrayValidatorRule);
        $this -> set("agentInformationFields", array());
		$this -> add("agentInformationFieldsFetchMultiple", new ArrayValidatorRule);
		$this -> set("agentInformationFieldsFetchMultiple", array());
    } 
} 

?>