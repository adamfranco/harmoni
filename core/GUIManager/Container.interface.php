<?php

require_once(HARMONI."GUIManager/Component.interface.php");

/**
 * An alignment constant.
 * @const integer LEFT
 * @package harmoni.gui
 */
define("LEFT", 5);

/**
 * An alignment constant.
 * @const integer RIGHT
 * @package harmoni.gui
 */
define("RIGHT", 6);

/**
 * An alignment constant.
 * @const integer TOP
 * @package harmoni.gui
 */
define("TOP", 7);

/**
 * An alignment constant.
 * @const integer BOTTOM
 * @package harmoni.gui
 */
define("BOTTOM", 8);

/**
 * An alignment constant.
 * @const integer CENTER
 * @package harmoni.gui
 */
define("CENTER", 9);

/**
 * The <code>Container</code> interface is an extension of the <code>Component</code>
 * interface; <code>Containers</code> are capable of storing multiple sub-<code>Components</code>
 * and when rendering Containers, all sub-<code>Components</code> will be rendered as well.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Container.interface.php,v 1.6 2005/02/07 21:38:13 adamfranco Exp $
 */
class ContainerInterface extends ComponentInterface {

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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the number of components in this container.
	 * @access public
	 * @return integer The number of components in this container.
	 **/
	function getComponentsCount() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns all components in this <code>Container</code>.
	 * @access public
	 * @return ref array An array of the components in this <code>Container</code>.
	 **/
	function &getComponents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	function &getLayout() {
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