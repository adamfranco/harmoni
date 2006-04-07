<?php

require_once(HARMONI."GUIManager/Component.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.interface.php");

/**
 * This is a generic implementation of the Component interface that allows the user
 * to output an arbitrary string (content).
 * <br /><br />
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Component.class.php,v 1.19 2006/04/07 15:09:14 adamfranco Exp $
 */
class Component extends ComponentInterface {

	/**
	 * The content of this component.
	 * @var string _content 
	 * @access private
	 */
	var $_content;
	
	/**
	 * This is an array of the style collections that have been applied to this
	 * component.
	 * @var array _styleCollections 
	 * @access private
	 */
	var $_styleCollections;
	
	/**
	 * The type of this <code>Component</code>.
	 * @var integer _type 
	 * @access private
	 */
	var $_type;
	
	/**
	 * The index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and 
	 * <code>addStyleForComponentType()</code> methods.
	 * @var integer _index 
	 * @access private
	 */
	var $_index;
	
	/**
	 * @var string $_preHTML; HTML text to surround the component. Useful for
	 *			properly nexting form tags.
	 * @access private
	 * @since 7/15/05
	 */
	var $_preHTML;
	
	/**
	 * @var string $_postHTML; HTML text to surround the component. Useful for
	 *			properly nexting form tags.
	 * @access private
	 * @since 7/15/05
	 */
	var $_postHTML;
	
	/**
	 * @var string $_id; The id of this component. (Optional 
	 * @access private
	 * @since 1/30/06
	 */
	var $_id = null;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string content This is an arbitrary string that will be printed,
	 * whenever the user calls the <code>render()</code> method. If <code>null</code>,
	 * then the component will have no content.
	 * @param integer type The type of this component. One of BLANK, HEADING, HEADER, FOOTER,
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
		$rule =& OptionalRule::getRule(StringValidatorRule::getRule());
		ArgumentValidator::validate($content, $rule, true);
		$rule =& ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										 MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, 
										 MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
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
		$rule =& ExtendsValidatorRule::getRule("StyleCollectionInterface");
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
		// Sometimes we need to incrementally build our form pre-html, so
		// provide access to it without the theme.
		if ($theme === null) {
			return $this->_preHTML;
		}
		
		ob_start();
		
		// print any surrounding form-tags, etc.
		print $tabs.$this->_preHTML."\n";
		
		// print any HTML code for this component type that is part of the given theme
		print $theme->getPreHTMLForComponentType($this->_type, $this->_index);
		
		$styleCollections = array_merge($this->_styleCollections, 
										$theme->getStylesForComponentType($this->_type, $this->_index));
	
		if (count($styleCollections) != 0) {
			// get the class selectors of all style collections
			$classSelectors = "";
			$styleCollectionPreHTML = "";
			foreach (array_keys($styleCollections) as $key) {
				$classSelectors .= $styleCollections[$key]->getClassSelector()." ";
				$styleCollectionPreHTML = 
					$styleCollectionPreHTML
					.$styleCollections[$key]->getPreHTML($tabs."\t");
			}

			print  $tabs."<div class=\"$classSelectors\"";
			if ($this->getId())
				print " id=\"".$this->getId()."\"";
			print ">\n";
			print $styleCollectionPreHTML;
		} else if ($this->getId()) {
			print  $tabs."<div id=\"".$this->getId()."\">\n";
		}
		
		$preHTML = ob_get_contents();
		ob_end_clean();
		return $preHTML;
	}
	
	/**
	 * Set pre HTML code that needs to surround this compontent. This is used to
	 * properly nest form-tags around tables/divs to generate valid XHTML.
	 * 
	 * @param string $html
	 * @return void
	 * @access public
	 * @since 7/15/05
	 */
	function setPreHTML ( $html ) {
		$this->_preHTML = $html;
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
		// Sometimes we need to incrementally build our form pre-html, so
		// provide access to it without the theme.
		if ($theme === null) {
			return $this->_postHTML;
		}
		
		ob_start();
		
		$styleCollections = array_merge($this->_styleCollections, 
										$theme->getStylesForComponentType($this->_type, $this->_index));

		if (count($styleCollections) != 0) {
			$styleCollectionPostHTML = "";
			foreach (array_keys($styleCollections) as $key) {
				$styleCollectionPostHTML = 
					$styleCollections[$key]->getPostHTML($tabs."\t")
					.$styleCollectionPostHTML;
			}

			print $styleCollectionPostHTML;
			
			print $tabs."</div>\n";
		} else if ($this->getId()) {
			print $tabs."</div>\n";
		}
			
		// print any HTML code for this component type that is part of the given theme
		print $theme->getPostHTMLForComponentType($this->_type, $this->_index);
		
		// print any surrounding form-tags, etc.
		print $tabs.$this->_postHTML;
		
		$postHTML = ob_get_contents();
		ob_end_clean();
		return $postHTML;
	}
	
	/**
	 * Set post HTML code that needs to surround this compontent. This is used to
	 * properly nest form-tags around tables/divs to generate valid XHTML.
	 * 
	 * @param string $html
	 * @return void
	 * @access public
	 * @since 7/15/05
	 */
	function setPostHTML ( $html ) {
		$this->_postHTML = $html;
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
	
	/**
	 * Set the (HTML) id of this component
	 * 
	 * @param string $id
	 * @return void
	 * @access public
	 * @since 1/30/06
	 */
	function setId ($id) {
		$this->_id = $id;
	}
	
	/**
	 * Answer the Id of this component
	 * 
	 * @return string or null if not set
	 * @access public
	 * @since 1/30/06
	 */
	function getId () {
		return $this->_id;
	}

}

?>