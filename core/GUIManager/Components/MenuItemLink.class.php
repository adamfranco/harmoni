<?php

require_once(HARMONI."GUIManager/Components/MenuItem.interface.php");

/**
 * The <code>MenuItemLink</code> class is an extension of the <code>MenuItem</code>
 * interface adding support for attaching extra data like URL, target window, an 
 * access key (shortcut), a toolTip, etc.
 * <br /><br />
 * <code>MenuItem</code> is an extension of <code>Component</code>; <code>MenuItems</code>
 * have display names and the ability to be added to <code>Menu</code> objects.
 *
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuItemLink.class.php,v 1.6 2005/02/07 21:38:14 adamfranco Exp $
 */
class MenuItemLink extends Component /* implements MenuItemInterface */ {

	/**
	 * The url of this menu item.
	 * @var string _url 
	 * @access private
	 */
	var $_url;
	
	/**
	 * The display name of this menu item.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	/**
	 * The selected state of this menu item.
	 * @var boolean _selected 
	 * @access private
	 */
	var $_selected;
	
	/**
	 * The target window of this menu item.
	 * @var string _target 
	 * @access private
	 */
	var $_target;
	
	/**
	 * The access key (shortcut) for this menut item.
	 * @var string _accessKey 
	 * @access private
	 */
	var $_accessKey;
	
	/**
	 * The toolTip for this menu item.
	 * @var string _toolTip 
	 * @access private
	 */
	var $_toolTip;
	
	/**
	 * An associative array of additional HTML attributes to be included with
	 * the <code>a href</code> tag. The key is the attribute, and the element
	 * is the value.
	 * @var array _attributes 
	 * @access private
	 */
	var $_attributes;
	
	/**
	 * The constructor.
	 * @param integer index The index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and 
	 * <code>addStyleForComponentType()</code> methods.
	 * @param string displayName The display name of this menu item.
	 * @param string url The url of this menu item.
	 * @param boolean selected The selected state of this menu item.
	 * @param string target The target window of this menu item.
	 * @param string accessKey The access key (shortcut) of this menu item.
	 * @param string toolTip The toolTip of this menu item.
	 * @access public
	 **/
	function MenuItemLink($displayName, $url, $selected, $index, $target = null, $accessKey = null, $toolTip = null) {
		// ** parameter validation
		$rule =& new StringValidatorRule();
		$optionalRule =& new OptionalRule($rule);
		ArgumentValidator::validate($displayName, $rule, true);
		ArgumentValidator::validate($url, $rule, true);
		ArgumentValidator::validate($selected, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($target, $optionalRule, true);
		ArgumentValidator::validate($accessKey, $optionalRule, true);
		ArgumentValidator::validate($toolTip, $optionalRule, true);
		// ** end of parameter validation	
		
		$this->_displayName = $displayName;
		$this->_url = $url;
		$this->_selected = $selected;
		$this->_target = $target;
		$this->_accessKey = $accessKey;
		$this->_toolTip = $toolTip;
		$this->_attributes = array();
		
		$type = ($selected) ? MENU_ITEM_LINK_SELECTED : MENU_ITEM_LINK_UNSELECTED;

		$this->Component(null, $type, $index);
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
		// pre-html
		echo $this->getPreHTML($theme, $tabs);
		// the url
		echo $tabs."<a href=\"$this->_url\"";
		// the target window
		if (isset($this->_target))
			echo " target=\"$this->_target\"";
		// the access key (shortcut)
		if (isset($this->_accessKey))
			echo " accesskey=\"$this->_accessKey\"";
		// the tooltip
		if (isset($this->_toolTip))
			echo " title=\"$this->_toolTip\"";
		// any additional attributes
		foreach ($this->_attributes as $attribute => $value)
			echo " $attribute=\"$value\"";
		echo ">";
		// the display name
		echo $this->_displayName;
		echo "</a>\n";
		// psot-html
		echo $this->getPostHTML($theme, $tabs);
	}

	/**
	 * Returns the URL of this menu item.
	 * @access public
	 * @return string url The URL of this menu item.
	 **/
	function getURL() {
		return $this->_url;
	}
	
	/**
	 * Sets the URL of this menu item.
	 * @access public
	 * @param string The URL to set.
	 **/
	function setURL($url) {
		// ** parameter validation
		ArgumentValidator::validate($url, new StringValidatorRule(), true);
		// ** end of parameter validation	

		$this->_url = $url;
	}
	
	/**
	 * Returns the display name of this menu item.
	 * @access public
	 * @return string The display name of this menu item.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Sets the display name of this menu item.
	 * @access public
	 * @param string displayName The new display name.
	 **/
	function setDisplayName($displayName) {
		// ** parameter validation
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		// ** end of parameter validation	

		$this->_displayName = $displayName;
	}
	
	/**
	 * Returns whether the menu item is currently selected.
	 * @access public
	 * @return boolean <code>TRUE</code> if the menu item is selected; <code>FALSE</code>
	 * otherwise.
	 **/
	function isSelected() {
		return $this->_selected;
	}
	
	/**
	 * Sets the selected state of this menu item.
	 * @access public
	 * @param boolean selected <code>TRUE</code> means selected; <code>FALSE</code>
	 * is unselected.
	 **/
	function setSelected($selected) {
		// ** parameter validation
		ArgumentValidator::validate($selected, new BooleanValidatorRule(), true);
		// ** end of parameter validation	

		$this->_selected = $selected;

		$type = ($selected) ? MENU_ITEM_LINK_SELECTED : MENU_ITEM_LINK_UNSELECTED;
		$this->_type = $type;
	}
	
	/**
	 * Returns the target window for this menu item.
	 * @access public
	 * @return string The target window.
	 **/
	function getTarget() {
		return $this->_target;
	}
	
	/**
	 * Sets the target window for this menu item.
	 * @access public
	 * @param string target The target window.
	 **/
	function setTarget($target) {
		// ** parameter validation
		ArgumentValidator::validate($target, new StringValidatorRule(), true);
		// ** end of parameter validation	

		$this->_target = $target;
	}

	/**
	 * Returns the access key character (shortcut) for this menu item.
	 * @access public
	 * @return string The access key character (shortcut) for this menu item. 
	 **/
	function getAccessKey() {
		return $this->_accessKey;
	}
	
	/**
	 * Sets the access key character (shortcut) for this menu item.
	 * @access public
	 * @param string accessKey The new access key character (shortcut) for this menu item. 
	 **/
	function setAccessKey($accessKey) {
		// ** parameter validation
		ArgumentValidator::validate($accessKey, new StringValidatorRule(), true);
		// ** end of parameter validation	

		$this->_accessKey = $accessKey;
	}
	
	/**
	 * Returns the toolTip text for this menu item.
	 * @access public
	 * @return string The toolTip.
	 **/
	function getToolTip() {
		return $this->_toolTip;
	}
	
	/**
	 * Sets the toolTip text for this menu item.
	 * @access public
	 * @param string tooltip The new toolTip.
	 **/
	function setToolTip($toolTip) {
		// ** parameter validation
		ArgumentValidator::validate($toolTip, new StringValidatorRule(), true);
		// ** end of parameter validation	

		$this->_toolTip = $toolTip;
	}
	
	/**
	 * Add an additional attribute to the <code>a href</code> HTML tag. For example,
	 * this could be a javascript event or simply any additional functionality
	 * not available through the standard get/set methods. Repeated attributes are
	 * not permitted.
	 * @access public
	 * @param string attribute The name of the attribute, for example: "tabindex".
	 * @param string value The value of the attribute, for example: "3".
	 **/
	function addAttribute($attribute, $value) {
		// ** parameter validation
		$rule =& new StringValidatorRule();
		ArgumentValidator::validate($attribute, $rule, true);
		ArgumentValidator::validate($value, $rule, true);
		// ** end of parameter validation
		
		if (!isset($this->_attributes[$attribute]))
			$this->_attributes[$attribute] = $value;
	}
	

}

?>