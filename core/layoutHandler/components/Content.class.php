<?php
require_once(HARMONI."layoutHandler/components/Content.interface.php");

/**
 * The Content interface defines what methods are required by any Content {@link VisualComponent}.
 *
 * @package harmoni.layout.components
 * @version $Id: Content.class.php,v 1.2 2004/03/05 21:40:05 adamfranco Exp $
 * @copyright 2003 
 **/
class Content extends ContentInterface {
	/**
	 * @access private
	 * @var integer $_level 
	 */ 
	var $_level;

	/**
	 * @access private
	 * @var string $_content The content.
	 **/
	var $_content;
	
	/**
	 * The constructor.
	 * @param optional string $content The content to put in this object.
	 * @access public
	 * @return void
	 **/
	function Content( $content="" ) {
		$this->_content = $content;
		$this->_themeWidgetType = BLANK_WIDGET;
		$this->_themeWidgetIndex = 1;
	}
	
	
	/**
	 * Sets the content to $contentString.
	 * @param string $contentString The content.
	 * @access public
	 * @return void
	 **/
	function setContent($contentString) {
		$this->_content = $contentString;
	}
	
	/**
	 * Returns this component's content.
	 * @access public
	 * @return string The content.
	 **/
	function getContent() {
		return $this->_content;
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @return void
	 **/
	function output(&$themeWidget, $orientation=HORIZONTAL) {
		print "\n\t\t".$this->getContent();
		//$themeWidget->output($this);
	}
	
	/**
	 * Returns this component's level in the visual hierarchy.
	 * @access public
	 * @return integer The level.
	 **/
	function getLevel() {
		return $this->_level;
	}
	
	/**
	 * Sets this component's level in the visual hierarchy. Spiders down to children (if it has any) and sets their level
	 * to $level+1 if $spiderDown is TRUE.
	 * @param integer $level The level.
	 * @param optional boolean $spiderDown Specifies if the function should spider down to children.
	 * @access public
	 * @return void 
	 **/
	function setLevel($level, $spiderDown=true) {
		$this->_level = $level;
	}
	
	/**
	 * Gets the ThemeWidget type for this element.
	 * return string The type of the theme widget.
	 */
	function getThemeWidgetType() {
		return $this->_themeWidgetType;
	}
	
	/**
	 * Sets the ThemeWidget type for this element.
	 * @param string $type The type of the theme widget.
	 * @return void
	 */
	function setThemeWidgetType( $type ) {
		ArgumentValidator::validate($type, new StringValidatorRule);
		
		$this->_themeWidgetType = $type;
	}
	
	/**
	 * Gets the ThemeWidget index for this element.
	 * return integer The index of the theme widget.
	 */
	function getThemeWidgetIndex() {
		return $this->_themeWidgetIndex;
	}
	
	/**
	 * Sets the ThemeWidget index for this element.
	 * @param string $index The index of the theme widget.
	 * @return void
	 */
	function setThemeWidgetIndex( $index ) {
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		$this->_themeWidgetIndex = $index;
	}
	
	/**
	 * gets the Vertical Alignment for this element in its parent.
	 * @return string The alignment of the element; TOP, CENTER, BOTTOM.
	 */
	function getVerticalAlignment () {
		return $this->_verticalAlignment;
	}
	
	/**
	 * Sets the Vertical Alignment for this element in its parent.
	 * @param string $valign The alignment of the element; TOP, CENTER, BOTTOM.
	 * @return void
	 */
	function setVerticalAlignment ( $valign ) {
		ArgumentValidator::validate($valign, new StringValidatorRule);
		if ($valign != TOP && $valign != CENTER && $valign != BOTTOM)
 			throwError(new Error("Could not set vertical alignment, parameter out of range.","Layout",true));
 		
		$this->_verticalAlignment = $valign;
	}
	
	/**
	 * Gets the Horizontal Alignment for this element in its parent.
	 * @return string The alignment of the element; LEFT, CENTER, RIGHT.
	 */
	function getHorizontalAlignment () {
		return $this->_horizontalAlignment;
	}
	
	/**
	 * Sets the Horizontal Alignment for this element in its parent.
	 * @param string $hvalign The alignment of the element; LEFT, CENTER, RIGHT.
	 * @return void
	 */
	function setHorizontalAlignment ( $halign ) {
		ArgumentValidator::validate($halign, new StringValidatorRule);
		if ($halign != LEFT && $halign != CENTER && $halign != RIGHT)
 			throwError(new Error("Could not set horizontal alignment, parameter out of range.","Layout",true));
		
		$this->_horizontalAlignment = $halign;
	}
}

?>