<?php

require_once(HARMONI."GUIManager/Container.class.php");
require_once(HARMONI."GUIManager/Components/Menu.interface.php");

/**
 * A <code>Menu</code> is a <code>Container</code> that stores a number of 
 * MenuItem objects. The familiar add/get/remove <code>Container</code> methods 
 * can be used to manage the <code>MenuItems</code>.
 * @version $Id: Menu.class.php,v 1.3 2004/10/26 21:07:28 adamfranco Exp $
 * @package harmoni.gui.components
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class Menu extends Container /* implements MenuInterface */ {

	/**
	 * This is the id of the menu item that is currently selected.
	 * @attribute private integer _selectedId
	 */
	var $_selectedId;

	/**
	 * The constructor.
	 * @access public
	 * @param ref object layout The <code>Layout</code> of this container.
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
	function Menu(& $layout, $index) {
		$this->Container($layout, MENU, $index);
		
		$this->_selectedId = null;

		// if there are style collections to add
		if (func_num_args() > 2)
			for ($i = 2; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}

	/**
	 * Adds the given menu item to this container. The only difference from the
	 * familiar <code>add()</code> method of the Container class is that now
	 * explicit checking is performed to make sure that the given component
	 * is indeed a <code>menuItem</code> and not just any component.
	 * <br><br>
	 * Warning: The <code>add()</code> method allows the user to add the same
	 * instance of an object multiple times. With menus, this is extremely unadvised because
	 * the menu might end up with multiple selected menu items at the same time.
	 * @access public
	 * @param ref object menuItem The menuItem to add. If it is selected, then the
	 * old selected menu item will be automatically deselected.
	 * @param string width The available width for the added menuItem. If null, will be ignored.
	 * @param string height The available height for the added menuItem. If null, will be ignored.
	 * @param integer alignmentX The horizontal alignment for the added menuItem. Allowed values are 
	 * <code>LEFT</code>, <code>CENTER</code>, and <code>RIGHT</code>.
	 * If null, will be ignored.
	 * @param integer alignmentY The vertical alignment for the added menuItem. Allowed values are 
	 * <code>TOP</code>, <code>CENTER</code>, and <code>BOTTOM</code>.
	 * If null, will be ignored.
	 * @return ref object The menuItem that was just added.
	 **/
	function &add(& $menuItem, $width, $height, $alignmentX, $alignmentY) {
		// ** parameter validation
		// some weird class checking here - would have been much simpler if PHP
		// supported multiple inheritance
		$rule1 =& new ExtendsValidatorRule("MenuItemLink");
		$rule2 =& new ExtendsValidatorRule("MenuItemHeading");
		ArgumentValidator::validate($menuItem, new OrValidatorRule($rule1, $rule2), true);
		// ** end of parameter validation

		parent::add($menuItem, $width, $height, $alignmentX, $alignmentY);
		
		// if the given menuItem is selected, then select it
		if (is_a($menuItem, "MenuItemLink"))
			if ($menuItem->isSelected()) {
				$id = $this->getComponentsCount();
				$this->select($id);
			}
	}

	/**
	 * Returns the menu item that is currently selected.
	 * @access public
	 * @return ref object The menu item that is currently selected.
	 **/
	function &getSelected() {
		if ($this->_selectedId)
			return $this->getComponent($this->_selectedId);
		else
			return null;
	}

	/**
	 * Determines whether the <code>MenuItem</code> with the given id is selected. Ids
	 * reflect the order in which menu items are added. That is, the very first 
	 * menu item has an id of 1, the second menu item has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the menu item.
	 * @return boolean <code>TRUE</code>, if the menu item with the given id is selected.
	 **/
	function isSelected($id) {
		// ** parameter validation
		ArgumentValidator::validate($id, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		return $this->_selectedId === $id;
	}
	
	/**
	 * Selects the <code>MenuItem</code> with the given id, and deselects the one
	 * that was previoiusly selected. Ids reflect the order in which menu items 
	 * are added. That is, the very first menu item has an id of 1, the second 
	 * menu item has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the menu item to select.
	 **/
	function select($id) {
		// ** parameter validation
		ArgumentValidator::validate($id, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		// make sure the id is valid
		$newSelected =& $this->getComponent($id);
		if (!isset($newSelected))
			return;

		// deselect the old one
		$oldSelected =& $this->getSelected();
		if (isset($oldSelected))
			$oldSelected->setSelected(false);

		// select the new component
		$newSelected->setSelected(true);
		
		$this->_selectedId = $id;
	}

}

?>