<?php

require_once(HARMONI."GUIManager/Theme.interface.php");
require_once(HARMONI."GUIManager/StyleComponent.interface.php");
require_once(HARMONI."GUIManager/StyleProperty.interface.php");
require_once(HARMONI."GUIManager/Component.interface.php");
require_once(HARMONI."GUIManager/Layout.interface.php");


/**
 * This abstract provides methods for theme management: saving/loading of theme state,
 * obtaining information about supported GUI components, etc.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GUIManager.abstract.php,v 1.7 2007/09/04 20:25:21 adamfranco Exp $
 */
class GUIManagerAbstract
	extends OutputHandler
{

/*********************************************************
 * Methods defined in OutputHandler
 *********************************************************/
	/**
	 * Output the content that was returned from an action. This content should
	 * have been created such that it is a type that this OutputHandler can deal
	 * with.
	 * 
	 * @param mixed $returnedContent Content returned by the action
	 * @param string $printedContent Additional content printed, but not returned.
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function output ( $returnedContent, $printedContent ) {		
		// alright, if what we got back was a layout, let's print it out!
		$rule = ExtendsValidatorRule::getRule("ComponentInterface");
		if ($rule->check($returnedContent)){
			$osidContext =$this->getOsidContext();
			$harmoni =$osidContext->getContext('harmoni');
			
			$doctypeDef = $this->_configuration->getProperty('document_type_definition');
			$doctype =  $this->_configuration->getProperty('document_type');
			$characterSet = $this->_configuration->getProperty('character_set');
			try {
				$xmlns = " xmlns=\"".$this->_configuration->getProperty('xmlns')."\"";
			} catch (Exception $e) {
				$xmlns = "";
			}
			$head = $this->getHead();
			
			$this->_theme->setComponent($returnedContent);
			
			$css = $this->_theme->getCSS("\t\t\t");
			
			header("Content-type: $doctype; charset=$characterSet");
			
			print<<<END
$doctypeDef
<html{$xmlns}>
	<head>
		<meta http-equiv="Content-Type" content="$doctype; charset=$characterSet" />
		<style type="text/css">
$css
		</style>
		
		$head
	</head>
	<body>
		$printedContent
		
END;

			$this->_theme->printPage();
			
			print<<<END
	</body>
</html>
END;

		} else {
			// we got something else back... well, let's print out an error
			// explaining what happened.
			$type = gettype($content);
			throwError(new HarmoniError("Harmoni::execute() - The result returned from action '$pair' was unexpected. Expecting a Layout
					object, but got a variable of type '$type'.","Harmoni",true));
		}
	}
	
/*********************************************************
 * Other general methods.
 *********************************************************/
 
	/**
	 * Sets the {@link ThemeInterface Theme} to use for output to the browser. $themeObject can
	 * be any Theme object that follows the {@link ThemeInterface}.
	 * @param ref object A {@link ThemeInterface Theme} object.
	 * @access public
	 * @return void
	 **/
	function setTheme($themeObject) {
		ArgumentValidator::validate($themeObject, 
			ExtendsValidatorRule::getRule("ThemeInterface"));
		
		$this->_theme =$themeObject;
	}
	
	/**
	 * Returns the current theme object.
	 * @access public
	 * @return ref object A {@link ThemeInterface Theme} object.
	 **/
	function getTheme() {
		return $this->_theme;
	}

/*********************************************************
 * Method definitions
 *********************************************************/
	/**
	 * Returns a list of themes supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a theme.
	 **/
	function getSupportedThemes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported themes.
	 * @access public
	 * @return string The relative path to the Theme directory.
	 **/
	function getThemePath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns a list of style properties supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a style property.
	 **/
	function getSupportedSPs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported style properties.
	 * @access public
	 * @return string The relative path to the style property directory.
	 **/
	function getSPPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}	
	
	/**
	 * Returns a list of style components supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a style components.
	 **/
	function getSupportedSCs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported style component.
	 * @access public
	 * @return string The relative path to the style component directory.
	 **/
	function getSCPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns a list of components supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a component.
	 **/
	function getSupportedComponents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported components.
	 * @access public
	 * @return string The relative path to the Component directory.
	 **/
	function getComponentPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}	
		
	/**
	 * Returns a list of layouts supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a layout.
	 **/
	function getSupportedLayouts() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported layouts.
	 * @access public
	 * @return string The relative path to the Layout directory.
	 **/
	function getLayoutPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	// *************************************************************************


	/**
	 * Saves the current theme by updating the theme settings in the database
	 *
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function saveTheme () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

	
	/**
	 * Load theme
	 *
	 * @param object HarmoniId $themeId
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function loadTheme ($themeId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Deletes the theme state with the given id from the database. Notice that
	 * this does not affect the Theme whose state is being deleted in any way!
	 * @access public
	 * @param ref object $id A HarmoniId identifying the theme state that needs to
	 * be deleted.
	 **/
	function deleteTheme($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>