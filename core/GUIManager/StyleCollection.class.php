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
 * @version $Id: StyleCollection.class.php,v 1.4 2004/08/09 03:54:23 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class StyleCollection extends StyleCollectionInterface {

	/**
	 * The display name of this StyleCollection.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	/**
	 * The description of this StyleCollection.
	 * @attribute private string _description
	 */
	var $_description;
	
	/**
	 * The selector of this StyleCollection.
	 * @attribute private string _selector
	 */
	var $_selector;
	
	/**
	 * The class selector of this style collection. A class selector is the string
	 * that would be included in the 'class' attribute of HTML tags. 
	 * @attribute private string _classSelector
	 */
	var $_classSelector;
	
	/**
	 * An array of the StyleProperties contained by this StyleCollection.
	 * @attribute private array _SPs
	 */
	var $_SPs;

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
	function StyleCollection($selector, $classSelector, $displayName, $description) {
		$this->_selector = $selector;
		$this->_classSelector = $classSelector;
		$this->_SPs = array();
		$this->_displayName = $displayName;
		$this->_description = $description;
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

		$css = $tabs.$this->_selector." {\n\t".$tabs;

		$values = array();
		foreach (array_keys($this->_SPs) as $key)
			$values[] = $this->_SPs[$key]->getCSS();

		$css .= implode("\n\t".$tabs, $values);

		$css .= "\n".$tabs."}\n";

		return $css;
	}
	
	/**
	 * Returns the class selector of this style collection. A class selector is the string
	 * that would be included in the 'class' attribute of HTML tags. One can use
	 * this method in order to apply the style collection to an arbitrary component.
	 * @access public
	 * @return string The class name of this style collection.
	 **/
	function getClassSelector() {
		return $this->_classSelector;
	}

	/**
	 * Determines whether this <code>StyleCollection</code> can be applied to <code>Components</code>.
	 * @access public
	 * @return boolean <code>TRUE</code> if this <code>StyleCollection</code> can be applied to <code>Components</code>.
	 **/
	function canBeApplied() {
		return isset($this->_classSelector);
	}

	/**
	 * Returns the selector of this StyleCollection.
	 * @access public
	 * @return string The selector of this StyleCollection.
	 **/
	function getSelector() {
		return $this->_selector;
	}

	/**
	 * Returns the display name of this StyleCollection.
	 * @access public
	 * @return string The display name of this StyleCollection.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Returns the description of this StlyeProperty.
	 * @access public
	 * @return string The description of this StlyeProperty.
	 **/
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * Adds one StyleProperty to this StyleCollection.
	 * @access public
	 * @param ref object sc A StyleProperty object.
	 * @return ref object The style property that was just added.
	 **/
	function & addSP(& $sp) {
		ArgumentValidator::validate($sp, new ExtendsValidatorRule("StylePropertyInterface"), true);
		$this->_SPs[$sp->getName()] =& $sp;
		
		return $sp;
	}

	/**
	 * Returns the StyleProperties of this StyleCollection in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return array An array of the StyleProperties of this StyleCollection.
	 **/
	function getSPs() {
		return $this->_SPs;
	}
	
	/**
	 * Remove the given StyleProperty from this Style Collection.
	 * @access public
	 * @param ref object The style property to remove.
	 * @return ref object The style property that was removed. <code>NULL</code>
	 * if it could not be found.
	 **/
	function & removeSP(& $sp) {
		ArgumentValidator::validate($sp, new ExtendsValidatorRule("StylePropertyInterface"), true);

		$result =& $this->_SPs[$sp->getName()];
		unset($this->_SPs[$sp->getName()]);
		
		return $result;
	}
	
}

?>