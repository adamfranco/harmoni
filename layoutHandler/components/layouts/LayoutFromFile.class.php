<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * A LayoutFromFile takes a file path as an argument (and an optional array of paths to search)
 * and generates a fully functional layout object from the code in that file. An example file:<br />
 * <br />
 * <table><tr><td>&lt;?$this->printComponent(0,MENU,HORIZONTAL)?&gt;</td></tr></table>
 * <br />
 * <br />
 * The above example essentially outputs a horizontal menu as the only cell in a table. Boring.
 *
 * @abstract
 * @package harmoni.layout.components
 * @version $Id: LayoutFromFile.class.php,v 1.2 2003/07/18 20:26:23 gabeschine Exp $
 * @copyright 2003 
 **/

class LayoutFromFile extends Layout {
	/**
	 * @access private
	 * @var string $_fullPath The layout file's full path.
	 */ 
	var $_fullPath;
	
	/**
	 * @access private
	 * @var boolean $_printing For printComponent(), decides if we should print or register the component.
	 */ 
	var $_printing;
	
	/**
	 * @access private
	 * @var object $_theme The theme object we're using during output.
	 */ 
	var $_theme;
	
	/**
	 * @access private
	 * @var integer $_level This layout's level.
	 */ 
	var $_level;
	
	/**
	 * The constructor.
	 * @param string $file A path to the file to use as a layout.
	 * @param optional mixed $searchPaths An optional array of paths or string (one path) in which to search for $file if it can't be found.
	 * @access public
	 * @return void
	 **/
	function LayoutFromFile($file, $searchPaths=null) {
		$fullPath = null;
		if (file_exists($file)) $fullPath = $file;
		else {
			// go through the searchPaths and find the file.
			if ($searchPaths && !is_array($searchPaths)) $searchPaths = array($searchPaths);
			foreach ($searchPaths as $path) {
				$try = $path . DIRECTORY_SEPARATOR . $file;
				if (file_exists($try)) { $fullPath = $try; break; }
			}
		}
		
		// if we found the file...
		if ($fullPath) {
			// execute the file and catch the output
			$this->_fullPath = $fullPath;
			ob_start();
			@include($fullPath);
			ob_end_clean();
			// success!
		} else {
			// throw an error
			throwError(new Error("LayoutFromFile - could not create new layout from file '$file' because it could not be found!","Layout",true));
		}
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $level The current level in the output hierarchy. Default=0.
	 * @access public
	 * @return void
	 **/
	function outputLayout($theme, $level) {
		$this->verifyComponents();
		
		$this->_theme =& $theme;
		$this->_level = $level;
		
		// do the output
		$this->_printing = true;
		include($this->_fullPath);
	}
	
	/**
	 * For use from within a layout file, does one of two things: either adds the component
	 * to the expected component list (if it hasn't been added already) or prints the component
	 * content to screen.
	 * 
	 * @param integer $index This component's index (for people using setComponent())
	 * @param string $type This component's type. A number of constants are defined for this.
	 * @param integer $orientation This component's orientation (really only useful for menus). Either HORIZONTAL or VERTICAL.
	 * @access public
	 * @return void 
	 **/
	function printComponent($index, $type, $orientation=HORIZONTAL) {
		if ($this->_printing) {
			// we're supposed to output this component
			$component =& $this->getComponent($index);
			$component->output(&$this->_theme, $this->_level+1, $orientation);
		} else {
			// otherwise, just check if it's been added already, and if not, add it.
			if (isset($this->_registeredComponents[$index])) {
				// if it is set, and its type doesn't match $type, we should throw an error
				if ($this->_registeredComponents[$index] != $type)
					throwError(new Error("LayoutFromFile::printComponent($index) - could not add component $index because it is already defined and of a different type.","Layout",true));
			} else
				$this->addComponent($index,$type);
		}
	}
}

?>