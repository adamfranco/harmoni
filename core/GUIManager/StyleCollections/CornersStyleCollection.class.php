<?php

require_once(HARMONI."GUIManager/StyleCollection.interface.php");

/**
 * A StyleCollection is one of the tree building pieces of CSS styles. As the  name
 * suggests it handles a collection of StyleProperties.
 * 
 * The other two CSS styles building pieces are <code>StylePropertiy</code> and
 * <code>StyleComponent</code>. To clarify the relationship between these three
 * building pieces, consider the following example:
 * <pre>
 * div {
 *     margin: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * <code>div</code> is a <code>StyleCollection</code> consisting of 2 
 * <code>StyleProperties</code>: <code>margin</code> and <code>border</code>. Each
 * of the latter consists of one or more <code>StyleComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StyleComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StyleComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CornersStyleCollection.class.php,v 1.2 2006/08/15 20:44:58 sporktim Exp $
 */
class CornersStyleCollection 
	extends StyleCollection 
{
	
	/**
	 * @var array $_urls;  
	 * @access private
	 * @since 11/28/05
	 */
	var $_urls;
	
	/**
	 * @var array $_positions;  
	 * @access private
	 * @since 11/28/05
	 */
	var $_positions;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string selector The selector of this StyleCollection.
	 * @param string classSelector The class selector of this style collection. If <code>null</code>,
	 * it will be ignored, but the collection will not be able to be applied 
	 * to components.
	 * @param string displayName The display name of this StyleCollection.
	 * @param string description The description of this StyleCollection.
	 **/
	function __construct($selector, $classSelector, $displayName, $description) {
		parent::__construct($selector, $classSelector, $displayName, $description);
		$this->_positions = array("TopLeft", "TopRight", "BottomLeft", "BottomRight");
		$this->_urls = array();
	}
	
	/**
	 * Set the url of the corner image
	 * 
	 * @param string $position
	 * @param string $url
	 * @param optional int $height
	 * @param optional int $width
	 * @return void
	 * @access public
	 * @since 11/28/05
	 */
	function setBorderUrl ($position, $url, $height = 15, $width = 15) {
		if (!in_array($position, $this->_positions))
			throwError(new HarmoniError("Invalid Position, $position"));
		
		$this->_urls[$position] = $url;
		$this->_heights[$position] = $height;
		$this->_widths[$position] = $width;
		
	}
	
	/**
	 * Set the url of the corner image
	 * 
	 * @param string $position
	 * @return void
	 * @access public
	 * @since 11/28/05
	 */
	function getBorderUrl ($position) {
		if (!in_array($position, $this->_positions))
			throwError(new HarmoniError("Invalid Position, $position"));
		
		return $this->_urls[$position];
	}

	/**
	 * Returns the CSS code for this StyleCollection.
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The CSS code for this StyleCollection.
	 **/
	function getCSS($tabs = "") {
		// nothing to return
		if (count($this->_SPs) == 0) 
			return "";

		$wrapperValues = array();
		$contentValues = array();
		$wrapperKeys = array("display", "visibility", "position", "margin", "height", "width");
		foreach (array_keys($this->_SPs) as $key) {
			if (!in_array($key, $wrapperKeys))
				$contentValues[] = $this->_SPs[$key]->getCSS();
			else {
				if (strstr("margin", $key)) {
					$wrapperValues[] = str_replace("margin", "padding", $this->_SPs[$key]->getCSS());
				} else {
					$wrapperValues[] = $this->_SPs[$key]->getCSS();
				}
			}
		}
		
		$css = $tabs.$this->_selector." {\n\t".$tabs;
		$css .= implode("\n\t".$tabs, $wrapperValues);
		$css .= "\n".$tabs."\tborder: 0px;\n";
		$css .= $tabs."}\n";
			
		$css .= $tabs.$this->_selector."Content {\n\t".$tabs;
		$css .= implode("\n\t".$tabs, $contentValues);
		$css .= "\n".$tabs."\tmargin: 0px;\n";
		$css .= $tabs."}\n";
		
		
		$css .= $tabs.".".$this->_classSelector."TopCorners, ."
			.$this->_classSelector."BottomCorners {\n";
		$css .= $tabs."\tmargin: 0px;\n";
		$css .= $tabs."\tpadding: 0px;\n";
		$css .= $tabs."}\n";
		
		
		
		$css .= $tabs.".".$this->_classSelector."Spacer {\n";
		$css .= $tabs."\tmargin: 0px; padding: 0px; border: 0px;\n";
		$css .= $tabs."\tclear: both;\n";
		$css .= $tabs."\tfont-size: 1px; line-height: 1px;\n";
		$css .= $tabs."}\n";
		
		$css .= "

/* In the CSS below, the numbers used are the following:
    111111111111px: the width of the border
    3px: a fudge factor needed for IE5/win (see below)
    4px: the width of the border (1px) plus the 3px IE5/win fudge factor
    14px: the width or height of the border image
*/
";
		
		$css .= $tabs.".".$this->_classSelector."BorderTL,"
			." .".$this->_classSelector."BorderTR,"
			." .".$this->_classSelector."BorderBL,"
			." .".$this->_classSelector."BorderBR {\n";
		$css .= $tabs."\twidth: 14px; height: 14px;\n";
		$css .= $tabs."\tpadding: 0px; border: 0px;\n";
		$css .= $tabs."\tz-index: 99;\n";
		$css .= $tabs."}\n";
		
		$css .= $tabs.".".$this->_classSelector."BorderTL,"
			." .".$this->_classSelector."BorderBL {\n";
		$css .= $tabs."\tfloat: left;\n";
		$css .= $tabs."\tclear: both;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderTR,"
			." .".$this->_classSelector."BorderBR {\n";
		$css .= $tabs."\tfloat: right;\n";
		$css .= $tabs."\tclear: right;\n";
		$css .= $tabs."}\n";
		
		$css .= $tabs.".".$this->_classSelector."BorderTL {\n";
		$css .= $tabs."\tmargin: 0px 0px 0px 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderTR {\n";
		$css .= $tabs."\tmargin: -0px -0px 0px 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderBL {\n";
		$css .= $tabs."\tmargin: -14px 0px 0px 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderBR {\n";
		$css .= $tabs."\tmargin: -14px 0px 0px 0px;\n";
		$css .= $tabs."}\n";
		
		// Stuff for aligning on IE
		$css .= $tabs.".".$this->_classSelector."BorderTL {\n";
		$css .= $tabs."\t margin-left: -4px;\n";
		$css .= $tabs."\t ma\\rgin-left: -1px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs."html>body .".$this->_classSelector."BorderTL {\n";
		$css .= $tabs."\t margin-left: 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderTR {\n";
		$css .= $tabs."\t margin-right: -4px;\n";
		$css .= $tabs."\t ma\\rgin-right: -1px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs."html>body .".$this->_classSelector."BorderTR {\n";
		$css .= $tabs."\t margin-right: 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderBL {\n";
		$css .= $tabs."\t margin-left: -3px;\n";
		$css .= $tabs."\t ma\\rgin-left: 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs."html>body .".$this->_classSelector."BorderBL {\n";
		$css .= $tabs."\t margin-left: -0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs.".".$this->_classSelector."BorderBR {\n";
		$css .= $tabs."\t margin-left: -3px;\n";
		$css .= $tabs."\t ma\\rgin-left: 0px;\n";
		$css .= $tabs."}\n";
		$css .= $tabs."html>body .".$this->_classSelector."BorderBR {\n";
		$css .= $tabs."\t margin-left: 0px;\n";
		$css .= $tabs."}\n";
		
		return $css;
	}

	/**
	 * Return HTML to nested inside of the component's block. This includes
	 * things such as corner images.
	 *
	 * See the example below:
	 * 	<pre>
	 * 	<div class='block3'>
	 *
	 *		<!-- preHTML start -->
	 *		<div class="content">
     *  		<img class="borderTL" src="images/block3_TL.gif" width="14" height="14" />
     *  		<img class="borderTR" src="images/block3_TR.gif" width="14" height="14" />
     *		<!-- preHTML end -->
     *		
     *			<h1>Hello world! (this is when my component renders itself)</h1>
     *
     *		<!-- postHTML start -->
	 *			<div class="roundedCornerSpacer">&nbsp;</div>
	 *		</div>
	 *	    <div class="bottomCorners">
     *  		<img class="borderBL" src="images/block3_BL.gif" width="14" height="14" />
     *  		<img class="borderBR" src="images/block3_BR.gif" width="14" height="14" />
     *		</div>
     *		<!-- postHTML end -->
     *
     *	</div>
     *	</pre>
	 * 
	 * @param string $tabs
	 * @return string
	 * @access public
	 * @since 11/22/05
	 */
	function getPreHTML ($tabs) {
		$html = $tabs."<div class='".$this->_classSelector."TopCorners'>\n";
   		$html .= $tabs."\t<img class='".$this->_classSelector."BorderTL' src='"
   			.$this->getBorderUrl('TopLeft')."' alt='&nbsp;' width='14' height='14' />\n";
		$html .= $tabs."\t<img class='".$this->_classSelector."BorderTR' src='"
   			.$this->getBorderUrl('TopRight')."' alt='&nbsp;' width='14' height='14' />\n";
		$html .= $tabs."</div>\n";
		$html .= $tabs."<div class='".$this->_classSelector."Content'>\n";
		return $html;
	}
	
	/**
	 * Return HTML to nested inside of the component's block. This includes
	 * things such as corner images.
	 *
	 * See the example below:
	 * 	<pre>
	 * 	<div class='block3'>
	 *
	 *		<!-- preHTML start -->
	 *		<div class="content">
     *  		<img class="borderTL" src="images/block3_TL.gif" width="14" height="14" />
     *  		<img class="borderTR" src="images/block3_TR.gif" width="14" height="14" />
     *		<!-- preHTML end -->
     *		
     *			<h1>Hello world! (this is when my component renders itself)</h1>
     *
     *		<!-- postHTML start -->
	 *			<div class="roundedCornerSpacer">&nbsp;</div>
	 *		</div>
	 *	    <div class="bottomCorners">
     *  		<img class="borderBL" src="images/block3_BL.gif" width="14" height="14" />
     *  		<img class="borderBR" src="images/block3_BR.gif" width="14" height="14" />
     *		</div>
     *		<!-- postHTML end -->
     *
     *	</div>
     *	</pre>
	 * 
	 * @param string $tabs
	 * @return string
	 * @access public
	 * @since 11/22/05
	 */
	function getPostHTML ($tabs) {
// 		$html = "\n".$tabs."\t<!-- IE5/win puts the margin-bottom of the content div's final element";
// 		$html .= "\n".$tabs."\tOUTSIDE the containing box (div.content), instead of putting it inside";
// 		$html .= "\n".$tabs."\tthe containing box\'s edge. So it needs this spacer. -->\n";
        $html = $tabs."\t<div class='".$this->_classSelector."Spacer'>&nbsp;</div>\n";
		$html .= $tabs."</div>\n";
//		$html .= "<!-- end of div.content -->\n";
		$html .= $tabs."<div class='".$this->_classSelector."BottomCorners'>\n";
		$html .= $tabs."\t<img class='".$this->_classSelector."BorderBL' src='"
   			.$this->getBorderUrl('BottomLeft')."' alt='&nbsp;' width='14' height='14' />\n";
		$html .= $tabs."\t<img class='".$this->_classSelector."BorderBR' src='"
   			.$this->getBorderUrl('BottomRight')."' alt='&nbsp;' width='14' height='14' />\n";
		$html .= $tabs."</div>\n";
		
		return $html;
	}
}

?>