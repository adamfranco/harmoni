<?php

require_once(HARMONI."themeHandler/NamedTheme.abstract.php");

require_once(HARMONI."utilities/Template.class.php");
require_once(HARMONI."utilities/FieldSetValidator/FieldSet.class.php");

/**
 * This is a test theme object.
 *
 * @package harmoni.themes
 * @version $Id: TestTheme.class.php,v 1.2 2004/03/01 15:48:36 adamfranco Exp $
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
		$this->_baseColor	=&		new HTMLcolor("369"); // a nice blue
		
		// does this theme have theme settings (controlled by handleThemeSettings())?
		$this->_hasSettings	=		false;
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param ref object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function printPageWithLayout(&$layoutObj) {
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
		
		$flds->set("content",$content);
		
		// make a copy
		$color = $this->_baseColor;
		$color->lighten(70);
		$flds->set("floatcolor",$color->getHTMLcolor());
		
		// output the template
		$tpl->output($flds);
	}

	/**
	 * Prints a {@link Menu}, with specified orientation.
	 * @param ref object $menuObj The {@link Menu} object to print.
	 * @param integer $otientation The orientation. Either HORIZONTAL or VERTICAL.
	 * @access public
	 * @return void
	 **/
	function printMenu(&$menuObj, $orientation) {
//		print "<div style='border: 1px solid gray; padding: 2px; margin: 2px;'>";
		$h = ($orientation == VERTICAL)?false:true;
		// make a copy
		$color = $this->_baseColor;
		$level = $menuObj->getLevel();
		print "\n".$this->_getTabs($level)."<table cellpadding=0 cellspacing=1 width=100%>";
		print "\n".$this->_getTabs($level)."\t<tr>";
		$color->lighten($level*10 + 50);
		$bgcolor = $color->getHTMLcolor();
		for($i = 0; $i < $menuObj->getCount(); $i++) {
			$item =& $menuObj->getItem($i);
			if ($item->getType() == LINK)$item->addExtraAttributes("class='menu'");
			print "\n".$this->_getTabs($level)."\t<td style='background-color: $bgcolor'".($h?" align=center":"").">";
			print "\n".$this->_getTabs($level)."\t\t".$item->getFormattedText();
			print "\n".$this->_getTabs($level)."\t</td>";
			print (!$h)?"\n".$this->_getTabs($level)."\t</tr><tr>":"";
		} // for
		print "\n".$this->_getTabs($level)."</tr></table>";
//		print "</div>";
	}
	
	/**
	 * Prints a {@link Content} object out using the theme. $level can be used to specify
	 * changing look the deeper into a layout you go.
	 * @param ref object $contentObj The {@link Content} object to use.
	 * @access public
	 * @return void
	 **/
	function printContent(&$contentObj) {
//		print "<div style='border: 1px solid gray; padding: 2px; margin: 2px;'>";
		print $contentObj->getContent();
//		print "</div>";
	}
	
	/**
	 * Prints a {@link Layout} object.
	 * @param ref object $layoutObj The Layout object.
	 * @access public
	 * @return void
	 **/
	function printLayout(&$layoutObj) {
		$level = $layoutObj->getLevel();
    	print "\n".$this->_getTabs($level)."<div style='border: 1px solid gray; padding: 2px; margin: 2px;'>";
		print "\n".$this->_getTabs($level)."<div align=center style='background-color: #eee;'>";
		print "\n".$this->_getTabs($level)."\tlevel=<b>".$layoutObj->getLevel()."</b>";
		print "\n".$this->_getTabs($level)."</div>";
		$layoutObj->outputLayout($this);
		print "\n".$this->_getTabs($level)."</div>";
	}
}

?>