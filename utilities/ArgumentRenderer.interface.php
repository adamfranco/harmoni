<?php

/**
 * An ArgumentRenderer provides functionallity to print/render/format a list of arguments.
 * An ArgumentRenderer provides functionallity to print/render/format a list of arguments.
 * @version $Id: ArgumentRenderer.interface.php,v 1.2 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.interfaces.utilities
 **/

class ArgumentRendererInterface {

	/**
	 * Renders one argument.
	 * Renders one argument by printing its type and value. In 'detailed' mode,
	 * includes some additional information (i.e., for arrays, prints all elements
	 * of the array; for objects, prints the object structure).
	 * @param mixed $argument The argument to render.
	 * @param boolean $isDetailed If TRUE, will print additional details.
	 * @param boolean $shouldPrint If TRUE, will print on screen; If FALSE, will not
	 * print, but just return the result as a string.
	 * @return string The output of the method. This will be output to the browser
	 * if $shouldPrint is set to TRUE.
	 * @access public
	 * @return void 
	 **/
	function renderOneArgument($argument, $isDetailed = false, $shouldPrint = false) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");		
	}

	/**
	 * Renders many arguments.
	 * Renders many arguments by printing their types and values and comma delimiting them.
	 * In 'detailed' mode, includes some additional information (i.e., for arrays, 
	 * prints all elements of the array; for objects, prints the object structure).
	 * @param array $arguments The arguments to render.
	 * @param boolean $isDetailed If TRUE, will print additional details.
	 * @param boolean $shouldPrint If TRUE, will print on screen; If FALSE, will not
	 * print, but just return the result as a string.
	 * @return string The output of the method. This will be output to the browser
	 * if $shouldPrint is set to TRUE. Returns FALSE, if something goes wrong.
	 * @access public
	 * @return void 
	 **/
	
	function renderManyArguments($arguments, $isDetailed = false, $shouldPrint = false) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");		
	}
}

?>