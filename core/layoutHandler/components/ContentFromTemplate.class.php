<?php
require_once(HARMONI."layoutHandler/components/Content.interface.php");

/**
 * Creates a {@link Content} object from a template which is called when text is requested.
 *
 * @package harmoni.layout.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ContentFromTemplate.class.php,v 1.3 2005/01/25 14:55:20 adamfranco Exp $
 */
class ContentFromTemplate extends Content {
	var $_template;
	var $_vars;
	
	/**
	 * The constructor.
	 * @param ref object $template The template to use.
	 * @param ref mixed $vars The array or {@link FieldSet} to use.
	 * @access public
	 * @return void
	 **/
	function ContentFromTemplate( &$template, &$vars ) {
		parent::Content();
		$this->_template =& $template;
		$this->_vars =& $vars;
	}
	
	/**
	 * Returns this component's content.
	 * @access public
	 * @return string The content.
	 **/
	function getContent() {
		$this->setContent($this->_template->catchOutput($this->_vars));
		
		return parent::getContent();
	}
}

?>