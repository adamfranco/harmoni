<?php
/**
 * @package harmoni.architecture.output
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CommandLineOutputHandler.class.php,v 1.1 2007/11/01 17:37:08 adamfranco Exp $
 */ 

require_once(HARMONI."/architecture/output/OutputHandler.abstract.php");

/**
 * The OutputHander abstract class defines methods for the interaction between
 * the Harmoni framework object and output handling classes.
 *
 * 
 * @package harmoni.architecture.output
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CommandLineOutputHandler.class.php,v 1.1 2007/11/01 17:37:08 adamfranco Exp $
 */
class CommandLineOutputHandler
	extends OutputHandler 
{
	
	/**
	 * Output the content that was returned from an action. This content should
	 * have been created such that it is a type that this OutputHandler can deal
	 * with.
	 * 
	 * @param mixed $returnedContent Content returned by the action
	 * @param string $printedContent Additional content printed, but not returned.
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function output ( $returnedContent, $printedContent ) {
		if (strlen($printedContent))
			print $printedContent."\n";
		
		if (is_string($returnedContent) && strlen($returnedContent))
			print $returnedContent."\n";
	}
}

?>