<?php

require_once(HARMONI."GUIManager/Component.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.interface.php");

/**
 * This is a generic implementation of the Component interface that allows the user
 * to output an arbitrary string (content).
 * <br><br>
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 * @version $Id: Component.class.php,v 1.8 2004/10/26 21:05:49 adamfranco Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class Component extends ComponentInterface {

	/**
	 * The content of this component.
	 * @attribute private string _content
	 */
	var $_content;
	
	/**
	 * This is an array of the style collections that have been applied to this
	 * component.
	 * @attribute private array _styleCollections
	 */
	var $_styleCollections;
	
	/**
	 * The type of this <code>Component</code>.
	 * @attribute private integer _type
	 */
	var $_type;
	
	/**
	 * The index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and 
	 * <code>addStyleForComponentType()</code> methods.
	 * @attribute private integer _index
	 */
	var $_index;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string content This is an arbitrary string that will be printed,
	 * whenever the user calls the <code>render()</code> method. If <code>null</code>,
	 * then the component will have no content.
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
	function Component($content, $type, $index) {
		// ** parameter validation
		$rule =& new OptionalRule(new StringValidatorRule($content));
		ArgumentValidator::validate($content, $rule, true);
		$rule =& new ChoiceValidatorRule(BLANK, HEADING, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, new IntegerValidatorRule(), true);
		// ** end of parameter validation	

		$this->_content = $content;
		$this->_styleCollections = array();
		$this->_type = $type;
		$this->_index = $index;

		// if there are style collections to add
		if (func_num_args() > 3)
			for ($i = 3; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}
	
	/**
	 * Adds a new <code>StyleCollection</code> to this component. The component
	 * can have 0 or more style collections attached; each of the latter will
	 * affect the appearance of the component. The uniqueness of the collections
	 * is enforce by their selector  (i.e., you can't have two collections
	 * with the same selector). If a style collection has been registered with
	 * the Theme for this Component's type and level, then the new style collection
	 * will take precedence.
	 * @access public
	 * @param ref object styleCollection The <code>StyleCollection</code> to add
	 * to this component. 
	 * @return ref object The style collection that was just added.
	 **/
	function &addStyle(& $styleCollection) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("StyleCollectionInterface");
		ArgumentValidator::validate($styleCollection, $rule, true);
		// ** end of parameter validation

		// make sure we can apply it
		if (!$styleCollection->canBeApplied()) {
			$err = "This style collection cannot be applied to components.";
			throwError(new Error($err, "GUIManager", false));
			return;
		}
		
		if (isset($this->_styleCollections[$styleCollection->getSelector()])) {
			$err = "Cannot add two StyleCollections with the same selector!";
			throwError(new Error($err, "GUIManager", true));
		}
		
	 	$this->_styleCollections[$styleCollection->getSelector()] =& $styleCollection;
		
		return $styleCollection;
	}
	
	/**
	 * Returns the style collection with the specified selector.
	 * @access public
	 * @param string selector The selector.
	 * @return ref object The style collection.
	 **/
	function &getStyle($selector) {
		if (isset($this->_styleCollections[$selector]))
			return $this->_styleCollections[$selector];
		else
			return null;
	}
	
	/**
	 * Remove the given StyleCollection from this Component.
	 * @access public
	 * @param string selector The selector of the style collection to remove.
	 * @return ref object The style collection that was removed. <code>NULL</code>
	 * if it could not be found.
	 **/
	function &removeStyle($selector) {
	 	$result =& $this->_styleCollections[$selector];
		unset($this->_styleCollections[$selector]);
		
		return $result;
	}

	/**
	 * Returns all style collections for this component.
	 * @access public
	 * @return array An array of style collections; the key corresponds to the
	 * selector of each collection.
	 **/
	function &getStyles() {
		return $this->_styleCollections;
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
		return $this->_index;
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
		// print any HTML code for this component type that is part of the given theme
		$html = $theme->getPreHTMLForComponentType($this->_type, $this->_index);
		echo $html;
		
		$styleCollections = array_merge($this->_styleCollections, 
										$theme->getStylesForComponentType($this->_type, $this->_index));
	
		if (count($styleCollections) == 0)
			return "";
		else {
			// get the class selectors of all style collections
			$classSelectors = "";
			foreach (array_keys($styleCollections) as $key)
				$classSelectors .= $styleCollections[$key]->getClassSelector()." ";

			return $tabs."<div class=\"$classSelectors\">\n";
		}
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
		$styleCollections = array_merge($this->_styleCollections, 
										$theme->getStylesForComponentType($this->_type, $this->_index));

		if (count($styleCollections) == 0)
			return "";
		else
			return $tabs."</div>\n";
			
		// print any HTML code for this component type that is part of the given theme
		$html = $theme->getPostHTMLForComponentType($this->_type, $this->_index);
		echo $html;
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
		if (isset($this->_content))
			echo $tabs.$this->_content;
		echo $this->getPostHTML($theme, $tabs);
	}
	
	
	/**
	 * Returns the type of this component.
	 * @access public
	 * @return integer The type of this component.
	 **/
	function getType() {
		return $this->_type;
	}

}

?>