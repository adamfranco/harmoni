<?php

/**
 * A constant defining the BLANK component type.
 * @const integer BLANK
 * @package harmoni.gui
 */
define("BLANK", 13);
 
/**
 * A constant defining the HEADING component type.
 * @const integer HEADING
 * @package harmoni.gui
 */
define("HEADING", 6);
 
/**
 * A constant defining the FOOTER component type.
 * @const integer FOOTER
 * @package harmoni.gui
 */
define("FOOTER", 7);
 
/**
 * A constant defining the BLOCK component type.
 * @const integer BLOCK
 * @package harmoni.gui
 */
define("BLOCK", 8);
 
/**
 * A constant defining the MENU component type.
 * @const integer MENU
 * @package harmoni.gui
 */
define("MENU", 9);
 
/**
 * A constant defining the MENU_ITEM_LINK_UNSELECTED component type.
 * @const integer MENU_ITEM_LINK_UNSELECTED
 * @package harmoni.gui
 */
define("MENU_ITEM_LINK_UNSELECTED", 10);
 
/**
 * A constant defining the MENU_ITEM_LINK_SELECTED component type.
 * @const integer MENU_ITEM_LINK_SELECTED
 * @package harmoni.gui
 */
define("MENU_ITEM_LINK_SELECTED", 11);
 
/**
 * A constant defining the MENU_ITEM_HEADING component type.
 * @const integer MENU_ITEM_HEADING
 * @package harmoni.gui
 */
define("MENU_ITEM_HEADING", 12); 

/**
 * A constant defining the OTHER component type.
 * @const integer OTHER
 * @package harmoni.gui
 */
define("OTHER", 13);
 
/**
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Component.interface.php,v 1.8 2005/01/19 21:07:51 adamfranco Exp $
 */
class ComponentInterface {

	/**
	 * Adds a new <code>StyleCollection</code> to this component. The component
	 * can have 0 or more style collections attached; each of the latter will
	 * affect the appearance of the component. The uniqueness of the collections
	 * is enforce by their selector  (i.e., you can't have two collections
	 * with the same selector). If a style collection has been registered with
	 * the Theme for this Component's type and level, then the new style collection
	 * @access public
	 * @param ref object styleCollection The <code>StyleCollection</code> to add
	 * to this component. 
	 * @return ref object The style collection that was just added.
	 **/
	function &addStyle($styleCollection) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the style collection with the specified selector.
	 * @access public
	 * @param string selector The selector.
	 * @return ref object The style collection.
	 **/
	function &getStyle($selector) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Remove the given StyleCollection from this Component.
	 * @access public
	 * @param string selector The selector of the style collection to remove.
	 * @return ref object The style collection that was removed. <code>NULL</code>
	 * if it could not be found.
	 **/
	function &removeStyle($selector) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns all style collections for this component.
	 * @access public
	 * @return array An array of style collections; the key corresponds to the
	 * selector of each collection.
	 **/
	function &getStyles() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and <code>addStyleForComponentType()</code>
	 * Theme methods.
	 * @access public
	 * @return integer The index of the component.
	 **/
	function getIndex() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns any pre HTML code that needs to be printed. This method should be called
	 * at the beginnig of <code>render()</code>.
	 * @access public
	 * @param ref object theme The Theme object to use in producing the result
	 * of this method.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The HTML string.
	 **/
	function getPreHTML(& $theme, $tabs = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns any post HTML code that needs to be printed. This method should be called
	 * at the end of <code>render()</code>.
	 * @access public
	 * @param ref object theme The Theme object to use in producing the result
	 * of this method.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The HTML string.
	 **/
	function getPostHTML(& $theme, $tabs = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the type of this component. One of BLANK, HEADING, FOOTER, BLOCK,
	 * MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @access public
	 * @return integer The type of this component.
	 **/
	function getType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>