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
 * @version $Id: HarmoniConfig.class.php,v 1.3 2005/01/19 21:09:40 adamfranco Exp $
 */

class HarmoniConfig extends DataContainer {
    /**
     * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
     * 
     * @see {@link DataContainer}
     * @access public 
     * @return void 
     */
    function HarmoniConfig()
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
		
		$this -> add("outputHTML", new BooleanValidatorRule);
		$this -> set("outputHTML", true);
		
		$this -> add("sessionName", new FieldRequiredValidatorRule);
		$this -> set("sessionName","Harmoni");
		$this -> add("sessionUseCookies", new BooleanValidatorRule);
		$this -> set("sessionUseCookies",true);
		$this -> add("sessionCookiePath", new FieldRequiredValidatorRule);
		$this -> set("sessionCookiePath","/");
		$this -> add("sessionCookieDomain", new StringValidatorRule, new Error("HarmoniConfig - You must set the 'sessionDomain' to the DNS domain you would like your session cookie sent to! (eg, '.mydomain.com')","Harmoni",true));
		$this -> set("sessionCookieDomain", ""); // default
	} 
} 

?>