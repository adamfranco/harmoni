<?php
require_once(HARMONI."themeHandler/NamedTheme.interface.php");

/**
 * The NamedTheme is an abstract class that assigns default functionality
 * to a lot of the methods for a NamedTheme, implementing both the {@link ThemeInterface} and
 * {@link NamedThemeInterface}.
 *
 * @package harmoni.themes
 * @version $Id: NamedTheme.abstract.php,v 1.2 2003/07/18 20:26:24 gabeschine Exp $
 * @copyright 2003 
 **/

class NamedTheme extends NamedThemeInterface {
	/**
	 * @access private
	 * @var string $_name Theme theme's name.
	 **/
	var $_name;
	
	/**
	 * @access private
	 * @var string $_description The theme's description.
	 **/
	var $_description;
	
	/**
	 * @access private
	 * @var string $_settings A serialized string of this theme's settings, if applicable.
	 **/
	var $_settings;
	
	/**
	 * @access private
	 * @var string $_pageTitle The title put on the output page. (in the <b>title</b> html tag)
	 **/
	var $_pageTitle;
	
	/**
	 * @access private
	 * @var string $_extraHeadContent Extra HTML to put in the <b>head</b> tag of the page.
	 **/
	var $_extraHeadContent;
	
	/**
	 * @access private
	 * @var boolean $_hasSettings Specifies if this theme can set settings or not.
	 **/
	var $_hasSettings;
	
	/**
	 * @access private
	 * @var object $_baseColor This theme's base color. Used for theme color conformity.
	 **/
	var $_baseColor;
	
	/**
	 * Returns this theme's name.
	 * @access public
	 * @return string The name.
	 **/
	function getName() {
		return $this->_name;
	}
	
	/**
	 * Returns this theme's description.
	 * @access public
	 * @return string The description.
	 **/
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * Returns an array containing the type & data of a preview image.
	 * @access public
	 * @return array|null A two-element array. [0]=mime-type of the image, [1]=the actual
	 * image data. If there is no preview image, returns NULL.
	 **/
	function getPreviewImage() {
		return null;
	}
	
	/**
	 * Sets the page title to $title.
	 * @param string $title The page title.
	 * @access public
	 * @return void
	 **/
	function setPageTitle($title) {
		$this->_pageTitle = $title;
	}
	
	/**
	 * Adds $content to the <pre><head>...</head></pre> (head) section of the page.
	 * @param string $content The content to add to the head section.
	 * @access public
	 * @return void
	 **/
	function addHeadContent($content) {
		$this->_extraHeadContent = $content;
	}
	
	/**
	 * Sets this theme's settings to $serializedSettings.
	 * @param string $serializedSettings A serialized string representing the optional
	 * settings for this theme. Most of the time, this string will have come from {@link ThemeInterface::getSettings getSettings()},
	 * stored in a database and then retrieved.
	 * @access public
	 * @see {@link ThemeInterface::getSettings}
	 * @return void
	 **/
	function setSettings($serializedSettings) {
		$this->_settings = $serializedSettings;
	}
	
	/**
	 * Returns a serialized string of this theme's settings.
	 * @access public
	 * @see {@link ThemeInterface::setSettings}
	 * @return string A serialized string representing the settings.
	 **/
	function getSettings() {
		return $this->_settings;
	}
		
	/**
	 * Returns if this theme supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this theme supports settings, FALSE otherwise.
	 **/
	function hasSettings() {
		return $this->_hasSettings;
	}
	
	/**
	 * Returns this Theme's base color. This is usually used for color conformance
	 * of certain elements in the output to a color scheme, like alternating table-row
	 * background colors, etc. 
	 * @access public
	 * @return object An {@link HTMLColor} object.
	 **/
	function getBaseColor() {
		return $this->_baseColor;
	}
	
	/**
	 * Prints a {@link Menu}, with specified orientation.
	 * @param object $menuObj The {@link Menu} object to print.
	 * @param integer $level The current level within a {@link Layout} we are.
	 * @param integer $otientation The orientation. Either HORIZONTAL or VERTICAL.
	 * @access public
	 * @return void
	 **/
	function printMenu($menuObj, $level, $orientation) {
		print "<br/>Printing Menu with level=$level and orientation=";
		print ($orientation==HORIZONTAL)?"HORIZONTAL":"VERTICAL";
		print "<br/><br/>";
		
		for($i = 0; $i < $menuObj->getCount(); $i++) {
			$item =& $menuObj->getItem($i);
			print $item->getFormattedText();
			print ($orientation == VERTICAL)?"<br />":" ";
		} // for
	}
	
	/**
	 * Prints a {@link Content} object out using the theme. $level can be used to specify
	 * changing look the deeper into a layout you go.
	 * @param object $contentObj The {@link Content} object to use.
	 * @param integer $level The current level within a {@link Layout} we are.
	 * @access public
	 * @return void
	 **/
	function printContent($contentObj, $level) {
		print "<br/>Printing Content with level=$level.<br/><br/>";
		print $contentObj->getContent();
	}
	
	/**
	 * Prints a {@link Layout} object.
	 * @param object $layoutObj The Layout object.
	 * @param integer $level The current depth in the layout.
	 * @access public
	 * @return void
	 **/
	function printLayout($layoutObj, $level) {
		$layoutObj->outputLayout($this,$level);
	}
}

?>