<?php

/**
 * The Template interface defines what methods are required of any Template class.
 *
 * @package harmoni.utilities.template
 * @version $Id: Template.interface.php,v 1.1 2003/07/18 03:23:14 gabeschine Exp $
 * @copyright 2003 
 **/

class TemplateInterface {
	/**
	 * Outputs the content of the current template with $variables containing
	 * the variable output.
	 * @param mixed $variables Either an associative array or a {@link FieldSet} containing
	 * a number of [key]=>content pairs.
	 * @access public
	 * @return void
	 **/
	function output( $variables ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Calls output() but catches whatever is printed and returns the output in a string.
	 * @param mixed $variables See description under {@link TemplateInterface::output()}
	 * @access public
	 * @return string The output from the template.
	 **/
	function catchOutput( $variables ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>