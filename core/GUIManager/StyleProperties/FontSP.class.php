<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");

/**
 * The FontSP represents the 'font' StyleProperty.
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
 * @version $Id: FontSP.class.php,v 1.1 2004/07/14 20:50:37 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class FontSP extends StyleProperty {

	/**
	 * The constructor. All parameters but size and family could be null, 
	 * in which case they will not be taken in consideration.
	 * @access public
	 * @param string family The font family.
	 * @param string size The font size.
	 * @param string style The font style.
	 * @param string weight The font weight.
	 * @param string variant The font variant.
	 **/
	function FontSP($family, $size, $style, $weight, $variant) {
		$this->StyleProperty("font", "Font", "This property sets the current 
											  font family, size, style, weight,
											  variant.");

		if (isset($style)) $this->addSC(new FontStyleSC($style));
		if (isset($variant)) $this->addSC(new FontVariantSC($variant));
		if (isset($weight)) $this->addSC(new FontWeightSC($weight));
		$this->addSC(new FontSizeSC($size));
		$this->addSC(new FontFamilySC($family));
	}

}

?>