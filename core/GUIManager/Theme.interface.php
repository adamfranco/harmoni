<?php

require_once(HARMONI."GUIManager/Component.interface.php");
require_once(HARMONI."GUIManager/Container.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.interface.php");

/**
 * A <code>Theme</code> is a combination of two things: first, it stores a variety
 * of reusable <code>StyleCollections</code> and second, it offers a mechanism for
 * printing an HTML web page.
 * <br><br>
 * Each <code>Theme</code> has a set of style collections that correspond to 
 * each component type.
 * <br><br>
 * Each <code>Theme</code> has a single component (could be container) that will
 * be printed when <code>printPage()</code> is called.
 * @version $Id: Theme.interface.php,v 1.2 2004/07/23 02:44:16 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/
class ThemeInterface {

	/**
	 * This method returns all style collections for the given component type and
	 * the given numeric index.
	 * <br><br>
	 * Each <code>Theme</code> has a set of style collections that correspond to 
	 * a combination of a component type and a numeric index. For example, the user
	 * can define two style collections for components of type BLOCK and index 1 and
	 * a totally different set of three style collections for componets of type
	 * MENU and index 2. 
	 * <br><br>
	 * The index has no semantic meaning: you can think of the index as 'level' of the
	 * component. Alternatively, the index could serve as means of distinguishing 
	 * between components with the same type.
	 * For example, a BLOCK component with index 2 will normally have a 
	 * different set of style collections than a BLOCK component with index 1. 
	 * <br><br>
	 * Another way of interpreting the index is drawing a parallel to the HTML headings
	 * &lt;h1&gt;, &lt;h2&gt;, &lt;h3&gt;, ..., where the lower the index, 
	 * the more "prominent" the look of the component.
	 * <br><br>
	 * The style collections would be normally set by the 
	 * <code>setStyleForComponentType()</code> method in the Theme constructor.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which style collections
	 * to return. If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return ref array An array of Style Collections.
	 **/
	function & getStylesForComponentType($type, $index) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Registers the specified style collection with the given component type.
	 * @access public
	 * @param ref object styleCollection The style collection to add.
	 * @param integer type The type of the component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index with which to register the style collection.
	 * For a description of the role of indices, see the documentation of
	 * <code>getStylesForComponentType()</code>.
	 **/
	function addStyleForComponentType(& $styleCollection, $type, $index) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the HTML string that needs to be printed before an attempt is made
	 * to render components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param string html The HTML code to use.
	 * @param integer type The type of the component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index with which to register the HTML string.
	 * For a description of the role of indices, see the documentation of
	 * <code>getStylesForComponentType()</code>.
	 **/
	function setPreHTMLForComponentType($html, $type, $index) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the HTML string that needs to be printed before an attempt is made
	 * to render components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 **/
	function getPreHTMLForComponentType($type, $index) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the HTML string that needs to be printed after successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param string html The HTML code to use.
	 * @param integer type The type of the component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index with which to register the HTML string.
	 * For a description of the role of indices, see the documentation of
	 * <code>getStylesForComponentType()</code>.
	 **/
	function setPostHTMLForComponentType($html, $type, $index) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the HTML string that needs to be printed after successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 **/
	function getPostHTMLForComponentType($type, $index) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the component of this <code>Theme</code>.
	 * @access public
	 * @return ref object The component of this <code>Theme</code>.
	 **/
	function & getComponent() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the component of this <code>Theme</code>.
	 * @access public
	 * @param ref object A component.
	 **/
	function setComponent(& $component) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Sets the page title of this <code>Theme</code>.
	 * @param string title The page title.
	 * @access public
	 * @return void
	 **/
	function setPageTitle($title) {
		ArgumentValidator::validate($title, new StringValidatorRule);
		
		$this->_pageTitle = $title;
	}

	/**
	 * Returns all CSS code: The CSS code for the Theme, the various component types,
	 * the theme component and all sub-components (if any).
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string CSS code.
	 **/
	function getCSS($tabs = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Prints the HTML page.
	 * @access public
	 **/
	function printPage() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>