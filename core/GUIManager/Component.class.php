<?php

require_once(HARMONI."GUIManager/Component.interface.php");

/**
 * This is a generic implementation of the Component interface that allows the user
 * to output an arbitrary string (content).
 * <br><br>
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 * @version $Id: Component.class.php,v 1.1 2004/07/19 23:59:50 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class Component extends ComponentInterface {

	/**
	 * A StyleProperty for the width of this component.
	 * @attribute private object _widthSP
	 */
	var $_widthSP;
	
	/**
	 * A StyleProperty for the height of this component.
	 * @attribute private object _heightSP
	 */
	var $_heightSP;
	
	/**
	 * The horizontal alignment.
	 * @attribute private integer _alignmentX
	 */
	var $_alignmentX;
	
	/**
	 * The vertical alignment.
	 * @attribute private integer _alignmentY
	 */
	var $_alignmentY;
	
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
	 * The constructor.
	 * @access public
	 * @param string content This is an arbitrary string that will be printed,
	 * whenever the user calls the <code>render()</code> method. If <code>null</code>,
	 * then the component will have no content.
	 **/
	function Component($content) {
		// ** parameter validation
		$rule =& new OptionalRule(new StringValidatorRule($content));
		ArgumentValidator::validate($content, $rule, true);
		// ** end of parameter validation	

		if (isset($width))
			$this->_widthSP =& new WidthSP($width);
		else
			$this->_widthSP = null;

		if (isset($height))
			$this->_heightSP =& new HeightSP($height);
		else
			$this->_heightSP = null;
			
		$this->_content = $content;
		$this->_styleCollections = array();
	}
	
	/**
	 * Adds a new <code>StyleCollection</code> to this component. The component
	 * can have 0 or more style collections attached; each of the latter will
	 * affect the appearance of the component.
	 * @access public
	 * @param ref object styleCollection The <code>StyleCollection</code> to add
	 * to this component. 
	 **/
	function addStyle($styleCollection) {
		// ** parameter validation
		$rule =& new ExtendsValidatorRule("StyleCollectionInterface");
		ArgumentValidator::validate($styleCollection, $rule, true);
		// ** end of parameter validation

		if (!$styleCollection->canBeApplied()) {
			$err = "This style collection cannot be applied to components.";
			throwError(new Error($err, "GUIManager", false));
			return; // this style collection cannot be applied to components
		}
			
	 	$this->_styleCollections[] =& $styleCollection;
	}
	
	/**
	 * Returns any HTML code that needs to be printed before the render() method
	 * is called.
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The HTML string.
	 **/
	function getPreHTML($tabs = "") {
		// get the class selectors of all style collections that have been applied
		$classAtribute = "";

		if (count($this->_styleCollections) > 0) {
			$classSelectors = array();
			foreach (array_keys($this->_styleCollections) as $key)
				$classSelectors[] =& $this->_styleCollections[$key]->getClassSelector();

			$classAtribute = "class=\"".implode(" ", $classSelectors)."\"";
		}
		
		return $tabs."<div $classAtribute>\n";
	}
	
	/**
	 * Returns any HTML code that needs to be printed after the render() method
	 * has been called.
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The HTML string.
	 **/
	function getPostHTML($tabs = "") {
		return $tabs."</div>\n";
	}

	/**
	 * Renders the component on the screen.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @access public
	 **/
	function render($tabs = "") {
		echo $this->getPreHTML($tabs);
		echo $tabs.$this->_content;
		echo $this->getPostHTML($tabs);
	}
	
}

?>