<?php

require_once(HARMONI."themeHandler/NamedTheme.abstract.php");

/**
 * This is a test theme object.
 *
 * @package harmoni.themes
 * @version $Id: TestTheme.class.php,v 1.1 2003/07/18 03:23:14 gabeschine Exp $
 * @copyright 2003 
 **/

class TestTheme extends NamedTheme {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function TestTheme() {
		// this theme's name and description
		$this->_name		=		"Test Theme";
		$this->_description	=		"This theme tests Harmoni's Theme functionality.";
		
		// this theme's base color (should be an HTMLColor object)
		$this->_baseColor	=		""; // @todo -cTestTheme Implement TestTheme.TestTheme
		
		// does this theme have theme settings (controlled by handleThemeSettings())?
		$this->_hasSettings	=		false;
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function outputPageWithLayout($layoutObj) {
		$tpl =& new Template("TestTheme.tpl",HARMONI."themeHandler");
		
		$flds =& new FieldSet;
		
		// the page title
		$flds->set("title",$this->_pageTitle);
		
		// get the extra stuff for the <head> tag
		$flds->set("head",$this->_extraHeadContent);
		
		// get the content
		ob_start();
		$layoutObj->output($this);
		$content = ob_get_contents();
		ob_end_clean();
		
		$flds->set("contents",$contents);
		
		// output the template
		$tpl->output(&$flds);
	}
}

?>