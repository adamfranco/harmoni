<?php

require_once(HARMONI."GUIManager/Theme.interface.php");
require_once(HARMONI."GUIManager/Component.class.php");
require_once(HARMONI."GUIManager/Container.class.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");

/**
 * A generic <code>Theme</code> implementation. It should be sufficient just to
 * extend it to create new fully fledged Themes.
 * <br><br>
 * A <code>Theme</code> is a combination of two things: first, it stores a variety
 * of reusable <code>StyleCollections</code> and second, it offers a mechanism for
 * printing an HTML web page.
 * <br><br>
 * Each <code>Theme</code> has a set of style collections that correspond to 
 * each component type.
 * <br><br>
 * Each <code>Theme</code> has a single component (could be container) that will
 * be printed when <code>printPage()</code> is called.
 * @version $Id: Theme.class.php,v 1.3 2004/07/26 23:23:30 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/
class Theme extends ThemeInterface {

	/**
	 * The display name of this Theme.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	/**
	 * The description of this Theme.
	 * @attribute private string _description
	 */
	var $_description;

	/**
	 * The component of this Theme.
	 * @attribute private object _component
	 */
	var $_component;

	/**
	 * The page title.
	 * @attribute private string _pageTitle
	 */
	var $_pageTitle;
	
	/**
	 * An array storing style collections for the different
	 * component types. The first dimension is the component type. The second
	 * dimension is the index. The thrid dimension is the selector of the style
	 * collection.
	 * @attribute private array _componentStyles
	 */
	var $_componentStyles;
	
	/**
	 * An array storing global style collections. It is one-dimensional. The key
	 * is the selector of the style collection. The element is the style collection
	 * itself.
	 * @attribute private array _globalStyles
	 */
	var $_globalStyles;
	
	/**
	 * This array combines <code>_componentStyles</code> and <code>_globalStyles</code>
	 * into one. The purpose is to avoid duplication of style collection and to
	 * provide an easy way to implement the <code>getCSS()</code> method.
	 * @attribute private array _styles
	 */
	var $_styles;
	
	/**
	 * This array will store the pre-HTML strings for the different component
	 * types. The first dimension is the component type. The second
	 * dimension is the index.
	 * @attribute private array _componentPreHTML
	 */
	var $_componentPreHTML;
	
	/**
	 * This array will store the post-HTML strings for the different component
	 * types. The first dimension is the component type. The second
	 * dimension is the index.
	 * @attribute private array _componentPostHTML
	 */
	var $_componentPostHTML;

	/**
	 * The constructor.
	 * @access public
	 * @param 
	 **/
	function Theme($displayName, $description) {
		// ** parameter validation
		$rule =& new OptionalRule(new StringValidatorRule());
		ArgumentValidator::validate($displayName, $rule, true);
		ArgumentValidator::validate($description, $rule, true);
		// ** end of parameter validation
	
		$this->_component = null;
		$this->_pageTitle = "";
		$this->_componentStyles = array();
		$this->_globalStyles = array();
		$this->_displayName = $displayName;
		$this->_description = $description;
	}

	/**
	 * Returns the display name of this Theme.
	 * @access public
	 * @return string The display name of this Theme.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}

	/**
	 * Sets the display name of this Theme.
	 * @access public
	 * @param string displayName The new display name of this Theme.
	 **/
	function setDisplayName($displayName) {
		// ** parameter validation
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		// ** end of parameter validation

		$this->_displayName = $displayName;
	}

	/**
	 * Returns the description of this Theme.
	 * @access public
	 * @return string The description of this Theme.
	 **/
	function getDescription() {
		return $this->_description;
	}

	/**
	 * Sets the description of this Theme.
	 * @access public
	 * @param string description The new description of this Theme.
	 **/
	function setDescription($description) {
		// ** parameter validation
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		// ** end of parameter validation

		$this->_description = $description;
	}
	
	/**
	 * Attaches to the Theme a style collection that will have a global effect
	 * on the page look and feel. For example, this could be a style collection
	 * affecting the <code>body</code> HTML element. IMPORTANT: The style collection
	 * must not be applicable, i.e. its <code>canBeApplied()</code> method should
	 * return <code>false</code>.
	 * @access public
	 * @param ref object styleCollection The style collection to attach.
	 **/
	function addGlobalStyle(& $styleCollection) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("StyleCollectionInterface");
		ArgumentValidator::validate($styleCollection, $rule, true);
		// ** end of parameter validation
		
		// the style collection must not be applicable
		if ($styleCollection->canBeApplied()) {
			$err = "Cannot add a global style collection that is applicable.";
			throwError(new Error($err, "GUIManager", false));
			return;
		}

		// check that this styleCollection hasn't been added already
		if (!isset($this->_globalStyles[$styleCollection->getSelector()]))
			$this->_globalStyles[$styleCollection->getSelector()] =& $styleCollection;
			
		if (!isset($this->_styles[$styleCollection->getSelector()]))
			$this->_styles[$styleCollection->getSelector()] =& $styleCollection;
	}

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
	 * to return. If the given index is greater than the maximum registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return ref array An array of Style Collections.
	 **/
	function & getStylesForComponentType($type, $index) {
		// ** parameter validation
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		// Frst of all, see if there are any registered styles for this
		// component type at all.
		if (!isset($this->_componentStyles[$type]))
			return array();

	    // Now, we know there is at least one style collection for this
		// component type. See, if there are any for the given index.
		if (isset($this->_componentStyles[$type][$index]))
			return $this->_componentStyles[$type][$index];

		// If not, then see if there are any style collections for smaller indices.
		// To do so, sort the indices in a reversed order and find the first
		// index that is smaller than the given one.
		$keys = array_keys($this->_componentStyles[$type]);
		rsort($keys, SORT_NUMERIC);
		for ($i = 0; $i < count($keys); $i++)
			if ($keys[$i] < $index)
				return $this->_componentStyles[$type][$keys[$i]];

		// nothing has been found
		return array();
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
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("StyleCollectionInterface");
		ArgumentValidator::validate($styleCollection, $rule, true);
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation
		
		// make sure we can apply it
		if (!$styleCollection->canBeApplied()) {
			$err = "This style collection cannot be applied to components.";
			throwError(new Error($err, "GUIManager", false));
			return;
		}
		
		// check that this styleCollection hasn't been added already
		if (!isset($this->_componentStyles[$type][$index][$styleCollection->getSelector()]))
			$this->_componentStyles[$type][$index][$styleCollection->getSelector()] =& $styleCollection;
			
		if (!isset($this->_styles[$styleCollection->getSelector()]))
			$this->_styles[$styleCollection->getSelector()] =& $styleCollection;
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
		// ** parameter validation
		ArgumentValidator::validate($html, new StringValidatorRule(), true);
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_componentPreHTML[$type][$index] = $html;
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
		// ** parameter validation
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		// Frst of all, see if there are any registered HTML strings for this
		// component type at all.
		if (!isset($this->_componentPreHTML[$type]))
			return "";

	    // Now, we know there is at least one HTML string for this
		// component type. See, if there are any for the given index.
		if (isset($this->_componentPreHTML[$type][$index]))
			return $this->_componentPreHTML[$type][$index];

		// If not, then see if there are any HTML strings for smaller indices.
		// To do so, sort the indices in a reversed order and find the first
		// index that is smaller than the given one.
		$keys = array_keys($this->_componentPreHTML[$type]);
		rsort($keys, SORT_NUMERIC);
		for ($i = 0; $i < count($keys); $i++)
			if ($keys[$i] < $index)
				return $this->_componentPreHTML[$type][$keys[$i]];

		// nothing has been found
		return "";
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
		// ** parameter validation
		ArgumentValidator::validate($html, new StringValidatorRule(), true);
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_componentPostHTML[$type][$index] = $html;
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
		// ** parameter validation
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		// Frst of all, see if there are any registered HTML strings for this
		// component type at all.
		if (!isset($this->_componentPostHTML[$type]))
			return "";

	    // Now, we know there is at least one HTML string for this
		// component type. See, if there are any for the given index.
		if (isset($this->_componentPostHTML[$type][$index]))
			return $this->_componentPostHTML[$type][$index];

		// If not, then see if there are any HTML strings for smaller indices.
		// To do so, sort the indices in a reversed order and find the first
		// index that is smaller than the given one.
		$keys = array_keys($this->_componentPostHTML[$type]);
		rsort($keys, SORT_NUMERIC);
		for ($i = 0; $i < count($keys); $i++)
			if ($keys[$i] < $index)
				return $this->_componentPostHTML[$type][$keys[$i]];

		// nothing has been found
		return "";
	}
	
	/**
	 * Returns the component of this <code>Theme</code>.
	 * @access public
	 * @return ref object The component of this <code>Theme</code>.
	 **/
	function & getComponent() {
		return $this->_component;
	}
	
	/**
	 * Sets the component of this <code>Theme</code>.
	 * @access public
	 * @param ref object A component.
	 **/
	function setComponent(& $component) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("ComponentInterface");
		ArgumentValidator::validate($component, $rule, true);
		// ** end of parameter validation

		$this->_component = $component;
	}
	
	/**
	 * Sets the page title of this <code>Theme</code>.
	 * @param string title The page title.
	 * @access public
	 * @return void
	 **/
	function setPageTitle($title) {
		// ** parameter validation
		ArgumentValidator::validate($title, new StringValidatorRule(), true);
		// ** end of parameter validation
		
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
		$css = "";
	
		// Get any style collections explicitly registered with this Theme
		$styleCollections = $this->_styles;

		// If the Theme does has an assigned component then get all the style
		// collection of the component and any subcomponents it might have.
		if (isset($this->_component))
			$this->_getAllStyles($this->_component, $styleCollections);
	
		// Now convert the array of style collections to a string with CSS code.
		foreach (array_keys($styleCollections) as $key) {
			$css .= $styleCollections[$key]->getCSS($tabs);
			$css .= "\n";
		}
		
		return $css;
	}
	
	/**
	 * A private function that returns all style collections for the given component and
	 * any subcomponents it might have.
	 * @access public
	 * @param ref object component The component to start at.
	 * @param array result This array will be recursively filled with
	 * all the style collections.
	 * @return string The CSS code.
	 **/
	function _getAllStyles(& $component, & $result) {
		// get all style collections for current component and add them to $result
		$styleCollections =& $component->getStyles();
		foreach (array_keys($styleCollections) as $key)
			// if not already in, then add it
			if (!isset($result[$key]))
				$result[$key] =& $styleCollections[$key];

		// now, see if $component is a container, if yes then recurse to children,
		// else return (base case)
		if (!is_a($component, "Container"))
			return; // base case
		else {
			$subcomponents =& $component->getComponents();
			foreach (array_keys($subcomponents) as $key)
				$this->_getAllStyles($subcomponents[$key], $result);				
		}
	}
	
	
	/**
	 * Prints the HTML page.
	 * @access public
	 **/
	function printPage() {
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
		echo "<html>\n";
		
		echo "\t<head>";
 		echo "\n\t\t<title>";
		echo $this->_pageTitle;
		echo "</title>\n\n";

		echo "\n\t\t<style type=\"text/css\">\n";
		echo $this->getCSS("\t\t\t");
 		echo "\t\t</style>\n";
 		echo "\t</head>\n";

 		echo "\t<body>\n";
		if (isset($this->_component))
	 		$this->_component->render($this, "\t\t");
 		echo "\t</body>\n";
 		echo "</html>";
	}
	
}

?>