<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");
require_once(HARMONI . "errorHandler/Error.class.php");


/**
 * The HamoniConfig is a {@link DataContainer} for the {@link Harmoni} object.
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniConfig.class.php,v 1.9 2005/04/05 18:53:18 adamfranco Exp $
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
    	$e =& new Error("HarmoniConfig - the option 'defaultAction' must be set to a string value!","Harmoni",true);
		$this -> add("defaultAction", StringValidatorRule::getRule(),$e);
		$this -> add("defaultAction", FieldRequiredValidatorRule::getRule(),$e);
		unset($e);
    	$e =& new Error("HarmoniConfig - the option 'defaultModule' must be set to a string value!","Harmoni",true);
		$this -> add("defaultModule", StringValidatorRule::getRule(),$e);
		$this -> add("defaultModule", FieldRequiredValidatorRule::getRule(),$e);
		
		$this -> add("charset", FieldRequiredValidatorRule::getRule());
		
		$this -> add("doctype", StringValidatorRule::getRule());
		$this -> set("doctype", "text/html");
		
		$this -> add("doctype_definition", StringValidatorRule::getRule());
		$this -> set("doctype_definition", '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');
		
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