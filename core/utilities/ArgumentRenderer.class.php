<?php

//require_once(HARMONI."utilities/ArgumentRenderer.interface.php");

/**
 * An ArgumentRenderer provides functionallity to print/render/format a list of arguments.
 * An ArgumentRenderer provides functionallity to print/render/format a list of arguments.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ArgumentRenderer.class.php,v 1.4 2005/02/07 21:38:28 adamfranco Exp $
 */
class ArgumentRenderer {

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
	 **/
	function renderOneArgument($argument, $isDetailed = false, $shouldPrint = false) {
		$result = "Unknown";
		
		// NULL type
	    if (is_null($argument)) {
	        $result = "NULL";
	    } 
		// Boolean type
		elseif (is_bool($argument)) {
	        $result = "Boolean: " . ($argument ? "true" : "false");
	    } 
		// String type
		elseif (is_string($argument)) {
	        $result = "String: \"$argument\"";
			if ($isDetailed)
			    $result .= " (length = ".strlen($argument).")";
	    } 
		// Integer type
		elseif (is_integer($argument)) {
	        $result = "Integer: $argument";
	    }
		// Float type
		elseif (is_float($argument)) {
	        $result = "Float: $argument";
	    } 
		// Array type
		elseif (is_array($argument)) {
	        $result = "Array: " . count($argument) . " elements";
			if ($isDetailed && count($argument) > 0) {
				$result .= " {\n";
				foreach ($argument as $key => $elt) {
					$result .= "    [".$key."] => ";
					$result .= ArgumentRenderer::renderOneArgument($elt,false,false);
					$result .= "\n";
				}
				$result .= "}";
			}
	    }
		// Resource type
		elseif (is_resource($argument)) {
	        $result = "Resource: ".get_resource_type($argument);
	    } 
		// Object type
		elseif (is_object($argument)) {
	        $result = "Object: " . get_class($argument);
			if ($isDetailed) {
				$memberVars = get_object_vars($argument);
				if (count($memberVars) > 0) {
					$result .= "\nMember variables: {\n";
					foreach (get_object_vars($argument) as $key => $elt) {
						$result .= "    [".$key."] => ";
						$result .= ArgumentRenderer::renderOneArgument($elt,false,false);
						$result .= "\n";
					}
					$result .= "}";				    
				}
			}
	    }

		// print if necessary
		if ($shouldPrint)
		    echo $result;
		
	    return $result;
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
	 **/
	
	function renderManyArguments($arguments, $isDetailed = false, $shouldPrint = false) {
		// see if $arguments is an array
		if (!is_array($arguments))
			return false;
		// make sure $arguments is not empty		
		if (count($arguments) == 0)
			return false;
		
		// render each element of $arguments
		$resultArray = array();
		foreach (array_keys($arguments) as $i => $key )
			$resultArray[] = ArgumentRenderer::renderOneArgument($arguments[$key],$isDetailed,false);
		
		$glue = ($isDetailed) ? ",\n" : ", ";
		$result = implode($glue, $resultArray);
	
		// print if necessary
		if ($shouldPrint)
		    echo $result;
		
	    return $result;
	}
}

?>