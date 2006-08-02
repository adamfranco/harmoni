<?php

require_once(HARMONI."GUIManager/Theme.interface.php");
require_once(HARMONI."GUIManager/Component.class.php");
require_once(HARMONI."GUIManager/Container.class.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");

/**
 * A generic <code>Theme</code> implementation. It should be sufficient just to
 * extend it to create new fully fledged Themes.
 * <br /><br />
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
 * @version $Id: Theme.class.php,v 1.24 2006/08/02 23:50:27 sporktim Exp $
 */
class Theme extends ThemeInterface {

	/**
	 * @var  $id; the id of the theme 
	 * @access private
	 * @since 5/1/06
	 */
	var $_id;

	/**
	 * The display name of this Theme.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	/**
	 * The description of this Theme.
	 * @var string _description 
	 * @access private
	 */
	var $_description;

	/**
	 * The component of this Theme.
	 * @var object _component 
	 * @access private
	 */
	var $_component;

	/**
	 * The page title.
	 * @var string _pageTitle 
	 * @access private
	 */
	var $_pageTitle;
	
	/**
	 * @var string $_headJavascript The javascript functions to put between &lt;script&gt; tags 
	 * 		in the &lt;head&gt; section.
	 * @access private
	 **/
	var $_headJavascript = "";
	
	/**
	 * An array storing style collections for the different
	 * component types. The first dimension is the component type. The second
	 * dimension is the index. The third dimension is the selector of the style
	 * collection.
	 * @var array _componentStyles 
	 * @access private
	 */
	var $_componentStyles;
	
	/**
	 * An array storing global style collections. It is one-dimensional. The key
	 * is the selector of the style collection. The element is the style collection
	 * itself.
	 * @var array _globalStyles 
	 * @access private
	 */
	var $_globalStyles;
	
	/**
	 * This array combines <code>_componentStyles</code> and <code>_globalStyles</code>
	 * into one. The purpose is to avoid duplication of style collection and to
	 * provide an easy way to implement the <code>getCSS()</code> method.
	 * @var array _styles 
	 * @access private
	 */
	var $_styles;
	
	/**
	 * This array will store the pre-HTML strings for the different component
	 * types. The first dimension is the component type. The second
	 * dimension is the index.
	 * @var array _componentPreHTML 
	 * @access private
	 */
	var $_componentPreHTML;
	
	/**
	 * This array will store the post-HTML strings for the different component
	 * types. The first dimension is the component type. The second
	 * dimension is the index.
	 * @var array _componentPostHTML 
	 * @access private
	 */
	var $_componentPostHTML;
	
	/**
	 * This array stores all registered mutable <code>StyleProperties</code>.
	 * @var array _registeredSPs 
	 * @access private
	 */
	var $_registeredSPs;	
	
	/**
	 * This array stores the names of the methods that will be run after
	 * importing of registered <code>StyleProperties</code>.
	 * @var array _postImportMethods	  
	 * @access private
	 */
	var $_postImportMethods;

	/**
	 * The constructor.
	 * @access public
	 * @param string $displayName
	 * @param string $description
	 **/
	function Theme($displayName, $description) {
		// ** parameter validation
		$rule =& OptionalRule::getRule(StringValidatorRule::getRule());
		ArgumentValidator::validate($displayName, $rule, true);
		ArgumentValidator::validate($description, $rule, true);
		// ** end of parameter validation

		$this->_component = null;
		$this->_pageTitle = "";
		$this->_componentStyles = array();
		$this->_globalStyles = array();
		$this->_styles = array();
		$this->_registeredSPs = array();
		$this->_postImportMethods = array();
		$this->_displayName = $displayName;
		$this->_description = $description;
	}
	
	/**
	 * Sets the id
	 * 
	 * @param string $id
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function setId (& $id) {
// 		$idManager =& Services::getService("Id");
// 		$this->_id =& $idManager->getId($id);
		if (!is_object($id))
			throwError(new Error("GUIMANAGER", "STRING ID PASSED"));
		$this->_id =& $id;
	}
	
	/**
	 * Answers the id
	 * 
	 * @return object HarmoniId
	 * @access public
	 * @since 4/26/06
	 */
	function &getId () {
		if (isset($this->_id)){
			return $this->_id;
		}else{
			$null =  null;
			return $null;
		}
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
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
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
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		// ** end of parameter validation

		$this->_description = $description;
	}

	/**
	 * Sets the template
	 * 
	 * @param string $template
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function setTemplate ($template) {
		$this->_template = $template;
	}
	
	/**
	 * Answers the template
	 * 
	 * @return string
	 * @access public
	 * @since 4/26/06
	 */
	function getTemplate () {
		if (isset($this->_template))
			return $this->_template;
	}

	/**
	 * Sets the level of customization for the theme
	 * 
	 * @param string $custom_lev
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function setCustom ($custom_lev) {
		$this->_custom_lev = $custom_lev;
	}
	
	/**
	 * Answers the customization level for the theme
	 * 
	 * @return string
	 * @access public
	 * @since 4/26/06
	 */
	function getCustom () {
		if (isset($this->_custom_lev))
			return $this->_custom_lev;
	}
	
	/**
	 * Answers the _styles array
	 * 
	 * @return ref array
	 * @access public
	 * @since 4/26/06
	 */
	function &getStyleCollections () {
		return $this->_styles;
	}

	/**
	 * Answers the class for constructing Style Collections for this theme
	 * 
	 * @return string 
	 * @access public
	 * @since 5/30/06
	 */
	function getCollectionClass () {
		reset($this->_styles);
		if (current($this->_styles)) {
			$key = key($this->_styles);
			while (!ereg("^.", $key)) {
				next($this->_styles);
				$key = key($this->_styles);
			}
			return get_class($this->_styles[$key]);
		}
		else return 'stylecollection';
	}

	/**
	 * removes the style collection from the theme, and the DB
	 * 
	 * @param ref object StyleCollection
	 * @return void
	 * @access public
	 * @since 5/16/06
	 */
	function removeStyleCollection (&$style) {
		$guiManager =& Services::getService("GUI");
		$dbHandler =& Services::getService('DB');
		
		$guiManager->deletePropertiesForCollection($style);

		$query =& new DeleteQuery();
		$query->addTable($guiManager->_dbName.".tm_style_collection");
		$query->addWhere("FK_theme_id = $idValue");
		$result =& $dbHandler->query($query, $guiManager->_dbIndex);
		
		unset($this->_styles[$style->getSelector()]);
	}
	
	/**
	 * Attaches to the Theme a style collection that will have a global effect
	 * on the page look and feel. For example, this could be a style collection
	 * affecting the <code>body</code> HTML element.
	 * @access public
	 * @param ref object styleCollection The style collection to attach.
	 **/
	function addGlobalStyle(& $styleCollection) {
		// ** parameter validation
		$rule =& ExtendsValidatorRule::getRule("StyleCollectionInterface");
		ArgumentValidator::validate($styleCollection, $rule, true);
		// ** end of parameter validation
		
		// check that this styleCollection hasn't been added already
		if (!isset($this->_globalStyles[$styleCollection->getSelector()]))
			$this->_globalStyles[$styleCollection->getSelector()] =& $styleCollection;
			
		if (!isset($this->_styles[$styleCollection->getSelector()]))
			$this->_styles[$styleCollection->getSelector()] =& $styleCollection;
	}

	/**
	 * Answers the Style Collection that has global effects.
	 *
	 * @access public
	 * @return ref array global styles array
	 **/
	function &getGlobalStyles() {
		if (isset($this->_globalStyles))
			return $this->_globalStyles;
		$array = array();
		return $array;
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
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which style collections
	 * to return. If the given index is greater than the maximum registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return ref array An array of Style Collections.
	 **/
	function &getStylesForComponentType($type, $index = null) {
		// ** parameter validation
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
//		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation

		// Frst of all, see if there are any registered styles for this
		// component type at all.
		// if there are and no index has been requested then return all of them
		$blank = array();
		if (!isset($this->_componentStyles[$type]))
			return $blank;
		else if (is_null($index))
			return $this->_componentStyles[$type];
			
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
		$array = array();
		return $array;
	}

	/**
	 * Registers the specified style collection with the given component type.
	 * @access public
	 * @param ref object styleCollection The style collection to add.
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index with which to register the style collection.
	 * For a description of the role of indices, see the documentation of
	 * <code>getStylesForComponentType()</code>.
	 **/
	function addStyleForComponentType(& $styleCollection, $type, $index) {
		// ** parameter validation
		$rule =& ExtendsValidatorRule::getRule("StyleCollectionInterface");
		ArgumentValidator::validate($styleCollection, $rule, true);
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
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
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index with which to register the HTML string.
	 * For a description of the role of indices, see the documentation of
	 * <code>getStylesForComponentType()</code>.
	 **/
	function setPreHTMLForComponentType($html, $type, $index) {
		// ** parameter validation
		ArgumentValidator::validate($html, StringValidatorRule::getRule(), true);
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_componentPreHTML[$type][$index] = $html;
	}

	/**
	 * Returns the HTML string that needs to be printed before an attempt is made
	 * to render components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 **/
	function getPreHTMLForComponentType($type, $index) {
		// ** parameter validation
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
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
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index with which to register the HTML string.
	 * For a description of the role of indices, see the documentation of
	 * <code>getStylesForComponentType()</code>.
	 **/
	function setPostHTMLForComponentType($html, $type, $index) {
		// ** parameter validation
		ArgumentValidator::validate($html, StringValidatorRule::getRule(), true);
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_componentPostHTML[$type][$index] = $html;
	}
	
	/**
	 * Returns the HTML string that needs to be printed after successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 **/
	function getPostHTMLForComponentType($type, $index) {
		// ** parameter validation
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
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
	function &getComponent() {
		return $this->_component;
	}
	
	/**
	 * Sets the component of this <code>Theme</code>.
	 * @access public
	 * @param ref object A component.
	 **/
	function setComponent(& $component) {
		// ** parameter validation
		$rule =& ExtendsValidatorRule::getRule("ComponentInterface");
		ArgumentValidator::validate($component, $rule, true);
		// ** end of parameter validation

		$this->_component =& $component;
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
		$css = "";
	
		// Get any style collections explicitly registered with this Theme
		$styleCollections = $this->_styles;

		// If the Theme does has an assigned component then get all the style
		// collection of the component and any subcomponents it might have.
		if (isset($this->_component)) {
			$this->_getAllStyles($this->_component, $styleCollections);
		}
	
		// Now convert the array of style collections to a string with CSS code.
		foreach (array_keys($styleCollections) as $key) {
			if (is_string($styleCollections[$key]))
				$css .= $styleCollections[$key];
			else{//printpre($styleCollections[$key]);
				$css .= $styleCollections[$key]->getCSS($tabs);}
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
			// Get the styles for its layout
			$layout =& $component->getLayout();
			$result[] = $layout->getCSS();
			
			// Get the styles for its children
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
		if (isset($this->_component))
	 		$this->_component->render($this, "\t\t");
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
	 * @param optional string postImportMethod This is the name of the method that will
	 * be called after this SP is imported (an optional argument). This can be useful in case other
	 * properties depend on the content of this property, but the user does not
	 * to export all of them.
	 * @return integer An integer id assigned to the given style property. The id 
	 * only meaningful within the context of this Theme (i.e. this is not a system wide unique id).
	 **/
	function registerSP(& $sp, $postImportMethod=NULL) {
		// ** parameter validation
		$rule =& ExtendsValidatorRule::getRule("StylePropertyInterface");
		ArgumentValidator::validate($sp, $rule, true);
		$rule =& OptionalRule::getRule(StringValidatorRule::getRule());
		ArgumentValidator::validate($postImportMethod, $rule, true);
		// ** end of parameter validation
		
		$this->_registeredSPs[] =& $sp;
		$id = count($this->_registeredSPs) - 1;
		
		if (isset($postImportMethod)){
			$this->_postImportMethods[$id] = $postImportMethod;
		}
		
		return $id;
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
		// ** parameter validation
		$rule =& IntegerRangeValidatorRule::getRule(0, count($this->_registeredSPs) - 1);
		ArgumentValidator::validate($sp, $rule, true);
		// ** end of parameter validation
			
		return $this->_registeredSPs[$id];
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
		// get the StylePorperty
		$sp =& $this->getRegisteredSP($id);
		
		// now get its StyleComponents
		$scs = $sp->getSCs();
		//print "Here it comes!!!!!!";
		//print_r($scs);
		
		// this is the export data - simply an array storing the values
		// of each style component
		$exportData = array();
		foreach (array_keys($scs) as $i => $key)
			$exportData[$key] = $scs[$key]->getValue();
			
		return $exportData;
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
		// the export data array
		$exportData = array();
		
		// export each registered style property and put in the array
		foreach (array_keys($this->_registeredSPs) as $i => $key)
			$exportData[$key] = $this->exportRegisteredSP($key);
			
		return $exportData;
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
		// ** parameter validation
		$rule =& ArrayValidatorRule::getRule();
		ArgumentValidator::validate($importData, $rule, true);
		// ** end of parameter validation
		
		// first, get the style property and its style components
		$sp =& $this->getRegisteredSP($id);
		$scs =& $sp->getSCs();
		
		// if the number of style components is different from the number
		// of elements in the importData array, then it's no good!
		if (count($importData) != count($scs)) {
		    $err = "Invalid import data or invalid style property id!";
			throwError(new Error($err, "GUIManager", true));
			return;
		}
		
		
		// now set the value of each style component
		foreach (array_keys($importData) as $i => $key)
			$scs[$key]->setValue($importData[$key]);
			
		// now see if there is a post import method set for this style property
		// if yes, run it
		if (isset($this->_postImportMethods[$id]))
			$this->{$this->_postImportMethods[$id]}();
			
		return $sp;	
	}
	
	
	/**
	 * Returns all registered mutable style properties in an array whose indexes are the
	 * ids of the style properties (as returned by <code>registerSP()</code>).
	 * @access public
	 * @return ref array An array containing all registered mutable 
	 * <code>StyleProperty</code> objects.
	 **/
	function &getAllRegisteredSPs() {
		return $this->_registeredSPs;
	}
	
}
?>