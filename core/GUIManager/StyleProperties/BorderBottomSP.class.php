<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");

/**
 * The BorderBottomSP represents the 'border-top' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. To clarify the relationship between these three
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
 * @version $Id: BorderBottomSP.class.php,v 1.1 2004/07/14 20:50:37 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BorderBottomSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string width The width of the border.
	 * @param string style The style of the border.
	 * @param string color The color of the border.
	 **/
	function BorderBottomSP($width, $style, $color) {
		$this->StyleProperty("border-bottom", "Bottom Border", "This property specifies the bottom border.");
		if (isset($width)) $this->addSC(new LengthSC($width));
		if (isset($style)) $this->addSC(new BorderStyleSC($style));
		if (isset($color)) $this->addSC(new ColorSC($color));
	}

}

?>