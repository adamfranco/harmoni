<?php

require_once(HARMONI."GUIManager/Component.interface.php");

/**
 * An alignment constant.
 * @const integer ALIGNMENT_LEFT
 * @package harmoni.gui
 */
define("ALIGNMENT_LEFT", 5);

/**
 * An alignment constant.
 * @const integer ALIGNMENT_RIGHT
 * @package harmoni.gui
 */
define("ALIGNMENT_RIGHT", 6);

/**
 * An alignment constant.
 * @const integer ALIGNMENT_TOP
 * @package harmoni.gui
 */
define("ALIGNMENT_TOP", 7);

/**
 * An alignment constant.
 * @const integer ALIGNMENT_BOTTOM
 * @package harmoni.gui
 */
define("ALIGNMENT_BOTTOM", 8);

/**
 * An alignment constant.
 * @const integer ALIGNMENT_CENTER
 * @package harmoni.gui
 */
define("ALIGNMENT_CENTER", 9);

/**
 * The <code>Container</code> interface is an extension of the <code>Component</code>
 * interface; <code>Containers</code> are capable of storing multiple sub-<code>Components</code>
 * and when rendering Containers, all sub-<code>Components</code> will be rendered as well.
 * @version $Id: Container.interface.php,v 1.1 2004/07/19 23:59:50 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class ContainerInterface extends ComponentInterface {

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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns all components in this <code>Container</code>.
	 * @access public
	 * @return ref array An array of the components in this <code>Container</code>.
	 **/
	function & getComponents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Removes all components from this <code>Container</code>.
	 * @access public
	 **/
	function removeAll() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the <code>Layout</code> of this container.
	 * @access public
	 * @return ref object The <code>Layout</code> of this container.
	 **/
	function & getLayout() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the <code>Layout</code> of this container
	 * @access public
	 * @param ref object layout The Layout to assign to this container.
	 **/
	function setLayout(& $layout) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>