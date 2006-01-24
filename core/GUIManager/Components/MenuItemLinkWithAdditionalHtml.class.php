<?php

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
 * @version $Id: MenuItemLinkWithAdditionalHtml.class.php,v 1.1 2006/01/24 18:37:12 adamfranco Exp $
 */
class MenuItemLinkWithAdditionalHtml 
	extends MenuItemLink 
	/* implements MenuItemInterface */ 
{
	
	/**
	 * @var string $_additionalHtml; <##> 
	 * @access private
	 * @since 1/24/06
	 */
	var $_additionalHtml;
	
	/**
	 * The constructor.
	 * @param string displayName The display name of this menu item.
	 * @param string url The url of this menu item.
	 * @param boolean selected The selected state of this menu item.
	 * @param integer index The index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and 
	 * <code>addStyleForComponentType()</code> methods.
	 * @param string target The target window of this menu item.
	 * @param string accessKey The access key (shortcut) of this menu item.
	 * @param string toolTip The toolTip of this menu item.
	 * @access public
	 **/
	function MenuItemLinkWithAdditionalHtml($displayName, $url, $selected, 
		$index, $target = null, $accessKey = null, $toolTip = null, 
		$additionalHtml = '') 
	{
		ArgumentValidator::validate($additionalHtml, StringValidatorRule::getRule());
		// ** end of parameter validation	
		
		$this->_additionalHtml = $additionalHtml;
		$this->MenuItemLink($displayName, $url, $selected, $index, $target,
							$accessKey, $toolTip);
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
		echo $tabs."<table width='100%'><tr><td valign='top'>\n";
		
		
		// pre-html
		echo $this->getPreHTML($theme, $tabs);
		
		// the url
		echo $tabs."\t<a href=\"$this->_url\"";
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
		
		// post-html
		echo $this->getPostHTML($theme, $tabs);
		
		
		echo $tabs."</td><td valign='top'>\n";
		echo $tabs."\t".$this->_additionalHtml."\n";
		echo $tabs."</td></tr></table>\n";
	}
}

?>