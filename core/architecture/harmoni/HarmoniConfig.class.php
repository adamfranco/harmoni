<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");
require_once(HARMONI . "errorHandler/HarmoniErrorHandler.class.php");


/**
 * The HamoniConfig is a {@link DataContainer} for the {@link Harmoni} object.
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniConfig.class.php,v 1.15 2007/10/10 22:58:35 adamfranco Exp $
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
    	$message = "HarmoniConfig - the option 'defaultAction' must be set to a string value!";
    	$type = "Harmoni";
		$this -> add("defaultAction", StringValidatorRule::getRule(), $message, $type);
		$this -> add("defaultAction", FieldRequiredValidatorRule::getRule(), $message, $type);
		unset( $message, $type);
    	$message ="HarmoniConfig - the option 'defaultModule' must be set to a string value!";
    	$type = "Harmoni";
		$this -> add("defaultModule", StringValidatorRule::getRule(), $message, $type);
		$this -> add("defaultModule", FieldRequiredValidatorRule::getRule(), $message, $type);
		$message ="HarmoniConfig - if specified, the option 'defaultParams' must be set to a an array of string values!";
		$this -> add("defaultParams",  OptionalRule::getRule(ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule())), $message, $type);
		
		$this -> add("programTitle", StringValidatorRule::getRule(), $message, $type);
		
		$this -> add("sessionName", FieldRequiredValidatorRule::getRule());
		$this -> set("sessionName","Harmoni");
		$this -> add("sessionUseCookies", BooleanValidatorRule::getRule());
		$this -> set("sessionUseCookies",true);
		$this -> add("sessionUseOnlyCookies", BooleanValidatorRule::getRule());
		$this -> set("sessionUseOnlyCookies",true);
		$this -> add("sessionCookiePath", FieldRequiredValidatorRule::getRule());
		$this -> set("sessionCookiePath","/");
		$this -> add("sessionCookieDomain", StringValidatorRule::getRule(), "HarmoniConfig - You must set the 'sessionDomain' to the DNS domain you would like your session cookie sent to! (eg, '.mydomain.com')", "Harmoni");
		$this -> set("sessionCookieDomain", ""); // default
		
		// An array of module.action in which session ids are allowed to be passed in the
		// url
		$this -> add("sessionInUrlActions",  OptionalRule::getRule(ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule())), $message, $type);
	} 
} 

?>