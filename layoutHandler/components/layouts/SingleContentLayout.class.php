<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The single content {@link Layout} contains only one content component. Useful for
 * filling the space in a layout that expects another layout as a component with just
 * some content.
 *
 * @abstract
 * @package harmoni.layout.components
 * @version $Id: SingleContentLayout.class.php,v 1.1 2003/07/15 23:23:44 gabeschine Exp $
 * @copyright 2003 
 **/

class SingleContentLayout extends Layout {
	/**
	 * @access private
	 * @var array $_setComponents Holds a list of components that have values (objects) assigned to them.
	 **/
	var $_setComponents;
	
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
		ArguemtnValidator::validate($type, new StringValidatorRule);
		
		if (isset($this->_registeredComponents[$index])) {
			throwError(new Error("Layout::addComponent($index) - A component for index $index is already defined!","layout",true));
			return false;
		}
		
		$this->_registeredComponents[$index] = $type;
	}
	
	/**
	 * Sets the "content" for the component indexed by $index to $object.
	 * @param integer $index The index number for the component to be set.
	 * @param object $object The object that complies to the expected type for $index.
	 * @access public
	 * @return void
	 **/
	function setComponent($index, $object) {
		ArgumentValidator($index, new IntegerValidatorRule);
		
		// first make sure they handed us the correct object type
		$rule = new ExtendsValidatorRule($this->_registeredComponents[$index]);
		if (!$rule->check($object)) {
			throwError(new Error("Layout::setComponent($index) - Could not set component for index $index because it is not of the required type: ".$this->_registeredComponents[$index],"layout",true));
			return false;
		}
		
		// looks like it's good
		$this->_setComponents[$index] =& $object;
	}
}

?>