<?php

require_once(HARMONI."layoutHandler/Layout.interface.php");

define ("TOP", "top");
define ("CENTER", "center");
define ("BOTTOM", "bottom");
define ("LEFT", "left");
define ("RIGHT", "right");

/**
 * The Layout class lays (hah!) out ground work for any layout-type children. It
 * holds any number of components of different types.
 *
 * @package harmoni.layout.components
 * @version $Id: Layout.abstract.php,v 1.5 2004/03/04 22:59:07 adamfranco Exp $
 * @copyright 2003 
 * @abstract
 **/

class Layout extends LayoutInterface {
	/**
	 * @access private
	 * @var integer $_level This component's level in the visual hierarchy.
	 */ 
	var $_level=0;

	/**
	 * @access private
	 * @var array $_setComponents Holds a list of components that have values (objects) assigned to them.
	 **/
	var $_setComponents;
	
	/**
	 * @access private
	 * @var array $_verticalAlignments Holds an array of what alignments pertain to each index.
	 **/
	var $_verticalAlignments;
	
	/**
	 * @access private
	 * @var array $_horizontalAlignments Holds an array of what alignments pertain to each index.
	 **/
	var $_horizontalAlignments;
	
	/**
	 * @access private
	 * @var array $_registeredComponents Holds an array of registered components (ones that have been added,
	 * but not necessarily set).
	 **/
	var $_registeredComponents;
	
	/**
	 * Adds a component required by this layout with index $index and type $type. The class
	 * must specify which components are required, a user then sets them using {@link LayoutInterface::setComponent setComponent()},
	 * and the layout prints them using {@link LayoutInterface::printComponent printComponent()}.
	 * @param integer $index The index number for this layout -- must be unique.
	 * @param string $type The component type. Options are set up by each component class. The string is also the interface name.
	 * @access protected
	 * @return void
	 **/
	function addComponent($index, $type) {
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		ArgumentValidator::validate($type, new StringValidatorRule);
		
		if (isset($this->_registeredComponents[$index])) {
			throwError(new Error("Layout::addComponent($index) - A component for index $index is already defined!","layout",true));
			return false;
		}
		
		$this->_registeredComponents[$index] = $type;
	}
	
	/**
	 * Sets the "content" for the component indexed by $index to $object.
	 * @param integer $index The index number for the component to be set.
	 * @param ref object $object The object that complies to the expected type for $index.
	 * @param optional boolean $valign Constants TOP = 0, CENTER = 1, BOTTOM = 2 define where
	 *			the child object will be aligned.
	 * @param optional boolean $halign Constants LEFT = 0, CENTER = 1, RIGHT = 2 define where
	 *			the child object will be aligned.
	 * @param optional boolean $dontSetLevel When TRUE, setComponent will not call setLevel on this component. Default = FALSE.
	 * @access public
	 * @return void
	 **/
	function setComponent($index, &$object, $valign=TOP, $halign=LEFT, $dontSetLevel=false) {
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		ArgumentValidator::validate($valign, new StringValidatorRule);
		ArgumentValidator::validate($halign, new StringValidatorRule);
		
		// first make sure they handed us the correct object type
		$rule = new ExtendsValidatorRule($this->_registeredComponents[$index]);
		if (!$rule->check($object)) {
			throwError(new Error(get_class($this)."::setComponent($index) - Could not set component for index $index because it is not of the required type: ".$this->_registeredComponents[$index],"layout",true));
			return false;
		}
		
		// set this component's level to $this->_level+1 if we're supposed to
		if (!$dontSetLevel)
			$object->setLevel($this->_level+1);
		
		// looks like it's good
		$this->_setComponents[$index] =& $object;
		
		// Set the alignment tags
		if ($valign != TOP && $valign != CENTER && $valign != BOTTOM)
 			throwError(new Error(get_class($this)."::setComponent($index $object, $valign, $halign) - Could not set vertical alignment, parameter out of range.","layout",true));
 		if ($halign != LEFT && $halign != CENTER && $halign != RIGHT)
 			throwError(new Error(get_class($this)."::setComponent($index $object, $valign, $halign) - Could not set horizontal alignment, parameter out of range.","layout",true));
			
		$this->_verticalAlignments[$index] = $valign;
		$this->_horizontalAlignments[$index] = $halign;
	}
	
	/**
	 * Verifies that all the required components have been added.
	 * @access protected
	 * @return boolean TRUE if everything verified OK, FALSE otherwise.
	 **/
	function verifyComponents() {
		foreach (array_keys($this->_registeredComponents) as $index) {
			if (!is_object($this->_setComponents[$index])) {
				// throw an error and return false;
				throwError(new Error(get_class($this)."::verifyComponents() - required component index $index was not set!","Layout",true));
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Gets the component object for index $index.
	 * @access protected
	 * @return object The component object.
	 **/
	function &getComponent($index) {
		return $this->_setComponents[$index];
	}
	
	/**
	 * Gets all the component objects.
	 * @access protected
	 * @return array The component objects.
	 **/
	function &getAllComponents() {
		return $this->_setComponents;
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @final
	 * @return void
	 **/
	function output(&$theme, $orientation=HORIZONTAL) {
		
		$theme->output($this);
	}
	
	/**
	 * Returns this component's level in the visual hierarchy.
	 * @access public
	 * @return integer The level.
	 **/
	function getLevel() {
		return $this->_level;
	}
	
	/**
	 * Sets this component's level in the visual hierarchy. Spiders down to children (if it has any) and sets their level
	 * to $level+1 if $spiderDown is TRUE.
	 * @param integer $level The level.
	 * @param optional boolean $spiderDown Specifies if the function should spider down to children.
	 * @param optional integer $increment If $spiderDown=true, specifies by how much we should increase childrens' levels.
	 * @access public
	 * @return void 
	 **/
	function setLevel($level, $spiderDown=true, $increment=1) {
		$this->_level = $level;
		if ($spiderDown) {
			foreach (array_keys($this->_setComponents) as $key) {
				$this->_setComponents[$key]->setLevel($this->_level+$increment,$spiderDown,$increment);
			}
		}
	}
	
	function _getTabs() {
		// Set up tabs for nice html output.
		$tabs = "\t\t";
		for ($i = 0; $i < $this->_level; $i++) {
			$tabs .= "\t";
		}
		
		return $tabs;
	}
}

?>