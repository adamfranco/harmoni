<?php

require_once(HARMONI."debugHandler/DebugHandlerPrinter.interface.php");
require_once(HARMONI."utilities/HTMLcolor.class.php");

/**
 * the NewWindowDebugHandlerPrinter prints debug items to a new HTML window.
 *
 * @package harmoni.utilities.debugging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: NewWindowDebugHandlerPrinter.class.php,v 1.9 2007/09/04 20:25:33 adamfranco Exp $
 **/

class NewWindowDebugHandlerPrinter extends DebugHandlerPrinterInterface {
	/**
	 * Outputs the DebugItems in $debugHandler.
	 *
	 * @param object DebugHandler $debugHandler The DebugHandler object to output.
	 * @param int $level The level to output. All output < $level will be displayed. Default = user Handler's internal output level.
	 * @param optional string $category Limit output to only items under $category.
	 * @access public
	 * @return void
	 **/
	function printDebugHandler( $debugHandler, $level = null, $category = "" ) {
		if ($level == null) $level = $debugHandler->getOutputLevel();
		
		$items =  $debugHandler->getDebugItems($category);
		
		if ($level == 0) return true;
		if (!count($items)) return true;
		print "<script type='text/javascript'>
//<![CDATA[\n";
		print "<!--\n";
		print "debugWindow = window.open('','debug','scrollbars=yes,menubar=no,location=no,status=no,resizeable=yes,width=750,height=520');\n";
		print "debugWindow.document.write('<body style=\"color: #fff; background-color:#222\"><div style=\"padding-left:25px; padding-top: 10px; border-bottom: solid 1px gray\">Starting debug output :: ".date("H").":".date("i").".".date("s")."</div>');\n";

		// some colors
		$base = new HTMLcolor("#833");

		foreach (array_keys($items) as $key) {
			if (($l = $items[$key]->getLevel()) <= $level) {
				$btext = '';
				if ($bt = $items[$key]->getBacktrace() && isset($bt[2])) {
					$b = $bt[2];
					$btext = basename($b['file'])." :: ".$b['line']." :: ".$b['class'].$b['type'].$b['function']."()";
					$btext .= " ";
				}
			
				$color = $base; // $color = $base->__replicate();
				$color->lighten(2*$l);
				$color->shiftRed(10*$l);
				$htmlColor = $color->getHTMLcolor();
				$string = "<div style='padding-top: 3px'><font face='monaco' size=1>";
				$string .= "{$btext}</font>";
				$string .= "<div style='padding-left:10px'><font face='monaco' size=2>[<font color='#$htmlColor'>".$items[$key]->getCategory().":".$items[$key]->getLevel()."</font>] ".$items[$key]->getText();
				$string .= "</font></div></div>";
				print "debugWindow.document.write('".addslashes(str_replace("\n","<BR /> ",$string))."');\n";
				print "debugWindow.scrollBy(0,100000);\n";
			}
		}

//		print "debugWindow.document.close();\n";
		print "debugWindow.document.write('</body>');\n";
		print "//-->\n";
		print "//]]>
</script>\n";
	}
}

?>