<?php

require_once(HARMONI."GUIManager/Container.interface.php");
require_once(HARMONI."GUIManager/Component.class.php");
require_once(HARMONI."GUIManager/StyleProperties/WidthSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/HeightSP.class.php");

/**
 * This is a generic <code>Container</code> implementation that should be sufficient
 * for all means and purposes.
 * <br /><br />
 * The <code>Container</code> interface is an extension of the <code>Component</code>
 * interface; <code>Containers</code> are capable of storing multiple sub-<code>Components</code>
 * and when rendering Containers, all sub-<code>Components</code> will be rendered as well.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Container.class.php,v 1.8 2005/01/19 21:07:52 adamfranco Exp $
 */
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
	 * @param integer type The type of this component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and 
	 * <code>addStyleForComponentType()</code> methods.
	 * @param optional object StyleCollections styles,... Zero, one, or more StyleCollection 
	 * objects that will be added to the newly created Component. Warning, this will
	 * result in copying the objects instead of referencing them as using
	 * <code>addStyle()</code> would do.
	 **/
	function Container(& $layout, $type, $index) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("LayoutInterface");
		ArgumentValidator::validate($layout, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation	
	
		$this->Component(null, $type, $index);
		$this->_layout =& $layout;
		$this->_components = array();
		$this->_constraints = array();

		// if there are style collections to add
		if (func_num_args() > 3)
			for ($i = 3; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}

	/**
	 * Renders the component on the screen.
	 * @param ref object theme The Theme object to use in producing the result
	 * of this method.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @access public
	 **/
	function render(& $theme, $tabs = "") {
		echo $this->getPreHTML($theme, $tabs);
		$this->_layout->render($this, $theme, $tabs);
		echo $this->getPostHTML($theme, $tabs);
	}

	/**
	 * Adds the given component to this container.
	 * @access public
	 * @param ref object component The component to add.
	 * @param string width The available width for the added component. If null, will be ignored.
	 * @param string height The available height for the added component. If null, will be ignored.
	 * @param integer alignmentX The horizontal alignment for the added component. Allowed values are 
	 * <code>LEFT</code>, <code>CENTER</code>, and <code>RIGHT</code>.
	 * If null, will be ignored.
	 * @param integer alignmentY The vertical alignment for the added component. Allowed values are 
	 * <code>TOP</code>, <code>CENTER</code>, and <code>BOTTOM</code>.
	 * If null, will be ignored.
	 * @return ref object The component that was just added.
	 **/
	function &add(& $component, $width, $height, $alignmentX, $alignmentY) {
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
	 * Returns the component of this container with the specified id. Ids
	 * reflect the order in which components are added. That is, the very first 
	 * component has an id of 1, the second component has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the component which should be returned.
	 * @return ref object The component.
	 **/
	function &getComponent($id) {
		// ** parameter validation
		ArgumentValidator::validate($id, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		if (isset($this->_components[$id-1]))
			return $this->_components[$id-1];
		else
			return null;
	}

	/**
	 * Returns the number of components in this container.
	 * @access public
	 * @return integer The number of components in this container.
	 **/
	function getComponentsCount() {
		return count($this->_components);
	}

	/**
	 * Returns all components in this <code>Container</code>.
	 * @access public
	 * @return ref array An array of the components in this <code>Container</code>.
	 **/
	function &getComponents() {
		return $this->_components;
	}

	/**
	 * Returns the width for the component of this container with the specified id. Ids
	 * reflect the order in which components are added. That is, the very first 
	 * component has an id of 1, the second component has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the component which should be returned.
	 * @return string The width.
	 **/
	function getComponentWidth($id) {
		return $this->_constraints[$id-1][0];
	}
	
	/**
	 * Returns the height for the component of this container with the specified id. Ids
	 * reflect the order in which components are added. That is, the very first 
	 * component has an id of 1, the second component has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the component which should be returned.
	 * @return string The height.
	 **/
	function getComponentHeight($id) {
		return $this->_constraints[$id-1][1];
	}
	
	/**
	 * Returns the horizontal alignment for the component of this container with the specified id. Ids
	 * reflect the order in which components are added. That is, the very first 
	 * component has an id of 1, the second component has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the component which should be returned.
	 * @return integer The horizontal alignment. 
	 **/
	function getComponentAlignmentX($id) {
		return $this->_constraints[$id-1][2];
	}

	/**
	 * Returns the vertical alignment for the component of this container with the specified id. Ids
	 * reflect the order in which components are added. That is, the very first 
	 * component has an id of 1, the second component has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the component which should be returned.
	 * @return integer The vertical alignment. 
	 **/
	function getComponentAlignmentY($id) {
		return $this->_constraints[$id-1][3];
	}

	/**
	 * Removes the component with the specified id from this container. Ids
	 * reflect the order in which components are added. That is, the very first 
	 * component has an id of 1, the second component has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the component which should be removed from
	 * this container..
	 * @return ref object The component that was just removed.
	 **/
	function &remove($id) {
		// ** parameter validation
		ArgumentValidator::validate($id, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		$component =& $this->_components[$id-1];
		unset($this->_components[$id-1]);
		unset($this->_constraints[$id-1]);

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
	function &getLayout() {
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

		$this->_layout =& $layout;		
	}
	
}

?>