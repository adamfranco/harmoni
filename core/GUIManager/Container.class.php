<?php

require_once(HARMONI."GUIManager/Container.interface.php");
require_once(HARMONI."GUIManager/StyleProperties/WidthSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/HeightSP.class.php");

/**
 * This is a generic <code>Container</code> implementation that should be sufficient
 * for all means and purposes.
 * <br><br>
 * The <code>Container</code> interface is an extension of the <code>Component</code>
 * interface; <code>Containers</code> are capable of storing multiple sub-<code>Components</code>
 * and when rendering Containers, all sub-<code>Components</code> will be rendered as well.
 * @version $Id: Container.class.php,v 1.1 2004/07/19 23:59:50 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class Container extends Component /* implements ContainerInterface */ {

	/**
	 * The <code>Layout</code> of this <code>Container</code>.
	 * @attribute private object _layout
	 */
	var $_layout;
	
	/**
	 * The <code>Components</code> of this <code>Container</code>.
	 * @attribute private array _components
	 */
	var $_components;
	
	/**
	 * An array storing constraint information for each component. Each element is
	 * another array of four elements storing the width, height, horizontal alignment,
	 * and vertical alignment of each component.
	 * @attribute private array _constraints
	 */
	var $_constraints;

	/**
	 * The constructor.
	 * @access public
	 * @param ref object layout The <code>Layout</code> of this container.
	 **/
	function Container(& $layout) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("LayoutInterface");
		ArgumentValidator::validate($layout, $rule, true);
		// ** end of parameter validation	
	
		$this->Component(null);
		$this->_layout =& $layout;
		$this->_components = array();
		$this->_constraints = array();
	}

	/**
	 * Renders the component on the screen.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @access public
	 **/
	function render($tabs = "") {
		echo $this->getPreHTML($tabs);
		$this->_layout->render($this, $tabs);
		echo $this->getPostHTML($tabs);
	}

	/**
	 * Adds the given component to this container.
	 * @access public
	 * @param ref object component The component to add.
	 * @param string width The available width for the added component. If null, will be ignored.
	 * @param string height The available height for the added component. If null, will be ignored.
	 * @param integer alignmentX The horizontal alignment for the added component. Allowed values are 
	 * <code>ALIGNMENT_LEFT</code>, <code>ALIGNMENT_CENTER</code>, and <code>ALIGNMENT_RIGHT</code>.
	 * If null, will be ignored.
	 * @param integer alignmentY The vertical alignment for the added component. Allowed values are 
	 * <code>ALIGNMENT_TOP</code>, <code>ALIGNMENT_CENTER</code>, and <code>ALIGNMENT_BOTTOM</code>.
	 * If null, will be ignored.
	 * @return ref object component The component that was just added.
	 **/
	function & add(& $component, $width, $height, $alignmentX, $alignmentY) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("ComponentInterface");
		ArgumentValidator::validate($component, $rule, true);
		// ** end of parameter validation
		
		$constraint = array();
		$constraint[0] = $width;
		$constraint[1] = $height;
		$constraint[2] = $alignmentX;
		$constraint[3] = $alignmentY;
		$this->_constraints[] =& $constraint;
		return $this->_components[] =& $component;
	}
	
	/**
	 * Returns the component of this container with the specified index. Indices
	 * reflect the order in which components are added. That is, the very first 
	 * component has an index of 1, the second component has an index of 2, and so forth.
	 * @access public
	 * @param integer index The index of the component which should be returned.
	 * @return ref object The component.
	 **/
	function & getComponent($index) {
		// ** parameter validation
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		return $this->_components[$index-1];
	}
	
	/**
	 * Returns all components in this <code>Container</code>.
	 * @access public
	 * @return ref array An array of the components in this <code>Container</code>.
	 **/
	function & getComponents() {
		return $this->_components;
	}

	/**
	 * Returns the width for the component of this container with the specified index. Indices
	 * reflect the order in which components are added. That is, the very first 
	 * component has an index of 1, the second component has an index of 2, and so forth.
	 * @access public
	 * @param integer index The index of the component which should be returned.
	 * @return string The width.
	 **/
	function getComponentWidth($index) {
		return $this->_constraints[$index-1][0];
	}
	
	/**
	 * Returns the height for the component of this container with the specified index. Indices
	 * reflect the order in which components are added. That is, the very first 
	 * component has an index of 1, the second component has an index of 2, and so forth.
	 * @access public
	 * @param integer index The index of the component which should be returned.
	 * @return string The height.
	 **/
	function getComponentHeight($index) {
		return $this->_constraints[$index-1][1];
	}
	
	/**
	 * Returns the horizontal alignment for the component of this container with the specified index. Indices
	 * reflect the order in which components are added. That is, the very first 
	 * component has an index of 1, the second component has an index of 2, and so forth.
	 * @access public
	 * @param integer index The index of the component which should be returned.
	 * @return integer The horizontal alignment. 
	 **/
	function getComponentAlignmentX($index) {
		return $this->_constraints[$index-1][2];
	}

	/**
	 * Returns the vertical alignment for the component of this container with the specified index. Indices
	 * reflect the order in which components are added. That is, the very first 
	 * component has an index of 1, the second component has an index of 2, and so forth.
	 * @access public
	 * @param integer index The index of the component which should be returned.
	 * @return integer The vertical alignment. 
	 **/
	function getComponentAlignmentY($index) {
		return $this->_constraints[$index-1][3];
	}

	/**
	 * Removes the component with the specified index from this container. Indices
	 * reflect the order in which components are added. That is, the very first 
	 * component has an index of 1, the second component has an index of 2, and so forth.
	 * @access public
	 * @param integer index The index of the component which should be removed from
	 * this container..
	 * @return ref object The component that was just removed.
	 **/
	function & remove($index) {
		// ** parameter validation
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		$component =& $this->_components[$index-1];
		unset($this->_components[$index-1]);
		unset($this->_constraints[$index-1]);

		return $component;
	}
	
	/**
	 * Removes all components from this <code>Container</code>.
	 * @access public
	 **/
	function removeAll() {
		$this->_components = array();
		$this->_constraints = array();
	}
	
	/**
	 * Returns the <code>Layout</code> of this container.
	 * @access public
	 * @return ref object The <code>Layout</code> of this container.
	 **/
	function & getLayout() {
		return $this->_layout;
	}
	
	/**
	 * Sets the <code>Layout</code> of this container
	 * @access public
	 * @param ref object layout The Layout to assign to this container.
	 **/
	function setLayout(& $layout) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("LayoutInterface");
		ArgumentValidator::validate($layout, $rule, true);
		// ** end of parameter validation	

		$this->_layout = $layout;		
	}
	
}

?>