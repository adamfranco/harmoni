<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The LDAPMethodOptions is a {@link DataContainer} for the {@link LDAPAuthenticationMethod}.
 * 
 * @package harmoni.authentication.ldap
 * @version $Id: HarmoniConfig.class.php,v 1.1 2003/07/22 22:05:47 gabeschine Exp $
 * @copyright 2003
 */

class HarmoniConfig extends DataContainer {
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
		$this -> add("useAuthentication",new BooleanValidatorRule,new Error("HarmoniConfig - the option 'useAuthentication' must be set to either TRUE or FALSE!","DataContainer",true));
    	$e =& new Error("HarmoniConfig - the option 'defaultAction' must be set to a string value!","Harmoni",true);
		$this -> add("defaultAction", new StringValidatorRule,$e);
		$this -> add("defaultAction", new FieldRequiredValidatorRule,$e);
		unset($e);
    	$e =& new Error("HarmoniConfig - the option 'defaultModule' must be set to a string value!","Harmoni",true);
		$this -> add("defaultModule", new StringValidatorRule,$e);
		$this -> add("defaultModule", new FieldRequiredValidatorRule,$e);
		
		$this -> add("charset", new FieldRequiredValidatorRule);
		
		$this -> add("sessionName", new FieldRequiredValidatorRule);
		$this -> set("sessionName","Harmoni");
		$this -> add("sessionCookiePath", new FieldRequiredValidatorRule);
		$this -> set("sessionCookiePath","/");
		$this -> add("sessionDomain", new FieldRequiredValidatorRule, new Error("HarmoniConfig - You must set a 'sessionDomain' to the DNS domain you would like your session cookie sent to! (eg, '.mydomain.com')","Harmoni",true));
	} 
} 

?>