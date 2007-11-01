<?php

/**
 * Argument Parser
 *
 * The following functions will take the parameters to a
 * command-line program and break them into two arrays,
 * $options and $params
 *
 * Valid option formats are:
 *		Single-letter flag:			-v
 *		Single-letter flags:		-vqt
 *		Multi-letter flags:			--delete
 *		Single-letter values:		-t=200
 *		Multi-letter values:		--time=200
 *
 * @copyright Copyright &copy; 2004, Adam Franco
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */

/**
 * Get an array of the options from the command-line inputs.
 *
 * Valid option formats are:
 *		Single-letter flag:			-v
 *		Single-letter flags:		-vqt
 *		Multi-letter flags:			--delete
 *		Single-letter values:		-t=200
 *		Multi-letter values:		--time=200
 * 
 * @param array $argv The array of argument values.
 * @return array
 * @access public
 * @date 12/6/04
 */
function getOptionArray($argv) {
	$argc = count($argv);
	$options = array();
	
	$startingIndex = 1;
	
	// pull apart our arguments into options and params
	for ($i=$startingIndex; $i < $argc; $i++) {
		// for single-letter flags
		if (ereg("^-[a-zA-Z]+$", $argv[$i])) {
			$list = substr( $argv[$i], 1);
			
			for($j=0; $j < strlen($list); $j++)
				$options[substr($list, $j, 1)] = TRUE;
		}
		
		// for multi-letter flags
		else if (ereg("^--[a-zA-Z0-9_\-]+$", $argv[$i])) {
			$options[substr($argv[$i], 2)] = TRUE;
		}
		
		// for options with values
		else if (ereg("^-{1,2}([a-zA-Z0-9_\-]+)=(.+)$", $argv[$i], $parts)) {
			$options[$parts[1]] = $parts[2];
		}
		
		// Otherwise, if it begins with a -, there is a problem
		else if (ereg("^-", $argv[$i])) {
			die ("Mal-formed option, ".$argv[$i]);
		}
		
		// If its not an option, then it must be a param
		else {
			//$params[] = $argv[$i];
		}
	}
	
	return $options;
}

/**
 * Get an array of the options from the command-line inputs that are not
 * options begining with '-'.
 * 
 * @param array $argv The array of argument values.
 * @return array
 * @access public
 * @date 12/6/04
 */
function getParameterArray($argv) {
	$argc = count($argv);
	$params = array();
	
	$startingIndex = 1;
	
	// pull apart our arguments into options and params
	for ($i=$startingIndex; $i < $argc; $i++) {
		// If it doesn't begin with a -, there is a param
		if (!ereg("^-", $argv[$i])) {
			$params[] = $argv[$i];
		}
	}
	
	return $params;
}

?>
