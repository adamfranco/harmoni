<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The single content {@link Layout} contains only one content component. Useful for
 * filling the space in a layout that expects another layout as a component with just
 * some content.
 * <br />
 * Content: <br />
 * <ul><li />Index: 0, A Content object.</ul>
 *
 * @abstract
 * @package harmoni.layout.components
 * @version $Id: SingleContentLayout.class.php,v 1.3 2003/07/17 04:25:23 gabeschine Exp $
 * @copyright 2003 
 **/

class SingleContentLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function SingleContentLayout() {
		$this->addComponent(0,CONTENT);
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $level The current level in the output hierarchy. Default=0.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @return void
	 **/
	function output($theme, $level=0, $orientation=HORIZONTAL) {
		$this->verifyComponents();
		// @todo -cSingleContentLayout Implement SingleContentLayout.print
		print "THIS IS THE CONTENT FROM SingleContentLayout:<br/><br/>";
		$c =& $this->getComponent(0);
		$c->output();
	}
}

?>