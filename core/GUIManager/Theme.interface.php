<?php

require_once(HARMONI."GUIManager/Component.interface.php");
require_once(HARMONI."GUIManager/Container.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.interface.php");

/**
 * A <code>Theme</code> is a combination of two things: first, it stores a variety
 * of reusable <code>StyleCollections</code> and second, it offers a mechanism for
 * printing an HTML web page.
 * <br /><br />
 * Each <code>Theme</code> has a set of style collections that correspond to 
 * each component type.
 * <br /><br />
 * Each <code>Theme</code> has a single component (could be container) that will
 * be printed when <code>printPage()</code> is called.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Theme.interface.php,v 1.10 2005/02/07 21:38:14 adamfranco Exp $
 **/
class ThemeInterface {

	/**
	 * Returns the display name of this Theme.
	 * @access public
	 * @return string The display name of this Theme.
	 **/
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Sets the display name of this Theme.
	 * @access public
	 * @param string displayName The new display name of this Theme.
	 **/
	function setDisplayName($displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the description of this Theme.
	 * @access public
	 * @return string The description of this Theme.
	 **/
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Sets the description of this Theme.
	 * @access public
	 * @param string description The new description of this Theme.
	 **/
	function setDescription($description) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Attaches to the Theme a style collection that will have a global effect
	 * on the page look and feel. For example, this could be a style collection
	 * affecting the <code>body</code> HTML element.
	 * @access public
	 * @param ref object styleCollection The style collection to attach.
	 **/
	function addGlobalStyle(& $styleCollection) {
	}
	
	/**
	 * This method returns all style collections for the given component type and
	 * the given numeric index.
	 * <br /><br />
	 * Each <code>Theme</code> has a set of style collections that correspond to 
	 * a combination of a component type and a numeric index. For example, the user
	 * can define two style collections for components of type BLOCK and index 1 and
	 * a totally different set of three style collections for componets of type
	 * MENU and index 2. 
	 * <br /><br />
	 * The index has no semantic meaning: you can think of the index as 'level' of the
	 * component. Alternatively, the index could serve as means of distinguishing 
	 * between components with the same type.
	 * For example, a BLOCK component with index 2 will normally have a 
	 * different set of style collections than a BLOCK component with index 1. 
	 * <br /><br />
	 * Another way of interpreting the index is drawing a parallel to the HTML headings
	 * &lt;h1&gt;, &lt;h2&gt;, &lt;h3&gt;, ..., where the lower the index, 
	 * the more "prominent" the look of the component.
	 * <br /><br />
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
	function &getStylesForComponentType($type, $index) {
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
	function &getComponent() {
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
	 * the theme component and all sub-components (if any). Theme styles should come
	 * first, followed by individual component's styles to allow the latter to take
	 * precedence.
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
	

	/**
	 * Adds the given StyleProperty to the internally maintained list of mutable
	 * (updateable) style properties and assigns it an id. This method and
	 * the <code>getRegisteredSP</code> method enable the user to quickly change
	 * the values of key Theme settings. For example,
	 * let us assume that Bob has created his own theme and he has added a global 
	 * style collection for the main content block. Bob would like to allow the
	 * user to change the width property of that collection. In order to do so,
	 * Bob needs to call <code>registerSP()</code> and pass the WidthSP 
	 * object accordingly. This WidthSP object must be the same object that had 
	 * been added to the aforementioned global style collection. The user now can
	 * call <code>getRegisteredSP</code> with the id that was returned by 
	 * <code>registerSP</code> and access/modify the <code>WidthSP</code> object.
	 * @access public
	 * @param ref object sp The StyleProperty object that will be registered as 
	 * mutable within this Theme.
	 * @param string postImportMethod This is the name of the method that will
	 * be called after this SP is imported. This can be useful in case other
	 * properties depend on the content of this property, but the user does not
	 * to export all of them.
	 * @return integer An integer id assigned to the given style property. The id 
	 * only meaningful within the context of this Theme (i.e. this is not a system wide unique id).
	 **/
	function registerSP(& $sp, $postImportMethod) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * This methods exports the content of a registered style property object. The
	 * output is implementation specific. The only requirement is that if the output
	 * of this method is passed as an input to <code>importRegisteredSP()</code>,
	 * then the contents of the <code>StyleProperty</code> should not change.
	 * @access public
	 * @param integer id The id of the <code>StyleProperty</code> as returned
	 * by <code>registerSP()</code>.
	 * @return mixed The contens of the <code>StyleProperty</code>. The output
	 * representation is implementation specific.
	 **/
	function exportRegisteredSP($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * This method is like <code>exportRegisteredSP</code> but exports all
	 * registered stlye properties at the same time. The output is an array
	 * whose elements are the inividual export data as returned by <code>exportRegisteredSP</code>.
	 * @access public
	 * @return array An array containing the export data for each registered
	 * <code>StylePorperty</code>. The indexes of the array are the ids of the 
	 * style properties.
	 **/
	function exportAllRegisteredSPs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Imports the contents of a registered mutable <code>StyleProperty</code>.
	 * The input to this method should be an output obtained from calling
	 * <code>exportRegisteredSP</code> on the same <code>StyleProperty</code>.
	 * @access public
	 * @param integer id The id of the <code>StyleProperty</code> as returned
	 * by <code>registerSP()</code>.
	 * @param mixed importData The contens of the <code>StyleProperty</code> as exported by
	 * <code>exportRegisteredSP()</code>.
	 * @return ref object The updated <code>StyleProperty</code> object.
	 **/
	function &importRegisteredSP($id, $importData) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns a <code> </code>previously registered by <code>registerSP()</code>
	 * for the given id.
	 * @access public
	 * @param integer id The id identifying which StyleProperty to return; as returned
	 * by <code>registerSP()</code>.
	 * @return ref object A <code>StylePorperty</code> object.
	 **/
	function &getRegisteredSP($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns all registered mutable style properties in an array whose indexes are the
	 * ids of the style properties (as returned by <code>registerSP()</code>).
	 * @access public
	 * @return ref array An array containing all registered mutable 
	 * <code>StyleProperty</code> objects.
	 **/
	function &getAllRegisteredSPs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
}

?>