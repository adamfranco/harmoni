<?php

require_once(HARMONI."GUIManager/StyleProperty.interface.php");

/**
 * The GenericSP allows one to create a StyleProperty of arbitrary nature
 * from scratch. It has no default StylePropertyComponents attached.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StylePropertyComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StylePropertyComponents</code> and
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
 * of the latter consists of one or more <code>StylePropertyComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StylePropertyComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StylePropertyComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 * 
 * @version $Id: GenericSP.class.php,v 1.1 2004/07/09 06:06:36 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class GenericSP extends StylePropertyInterface {

	/**
	 * The display name of this StyleProperty.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	/**
	 * The description of this StyleProperty.
	 * @attribute private string _description
	 */
	var $_description;
	
	/**
	 * The name of this StyleProperty.
	 * @attribute private string _name
	 */
	var $_name;
	
	/**
	 * An array of the StylePropertyComponents contained by this StyleProperty.
	 * @attribute private array _SPCs
	 */
	var $_SPCs;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string name The name of this StyleProperty.
	 * @param ref mixed SPCs Either one or an array of a few StylePropertyComponents to be contained
	 * by this StyleProperty.
	 * @param string displayName The display name of this StyleProperty.
	 * @param string description The description of this StyleProperty.
	 **/
	function GenericSP($name, $displayName, $description) {
		$this->_name = $name;
		$this->_SPCs = array();

		$this->_displayName = $displayName;
		$this->_description = $description;
	}
	

	/**
	 * Returns the CSS code for this StyleProperty.
	 * @access public
	 * @return string The CSS code for this StyleProperty.
	 **/
	function getCSS() {
		$css = $this->_name.": ";

		$values = array();
		foreach (array_keys($this->_SPCs) as $key)
			$values[] = $this->_SPCs[$key]->getValue();

		$css .= implode(" ", $values);

		$css .= ";";
		return $css;
	}
	
	/**
	 * Returns the name of this StyleProperty.
	 * @access public
	 * @return string The name of this StyleProperty.
	 **/
	function getName() {
		return $this->_name;
	}

	/**
	 * Returns the display name of this StyleProperty.
	 * @access public
	 * @return string The display name of this StyleProperty.
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
	 * Adds one StylePropertyComponent to this StyleProperty.
	 * @access public
	 * @param ref object A StylePropertyComponent object.
	 **/
	function addSPC(& $spc) {
		ArgumentValidator::validate($spc, new ExtendsValidatorRule("StylePropertyComponentInterface"), true);
		$this->_SPCs[] =& $spc;
	}

	/**
	 * Returns the StylePropertyComponents of this StyleProperty in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return ref object An iterator of the StylePropertyComponents of this StyleProperty.
	 **/
	function & getSPCs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>