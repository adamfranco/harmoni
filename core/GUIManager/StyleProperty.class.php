<?php

require_once(HARMONI."GUIManager/StyleProperty.interface.php");

/**
 * This StyleProperty generic class allows one to create a StyleProperty of arbitrary nature
 * from scratch. It has no default StyleComponents attached.
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
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StyleProperty.class.php,v 1.4 2005/01/19 23:23:00 adamfranco Exp $
 */
class StyleProperty extends StylePropertyInterface {

	/**
	 * The display name of this StyleProperty.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	/**
	 * The description of this StyleProperty.
	 * @var string _description 
	 * @access private
	 */
	var $_description;
	
	/**
	 * The name of this StyleProperty.
	 * @var string _name 
	 * @access private
	 */
	var $_name;
	
	/**
	 * An array of the StyleComponents contained by this StyleProperty.
	 * @var array _SCs 
	 * @access private
	 */
	var $_SCs;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string name The name of this StyleProperty.
	 * @param ref mixed SCs Either one or an array of a few StyleComponents to be contained
	 * by this StyleProperty.
	 * @param string displayName The display name of this StyleProperty.
	 * @param string description The description of this StyleProperty.
	 **/
	function StyleProperty($name, $displayName, $description) {
		$this->_name = $name;
		$this->_SCs = array();

		$this->_displayName = $displayName;
		$this->_description = $description;
	}
	

	/**
	 * Returns the CSS code for this StyleProperty.
	 * @access public
	 * @return string The CSS code for this StyleProperty.
	 **/
	function getCSS() {
		if (count($this->_SCs) == 0) 
			return "";
	
		$css = $this->_name.": ";

		$values = array();
		foreach (array_keys($this->_SCs) as $key)
			$values[] = $this->_SCs[$key]->getValue();

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
	 * Adds one StyleComponent to this StyleProperty.
	 * @access public
	 * @param ref object A StyleComponent object.
	 **/
	function addSC(& $sc) {
		ArgumentValidator::validate($sc, new ExtendsValidatorRule("StyleComponentInterface"), true);
		$this->_SCs[] =& $sc;
	}

	/**
	 * Returns the StyleComponents of this StyleProperty in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return array An array of the StyleComponents of this StyleProperty.
	 **/
	function getSCs() {
		return $this->_SCs;
	}
}

?>