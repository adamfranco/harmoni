<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The HamoniConfig is a {@link DataContainer} for the {@link Harmoni} object.
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniConfig.class.php,v 1.7 2005/04/01 19:59:37 adamfranco Exp $
 */

class HarmoniConfig extends DataContainer {
    /**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
     * 
     * @see DataContainer
     * @access public 
     * @return void 
     */
    function HarmoniConfig()
    { 
        // initialize the data container
        $this -> init(); 
        // add the fields we want to allow
		$this -> add("useAuthentication",BooleanValidatorRule::getRule(),new Error("HarmoniConfig - the option 'useAuthentication' must be set to either TRUE or FALSE!","DataContainer",true));
		$this -> set("useAuthentication",false);
    	$e =& new Error("HarmoniConfig - the option 'defaultAction' must be set to a string value!","Harmoni",true);
		$this -> add("defaultAction", StringValidatorRule::getRule(),$e);
		$this -> add("defaultAction", FieldRequiredValidatorRule::getRule(),$e);
		unset($e);
    	$e =& new Error("HarmoniConfig - the option 'defaultModule' must be set to a string value!","Harmoni",true);
		$this -> add("defaultModule", StringValidatorRule::getRule(),$e);
		$this -> add("defaultModule", FieldRequiredValidatorRule::getRule(),$e);
		
		$this -> add("charset", FieldRequiredValidatorRule::getRule());
		
		$this -> add("useThemingSystem", BooleanValidatorRule::getRule());
		$this -> set("useThemingSystem", true);
		
		$this -> add("sessionName", FieldRequiredValidatorRule::getRule());
		$this -> set("sessionName","Harmoni");
		$this -> add("sessionUseCookies", BooleanValidatorRule::getRule());
		$this -> set("sessionUseCookies",true);
		$this -> add("sessionCookiePath", FieldRequiredValidatorRule::getRule());
		$this -> set("sessionCookiePath","/");
		$this -> add("sessionCookieDomain", StringValidatorRule::getRule(), new Error("HarmoniConfig - You must set the 'sessionDomain' to the DNS domain you would like your session cookie sent to! (eg, '.mydomain.com')","Harmoni",true));
		$this -> set("sessionCookieDomain", ""); // default
	} 
} 

?>