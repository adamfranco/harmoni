<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");

/**
 * The PaddingTopSP represents the 'padding-top' StyleProperty.
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
 *     padding: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * <code>div</code> is a <code>StyleCollection</code> consisting of 2 
 * <code>StyleProperties</code>: <code>padding</code> and <code>border</code>. Each
 * of the latter consists of one or more <code>StyleComponents</code>. In
 * specific, <code>padding</code> consists of one <code>StyleComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StyleComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 * 
 * @version $Id: PaddingTopSP.class.php,v 1.1 2004/07/14 20:50:37 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class PaddingTopSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of the padding.
	 **/
	function PaddingTopSP($length) {
		$this->StyleProperty("padding-top", "Top Padding", "This property specifies the top padding.");
		$this->addSC(new LengthSC($length));
	}

}

?>