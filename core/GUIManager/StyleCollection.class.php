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
 * @version $Id: StyleCollection.class.php,v 1.2 2004/07/16 04:17:14 dobomode Exp $
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
	 * The name of this StyleCollection.
	 * @attribute private string _name
	 */
	var $_name;
	
	/**
	 * An array of the StyleProperties contained by this StyleCollection.
	 * @attribute private array _SPs
	 */
	var $_SPs;

	/**
	 * The constructor.
	 * @access public
	 * @param string name The name of this StyleCollection.
	 * @param ref mixed SCs Either one or an array of a few StyleComponents to be contained
	 * by this StyleCollection.
	 * @param string displayName The display name of this StyleCollection.
	 * @param string description The description of this StyleCollection.
	 **/
	function StyleCollection($name, $displayName, $description) {
		$this->_name = $name;
		$this->_SPs = array();

		$this->_displayName = $displayName;
		$this->_description = $description;
	}
	

	/**
	 * Returns the CSS code for this StyleCollection.
	 * @access public
	 * @param integer indent An optional integer specifying how many tabs to indent
	 * the result string.
	 * @return string The CSS code for this StyleCollection.
	 **/
	function getCSS($indent = 0) {
		// nothing to return
		if (count($this->_SPs) == 0) 
			return "";

		// the tabs
		$tabs = "";
		for ($i = 0; $i < $indent; $i++)
			$tabs .= "\t";
	
		$css = $tabs.$this->_name." {\n\t".$tabs;

		$values = array();
		foreach (array_keys($this->_SPs) as $key)
			$values[] = $this->_SPs[$key]->getCSS();

		$css .= implode("\n\t".$tabs, $values);

		$css .= "\n".$tabs."}";

		return $css;
	}
	
	/**
	 * Returns the name of this StyleCollection.
	 * @access public
	 * @return string The name of this StyleCollection.
	 **/
	function getName() {
		return $this->_name;
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
	 * @param ref object A StyleComponent object.
	 **/
	function addSP(& $sp) {
		ArgumentValidator::validate($sp, new ExtendsValidatorRule("StylePropertyInterface"), true);
		$this->_SPs[] =& $sp;
	}

	/**
	 * Returns the StyleProperties of this StyleCollection in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return array An array of the StyleComponents of this StyleCollection.
	 **/
	function getSPs() {
		return $this->_SPs;
	}
	
	
}

?>