<?php
require_once(HARMONI."layoutHandler/components/MenuItem.interface.php");

/**
 * @const integer MENUITEM_UNKNOWN Defines a {@link MenuItem} as being of unknown type. 
 * @package harmoni.layout.components
 **/
define("MENUITEM_UNKNOWN",-1);

/**
 * The MenuItem lays out groundwork for sub-classes. It should not be instantiated as it has no
 * type.
 *
 * @package harmoni.layout.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuItem.abstract.php,v 1.4 2005/01/19 21:10:01 adamfranco Exp $
 * @abstract
 **/
class MenuItem extends MenuItemInterface {
	/**
	 * @access private
	 * @var mixed $_type This MenuItem's type.
	 **/
	var $_type = MENUITEM_UNKNOWN;

	/**
	 * @access private
	 * @var string $_label The MenuItem's label.
	 **/
	var $_label;
	
	/**
	 * @access private
	 * @var string $_extra The extra text to be displayed along with the label.
	 **/
	var $_extra;
	
	/**
	 * Returns the type of this menu item. (eg, header, spacer, link, ...)
	 * @access public
	 * @return mixed The MenuItem type.
	 **/
	function getType() {
		return $this->_type;
	}
	
	/**
	 * Returns the label associated with this menu item.
	 * @access public
	 * @return string The label.
	 **/
	function getLabel() {
		return $this->_label;
	}
	
	/**
	 * Sets the label for this menu item to $label.
	 * @param string $label The label. 
	 * @access public
	 * @return void
	 **/
	function setLabel($label) {
		$this->_label = $label;
	}
	
	/**
	 * Sets this menu item's "extra text" to $text. Extra text is useful for displaying
	 * administrative links for this menu item or other useful extra information. 
	 * @param string $text The text.
	 * @access public
	 * @return void
	 **/
	function setExtraText($text) {
		$this->_extra = $text;
	}

	/**
	 * Returns the "extra text".
	 * @see {@link MenuItem::setExtraText setExtraText()}
	 * @access public
	 * @return string The text.
	 **/
	function getExtraText() {
		return $this->_extra;
	}
	
	/**
	 * Returns the "formatted" menu item text. What is returned really depends
	 * on the menu item type.
	 * @access public
	 * @return string The formatted text.
	 **/
	function getFormattedText() {
		return $this->getLabel();
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
		if ($valign != TOP && $valign != MIDDLE && $valign != BOTTOM)
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