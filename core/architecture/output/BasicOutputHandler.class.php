<?php
/**
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicOutputHandler.class.php,v 1.2 2005/04/05 20:45:56 adamfranco Exp $
 */ 

require_once(HARMONI."/architecture/output/OutputHandler.abstract.php");

/**
 * The OutputHander abstract class defines methods for the interaction between
 * the Harmoni framework object and output handling classes.
 *
 * 
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicOutputHandler.class.php,v 1.2 2005/04/05 20:45:56 adamfranco Exp $
 */
class BasicOutputHandler
	extends OutputHandler 
{
	
	/**
	 * Output the content that was returned from an action. This content should
	 * have been created such that it is a type that this OutputHandler can deal
	 * with.
	 * 
	 * @param mixed $content Content returned by the action
	 * @param string $printedContent Additional content printed, but not returned.
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function output ( &$content, $printedContent ) {		
		$osidContext =& $this->getOsidContext();
		$harmoni =& $osidContext->getContext('harmoni');
		
		$doctypeDef = $harmoni->config->get('doctype_definition');
		$doctype = $harmoni->config->get('doctype');
		$characterSet = $harmoni->config->get('charset');
		$head = $this->getHead();
		
		header("Content-type: $doctype; charset=$characterSet");
		print<<<END
$doctypeDef
<html>
	<head>
		<meta http-equiv="Content-Type" content="$doctype; charset=$characterSet" />
		$head
	</head>
	<body>
		$printedContent
		
END;
		
		if (is_string($content))
			print $content;
			
		print<<<END

	</body>
</html>
END;
	}
}

?>